<?php
include("get.php");
include("update.php");

// FEATURED
$featured           = getFeatured($_POST['check_featured']);
$array_product_name = $_POST['product-name'];
$post_alias_id      = $_POST['check_featured'];
//$post_type_id       = $_POST['product_name'];

if(isset($_POST['btn-pages-home'])){
   
   if($_POST['btn-pages-home'] == "Save Changes"){
	  
   $i = 0;
   foreach($array_product_name as $product_name){
	  $i++;
	  $check = get_featured($i);
	  
	  if($check['featured_alias_id'] != $i){
	     
		 if($product_name != 0){
            insertFeatured($product_name, $post_alias_id.$i);
	     }
		 
	  }else{
	     updateFeatured($product_name, $i);
	  }
	  
   }

   
   }
   
   
} // END ISSET
?>