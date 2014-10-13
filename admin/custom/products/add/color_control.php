<?php
function get_product_id_color(){
   $conn   = connDB();
   
   $sql    = "SELECT MAX(id) as product_id FROM tbl_product";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


function custom_color_insert($post_tag_id, $post_product_id){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_product_color (`tag_id`, `product_id`)
                                     VALUES('$post_tag_id', '$post_product_id')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
   
}


if(isset($_POST['add-product'])){
   // CALL FUNCTION
   $color_product_id = get_product_id_color();
   
   // DEFINED VARIABLE
   $tag_id = $_POST['tag_id'];
   
   foreach($tag_id as $key=>$tag_id){
      custom_color_insert($tag_id, $color_product_id['product_id']);
   }
   
}
?>
