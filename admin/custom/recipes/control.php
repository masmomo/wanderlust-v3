<?php

/*
|--------------------|
|      SORTING       |
|--------------------|
*/

$equal_search    = array('type_visibility', 'total_recipes', 'category_visibility');
$default_sort_by = "recipe_name";

if ($_REQUEST["cat"] == ""|| $_REQUEST["cat"] == "top"){
   $cat   = 'top';
   $field = "additional";
}else{
   $field    = "category_recipes";
   $cat      = $_REQUEST["cat"];
   $cat_name = ($_REQUEST["cat"]);
}

$recipe_category = getAllCategory();

$pgdata = page_init($equal_search,$default_sort_by); // static/general.php

$page             = $pgdata['page'];
$query_per_page   = $pgdata['query_per_page'];
$sort_by          = $pgdata['sort_by'];
$first_record     = $pgdata['first_record'];
$search_parameter = $pgdata['search_parameter'];
$search_value     = $pgdata['search_value'];
$search_query     = $pgdata['search_query'];
$search           = $pgdata['search'];

$full_product = get_full_recipes($search_query, $field, $cat, $sort_by, $first_record, $query_per_page);
$total_query  = $full_product['total_query'];
$total_page   = $full_product['total_page']; // RESULT

// FROM get.php
$index_recipes = get_listing_recipes($search_query, $field, $cat, $sort_by, $first_record, $query_per_page);


// HANDLING ARROW SORTING
if($sort_by == "recipe_name DESC"){
   $arr_recipe_name = "<span class=\"sort-arrow-up\"></span>";
}else if($sort_by == "recipe_name"){
   $arr_recipe_name = "<span class=\"sort-arrow-down\"></span>";
			   
}else if($sort_by == "recipe_date DESC"){
   $arr_recipe_date = "<span class=\"sort-arrow-up\"></span>";
}else if($sort_by == "recipe_date"){
   $arr_recipe_date = "<span class=\"sort-arrow-down\"></span>";
									  
}else if($sort_by == "visibility_status DESC"){
   $arr_recipe_visibility = "<span class=\"sort-arrow-up\"></span>";
}else if($sort_by == "visibility_status"){
   $arr_recipe_visibility = "<span class=\"sort-arrow-down\"></span>";	  
}


// STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-view\">\n";
echo "<input type=\"hidden\" name=\"page\" id=\"page\" class=\"hidden\" value=\"".$page."\" /> \n";
echo "<input type=\"hidden\" name=\"current_category\" id=\"current_category\" class=\"hidden\" value=\"";
	if($cat=='top'){echo 'top';}
	else{echo $cat_name;}
echo "\" /> \n";
echo "<input type=\"hidden\" name=\"query_per_page\" id=\"query_per_page\" class=\"hidden\" value=\"".$query_per_page."\" /> \n";
echo "<input type=\"hidden\" name=\"total_page\" id=\"total_page\" class=\"hidden\" value=\"".$total_page."\" /> \n";
echo "<input type=\"hidden\" name=\"sort_by\" id=\"sort_by\" class=\"hidden\" value=\"".$sort_by."\" /> \n";
echo "<input type=\"hidden\" name=\"search\" id=\"search\" class=\"hidden\" value=\"".$search_parameter."-".$search_value."\" /> \n";

if(isset($_POST['btn-add-recipes'])){

   if($_POST['btn-add-recipes'] == "GO"){
      $option = $_POST['listing-option'];
	  $action = $_POST['listing-action'];
	  $array  = $_POST['array_recipe_id'];
	  
	  if($option == "delete" and $action == "yes"){
	     foreach($array as $recipe_id){
	        deleteMultiple($recipe_id);
			?>
            <script>
			location.href = "http://<?php echo $_SERVER['HTTP_HOST'],get_dirname($_SERVER['PHP_SELF'])."/recipe";?>"
			</script>
            <?php
		 }
	  }
	  
   }
	  
}
?>