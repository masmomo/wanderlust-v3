<?php
/* --- CONTROL HEADER --- *//*
|--------------------|
|      SORTING       |
|--------------------|
*/


// CATEGORY
if ($_REQUEST["cat"] == "" || $_REQUEST["cat"] == "top"){
   $column_name = '';
   $opt_name    = '';
   $record_name = 1;
}else{
   $column_name = 'category_id';
   $opt_name    = ' = ';
   $record_name = $_REQUEST["cat"];
}

$equal_search     = array('news_visibility', 'news_created_date');
$default_sort_by  = "news_created_date";

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];


$full_order  = count_news($search_query, $sort_by, $query_per_page, $column_name, $opt_name, $record_name);
$total_query = $full_order['total_query'];
$total_page  = $full_order['total_page']; // RESULT


// CALL FUNCTION
$all_news = get_listing_news($search_query, $sort_by, $first_record, $query_per_page, $column_name, $opt_name, $record_name);

$count_category = count_news_category();
$get_category   = get_news_category();


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news-view\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"current_category\" id=\"current_category\" class=\"hidden\" value=\"";
	if($cat == ''){
	   echo 'top';
	}else{
	   echo $_REQUEST["cat"];
	}
echo "\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".$total_page."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";
echo "<input type=\"hidden\" name=\"alternate-url\" id=\"alternate-url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\" /> \n";


// HANDLING ARROW SORTING
if($_REQUEST['srt'] == "category_name DESC"){
   $arr_order_number = "<span class=\"sort-arrow-up\"></span>";
}else if($_REQUEST['srt'] == "category_name"){
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}else{
   $arr_order_number = "<span class=\"sort-arrow-down\"></span>";
}

/* -- BUTTON RESET -- */
if(empty($search_parameter)){
   $reset = "hidden";
}else{
   $reset = "";
}


// DEFINED VARIABLE
$news_id     = $_POST['news_id'];
$post_option = $_POST['option-option'];

if(isset($_POST['btn-index-news-listing'])){
   
   if(!empty($news_id)){
   
      if($_POST['option-action'] == 'delete'){
	  
	     foreach($news_id as $news_id){
            delete($news_id);
	     }
	  
	     $_SESSION['alert'] = 'success';
	     $_SESSION['msg']   = 'Item(s) has been successfully deleted';
	  
      }else if($_POST['option-action'] == 'visibility'){
	     
		 foreach($news_id as $news_id){
		    update($post_option, $news_id);
		 }
		 
		 $_SESSION['alert'] = 'success';
		 $_SESSION['msg']   = 'Changes has been successfully deleted';
   
      }
   
   }
   
}



/*
echo 'PAGE: '.$pgdata['page']."<br>";
echo 'QUERY PER PAGE: '.$pgdata['query_per_page']."<br>";
echo 'SORT BY: '.$pgdata['sort_by']."<br>";
echo 'FIRST RECORD: '.$pgdata['first_record']."<br>";
echo 'SEARCH PARAMETER: '.$pgdata['search_parameter']."<br>";
echo 'SEARCH VALUE: '.$pgdata['search_value']."<br>";
echo 'SEARCH QUERY: '.$pgdata['search_query']."<br>";
echo 'SEARCH: '.$pgdata['search'];
*/
?>