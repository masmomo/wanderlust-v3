<?php
//GET
function update_sizefit(){
	$conn = connDB();
	
	$product_category     = $_POST["product_category"];
	$product_size_type_id = $_POST["size_type_id"];
	$product_name         = $_POST["product_name"];
	$type_name            = $_POST["type_name"]; //array
	$type_sizefit         = $_POST["type_sizefit"]; //array
	$product_id           = $_POST["product_id"];
	
	if($product_id==''){
	   //get the new product id
	   $get_id = mysql_query("
				 SELECT * from tbl_product
				 WHERE product_category = '$product_category' AND product_name = '$product_name' AND product_size_type_id = '$product_size_type_id'
				 ORDER BY id DESC
				 ",$conn);

	   if (mysql_num_rows($get_id)!=null){
	      $get_id_array = mysql_fetch_array($get_id);
	      $product_id = $get_id_array["id"];
	   }
		
	}
	
	//!product types
	for ($i=1;$type_name[$i]!=null;$i++){
	   echo $sql = "
				   UPDATE tbl_product_type
				   SET type_sizefit = '$type_sizefit[$i]'
				   WHERE type_name = '$type_name[$i]' AND product_id='$product_id'
				   ";
			
	   mysql_query($sql, $conn);
	}
		
}

/* function database */
if(isset($_POST['add-product'])){
   if ($_POST["add-product"]=='Save Changes' || $_POST["add-product"]=='Save Changes & Exit'){
      update_sizefit();
   }
}else if(isset($_POST['btn-product-detail'])){
   update_sizefit();
}
?>