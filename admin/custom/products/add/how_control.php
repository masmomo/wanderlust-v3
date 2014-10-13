<?php
function insert_how($post_product_id, $post_how, $post_technical){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_product_custom (`product_id`, `how`, `technical`)
                                      VALUES('$post_product_id', '$post_how', '$post_technical')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function get_product_id_how(){
   $conn  = connDB();
   
   $sql    = "SELECT MAX(id) as product_id FROM tbl_product";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


if(isset($_POST['add-product'])){
   
   // CALL FUNCTION
   $how_product_id = get_product_id_how();
   
   // DEFINED VARIABLE
   
   $how       = $_POST['how'];
   $technical = $_POST['technical'];
   
   insert_how($how_product_id['product_id'], $how, $technical);
   
}

?>