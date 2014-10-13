<?php
function get_courier($search, $sort_by, $first_record, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_courier
             WHERE $search
			 ORDER BY $sort_by
			 LIMIT $first_record, $query_per_page
			";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_full_courier($search, $sort_by, $first_record, $query_per_page){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_courier
             WHERE $search
			 ORDER BY $sort_by
			 LIMIT $first_record, $query_per_page
			";
   $query = mysql_query($sql, $conn);

   $full_order['total_query'] = mysql_num_rows($query);
   $full_order['total_page']  = ceil($full_order['total_query'] / $query_per_page); // 

   return $full_order;
}


/* -- EDIT -- */

?>