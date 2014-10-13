<?php
function insert_product(){
	$conn = connDB();
	//var_dump($_POST);
	include("static/thumbnail.php");
	
	
	date_default_timezone_set("Asia/Jakarta");
	$date = date('Y-m-d H:i:s');
	$date_only = date('Y-m-d_H-i-s');
	
	$product_category = $_POST["product_category"];
	$product_size_type_id = $_POST["size_type_id"];
	$product_id = $_POST["product_id"]; 
	$product_name = $_POST["product_name"];				
	
	$type_id = $_POST["type_id"]; //array
	$color_id = $_POST["color_id"]; //array
	$type_name = $_POST["type_name"]; //array
	
	$type_alias			  = array();
	foreach ($type_name as $type_name_){
		array_push($type_alias,cleanurl($type_name_));
	}
	
	
	$type_code = $_POST["type_code"]; //array
	$type_price = $_POST["type_price"]; //array
	$type_description = $_POST["type_description"]; //array
	//$type_image = $_POST["type_image"]; //double_array
	$type_delete = $_POST["type_delete"]; //array
	
	$order = $_POST["order"]; //double_array
	$image_id = $_POST["image_id"];
	$image_delete = $_POST["image_delete"];
	
	$stock_quantity = $_POST["stock_quantity"]; //double_array
	$stock_name = $_POST["stock_name"]; //double_array
	$type_weight = $_POST["type_weight"];
	
	$page_title = $_POST["page_title"];
	$page_description = $_POST["page_description"];
	$product_alias = $_POST["product_alias"];
	
	//!new product
	if ($product_id==''){
		//!new product - get product order
		$get_order = mysql_query("
						SELECT * from tbl_product
						ORDER BY product_order DESC
					 ",$conn);

		if (mysql_num_rows($get_order)!=null){
			$get_order_array = mysql_fetch_array($get_order);
			$product_order = $get_order_array["product_order"]*1+1;
		}
		
		//!new product - insert
		$sql = "
			INSERT INTO tbl_product(product_category, product_name,product_size_type_id,product_date_added,product_order,product_alias,page_title,page_description) 
		VALUES('$product_category', '$product_name','$product_size_type_id','$date','$product_order','$product_alias','$page_title','$page_description')"; 
		
		mysql_query($sql, $conn);
		
		
		//!new product - get the new product id
		$get_id = mysql_query("
				SELECT * from tbl_product
				WHERE product_category = '$product_category' AND product_name = '$product_name' AND product_size_type_id = '$product_size_type_id' AND product_date_added = '$date'
				ORDER BY id DESC
",$conn);

		if (mysql_num_rows($get_id)!=null){
			$get_id_array = mysql_fetch_array($get_id);
			$product_id = $get_id_array["id"];
		}  
	}
	
	//!edit product - if previously exsisted	
	else{
		$sql = "
			UPDATE tbl_product
			SET product_category = '$product_category', product_name = '$product_name', product_size_type_id = '$product_size_type_id', product_alias='$product_alias', page_title='$page_title', page_description='$page_description'
			WHERE id = '$product_id'
		";
		
		mysql_query($sql, $conn);	
	}
	
	
	//!product types
	for ($i=1;$type_name[$i]!=null;$i++){
		//!delete
		if ($type_delete[$i]=='1'){		
		//!delete the existing type
			if ($type_id[$i]!=''){
				//!delete - set the type_delete to 1
				$type_id_ = $type_id[$i];
				$sql = "
					UPDATE tbl_product_type
					SET type_delete = '1'
					WHERE type_id = '$type_id_'
					";
			
				mysql_query($sql, $conn);
				
				//!delete - remove all stock
				mysql_query("
					DELETE FROM tbl_product_stock
					WHERE type_id = '$type_id_'
					", $conn);
			}
		}
		else{
		//!new product type
		if ($type_id[$i]==''){
			//!new product type - insert
			$sql = "
				INSERT INTO tbl_product_type(type_code,type_name,type_price,type_description,color_id,type_weight,type_alias,product_id,type_order,page_title,page_description)
				VALUES ('$type_code[$i]','$type_name[$i]','$type_price[$i]','$type_description[$i]','$color_id[$i]','$type_weight[$i]','$type_alias[$i]','$product_id','$counter','$page_title','$page_description')
			";
			
			mysql_query($sql, $conn);	
			
			//!new product type - get the new type id
			$get_id = mysql_query("
				SELECT * from tbl_product_type
				WHERE type_code='$type_code[$i]' AND type_name='$type_name[$i]' AND type_description='$type_description[$i]' AND type_price='$type_price[$i]'
				ORDER BY type_id DESC
				",$conn);
		
				if (mysql_num_rows($get_id)!=null){
					$get_id_array = mysql_fetch_array($get_id);
					$type_id_ = $get_id_array["type_id"];
					
					//echo $type_id_;
				}
		}
		
		
		//!edit product type
		else{
			$type_id_ = $type_id[$i];
			$sql = "
				UPDATE tbl_product_type
				SET type_code = '$type_code[$i]', type_name = '$type_name[$i]', type_price = '$type_price[$i]', type_description = '$type_description[$i]', color_id = '$color_id[$i]' , type_weight = '$type_weight[$i]', type_alias = '$type_alias[$i]',type_order='$counter', page_title='$page_title', page_description='$page_description'
				WHERE type_id = '$type_id_'
			";
			
			mysql_query($sql, $conn);
		}
		
		
		//!product image
		for ($j=0;$j<5;$j++){
			$k = $order[$i][$j]; //initial order
			$image_id_ = $image_id[$i][$k];
			
			//!type image - new image
			if ($image_id_ == ""){
			
				//!type image - new image, image existed
				if ($_FILES["product_image"]["tmp_name"][$i][$k]!=null){
				

					$tmp_name = $_FILES["product_image"]["tmp_name"][$i][$k];
					$name = cleanurl($product_name)."_".cleanurl($type_name[$i])."_".$date_only."_".$_FILES["product_image"]["name"][$i][$k];
					$error = $_FILES["product_image"]["error"][$i][$k];
					//$link = $_POST["type_image"mage_counter];
				
					if ($error == 0){
					move_uploaded_file($tmp_name,"../files/uploads/product_image/$name");
					$img_src="files/uploads/product_image/$name";
					}
				
				
					//!type image - new image create thumbnails
					$tg = new thumbnailGenerator;
					$tg->generate('../files/uploads/product_image/'.$name, 240, 360, '../files/uploads/product_image/thumb_240x360/'.$name);

					mysql_query("
					INSERT INTO tbl_product_image(type_id,img_src,image_order)
					VALUES ('$type_id_','$img_src','$j')

					",$conn);
		
				} 	
			}
			
			//!type image - update image
			else{

				//!type image - update image, image existed
				if ($_FILES["product_image"]["tmp_name"][$i][$k]!=null){
				
					
					$tmp_name = $_FILES["product_image"]["tmp_name"][$i][$k];
					$name = cleanurl($product_name)."_".cleanurl($type_name[$i])."_".$date_only."_".$_FILES["product_image"]["name"][$i][$k];
					$error = $_FILES["product_image"]["error"][$i][$k];
					//$link = $_POST["type_image"mage_counter];
				
					if ($error == 0){
					move_uploaded_file($tmp_name,"../files/uploads/product_image/$name");
					$img_src="files/uploads/product_image/$name";
					}
				
				
					//!type image - new image create thumbnails
					$tg = new thumbnailGenerator;
					$tg->generate('../files/uploads/product_image/'.$name, 240, 360, '../files/uploads/product_image/thumb_240x360/'.$name);

					mysql_query("
					UPDATE tbl_product_image
					SET img_src='$img_src'
					WHERE image_id='$image_id_'
					",$conn);
		
				}
				
				//!delete type image
				if($image_delete[$i][$k]=='1'){
					mysql_query("
					DELETE FROM tbl_product_image
					WHERE image_id='$image_id_'
					",$conn);
				}
				
				//!type image - update image, order
				
				mysql_query("
				UPDATE tbl_product_image
				SET image_order='$j'
				WHERE image_id='$image_id'
				",$conn);
					
					
				
			}
		}//type image
		
		//!type stock
		//!type stock - delete all
		mysql_query("
					DELETE FROM tbl_product_stock
					WHERE type_id='$type_id_'
					",$conn);
		$stock_name_ = current($stock_name[$i]);
		foreach ($stock_quantity[$i] as $stock_quantity_){
			
			if($stock_quantity_!=0){
				$stock_sold_out=0;
			}
			else{
				$stock_sold_out=1;
			}
			
			
			
			//!type stock - insert
			mysql_query("
				INSERT INTO tbl_product_stock(type_id,stock_name,stock_quantity,stock_sold_out)
				VALUES ('$type_id_','$stock_name_','$stock_quantity_','$stock_sold_out')

			",$conn);
			
			$stock_name_ = next($stock_name[$i]);
		}
		}//delete	
			
	}//for
	check_sold_out($product_id);
}

function check_sold_out($product_id){
	$conn = connDB();
	
	
	$get_type = mysql_query("
		SELECT * from tbl_product_type
		WHERE product_id='$product_id'	
		",$conn);
	if (mysql_num_rows($get_type)!=null){
		
		for ($counter=1;$counter<=mysql_num_rows($get_type);$counter++){
		
		$get_type_array = mysql_fetch_array($get_type);
		$type_id_ = $get_type_array["type_id"];
		
		
		//!check stock sold out
		$check = mysql_query("
			SELECT * from tbl_product_stock AS stock INNER JOIN tbl_size AS size
			ON stock.stock_name = size.size_name
			WHERE type_id='$type_id_' AND stock_sold_out='0'

			",$conn);
			if (mysql_num_rows($check)==null){
			mysql_query("
				UPDATE tbl_product_type
				SET type_sold_out = '1'
				WHERE type_id = '$type_id_'
			",$conn);
			}
			else{
			mysql_query("
				UPDATE tbl_product_type
				SET type_sold_out = '0'
				WHERE type_id = '$type_id_'
			",$conn);	
			}
			
		}
	
		//!check type sold out
		$check2 = mysql_query("
			SELECT * from tbl_product_type
			WHERE product_id='$product_id' AND type_sold_out='0'	
			",$conn);
		
		if (mysql_num_rows($check2)==null){
			mysql_query("
				UPDATE tbl_product
				SET product_sold_out = '1'
				WHERE id = '$product_id'
				",$conn);
		}
		else{
			mysql_query("
				UPDATE tbl_product
				SET product_sold_out = '0'
				WHERE id = '$product_id'
				",$conn);	
		}

	}
}

?>