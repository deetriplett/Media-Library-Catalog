<?php
function get_item_html($id, $item) {
 $output = "<li><a href='#'><img src="
        . $item["img"] . "'alt='" 
        . $item["title"] . " '/>" 
        ."<p>View Details</p>"
        . "</a></li>";
  return $output;

}

function array_category($catalog, $category){
  if($catgeory == null){
    return array_keys($catalog);}
  $output = array();
  
  foreach($catalog as $id => $item){
    if(strtolower($category) == strtolower($item[$category])){
      $sort = $item["title"]; //sorts by title
      $sort = ltrim($sort, "The ");
      $sort = ltrim($sort, "A ");
      $sort = ltrim($sort, "An ");//trim form the left, targets "the", etc. 
      $output[$id] = $sort; 
    }
  }//end foreach loop
  asort($output);
  return array_keys($output);
  

}


