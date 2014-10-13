<?php
function get_product_details_custom(){
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
	     
		 if($counter==1){
		    //$data['product_gender']     = $get_info_array["product_gender"];
		    //$data['product_artist']     = $get_info_array["product_artist"];
		    //$data['product_series']     = $get_info_array["product_series"];
			$data['product_collection'] = $get_info_array["product_collection"];
			//$data['product_story']      = $get_info_array["product_story"];
			$data['product_sizefit']    = $get_info_array["type_sizefit"];
			//$data['product_usd']        = $get_info_array["type_price_usd"];
		 }
	  
	  }
	  	
   }
	
   $data['total_type'] = $counter-1;
   return $data;
} 

$custom_data = get_product_details_custom();
?>


<!--gender module-->
<?php
include("custom/products/add/control.php");
?>

<!--collection module-->
<?php
//include("custom/products/add/collection/control.php");
?>

<!--series module-->
<?php
//include("custom/products/add/series/control.php");
?>

<!--artist module-->
<?php
//include("custom/products/add/artist/control.php");
?>

<!--story module-->
<?php
//include("custom/products/add/story/control.php");
?>

<!--image module-->
<?php
//include("custom/products/add/image/control.php");
?>

<!--sizefit module-->
<?php
include("custom/products/add/sizefit/control.php");
?>
