//display the details/data of each item
<?php 
include("inc/data.php");
include("inc/functions.php");


if (isset($_GET["id"])) {
 $id = $_GET["id"];
  if(isset($catalog[$id])){
    $item = $catalog[$id];
  }
}

if (!isset($item)){
  header("location: catalog.php");//redirect, if item not set look in a different location
  exit;
}

$pageTitle = $item["title"];
$section = null;

include("inc/header.php"); ?>

<div class="section page">
  <div class="wrapper">
    <img src="<?php echo $item["img"]; ?>" alt="<?php echo $item["title"]; ?>" />
  </div>
</div>


<?php include("inc/footer.php"); ?>



