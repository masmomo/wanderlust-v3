<?php
function insert_how($post_product_id, $post_how, $post_technical){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_product_custom (`product_id`, `how`, `technical`)
                                      VALUES('$post_product_id', '$post_how', '$post_technical')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_how($post_how, $post_technical, $post_product_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_product_custom SET `how` = '$post_how', `technical` = '$post_technical' WHERE `product_id` = '$post_product_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function get_product_id_how($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


if(isset($_POST['btn-product-detail'])){
   
   // REQUEST VARIABLE
   $req_prod_how = $_REQUEST['product_alias'];
   
   
   // CALL FUNCTION
   $how_product_id = get_product_id_how($req_prod_how);
   
   
   // DEFINED VARIABLE
   $how       = $_POST['how'];
   $technical = $_POST['technical'];
   
   update_how($how, $technical, $how_product_id['id']);
   
}
?>