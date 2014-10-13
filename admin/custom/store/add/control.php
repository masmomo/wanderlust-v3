<?php
/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('visibility');
$default_sort_by = "category_name";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = count_city($search_query, $sort_by, $query_per_page);
$total_query = $full_order['total_query'];
$total_page  = ceil($full_order['total_query'] / $query_per_page);

// CALL FUNCTION
$listing_order = get_city($search_query, $sort_by, $first_record, $query_per_page);


// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "category_name DESC"){
   $arr_order_number = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_name"){
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}else{
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/career-city-view\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".ceil($full_order['total_query'] / $query_per_page)."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";


if(isset($_POST['btn_add_store_city'])){
   
   // DEFINED VARIABLE
   $active     = '1';
   $visibility = $_POST['visibility_status'];
   $city_name  = stripslashes($_POST['category_name']);
   
   insert($city_name, $active, $visibility);
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Item has been successfully saved.';
   
}
?>