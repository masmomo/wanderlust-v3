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

function count_inspiration(){
   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_inspiration($post_inspiration_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_inspiration WHERE `inspiration_id` = '$post_inspiration_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_inspirations($search_query, $sort_by, $first_record, $query_per_page, $post_column_name, $post_opt_name, $post_record_name){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_inspiration AS ins LEFT JOIN tbl_inspiration_image AS img ON ins.inspiration_id = img.param_inspiration_id
                                                   LEFT JOIN tbl_inspiration_featured AS feat ON ins.inspiration_id = feat.param_inspiration_id
              WHERE $search_query AND $post_column_name $post_opt_name '$post_record_name'
			  GROUP BY inspiration_id
			  ORDER BY $sort_by
			  LIMIT $first_record, $query_per_page
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
   
}


function get_record_inspirations($search_query, $sort_by, $first_record, $query_per_page, $post_column_name, $post_opt_name, $post_record_name){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_inspiration AS ins LEFT JOIN tbl_inspiration_image AS img ON ins.inspiration_id = img.param_inspiration_id
                                                   LEFT JOIN tbl_inspiration_featured AS feat ON ins.inspiration_id = feat.param_inspiration_id
              WHERE $search_query AND $post_column_name $post_opt_name '$post_record_name'
			  GROUP BY inspiration_id
			  ORDER BY $sort_by
			 ";
   $query  = mysql_query($sql, $conn);

   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $query_per_page);
   
   return $full_order;
   
}


/* -- RELATIONS -- */

// IMAGE
function get_inspiration_image($post_inspiration_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_inspiraton_image WHERE `param_inspiration_id` = '$post_inspiration_id'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// FEATURED
function get_inspiration_featured($post_inspiration_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_inspiraton_featured WHERE `param_inspiration_id` = '$post_inspiration_id'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>