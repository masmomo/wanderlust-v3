<?php
include("custom/products/add/multiple_insert_product/control.php");

include("custom/products/add/files_control.php");
include("custom/products/add/color_control.php");
include("custom/products/add/how_control.php");
include("custom/products/add/filter_control.php");



//UPDATE COLLECTION
function update_collection(){
   $conn = connDB();
   
   $product_category     = $_POST["product_category"];
   $product_size_type_id = $_POST["size_type_id"];
   $product_name         = $_POST["product_name"];
   $product_collection   = $_POST["product_collection"]; 
   
   $product_id = $_POST["product_id"];
   
   if($product_id==''){
      //get the new product id
	  $get_id = mysql_query("SELECT * from tbl_product
				             WHERE product_category = '$product_category' AND product_name = '$product_name' AND product_size_type_id = '$product_size_type_id'
							 ORDER BY id DESC
							",$conn);

      if (mysql_num_rows($get_id)!=null){
	     $get_id_array = mysql_fetch_array($get_id);
		 $product_id = $get_id_array["id"];
	  }
   }
   
   $sql = "UPDATE tbl_product
           SET product_collection = '$product_collection'
		   WHERE id='$product_id'
		  ";
			
   mysql_query($sql, $conn);		
		
}



/* function database */

if(isset($_POST['add-product'])){
   if ($_POST["add-product"]=='Save Changes' || $_POST["add-product"]=='Save Changes & Exit'){
	
	//update_gender();
	update_collection();
	//update_series();
	//update_artist();
	//update_story();
	//update_image_gender();
	
	/* --- USD PRICE --- */
	//update_usd('add');
   }

}
//edit
else if(isset($_POST['btn-product-detail'])){
   if ($_POST["btn-product-detail"]=='Save Changes'){
	
	//update_gender();
	update_collection();
	//update_series();
	//update_artist();
	//update_story();
	//update_image_gender();
	
	/* --- USD PRICE --- */
	//update_usd('edit');
   }

}
?>