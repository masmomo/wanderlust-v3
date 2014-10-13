<?php
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('category_active_status', 'category_visibility_status');
$default_sort_by = "category_order";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];

$parent_id        = $_REQUEST['cid'];
$parent           = get_parent($parent_id);


$full_order  = count_category($parent['relation_level'] + 1, $parent_id, $search_query, $sort_by ,$query_per_page);
$total_query = $full_order['total_query'];
$total_page  = ceil($full_order['total_query'] / $query_per_page);

// CALL FUNCTION
$listing_order = get_categories($parent['relation_level'] + 1, $parent_id, $search_query, $sort_by, $first_record ,$query_per_page);


// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "category_name DESC"){
   $arr_order_number = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_name"){
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}else{
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/child-category-view/".$_REQUEST['cid']."/".$_REQUEST['cname']."\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".ceil($full_order['total_query'] / $query_per_page)."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";


/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}



if($_POST['category-action'] == "delete"){

   if($_POST['category-option'] == "yes"){
      //echo "Deleted";
   }else if($_POST['category-option'] == "no"){
      //echo "Save";
   } 

}else if($_POST['category-action'] == "save"){

   if($_POST['category-option'] == "yes"){
      //echo "save yes";
   }else if($_POST['category-option'] == "no"){
      //echo "Save no";
   } 

}

if($_POST['btn-index-category'] == "Save Changes"){
  
   $conn = connDB();
  
   $category_name        = $_POST['category_name'];
   $category_description = $_POST['category_description'];
   $post_active_status   = $_POST['active_status'];
   $visibility_status    = $_POST['visibility_status'];
   $category_parent      = $_POST['category_parent'];
   $category_id          = $_POST['cat_id'];
  
   if(empty($category_id)){
      $get_order = mysql_query("SELECT * from tbl_category ORDER BY category_order DESC",$conn);
	  
	  if (mysql_num_rows($get_order)!=null){
         $get_order_array = mysql_fetch_array($get_order);
	     $category_order  = $get_order_array["category_order"]*1+1;
      }
	  
	  mysql_query(" INSERT INTO tbl_category
	                (category_name,category_order,category_active_status,category_visibility_status) 
				    VALUES('$category_name','$category_order','$post_active_status','$visibility_status')",$conn);
   
   
      $get_id = mysql_query("SELECT * from tbl_category WHERE category_name = '$category_name' ORDER BY category_id DESC",$conn);
   
      if (mysql_num_rows($get_id)!=null){
         $get_id_array = mysql_fetch_array($get_id);
	     $category_id  = $get_id_array["category_id"];
      }
	  
	  $parent_array = array();
	  $get_parent   = mysql_query("SELECT * from tbl_category_relation WHERE category_child='$category_parent'",$conn);
	  
	  if (mysql_num_rows($get_parent)!=null){
	     
		 for($counter=1;$counter<=mysql_num_rows($get_parent);$counter++){
	        $get_parent_array = mysql_fetch_array($get_parent);
		    $tmp_level        = $get_parent_array["relation_level"];
		    $tmp_parent       = $get_parent_array["category_parent"];
		    $parent_array[$tmp_level]=$tmp_parent;
         }	
		 
      }
	  
	  mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','1')",$conn);
	  
	  foreach($parent_array as $level => $parent){
	     $new_level = $level*1+1;
	     mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level)VALUES('$category_id','$parent','$new_level')",$conn);
		 
		 if ($parent=='top'){
            $category_level = $level;
         }
		 
      }
	  
   //}else if(!empty($category_id)){
      mysql_query("UPDATE tbl_category SET category_level = '$category_level' WHERE category_id = '$category_id'",$conn);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Item(s) has been successfully added.";
	  
   }else if(!empty($category_id)){
	   
	   $new_id          = mysql_query("SELECT MAX(category_id) AS new_id FROM tbl_category",$conn);
	   
	   $new_id = (int) $new_id['new_id'] + 1;
	   $update_product  = mysql_query("UPDATE tbl_product SET `product_category` = '$new_id' WHERE `product_category` = '$category_id' MAX(category_id) AS new_id FROM tbl_category",$conn);
	   
	   $delete_relation = mysql_query("DELETE FROM tbl_category_relation WHERE `category_child` = '$category_id'",$conn);
	   $delete_root     = mysql_query("DELETE FROM tbl_category WHERE `category_id` = '$category_id'",$conn);
	   
	  /* UPDATE */
	  
      $get_order = mysql_query("SELECT * from tbl_category ORDER BY category_order DESC",$conn);
	  
	  if (mysql_num_rows($get_order)!=null){
         $get_order_array = mysql_fetch_array($get_order);
	     $category_order  = $get_order_array["category_order"]*1+1;
      }
	  
	  mysql_query(" INSERT INTO tbl_category
	                (category_name,category_order,category_active_status,category_visibility_status) 
				    VALUES('$category_name','$category_order','$post_active_status','$visibility_status')",$conn);
   
   
      $get_id = mysql_query("SELECT * from tbl_category WHERE category_name = '$category_name' ORDER BY category_id DESC",$conn);
   
      if (mysql_num_rows($get_id)!=null){
         $get_id_array = mysql_fetch_array($get_id);
	     $category_id  = $get_id_array["category_id"];
      }
	  
	  $parent_array = array();
	  $get_parent   = mysql_query("SELECT * from tbl_category_relation WHERE category_child='$category_parent'",$conn);
	  
	  if (mysql_num_rows($get_parent)!=null){
	     
		 for($counter=1;$counter<=mysql_num_rows($get_parent);$counter++){
	        $get_parent_array = mysql_fetch_array($get_parent);
		    $tmp_level        = $get_parent_array["relation_level"];
		    $tmp_parent       = $get_parent_array["category_parent"];
		    $parent_array[$tmp_level]=$tmp_parent;
         }	
		 
      }
	  
	  mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','1')",$conn);
	  
	  foreach($parent_array as $level => $parent){
	     $new_level = $level*1+1;
	     mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level)VALUES('$category_id','$parent','$new_level')",$conn);
		 
		 if ($parent=='top'){
            $category_level = $level;
         }
		 
      }
	  
   //}else if(!empty($category_id)){
      mysql_query("UPDATE tbl_category SET category_level = '$category_level' WHERE category_id = '$category_id'",$conn);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Changes have been successfully saved.";
      
   }
   
   ?>
   <script>
      //alert("Success insert <?php echo $category_name;?> into database");
   </script>
   <?php
   
   
}else if($_POST['btn-index-category'] == "Delete"){
   // DEFINED VARIABLE
   $category_id   = $_POST['cat_id'];
   
   // CALL FUNCTION
   $conn = connDB();
   $check_delete        = check_delete($category_id);
   $category_check_name = check_delete_get_category_name($category_id);
   $validate_delete     = getTotal($category_id);
   
   if($validate_delete['total_product'] > 0){
      $_SESSION['alert'] = "error";
	  $_SESSION['msg']   = "Can't delete because it contains one or more items.";
   }else{
   
      $get_order = mysql_query("SELECT * from tbl_category WHERE category_id = '$category_id'",$conn);
   
      if (mysql_num_rows($get_order)!=null){
         $get_order_array = mysql_fetch_array($get_order);
	     $category_order  = $get_order_array["category_order"];
      }
   
      mysql_query("UPDATE tbl_category SET category_order = category_order-1 WHERE category_order > '$category_order'",$conn);
   
      //$category_parent_redirect = $_GET["parent_category"];
      mysql_query("DELETE FROM tbl_category WHERE category_id = '$category_id'",$conn);
   
      $category_relation = mysql_query("SELECT * from tbl_category_relation WHERE category_parent = '$category_id'",$conn);
   
      if (mysql_num_rows($category_relation)!=null){
      
	     for ($counter=1;$counter<=mysql_num_rows($category_relation);$counter++){
	        $category_relation_array = mysql_fetch_array($category_relation);
		    $category_child = $category_relation_array["category_child"];
		 
		    mysql_query("DELETE FROM tbl_category_relation WHERE category_parent = '$category_child'",$conn);
		    mysql_query("DELETE FROM tbl_category WHERE category_id = '$category_child'",$conn);
         }
      }
   
      mysql_query("DELETE FROM tbl_category_relation WHERE category_child = '$category_id' OR category_parent = '$category_id'",$conn);
   
   }//END CHECK
   
   $_SESSION['alert'] = "success";
   $_SESSION['msg']   = "Item(s) has been successfully deleted.";
   
}else if($_POST['btn-index-category'] == "GO"){
   
   if($_POST['category-action'] == "delete" || $_POST['category-option'] == "yes"){
	  
	  foreach($_POST['category_id'] as $category_id){
		 // CALL FUNCTION
		 $check_delete        = check_delete($category_id);
		 $category_check_name = check_delete_get_category_name($category_id);
		 $validate_delete     = getTotal($category_id);
		 
		 if($validate_delete['total_product'] > 0){
	        $_SESSION['alert'] = "error";
			$_SESSION['msg']   = "Can't delete because it contains one or more items.";
		 }else{
            mysql_query("DELETE FROM tbl_category WHERE category_id = '$category_id'",$conn);
			
			$_SESSION['alert'] = "success";
			$_SESSION['msg']   = "Item(s) has been successfully deleted.";
		 }
	  
	  }
	  
   }
   
}



// SHOW CATEGORY
function listCategory($level,$parent,$current_category){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level = $level*1+1;
		 $new_parent = $get_data_array["category_id"];
		 echo '<option class="option_level_'.$level.'" data-level="'.$level.'" id="option_level_'.$level.'"';
		 if ($current_category==$new_parent."'"){
			echo "selected=selected";
		 }
		 
		 echo ' value="'.$new_parent.'">';
		 
		 for ($i=0;$i<$level;$i++){
			echo '-- ';
		 }
		 
		 echo $get_data_array["category_name"].'</option>';
		 listCategory($new_level,$new_parent,$current_category);
      }
   }
}


// SHOW LISTING
function showCategory($level,$parent,$current_category, $one, $two, $three, $four,$tot_query, $row){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT 
                            cat.category_id, cat.category_name, cat.category_level, cat.category_order, cat.category_active_status, cat.category_visibility_status,
							rel.relation_id, rel.category_child, rel.category_parent, rel.relation_level,
							COUNT( prod.id ) AS total_product, prod.product_name
							
							FROM tbl_category AS cat LEFT JOIN tbl_product AS prod ON cat.category_id = prod.product_category
							                         INNER JOIN tbl_category_relation AS rel ON cat.category_id = rel.category_child
							WHERE $one AND cat.category_level = '$level' AND rel.category_parent = '$parent'
							GROUP BY category_id
							ORDER BY $two 
							LIMIT  $three, $four
						   ",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
		 
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		 
		 $cat_name       = $get_data_array['category_name'];
		 $cat_active     = $get_data_array['category_active_status'];
		 $cat_visibility = $get_data_array['category_visibility_status'];
		 
		 echo "<tr class=\"odd\" id=\"row_".$row."\" onclick=\"selectRow('".$row."')\">";
		 echo "<td><input type=\"checkbox\" name=\"category_id[]\" value=\"".$new_parent."\" id=\"check_".$row."\" onmouseover=\"downCheck()\" onmouseout=\"upCheck()\" onclick=\"selectRowCheck('".$row."')\"></td>";
		 echo "<td><a href=\"#\"";
		 echo "category_name=\"ucwords(strtolower(".$cat_name."))\""; 
		 echo "active=\"".$cat_active."\"";
		 echo "cat_id=\"".$new_parent."\"";
		 echo "visible=\"".$cat_visibility."\"";
		 echo "id=\"link-category-".$new_parent."\">";
		 for ($i=0;$i<$level;$i++){
			echo '-- ';
		 }
		 echo ucwords(strtolower($cat_name))."</a></td>";
		 echo "<td class=\"tr\"><a href=\"\">".$get_data_array['total_product']."</a></td>";
		 echo "<td>".$cat_active."</td>";
		 echo "<td>".$cat_visibility."</td>";
		 echo "</tr>";
		 
		 $new_row        = ($row * 1) + 1;
	
		 showCategory($new_level,$new_parent,$current_category,$one,$two,$three,$four, $tot_query, $new_row);
      }
   }
}


if(isset($_POST['btn_child_category'])){
   
   $category_id = $_POST['category_id'];
	
   if($_POST['category-action'] == "delete"){
      foreach($category_id as $category_id){
	     delete_category($category_id);   
	  }
		
   }else if($_POST['category-action'] == "order"){
	    
      $hidden_id = $_POST['hidden_category_id'];
	  
	  foreach($hidden_id as $key=>$category_id){
	     update_order($key, $category_id); 
	  }
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Changes has been successfully saved.';
	  
   }
   
}
?>