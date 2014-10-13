<?php
//multiple
function insert_multiple_products(){
	$conn = connDB();
	$multi_files=$_FILES["multi_files"];
	//print_r($multi_files);
	$xls_file="";

	date_default_timezone_set("Asia/Jakarta");
	$date = date('Y-m-d');

	include("static/thumbnail.php");

	$tmp_name = current($multi_files["tmp_name"]);
	$error = current($multi_files["error"]);
	$type = current($multi_files["type"]);
	foreach ($multi_files["name"] as $name){
	
	
		$name = $date."_".$name;
	
		if ($error == 0&&$type!="application/zip"){
			move_uploaded_file($tmp_name,"../files/uploads/products/$name");
			if (strpos($name,".xls")!==false){
				$xls_file = "../files/uploads/products/".$name;	
			}
		
		}
		else{
			// Zip file header
			$zip = new ZipArchive;
			if ($zip->open($tmp_name) === TRUE) {
				if (!file_exists('../files/uploads/products/'.$date)){
						mkdir('../files/uploads/products/'.$date, 0777);
					}
				$zip->extractTo('../files/uploads/products/'.$date.'/');
				$zip->close();
	    
				if ($handle = opendir('../files/uploads/products/'.$date.'/')) {
					if (!file_exists('../files/uploads/products/thumb_240x360/'.$date)){
						mkdir('../files/uploads/products/thumb_240x360/'.$date, 0777);
					}
				
				
					while (false !== ($entry = readdir($handle))) {
			        	if (strpos($entry,".jpg")!==false||strpos($entry,".jpeg")!==false||strpos($entry,".png")!==false||strpos($entry,".gif")!==false){
	
							$tg = new thumbnailGenerator;
							$tg->generate('../files/uploads/products/'.$date.'/'.$entry, 240, 360, $prefix.'../files/uploads/products/thumb_240x360/'.$date.'/'.$entry);
						
						}
					}
					closedir($handle);
				}	
			} else {
		    	$error_zip = 1;
			}
		}
	
	$tmp_name = next($multi_files["tmp_name"]);
	$error = next($multi_files["error"]);
	$type = next($multi_files["type"]);
	}

	if ($xls_file!=""){
		read_xls($xls_file);
	}
} //close function

function read_xls($xls_file){
	$conn = connDB();
	
	include("static/PHPExcel.php");

	$objPHPExcel = new PHPExcel();

	//$objReader = new PHPExcel_Reader_Excel2007(); /*.xlsx*/
	$objReader = new PHPExcel_Reader_Excel5();
	$objReader->setReadDataOnly(true);
	$objPHPExcel = $objReader->load($xls_file);

	$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();

	$array_data = array();
	foreach($rowIterator as $row){
    	$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
		if(1 == $row->getRowIndex ()) continue;//skip first row
		$rowIndex = $row->getRowIndex ();
		$array_data[$rowIndex] = array('no'=>'','product_category'=>'','type_code'=>'','product_name'=>'','type_name'=>'','color_group'=>'','color_image'=>'','type_price'=>'','type_description'=>'','type_weight'=>'','size_type'=>'','quantity'=>'','image1'=>'','image2'=>'','image3'=>'','image4'=>'','image5'=>'');
 
		foreach ($cellIterator as $cell) {
        	if('A' == $cell->getColumn()){
            	$array_data[$rowIndex]["no"] = $cell->getCalculatedValue();
	        } else if('B' == $cell->getColumn()){
	            $array_data[$rowIndex]["product_category"] = $cell->getCalculatedValue();
	        } else if('C' == $cell->getColumn()){
	            $array_data[$rowIndex]["type_code"] = $cell->getCalculatedValue();
	        } else if('D' == $cell->getColumn()){
	            $array_data[$rowIndex]["product_name"] = $cell->getCalculatedValue();
	        } else if('E' == $cell->getColumn()){
		        $array_data[$rowIndex]["type_name"] = $cell->getCalculatedValue();
	     	} else if('F' == $cell->getColumn()){
			    $array_data[$rowIndex]["color_group"] = $cell->getCalculatedValue();
		   	} else if('G' == $cell->getColumn()){
		    	$array_data[$rowIndex]["color_image"] = $cell->getCalculatedValue();
			} else if('H' == $cell->getColumn()){
			    $array_data[$rowIndex]["type_price"] = $cell->getCalculatedValue();
			
			} else if('I' == $cell->getColumn()){
			    $array_data[$rowIndex]["type_description"] = $cell->getCalculatedValue();
			
			} else if('J' == $cell->getColumn()){
			    $array_data[$rowIndex]["type_weight"] = $cell->getCalculatedValue();
			
			} else if('K' == $cell->getColumn()){
			    $array_data[$rowIndex]["size_type"] = $cell->getCalculatedValue();
			
			} else if('L' == $cell->getColumn()){
			    $array_data[$rowIndex]["quantity"] = $cell->getCalculatedValue();
			
			} else if('M' == $cell->getColumn()){
			    $array_data[$rowIndex]["image1"] = $cell->getCalculatedValue();
			
			} else if('N' == $cell->getColumn()){
			    $array_data[$rowIndex]["image2"] = $cell->getCalculatedValue();
			
			} else if('O' == $cell->getColumn()){
			    $array_data[$rowIndex]["image3"] = $cell->getCalculatedValue();
			
			} else if('P' == $cell->getColumn()){
			    $array_data[$rowIndex]["image4"] = $cell->getCalculatedValue();
			
			} else if('Q' == $cell->getColumn()){
			    $array_data[$rowIndex]["image5"] = $cell->getCalculatedValue();
			}
			

		}//foreach cell
	}//foreach row

$result = translate($array_data);
insert_database_multiple($result);
}

function translate($array_data){
	$conn = connDB();
	
	$result['product_name_array'] = array();
	$result['type_code_array'] = array();
	$result['type_name_array'] = array();
	$result['type_price_array'] = array();
	$result['type_description_array'] = array();
	$result['type_weight_array'] = array();
	$result['color_image_array'] = array();
	$result['product_category_array'] = array();
	$result['color_id_array'] = array();
	$result['type_image_array'] = array();
	$result['product_size_type_id_array'] = array();
	$result['product_stock_array'] = array();

	$counter=0;
	foreach ($array_data as $one_row){
	
		array_push($result['type_code_array'],$one_row["type_code"]);
		array_push($result['product_name_array'],$one_row["product_name"]);
		array_push($result['type_name_array'],$one_row["type_name"]);
		array_push($result['type_price_array'],$one_row["type_price"]);
		array_push($result['type_description_array'],addslashes($one_row["type_description"]));
		array_push($result['type_weight_array'],$one_row["type_weight"]);
	
	
	
		//image
		$image_array = array ($one_row["image1"],$one_row["image2"],$one_row["image3"],$one_row["image4"],$one_row["image5"]);
		array_push($result['type_image_array'],$image_array);
	
	
		//category
		$category_name = $one_row["product_category"];
		$get_id = mysql_query("
			SELECT * from tbl_category
			WHERE category_name = '$category_name'
			ORDER BY category_id DESC
		",$conn);
	
		if (mysql_num_rows($get_id)!=null){
			$get_id_array = mysql_fetch_array($get_id);
			$category_id = $get_id_array["category_id"];
			array_push($result['product_category_array'],$category_id);
		}
		else{
			array_push($result['product_category_array'],"");
		}
	
	
		//color
		$color_name = $one_row["color_group"];
		$get_id = mysql_query("
			SELECT * from tbl_color
			WHERE color_name = '$color_name'
			ORDER BY color_id DESC
		",$conn);
	
		if (mysql_num_rows($get_id)!=null){
			$get_id_array = mysql_fetch_array($get_id);
			$color_id_ = $get_id_array["color_id"];
			array_push($result['color_id_array'],$color_id_);
			$color_image = $get_id_array["color_image"];
		}
		else{
			array_push($result['color_id_array'],"");
			$color_image="";
		}
		
		if ($one_row["color_image"]!="default"){
			array_push($result['color_image_array'],"files/uploads/products/".$one_row["color_image"]);
		}
		else{
			array_push($result['color_image_array'],$color_image);
		}
	
	
		//size
		$size_type_name = $one_row["size_type"];
		$get_id = mysql_query("
			SELECT * from tbl_size_type
			WHERE size_type_name = '$size_type_name'
			ORDER BY size_type_id DESC
		",$conn);
	
		if (mysql_num_rows($get_id)!=null){
			$get_id_array = mysql_fetch_array($get_id);
			$size_type_id_ = $get_id_array["size_type_id"];
			array_push($result['product_size_type_id_array'],$size_type_id_);
			//echo $size_type_id_;
		}
		else{
			array_push($result['product_size_type_id_array'],"");
			
		}
	
		
		
		//quantity
		$tmp_array = array();
		$tmp_array = explode(",",$one_row["quantity"]);
		
		foreach ($tmp_array as $tmp){
			$tmp2 = array();
			$tmp2 = explode(":",$tmp);
			$stock_name = $tmp2[0];
			$stock_quantity = $tmp2[1];
			$result['product_stock_array'][$counter][$stock_name] = $stock_quantity;
			
			//echo $stock_name.$stock_quantity;
		}
	
		$counter++;
	}//foreach
	
	return $result;
}

function insert_database_multiple($result){
	$conn = connDB();
	
	date_default_timezone_set("Asia/Jakarta");
	$date = date('Y-m-d');


	$type_code = current($result['type_code_array']);
	$type_name = current($result['type_name_array']);
	$type_price = current($result['type_price_array']);
	$type_description = current($result['type_description_array']);
	$type_weight = current($result['type_weight_array']);
	$color_image = current($result['color_image_array']);
	$product_category = current($result['product_category_array']);
	$color_id = current($result['color_id_array']);
	$type_image = current($result['type_image_array']);
	$product_size_type_id = current($result['product_size_type_id_array']);
	$product_stock = current($result['product_stock_array']);
	
	foreach ($result['product_name_array'] as $product_name){
		$type_alias = cleanurl($type_name);
		
		$get_id = mysql_query("
			SELECT * from tbl_product
			WHERE product_name = '$product_name'
			ORDER BY id DESC
		",$conn);
	
		if (mysql_num_rows($get_id)!=null){
			$get_id_array = mysql_fetch_array($get_id);
			$product_id = $get_id_array["id"];
			
		}
		else{
			$get_order = mysql_query("
				SELECT * from tbl_product
				ORDER BY product_order DESC
			",$conn);
	
			if (mysql_num_rows($get_order)!=null){
				$get_order_array = mysql_fetch_array($get_order);
				$product_order = $get_order_array["product_order"]*1+1;
			}
			
			$product_alias = get_alias($product_name);
			
			
			
			mysql_query("
				INSERT INTO tbl_product(product_category, product_name,product_size_type_id,product_date_added,product_order,product_alias,page_title)
				VALUES('$product_category', '$product_name','$product_size_type_id','$date','$product_order','$product_alias','$product_name')
	
			",$conn);
			
			
	
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
		
		//type
		mysql_query("
			INSERT INTO tbl_product_type(type_code,type_name,type_price,type_image,type_description,color_id,type_weight,type_alias,product_id,page_title)
			VALUES ('$type_code','$type_name','$type_price','$color_image','$type_description','$color_id','$type_weight','$type_alias','$product_id','$product_name')
			
		",$conn);
		
		$sql_ = "SELECT * from tbl_product_type
		WHERE type_code='$type_code' AND type_name='$type_name' AND type_description='$type_description' AND type_price='$type_price'
		ORDER BY type_id DESC";
		
		//echo $sql_;
		$get_id2 = mysql_query($sql_
		,$conn);
		
		if (mysql_num_rows($get_id2)!=null){
			$get_id2_array = mysql_fetch_array($get_id2);
			$type_id = $get_id2_array["type_id"];
		}
		
		
		//image
		$image_order=1;
		foreach ($type_image as $img_src){ 
			if ($img_src!=""){
			$img_src = "files/uploads/products/".$date."/".$img_src;
			mysql_query("
				INSERT INTO tbl_product_image(type_id,img_src,image_order)
				VALUES ('$type_id','$img_src','$image_order')
	
			",$conn);
			}
			$image_order++;
			
		}
		
		//stock
		foreach ($product_stock as $stock_name => $stock_quantity){
			if ($stock_quantity==""||$stock_quantity=="0"){
				$stock_sold_out = 1;
			}
			else{
				$stock_sold_out = 0;
			}
			
			$check = mysql_query("
				SELECT * from tbl_product_stock
				WHERE type_id='$type_id' AND stock_name='$stock_name'
				
			",$conn);
			
			if (mysql_num_rows($check)!=null){
				$check_array = mysql_fetch_array($check);
				$stock_id = $check_array["stock_id"];
				
				mysql_query("
					UPDATE tbl_product_stock
					SET stock_quantity='$stock_quantity', stock_sold_out = '$stock_sold_out'
					WHERE stock_id='$stock_id'
				",$conn);
			}
			else{
				//echo $stock_name.$stock_quantity.$type_id.'<br/>';
				mysql_query("
					INSERT INTO tbl_product_stock(type_id,stock_name,stock_quantity,stock_sold_out)
					VALUES ('$type_id','$stock_name','$stock_quantity','$stock_sold_out')
	
				",$conn);
			}
		}
		
		
		$type_code = next($result['type_code_array']);
		$type_name = next($result['type_name_array']);
		$type_price = next($result['type_price_array']);
		$type_description = next($result['type_description_array']);
		$type_weight = next($result['type_weight_array']);
		$color_image = next($result['color_image_array']);
		$product_category = next($result['product_category_array']);
		$color_id = next($result['color_id_array']);
		$type_image = next($result['type_image_array']);
		$product_size_type_id = next($result['product_size_type_id_array']);
		$product_stock = next($result['product_stock_array']);
	}

}

function get_alias($product_name,$trial=0){	
	$conn = connDB();
																
	$product_name = preg_replace('/[^a-zA-Z0-9\s\/\-+_\|]/','',$product_name);
	$product_name = strtolower($product_name);
	$product_name = preg_replace('/[\s\/\-+_\|]/','-',$product_name);
								
	if($trial!=0){
		$product_name = $product_name . '-' . $trial;
	}
								
	$check = mysql_query("SELECT * from tbl_product WHERE product_alias='$product_name'",$conn);
	

	if (mysql_num_rows($check)!=null){
		$trial++;
		get_alias($product_name,$trial);
	}
	else{
		return $product_name;
	}							
								
}
?>