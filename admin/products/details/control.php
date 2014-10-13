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
if ($_POST["btn-product-detail"] == 'Save Changes' || $_POST["btn-product-detail"] == 'Save Changes & Exit'){
   insert_product();
}else{
   $data = get_product_details();
}
?>