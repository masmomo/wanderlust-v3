<?php
/* -- FUNCTIONS -- */
function get_product_id_filter($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
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


function custom_filter_delete($post_product_param){
   $conn  = connDB();
   $sql   = "DELETE FROM tbl_filter_item WHERE `product_param` = '$post_product_param'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function get_filtered($post_product_param){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_filter AS filter LEFT JOIN tbl_filter_item AS items ON filter.filter_id = items.filter_param 
              WHERE `product_param` = '$post_product_param'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}



// REQUEST VARIABLE
$req_prod_filter = $_REQUEST['product_alias'];


// CALL FUNCTIONS
$filter_prod = get_product_id_filter($req_prod_filter);


// CONTROL
if(isset($_POST['btn-product-detail'])){
   
   // DEFINED VARIABLE
   $product_param = $filter_prod['id'];
   $filter_param  = $_POST['filter_id'];
   
   // DELETE FIRST
   custom_filter_delete($filter_prod['id']);
   
   // RE-INSERT
   foreach($filter_param as $filter_param){
      custom_filter_insert($filter_param, $product_param);
   }
   
}
?>