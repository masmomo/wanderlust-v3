<?php
include("get.php");
include("update.php");

$equal_search = array('type_price','type_visibility');
$default_sort_by = "product_order DESC";

// CATEGORY
if ($_REQUEST["cat"] == "" || $_REQUEST["cat"] == "top"){
   $cat = 'top';
}else{
   $cat      = get_category_id($_REQUEST["cat"]);
   $cat_name = ($_REQUEST["cat"]);
}

	
$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];

$full_product = get_full_product($search_query, $sort_by, $first_record, $query_per_page, $cat);

$total_query  = $full_product['total_query'];
$total_page   = $full_product['total_page']; // RESULT
						

$all_product  = get_all_product($search_query, $sort_by, $first_record, $query_per_page, $cat);

//variable
// Category
$all_category    = get_all_category();

// Size Group
$all_size_group  = get_all_size_group();

// Color
$all_color_group = get_all_color_group();



//UPDATE
if ($_POST["btn-product-index"]=='GO'){
   
   if($_POST['product-index-action'] != 'order'){
      update_product_table();
   }else if($_POST['product-index-action'] == 'order'){
      
	  // DEFINED VARIABLE
	  $hidden_id = $_POST['hidden_product_id'];
	  $order     = $_POST['product_order'];
	  
	  foreach($hidden_id as $key=>$hidden_id){
	     update_order($key, $hidden_id);
	  }
	  
   }
   
}

// Show category
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
		 
		 echo ' value="'.$get_data_array['category_name'].'">';
		 
		 for ($i=0;$i<$level;$i++){
			echo '-- ';
		 }
		 
		 echo $get_data_array["category_name"].'</option>';
		 listCategory($new_level,$new_parent,$current_category);
      }
   }
}
?>