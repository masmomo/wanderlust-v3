<?php
// Add Category
function add_category($one, $two, $three, $four, $five, $six, $seven){
   $conn = connDB();
   
   $sql    = "INSERT INTO tbl_tags 
              (category_name, category_description, category_level, category_order, category_active_status, category_visibility_status)
			  VALUES ('$one', '$two', '$three', '$four', '$five', '$six')";
   $query  = mysql_query($sql, $conn);
}


function add_category_relation($one, $two, $three, $four){
   $conn = connDB();
   
   $sql    = "INSERT INTO tbl_tags_relation 
              (relation_id, category_child, category_parent, relation_level)
			  VALUES ('$one', '$two', '$three', '$four')";
   $query  = mysql_query($sql, $conn);
}



function delete_category($category_id){
   $conn          = connDB();
   
   $total_product = get_total_product($category_id);
   
   if($total_product != 0){
	   /*
	  mysql_query("UPDATE tbl_category SET category_active_status='inactive', category_visibility_status='0' WHERE category_id='$category_id'", $conn);
	  
	  $sql            = "SELECT * from tbl_category AS cat LEFT JOIN tbl_category_relation AS rel ON cat.category_id = rel.category_parent WHERE category_id='$category_id'";
	  $query          = mysql_query($sql, $conn);
	  $category_child = array();
	  
	  while($result = mysql_fetch_array($query)){
	     array_push($category_child, $result['category_child']);
	  }
	  
	  foreach($category_child AS $category_child_){
	     mysql_query("UPDATE tbl_category SET category_active_status='inactive', category_visibility_status='0' WHERE category_id='$category_child_'", $conn);
	  }
	  */
	  
	  $_SESSION["alert"] = 'error';
	  $_SESSION["msg"]   = "Can't delete item(s) because it contains one or more item under it.";
	  
   }else{
      $get_order = mysql_query("SELECT * from tbl_tags WHERE category_id = '$category_id'",$conn);
	  
	  if (mysql_num_rows($get_order)!=null){
	     $get_order_array = mysql_fetch_array($get_order);
		 $category_order  = $get_order_array["category_order"];
	  }
	  
	  mysql_query("UPDATE tbl_tags SET category_order = category_order-1 WHERE category_order > '$category_order'",$conn);
	  
	  //$category_parent_redirect = $_GET["parent_category"];
	  mysql_query("DELETE FROM tbl_tags WHERE category_id = '$category_id'",$conn);
	  
	  $category_relation = mysql_query("SELECT * from tbl_tags_relation WHERE category_parent = '$category_id'",$conn);
	  
	  if (mysql_num_rows($category_relation)!=null){
		  
	     for ($counter=1;$counter<=mysql_num_rows($category_relation);$counter++){
		    $category_relation_array = mysql_fetch_array($category_relation);
			$category_child = $category_relation_array["category_child"];
			
			mysql_query("DELETE FROM tbl_tags_relation WHERE category_parent = '$category_child' OR category_child = '$category_child'",$conn);
			mysql_query("DELETE FROM tbl_tags WHERE category_id = '$category_child'",$conn);
		 }
		 
	  }
	  
	  mysql_query("DELETE FROM tbl_tags_relation WHERE category_child = '$category_id' OR category_parent = '$category_id'",$conn);
	  
	  $_SESSION["alert"] = 'success';
	  $_SESSION["msg"]   = 'You successfully delete';
   }
   
}



function update_order($post_order, $post_category_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_tags SET `category_order` = '$post_order' WHERE `category_id` = '$post_category_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>