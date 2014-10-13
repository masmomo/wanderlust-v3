<?php
/*
# ----------------------------------------------------------------------
# CUSTOMS
# ----------------------------------------------------------------------
*/


/*
# ----------------------------------------------------------------------
# NEWS
# ----------------------------------------------------------------------
*/


/* --- NEWS EDIT --- */
if(isset($_POST['btn-edited-news'])){
   if($_POST['btn-edited-news'] == "Save Changes"){
	  $nid = $_POST['hidden_id'];
	  $nit = $_POST['hidden_title'];
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news-edit/".$nid."/".cleanurl($nit));
   }else{
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news");
   }
   
   
/* --- NEWS LISTING --- */
}else if(isset($_POST['btn-index-news-listing'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news");
   
   
/* --- ADD NEWS --- */
}else if(isset($_POST['btn-add-news'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-news");
   

/* --- NEWS CATEGORY--- */
}else if(isset($_POST['btn_detail_news_category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news-category-detail/".$_POST['hidden_category_id'].'/'.cleanurl($_POST['hidden_category_name']));
}else if(isset($_POST['btn_insert_news_category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-news-category");
}else if(isset($_POST['btn_index_news_category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news-category");



/*
# ----------------------------------------------------------------------
# RECIPE
# ----------------------------------------------------------------------
*/


/* --- ADD RECIPE--- */ 
}else if(isset($_POST['btn-add-recipe'])){
   
   if($_POST['btn-add-recipe'] == "Save Changes"){
	  
	  if(empty($_POST['category_id'])){
         header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-category-added");
	  }else{
         header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-category-edited");
	  }
   
   
   /* --- DELETE RECIPE --- */	  
   }else if($_POST['btn-add-recipe'] == "Delete"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-category-deleted");
   
   
   /* --- ADD RECIPE --- */	  
   }else if($_POST['btn-add-recipe'] == "GO"){
      if(!empty($_POST['array_category_id'])){
	     header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-category-deleted");
	  }
   }

}


/* --- RECIPE INDEX --- */	
else if(isset($_POST['btn-index-recipes'])){
   
   if($_POST['btn-edit-recipes'] == "Save Changes & Exit"){
	   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe");
   }
   
}


/* --- DESIGNER --- */	
else if(isset($_POST['btn_add_designer'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/designers");
}


/* --- VOUCHER --- */	
else if(isset($_POST['btn_voucher_submit'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/voucher-manager");



/* --- SHIPPING --- */	
}else if(isset($_POST['btn-add-shipping'])){
   
   if($_POST['btn-add-shipping'] == "Save Changes & Exit"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping");
   }else if($_POST['btn-add-shipping'] == "Save Changes"){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping/".$_REQUEST['sid']);
   }

}

// NEW ARRIVAL
else if(isset($_POST['btn_submit_new_arrival'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/new-arrivals");
   
}


// TAGS
else if(isset($_POST['btn_index_tag'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/tag");
}else if(isset($_POST['btn_detail_tag'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/detail-tag/".$_POST['hidden_category_id'].'/'.$_POST['category_name']);
}else if(isset($_POST['btn_add_tag'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-tag");
}


// TAGS WOOD
else if(isset($_POST['btn_index_tagging'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/tagging");
}else if(isset($_POST['btn_detail_tagging'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/detail-tagging/".$_POST['hidden_category_id'].'/'.$_POST['category_name']);
}else if(isset($_POST['btn_add_tagging'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-tagging");
}


// INSPIRATION
if(isset($_POST['btn_add_inspiration'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-project");
}else if(isset($_POST['btn_edit_inspiration'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/project-detail/".$_POST['inspiration_id']);
}else if(isset($_POST['btn_index_inspiration'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/project");
}else if(isset($_POST['btn_detail_project_category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/project-category-detail/".$_POST['hidden_category_id']);
}else if(isset($_POST['btn_pop_category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/project-category");
}


// CAREERS
else if(isset($_POST['btn_index_department'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/career-department");
}else if(isset($_POST['btn_add_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-department");
}else if(isset($_POST['btn_detail_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/career-department-detail/".$_POST['cat_id']."/".$_POST['hidden_department']);
}else if(isset($_POST['btn_index_job'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/career");
}else if(isset($_POST['btn_add_job'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-career");
}else if(isset($_POST['btn_detail_job'])){
   
   if($_POST['btn_detail_job'] == 'Delete'){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/career");
   }else{
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/career-detail/".$_POST['cat_id']."/".$_POST['hidden_name']);
   }
   
}


// STORE
else if(isset($_POST['btn_index_store_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/store-city");
}else if(isset($_POST['btn_add_store_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-city");
}else if(isset($_POST['btn_detail_store_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/store-city-detail/".$_POST['cat_id']."/".$_POST['hidden_department']);
}else if(isset($_POST['btn_index_store_job'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/store");
}else if(isset($_POST['btn_add_store_job'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-store");
}else if(isset($_POST['btn_detail_store_job'])){
   
   if($_POST['btn_detail_store_job'] == 'Delete'){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/store");
   }else{
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/store-detail/".$_POST['cat_id']."/".$_POST['hidden_name']);
   }
   
}


// SERVICE
else if(isset($_POST['btn_index_service_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/service-city");
}else if(isset($_POST['btn_add_service_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-service-city");
}else if(isset($_POST['btn_detail_service_city'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/service-city-detail/".$_POST['cat_id']."/".$_POST['hidden_department']);
}else if(isset($_POST['btn_index_service_job'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/service");
}else if(isset($_POST['btn_add_service_job'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-service");
}else if(isset($_POST['btn_detail_service_job'])){
   
   if($_POST['btn_detail_service_job'] == 'Delete'){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/service");
   }else{
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/service-detail/".$_POST['cat_id']."/".$_POST['hidden_name']);
   }
   
}


// FILTER
if(isset($_POST['btn_add_filter'])){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-filter");
}else if(isset($_POST['btn_detail_filter'])){
   
   if($_POST['btn_detail_filter'] == 'Delete'){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/filter");
   }else{
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/filter-detail/".$_POST['cat_id']."/".cleanurl($_POST['category_name']));
   }
}


// FILTER (substrat)
if(isset($_POST['btn_index_filter_sub'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/filter-substrat");
}else if(isset($_POST['btn_add_filter_sub'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/add-filter-substrat");
}else if(isset($_POST['btn_detail_filter_sub'])){
   
   if($_POST['btn_detail_filter_sub'] == 'Delete'){
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/filter-substrat");
   }else{
      header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/filter-substrat-detail/".$_POST['cat_id']."/".cleanurl($_POST['category_name']));
   }
}

// CATEGORY

if(isset($_POST['btn_detail_collection'])){
   header('location: '.$_SERVER['REQUEST_URI']);
}
else if(isset($_POST['btn-collection-index'])){
   header('location: '.$_SERVER['REQUEST_URI']);
}

/*
* ----------------------------------------------------------------------
* DUAL LANGUAGE
* ----------------------------------------------------------------------
*/

// ABOUT
else if(isset($_POST['btn_about_lang'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$_SESSION['lang_admin']."-about");
}


/* -- NEWS -- */

// NEWS
else if(isset($_POST['btn_custom_news_lang'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$_SESSION['lang_admin']."-news-edit/".$_POST['news_id']."/".cleanurl($_POST['ct_post_news_title']));
}else if(isset($_POST['btn_detail_news_category_lang'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$_SESSION['lang_admin']."-news-category-detail/".$_POST['hidden_category_id']."/".cleanurl($_POST['hidden_category_name']));
}


/* -- PRODUCT -- */

// CATEGORY
else if(isset($_POST['btn_lang_detail_category'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$_SESSION['lang_admin']."-detail-category/".$_POST['hidden_category_id']."/".cleanurl($_POST['category_name']));
}

// PRODUCT
else if(isset($_POST['btn_product_lang'])){
   header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$_SESSION['lang_admin']."-product-details-".$_POST['product_alias']);
}


?>