<?php
function get_category(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_inspiration_category ORDER BY `category_order`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;

}


function get_inspiration($post_inspiration_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_inspiration WHERE `inspiration_id` = '$post_inspiration_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_inspiration_image($post_inspiration_id, $post_inspiration_image_id){
   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration_image WHERE `param_inspiration_id` = '$post_inspiration_id' AND `inspiration_image_id` = '$post_inspiration_image_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_inspiration_images($post_inspiration_id){
   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration_image WHERE `param_inspiration_id` = '$post_inspiration_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_latest_inspiration_image_id(){
   $conn   = conndB();
   
   $sql    = "SELECT MAX(inspiration_image_id) AS latest_id FROM tbl_inspiration_image";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_inspiration_images($post_inspiration_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_inspiration_image WHERE `param_inspiration_id` = '$post_inspiration_id' ORDER BY `order`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;
}


function get_inspiration_image($post_inspiration_image_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_inspiration_image WHERE `inspiration_image_id` = '$post_inspiration_image_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
   
}


function get_inspiration_latest_id(){
   $conn   = connDB();
   
   $sql    = "SELECT MAX(inspiration_id) AS latest_inspiration_id FROM tbl_inspiration";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
   
}



/* -- INSPIRATION FEATURED -- */


function get_inspiration_featured($post_inspiration_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_inspiration_featured WHERE `param_inspiration_id` = '$post_inspiration_id' ORDER BY inspiration_featured_id ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;
}


function get_products(){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_product AS prod_ LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
                                                 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
              
			  WHERE `type_delete` = '0' AND `type_visibility` = '1'
			  GROUP BY `id`
			  ORDER BY `product_name`
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_product($post_param_inspiration_id, $post_product_type_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM `tbl_inspiration_featured` WHERE `param_inspiration_id` = '$post_param_inspiration_id' AND `product_type_id` = '$post_product_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

?>