<?php 

function full_catalog_array(){
  include("connection.php");
  try {
   $results = $db->query(
     "SELECT media_id, title, category, img 
     FROM Media");
  } catch (Exception $e) {
    echo "Unable to retrieve results";
    exit;
  }
    $catalog = $results->fetchAll();
    return $catalog;
  } 

////////////////////////////////////////////

function category_catalog_array($category) {
  include("connection.php");
  $category = strtolower($category);
  try {
   $results = $db->prepare("SELECT media_id, title, LOWER(category), img 
    FROM Media
    WHERE category = ?
    ORDER BY title"
    );
    $results->bindParam(1,$category, PDO::PARAM_STR);
    $results->execute();
  } catch (Exception $e) {
    echo "Unable to retrieve results";
    exit;
  }
    
    $catalog = $results->fetchAll();
    return $catalog;
  } 

///////////////////////////////////////////////

function random_catalog_array() {
  include("connection.php");
//Run the query that Retrieves the items
  try {
   $results = $db->query("SELECT media_id, title, category, img 
   FROM Media
   ORDER BY RAND()
   LIMIT 3"
  );
  //echo "Retrieved Results";
  } catch (Exception $e) {
    echo "Unable to retrieve results";
    exit;
  }
    //Load results into variable called catalog
    $catalog = $results->fetchAll();
    return $catalog;
  }


////////////////////////////////////////////

function single_item_array($id) {
  include("connection.php");

  //Run the query that Retrieves the items
  try {
   $results = $db->prepare("SELECT Media.media_id, title, category, img, format, year, genre
   FROM Media
   JOIN Genres on Media.genre_id = Genres.genre_id
   LEFT OUTER JOIN Books  
   ON Media.media_id = Books.media_id
   WHERE Media.media_id = ?" 
   );
    //Connect ? placeholder to $results variable
   $results->bindParam(1,$id, PDO::PARAM_INT);
   $results->execute();
  } catch (Exception $e) {
    echo "Unable to retrieve results";
    exit;
  }
   
    $item = $results->fetch();
    if (empty($item)) return $item;
    try {
   $results = $db->prepare("SELECT 
   fullname, role
   FROM Media_People
   JOIN People ON Media_people.people_id = People.people_id
   WHERE Media_People.media_id = ?" 
   );
   $results->bindParam(1,$id, PDO::PARAM_INT);
   $results->execute();
  } catch (Exception $e) {
    echo "Unable to retrieve results";
    exit;
  }
  //Don't want results to be a simple array; while loop will go through results one at a time and format them as it goes
  while($row = $results->fetch(PDO::FETCH_ASSOC)){
    $item[$row["role"]][]= $row["fullname"];
  };
  return $item;
  }

/////////////////////////////////////////////


function get_item_html($item) {
    $output = "<li><a href='details.php?id="
        . $item["media_id"] . "'><img src='" 
        . $item["img"] . "' alt='" 
        . $item["title"] . "' />" 
        . "<p>View Details</p>"
        . "</a></li>";
    return $output;
}

function array_category($catalog,$category) {
    $output = array();
    
    foreach ($catalog as $id => $item) {
        if ($category == null OR strtolower($category) == strtolower($item["category"])) {
            $sort = $item["title"];
            $sort = ltrim($sort,"The ");
            $sort = ltrim($sort,"A ");
            $sort = ltrim($sort,"An ");
            $output[$id] = $sort;            
        }
    }
    
    asort($output);
    return array_keys($output);
}
