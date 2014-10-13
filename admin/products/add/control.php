<?php
include("get.php");
include("update.php");
/* variable */
// Category
$all_category = get_all_category();

// Size Group
$all_size_group = get_all_size_group();

// Color
$all_color_group = get_all_color_group();



/* function database */
if(isset($_POST['add-product'])){
   
   if ($_POST["add-product"]=='Save Changes' || $_POST["add-product"]=='Save Changes & Exit'){
      
	  if ($_POST["product_name"]!=''){
		insert_product();
	  }
	
   }

}
?>