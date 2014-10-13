<?php
$equal_search    = array('type_price', 'type_new_arrival');
//$null_search     = array('type_new_arrival');
$default_sort_by = 'product_name';

// CATEGORY
if ($_REQUEST["cat"] == ""|| $_REQUEST["cat"] == "top"){
   $cat = 'top';
}else{
   $cat = get_category_id($_REQUEST["cat"]);
   $cat_name = ($_REQUEST["cat"]);
}
	
$pgdata = page_init($equal_search, $default_sort_by, $equal_search); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];

/*
echo "<br>SEARCH: ".$search_query;
echo "<br>CATEGORY: ".$cat;
echo "<br>SORT BY: ".$sort_by;
echo "<br>FIRST RECORD: ".$first_record;
echo "<br>QUERY PER PAGE: ".$query_per_page;
*/

$full_product = get_product($search_query, $cat, $sort_by, $first_record, $query_per_page);

$total_query = $full_product['total_query'];
$total_page  = ceil($full_product['total_query'] / $query_per_page);
						

$all_product = all_product($search_query, $cat, $sort_by, $first_record, $query_per_page);



// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "product_name"){
   $arr_product_name = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "product_name DESC"){
   $arr_product_name = "<span class=\"sort-arrow-down\"></span>";
   
}else if($_REQUEST['srt'] == "type_name DESC"){
   $arr_type_name = "<span class=\"sort-arrow-down\"></span>";
}else if($_REQUEST['srt'] == "type_name"){
   $arr_type_name = "<span class=\"sort-arrow-up\"></span>";
									  
}else if($_REQUEST['srt'] == "type_price DESC"){
   $arr_type_price = "<span class=\"sort-arrow-down\"></span>";
}else if($_REQUEST['srt'] == "type_price"){
   $arr_type_price = "<span class=\"sort-arrow-up\"></span>";
									  
}else if($_REQUEST['srt'] == "promo_value DESC"){
   $arr_promo_value = "<span class=\"sort-arrow-down\"></span>";
}else if($_REQUEST['srt'] == "promo_value"){
   $arr_promo_value = "<span class=\"sort-arrow-up\"></span>";									  
}

/*
else if($_REQUEST['srt'] == "stock_quantity DESC"){
   $arr_stock_quantity = "<span class=\"sort-arrow-down\"></span>";
}else if($_REQUEST['srt'] == "stock_quantity"){
   $arr_stock_quantity = "<span class=\"sort-arrow-up\"></span>";
}
*/


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"".$prefix_url."new-arrivals-view\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"current_category\" id=\"current_category\" class=\"hidden\" value=\"";
	if($cat=='top'){
	   echo 'top';
	}else{
	   echo $cat_name;
	}
echo "\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".ceil($full_order['total_query'] / $query_per_page)."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";



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
		 if ($current_category == $new_parent."'"){
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

/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}



if(isset($_POST['btn_submit_new_arrival'])){
   
   if($_POST['btn_submit_new_arrival'] != "Remove All Status"){
      //DEFINED VALUE 
      $promo_id      = $_POST['category'];
      $promo_type_id = $_POST['type_id'];
      $promo_value   = clean_price($_POST['promo_value']);
      $promo_start   = cleanurl($_POST['date_from']);
      $promo_end     = cleanurl($_POST['date_to']);
   
      foreach($promo_type_id as $promo_type_id){
		 
		 $product = sale_get_type_id($promo_type_id);
		 
		 foreach($product as $product){
		    insert_new_arrival(1, $product['type_id']);
		    insert_new_arrivals($promo_start, $promo_end, $product['type_id']);
		 }
		 
      }
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Success add promo(s)";
	  
   }else if($_POST['btn_submit_new_arrival'] == "Remove All Status"){
      //deleteAllSale();
	  delete_all_new_arrivals(0);
	  delete_all_new_arrival(0);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Success delete all promo";
   }
   
}
?>