<?php
function get_product_id_color($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


function custom_color_delete($post_product_id){
   $conn  = connDB();
   $sql   = "DELETE FROM tbl_product_color WHERE `product_id` = '$post_product_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function custom_color_insert($post_tag_id, $post_product_id){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_product_color (`tag_id`, `product_id`)
                                     VALUES('$post_tag_id', '$post_product_id')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
   
}


if(isset($_POST['btn-product-detail'])){
   // REQUEST VARIABLE
   $req_prod_filter = $_REQUEST['product_alias'];


   // CALL FUNCTIONS
   $color_product_id = get_product_id_color($req_prod_filter);
   
   
   // DEFINED VARIABLE
   $tag_id = $_POST['tag_id'];
   
   
   // DELETE ALL
   custom_color_delete($color_product_id['id']);
   
   
   foreach($tag_id as $key=>$tag_id){
      custom_color_insert($tag_id, $color_product_id['id']);
   }
   
}
?>
