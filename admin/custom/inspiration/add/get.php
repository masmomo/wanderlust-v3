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


function count_inspiration_image(){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration_imgae";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_inspiration_images(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_inspiration";
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
/*
function get_products(){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_product AS prod LEFT JOIN tbl_product_type AS type_ ON prod.id = type_.product_id
                                                LEFT JOIN tbl_product_stock AS stock ON type_.type_id = stock.type_id
              WHERE `type_visibility` = '1' AND `type_delete` != '1' AND `stock_quantity` != '0'
			  GROUP BY `id`
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   
   return $row;
}
*/

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

?>