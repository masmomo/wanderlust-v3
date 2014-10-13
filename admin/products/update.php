<?php
function update_product_table(){
	$action = $_POST["product-index-action"];
	
	if($action=='visibility'){
		update_product_table_visibility();
	}
	else if($action=='delete'){
		update_product_table_delete();
	}
	else if($action=='new'){
		update_product_table_new();
	}
}

function update_product_table_visibility(){
	$conn = connDB();

	$type_id = $_POST["type_id"];
	$product_id = $_POST["product_id"];
	$option = $_POST["product-index-option"];
	
	foreach ($type_id as $type_id_){
		mysql_query("
				UPDATE tbl_product_type
				SET type_visibility = '$option'
				WHERE type_id = '$type_id_'
				",$conn);
	}
	
	foreach ($product_id as $product_id_){
		$get_info = mysql_query(
			"SELECT * from tbl_product_type
			WHERE product_id ='$product_id_' AND type_visibility = '1' AND type_delete = '0'	
			",$conn);
			
		if (mysql_num_rows($get_info)>0){
			mysql_query("
				UPDATE tbl_product
				SET product_visibility = '1'
				WHERE id = '$product_id_'
				",$conn);
		} 
		else{
			mysql_query("
				UPDATE tbl_product
				SET product_visibility = '0'
				WHERE id = '$product_id_'
				",$conn);
		}
	}
}

function update_product_table_delete(){
	$conn = connDB();

	$type_id = $_POST["type_id"];
	$product_id = $_POST["product_id"];
	//$option = $_POST["product-index-option"];
	
	foreach ($type_id as $type_id_){
		mysql_query("
				UPDATE tbl_product_type
				SET type_delete = '1'
				WHERE type_id = '$type_id_'
				",$conn);
	}
	
	foreach ($product_id as $product_id_){
		$get_info = mysql_query(
			"SELECT * from tbl_product_type
			WHERE product_id ='$product_id_' AND type_delete = '0'	
			",$conn);
			
		if (mysql_num_rows($get_info)>0){
			mysql_query("
				UPDATE tbl_product
				SET product_delete = '0'
				WHERE id = '$product_id_'
				",$conn);
		} 
		else{
			mysql_query("
				UPDATE tbl_product
				SET product_delete = '1'
				WHERE id = '$product_id_'
				",$conn);
		}
	}
}

function update_product_table_new(){
	$conn = connDB();

	$type_id = $_POST["type_id"];
	$product_id = $_POST["product_id"];
	$option = $_POST["product-index-option"];
	
	foreach ($type_id as $type_id_){
		mysql_query("
				UPDATE tbl_product_type
				SET type_new_arrival = '$option'
				WHERE type_id = '$type_id_'
				",$conn);
	}
	
	foreach ($product_id as $product_id_){
		$get_info = mysql_query(
			"SELECT * from tbl_product_type
			WHERE product_id ='$product_id_' AND type_new_arrival = '1' AND type_delete = '0'	
			",$conn);
			
		if (mysql_num_rows($get_info)>0){
			mysql_query("
				UPDATE tbl_product
				SET product_new_arrival = '1'
				WHERE id = '$product_id_'
				",$conn);
		} 
		else{
			mysql_query("
				UPDATE tbl_product
				SET product_new_arrival = '0'
				WHERE id = '$product_id_'
				",$conn);
		}
	}
}


// ORDER
function update_order($post_order, $post_product_id){
   $conn = connDB();
   
   $sql    = "UPDATE tbl_product SET `product_order` = '$post_order' WHERE `id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}
?>