<?php



/* -- FUNCTIONS -- */
function get_product_id_filter(){
   $conn   = connDB();
   
   $sql    = "SELECT MAX(id) as product_id FROM tbl_product";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


function custom_filter_insert($post_filter_param, $post_product_param){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_filter_item (`filter_param`, `product_param`)
                                     VALUES('$post_filter_param', '$post_product_param')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
   
}



// CONTROL
if(isset($_POST['add-product'])){
	
   // CALL FUNCTION
   $filter_product_id = get_product_id_filter();
   
   // DEFINED VARIABLE
   $product_param = $filter_product_id['product_id'];
   $filter_param  = $_POST['filter_id'];
   
   foreach($filter_param as $filter_param){
      custom_filter_insert($filter_param, $product_param);
   }
   
}
?>