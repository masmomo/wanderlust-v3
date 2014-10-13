<?php

// Get all category
function get_all_category(){
$conn = connDB();

$sql    = "SELECT 
           category.category_name, category.category_level, category.category_order,
		   relation.category_parent, relation.relation_level, category_id
		   
		   FROM tbl_category AS category  LEFT JOIN tbl_category_relation AS relation ON category.category_id = relation.category_child
		   
		   ORDER BY category.category_order";
$query  = mysql_query($sql, $conn);
$row    = array();
          while($result = mysql_fetch_array($query)){
		     array_push($row, $result);
		  }
return $row;
}

function get_all_size_group(){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_size_type ORDER BY size_type_order ASC";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_all_color_group(){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_color ORDER BY color_order ASC";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_product_details(){
	$product_alias=$_GET["product_alias"];
	
	
	$conn = connDB();
	
	$get_info = mysql_query("
		SELECT * from tbl_product AS product INNER JOIN tbl_product_type AS p_type
		ON product.id = p_type.product_id
		WHERE product_alias = '$product_alias' AND type_delete!='1'
		ORDER BY type_order
	",$conn);
	
	if (mysql_num_rows($get_info)!=null){
		for ($counter=1;$counter<=mysql_num_rows($get_info);$counter++){
			$get_info_array = mysql_fetch_array($get_info);
			if ($counter==1){
				$data['collection_id'] = $get_info_array["collection_id"];
				$data['product_id'] = $get_info_array["product_id"];
				$data['product_category'] = $get_info_array["product_category"];
				$data['product_name'] = $get_info_array["product_name"];
				$data['product_size_type_id'] = $get_info_array["product_size_type_id"];
				$data['product_alias'] = $get_info_array["product_alias"];
				$data['page_title'] = $get_info_array["page_title"];
				$data['page_description'] = $get_info_array["page_description"];				
			}
			$data['type_code'][$counter] = $get_info_array["type_code"];
			$data['type_name'][$counter] = $get_info_array["type_name"];
			
			$data['type_price'][$counter] = $get_info_array["type_price"];
			$data['color_id'][$counter] = $get_info_array["color_id"];
			
			$data['type_description'][$counter] = $get_info_array["type_description"];
			$data['type_weight'][$counter] = $get_info_array["type_weight"];
			//$type_image[$counter] = $get_info_array["type_image"];
			$data['type_code'][$counter] = $get_info_array["type_code"];
			$data['type_id'][$counter] = $get_info_array["type_id"];
			
			$data['product_image'][$counter] = get_product_image($data['type_id'][$counter]);
			$data['quantity'][$counter] = get_type_quantity($data['type_id'][$counter],$counter);
		}
		
	}
	
	$data['total_type'] = $counter-1;
	return $data;
}

function get_product_image($type_id_){
	$conn = connDB();
	$product_image['image_id_list']=array();
	$product_image['img_src_list']=array();
	$get_image = mysql_query("
								SELECT * from tbl_product_image
								WHERE type_id = '$type_id_'
								ORDER BY image_order
							",$conn);
							
	
							if (mysql_num_rows($get_image)!=null){
								for ($image_count=1;$image_count<=mysql_num_rows($get_image);$image_count++){
									$get_image_array = mysql_fetch_array($get_image);
									array_push($product_image['image_id_list'],$get_image_array["image_id"]);
									array_push($product_image['img_src_list'],$get_image_array["img_src"]);
									
								}
							}
							
							
							
	return $product_image;
}

function get_type_quantity($type_id_){
	$conn = connDB();
	$get_stock = mysql_query("
									SELECT * from tbl_product_stock
									WHERE type_id = '$type_id_'
									
								",$conn);
								
								if (mysql_num_rows($get_stock)!=null){
									
									


									for ($stock_count=1;$stock_count<=mysql_num_rows($get_stock);$stock_count++){
										$get_stock_array = mysql_fetch_array($get_stock);
										$tmp = $get_stock_array["stock_name"];
										$quantity[$tmp] = $get_stock_array["stock_quantity"];
										
									}
								}
								
								return $quantity;
}
?>