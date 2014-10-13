<?php
/*
# ----------------------------------------------------------------------
# SHOP INDEX
# ----------------------------------------------------------------------
*/
//MOVE TO navbar.php
//if($_REQUEST['shop_root']=='1'){
//	$_SESSION['root_cat']=$_REQUEST['shop_cat_id'];
	
//}


/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

/* --- SHOW CATEGORY --- */
function listCategory($level,$parent,$current_category){
	//SALE
	  $default_word = 'shop';
	  if($_REQUEST['sale']=='1'){
		$default_word = 'sale';
	  }
	
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child 
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' AND category_visibility_status = '1' ORDER BY category_order",$conn);
	
	 						

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter = 1; $counter <= mysql_num_rows($get_data); $counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		$product_count = count_products_cat($get_data_array['category_id']);
		if($product_count>0){
		 
		 /* --- DEFINED VARIABLE --- */
		 if(!empty($_REQUEST['shop_filter'])){
		    $req_filter = $_REQUEST['shop_filter'];
		 }else{
		    $req_filter = 'all';
		 }
		 
		 if(!empty($_REQUEST['shop_sort'])){
		    $req_sort = $_REQUEST['shop_sort'];
		 }else{
		    $req_sort = 'all';
		 }
		 
		 if(empty($_REQUEST['shop_view'])){
		    $query_per_page = 15;
		 }else{
		    $query_per_page = clean_number($_REQUEST['shop_view']);
		 }
		 
		 $post_page = 1;
		 
		//category sub
		 
		
			//$level = $level-1;
			//SALE
		 	if($_REQUEST['sale']!=1){
				$level = $level-1;
			}
			
		 
		 if($level == 0){
		    echo '<li ';
			if($get_data_array['category_id']==$_REQUEST['shop_cat_id']){
				echo ' class="active" ';
			}
			echo'>';
		    echo '<a href="http://'.$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']).'/'.$default_word.'-view/'.$get_data_array['category_id'].'/'.$req_filter.'/'.$req_sort.'/'.$post_page.'/'.$query_per_page.'".>'.$get_data_array["category_name"].'</a>';
		 }
		 
		 
		 for ($i=0;$i<$level;$i++){
			echo '<ul>';
			echo '  <li ';
			if($get_data_array['category_id']==$_REQUEST['shop_cat_id']){
				echo ' class="active" ';
			}
			echo'><a href="http://'.$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']).'/'.$default_word.'-view/'.$get_data_array['category_id'].'/'.$req_filter.'/'.$req_sort.'/'.$post_page.'/'.$query_per_page.'">'.$get_data_array["category_name"].'</a></li>';
			echo '</ul>';
		 }
		 
		 if($level == 0){
		    echo '</li>';
		 }
		
		 //category sub
		 	//$level = $level*1+1;
			//SALE
		 	if($_REQUEST['sale']!=1){
				$level = $level*1+1;
			}
		 
		 
		 listCategory($new_level,$new_parent,$current_category);
		}//product_count
      }
   }
} 


function get_category($src_param, $src_value){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category WHERE `$src_param` = '$src_value'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_products_cat($search_category){
   $conn   = connDB();
   
   $sql    = "SELECT * from (
				SELECT id,product_category FROM tbl_product AS prod_ LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id 
				WHERE type_delete != '1' AND type_visibility = '1' 
				GROUP BY id) AS table_1 
				
				LEFT JOIN tbl_category AS cat_ ON cat_.category_id = table_1.product_category
			    LEFT JOIN tbl_category_relation AS rel_ ON cat_.category_id = rel_.category_child
				WHERE category_id = '$search_category' OR category_parent = '$search_category'
				GROUP BY id
																				  
			 ";
			
   		//SALE
		   if($_REQUEST['sale']=='1'){
			$now    = date('Y-m-d');
			$sql    = "SELECT * from (
							SELECT id,product_category FROM tbl_product AS prod_ LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id 
							LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_. product_type_id
							WHERE type_delete != '1' AND type_visibility = '1' AND promo_start_datetime <= '$now'
								  AND promo_end_datetime >= '$now'
							GROUP BY id) AS table_1 

							LEFT JOIN tbl_category AS cat_ ON cat_.category_id = table_1.product_category
						    LEFT JOIN tbl_category_relation AS rel_ ON cat_.category_id = rel_.category_child
							 
						WHERE (category_id = '$search_category' OR category_parent = '$search_category')
							GROUP BY id
						 ";
		   }
   $query  = mysql_query($sql, $conn);
   //$result = mysql_fetch_array($query);
   
   return mysql_num_rows($query);

}



function count_product($search_string, $filter_string, $order_by){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_category AS cat_ LEFT JOIN tbl_product AS prod_ ON cat_.category_id = prod_.product_category
                                                 LEFT JOIN tbl_category_relation AS rel_ ON cat_.category_id = rel_.category_child
												 LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
												 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
												 LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_. product_type_id
												 LEFT JOIN tbl_new_arrival AS new_ ON type_.type_id = new_.new_type_id
			  WHERE $search_string
			  AND $filter_string
			  AND `type_delete` != '1'
			  AND `type_visibility` = '1' 
			  GROUP BY `product_id`
			  ORDER BY $order_by
			 ";
			
		//SALE
		   if($_REQUEST['sale']=='1'){
			$now    = date('Y-m-d');
			$sql    = "SELECT COUNT(*) AS rows FROM tbl_category AS cat_ LEFT JOIN tbl_product AS prod_ ON cat_.category_id = prod_.product_category
			                                                 LEFT JOIN tbl_category_relation AS rel_ ON cat_.category_id = rel_.category_child
															 LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
															 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
															 LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_. product_type_id
															 LEFT JOIN tbl_new_arrival AS new_ ON type_.type_id = new_.new_type_id
						  WHERE $search_string
						  AND $filter_string
						  AND `type_delete` != '1'
						  AND `type_visibility` = '1'
						  AND promo_start_datetime <= '$now' 
						  AND promo_end_datetime >= '$now'
						  GROUP BY `product_id`
						  ORDER BY $order_by
						 ";
		   }
   $query  = mysql_query($sql, $conn);
   $result = mysql_num_rows($query);
   
   return $result;
}

function get_product($search_string, $filter_string, $order_by, $start, $query_per_page){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category AS cat_ LEFT JOIN tbl_product AS prod_ ON cat_.category_id = prod_.product_category
                                                 LEFT JOIN tbl_category_relation AS rel_ ON cat_.category_id = rel_.category_child
												 LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
												 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
												 LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_. product_type_id
												 LEFT JOIN tbl_new_arrival AS new_ ON type_.type_id = new_.new_type_id
			  WHERE $search_string
			  AND $filter_string
			  AND `type_delete` != '1'
			  AND `type_visibility` = '1' 
			  GROUP BY `product_id`
			  ORDER BY $order_by
			  LIMIT $start, $query_per_page
			 ";
			
   		//SALE
		   if($_REQUEST['sale']=='1'){
			$now    = date('Y-m-d');
			$sql    = "SELECT * FROM tbl_category AS cat_ LEFT JOIN tbl_product AS prod_ ON cat_.category_id = prod_.product_category
			                                                 LEFT JOIN tbl_category_relation AS rel_ ON cat_.category_id = rel_.category_child
															 LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
															 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
															 LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_. product_type_id
															 LEFT JOIN tbl_new_arrival AS new_ ON type_.type_id = new_.new_type_id
						  WHERE $search_string
						  AND $filter_string
						  AND `type_delete` != '1'
						  AND `type_visibility` = '1' 
						  AND promo_start_datetime <= '$now'
						  AND promo_end_datetime >= '$now'
						  GROUP BY `product_id`
						  ORDER BY $order_by
						  LIMIT $start, $query_per_page
						 ";
		   }
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   return $row;
}

function get_total_stock($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT SUM(stock_quantity) AS total_stock FROM tbl_product_stock WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function view_pagination($post_total_record, $post_qpp, $post_req_cat, $post_req_filter, $post_req_sort, $post_req_page){
	
   // DEFINED VARIABLE
   $paging['total_record'] = $post_total_record;
   $paging['qpp']          = $post_qpp;
   $paging['total_page']   = ceil($post_total_record / $post_qpp);
   
   //$paging['first']        = 
   
   if($paging['total_page'] > 1){
	  //SALE
	  $default_word = 'shop';
	  if($_REQUEST['sale']=='1'){
		$default_word = 'sale';
	  }
	
      echo '<ul class="pagination pull-right">';
      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/$default_word\">&laquo;</a></li>";
   
      for($i=1; $i <= $paging['total_page']; $i++){
         echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/$default_word-view/".$post_req_cat."/".$post_req_filter."/".$post_req_sort."/".$i."\">".$i."</a></li>";
	  }
	  
      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/$default_word-view/".$post_req_cat."/".$post_req_filter."/".$post_req_sort."/".$paging['total_page']."\">&raquo;</a></li>";
      echo '</ul>';
   }
   
}

//collection
function get_collection(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_collection WHERE collection_visibility_status='Yes' ORDER BY collection_order DESC";
   $query  = mysql_query($sql, $conn);
   $row    = array();

   while($result = mysql_fetch_array($query)){
	  array_push($row, $result);
   }
   return $row;
}

/*
# ----------------------------------------------------------------------
# DEFINED VARIABLE
# ----------------------------------------------------------------------
*/

/* -- SESSION PREV NEXT IN DETAIL -- */
if(!empty($_REQUEST['shop_cat_id'])){
   $_SESSION['sort_detail_view'] = "true";
   unset($_SESSION['sort_detail']);
}else{
   $_SESSION['sort_detail'] = "true";
   unset($_SESSION['sort_detail_view']);
}


/* -- REQUEST ALIASING -- */

// CATEGORY
if(!empty($_REQUEST['shop_cat_id'])){
   $req_category = $_REQUEST['shop_cat_id'];
}else{
   $req_category = 'all';
}

// FILTER
if(!empty($_REQUEST['shop_filter'])){
   $req_filter = $_REQUEST['shop_filter'];
}else{
   $req_filter = 'all';
}

// SORT
if(!empty($_REQUEST['shop_sort'])){
   
   if($_REQUEST['shop_sort'] == "all"){
	  $req_sort_new   = "new";
	  $req_sort_price = "price";
	  $req_sort_az    = "atoz";
	  
	  $req_page_new   = "new";
	  $req_page_price = "price";
	  $req_page_az    = "atoz";
	  
	  $req_sort       = "all";
   }else if($_REQUEST['shop_sort'] == 'new'){
	  $req_sort_new   = "oldest";
	  $req_sort_price = "price";
	  $req_sort_az    = "atoz";
	  
	  $req_page_new   = "oldest";
	  $req_page_price = "price";
	  $req_page_az    = "atoz";
	  
	  $req_sort       = "new";
   }else if($_REQUEST['shop_sort'] == 'oldest'){
	  $req_sort_new   = "new";
	  $req_sort_price = "price";
	  $req_sort_az    = "atoz";
	  
	  $req_page_new   = "new";
	  $req_page_price = "price";
	  $req_page_az    = "atoz";
	  
	  $req_sort       = "oldest";
	  
   }else if($_REQUEST['shop_sort'] == 'price'){
	  $req_sort_new   = "new";
	  $req_sort_price = "pricedown";
	  $req_sort_az    = "atoz";
	  
	  $req_page_new   = "new";
	  $req_page_price = "pricedown";
	  $req_page_az    = "atoz";
	  
	  $req_sort       = "price";
   }else if($_REQUEST['shop_sort'] == 'pricedown'){
	  $req_sort_new   = "new";
	  $req_sort_price = "price";
	  $req_sort_az    = "atoz";
	  
	  $req_page_new   = "new";
	  $req_page_price = "price";
	  $req_page_az    = "atoz";
	  
	  $req_sort       = "pricedown";
   
	  
   }else if($_REQUEST['shop_sort'] == 'atoz'){
	  $req_sort_new   = "new";
	  $req_sort_price = "price";
	  $req_sort_az    = "ztoa";
	  
	  $req_page_new   = "new";
	  $req_page_price = "price";
	  $req_page_az    = "ztoa";
	  
	  $req_sort       = "atoz";
   }else if($_REQUEST['shop_sort'] == 'ztoa'){
	  $req_sort_new   = "new";
	  $req_sort_price = "price";
	  $req_sort_az    = "atoz";
	  
	  $req_page_new   = "new";
	  $req_page_price = "price";
	  $req_page_az    = "atoz";
	  
	  $req_sort       = "ztoa";
   }
   
}else{
   $req_sort_new   = "new";
   $req_sort_price = "price";
   $req_sort_az    = "atoz";
   
   $req_sort       = "all";
}


/* -- DATABASE FEEDER -- */

// CATEGORY
if(empty($_REQUEST['shop_cat_id']) || $_REQUEST['shop_cat_id'] == "all"){
   $search_string        = "1";
}else{
   $search_string        = "(product_category = '".$_REQUEST['shop_cat_id']."' OR category_parent  = '".$_REQUEST['shop_cat_id']."')";
}


// FILTER
//print_r($_SESSION["filters"]);
if ($_SESSION["filters"]!=null){
	$filter_string     .= "(";
	$filter_count=0;
	foreach ($_SESSION["filters"] as $filter){
		if ($filter_count>0){
			$filter_string     .= " OR ";
		}
		$filter_string     .= "product_collection = '$filter'";
		$filter_count++;
	}
	$filter_string     .= ")";
}else{
   $filter_string        = "1";
}
/*
if(empty($_REQUEST['shop_filter']) || $_REQUEST['shop_filter'] == "all"){
   $filter_string        = "1";
}else{
   $filter_string        = "1";
} 
*/

// ORDER
if(empty($_REQUEST['shop_sort']) || $_REQUEST['shop_sort'] == "all"){
   $order_by = "product_name ASC";
}else if($_REQUEST['shop_sort'] == "new"){
   $order_by = "product_date_added DESC";
} else if($_REQUEST['shop_sort'] == "oldest"){
   $order_by = "product_date_added ASC";
}

else if($_REQUEST['shop_sort'] == "price"){
   $order_by = "type_price DESC";
} else if($_REQUEST['shop_sort'] == "pricedown"){
   $order_by = "type_price ASC";
}

else if($_REQUEST['shop_sort'] == "atoz"){
   $order_by = "product_name ASC";
} else if($_REQUEST['shop_sort'] == "ztoa"){
   $order_by = "product_name DESC";
}


// PAGE
if(!empty($_REQUEST['shop_page']) and $_REQUEST['shop_page'] != 1){
   $page = $_REQUEST['shop_page']; 
}else{
   $page = 0;
}


/* -- PAGINATION FEEDER -- */
$total_record   = $record;
$start          = 0;
$query_per_page = 16;

if(!empty($page)){
   $start = ($page - 1) * $query_per_page;
}else{
   $start = 0;
}

$total_record   = $record;
$start          = 0;

if(empty($_REQUEST['shop_view'])){
   $query_per_page = 15;
}else{
   $query_per_page = clean_number($_REQUEST['shop_view']);
}


if($_REQUEST['shop_sort'] == 'price' || $_REQUEST['shop_sort'] == 'pricedown'){
   $active_price = 'active';
   $active_atoz  = '';
   $active_new   = '';
}else if($_REQUEST['shop_sort'] == 'atoz' || $_REQUEST['shop_sort'] == 'ztoa'){
   $active_price = '';
   $active_atoz  = 'active';
   $active_new   = '';
}else if($_REQUEST['shop_sort'] == 'new' || $_REQUEST['shop_sort'] == 'oldest'){
   $active_price = '';
   $active_atoz  = '';
   $active_new   = 'active';
}


/*
# ----------------------------------------------------------------------
# CALL FUNCTION
# ----------------------------------------------------------------------
*/

$record    = count_product($search_string, $filter_string, $order_by);
$products  = get_product($search_string, $filter_string, $order_by, $start, $query_per_page);

$collections = get_collection();
//print_r($_REQUEST);

//SALE
$default_word = 'shop';
if($_REQUEST['sale']=='1'){
	$default_word = 'sale';
	$_SESSION['root_cat']='top';
}
?>	

    <div class="container main">

    	<img src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">

    	<div class="content">
        
        <div class="row">

          <div class="col-xs-2">

            <!--SIDEBAR CATEGORY-->
            <div class="category">
              <p class="h6 heading m_b_10">Categories</p>
              <ul>
                <li <?php if($_REQUEST['shop_cat_id']==$_SESSION['root_cat']||$_REQUEST['shop_root']=='1'){echo 'class="active"';}?>><a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']).'/'.$default_word.'-view/'.$_SESSION['root_cat'].'/'.$req_filter.'/'.$req_sort.'/1/'.$query_per_page;?>">All Products</a></li>
                <?php 
					//category sub
					//listCategory('1',$_SESSION['root_cat'],'');
					//SALE
					if($_REQUEST['sale']=='1'){
						listCategory('0',$_SESSION['root_cat'],'');
					}
					else{
						listCategory('1',$_SESSION['root_cat'],'');
					}
?>
              </ul>
            </div>

            <!--SIDEBAR CATEGORY-->
            <div class="filter">
              <p class="h6 heading m_b_10">COLLECTIONS</p>

			  <?php if ($_SESSION['filters']!=null){?>
              <div class="clear-box">
              	<ul>
	              	<li class="clear"><a href="javascript:resetFilter()">Clear All</a></li>
	              	<!--<li class="clear"><a href="">Collection 2</a></li>-->
              	</ul>
              </div>
			  <?php } ?>
              <ul>
              	<!--<li class="clear"><a href="">Clear Collection</a></li>-->
				<?php
				foreach($collections as $collection){
				?>
				
					<li <?php
					if (in_array($collection['collection_id'],$_SESSION['filters'])){
						echo ' class="active" ';
					}
					?>
					><a href="javascript:addFilter(<?=$collection['collection_id'];?>)"><?=ucfirst($collection['collection_name']);?></a></li>
						
				<?php	
				}
				?>
                
                <!--<li class="active"><a href="">Valentines</a></li>
                <li><a href="">Christmas</a></li>-->
              </ul>
            </div>

          </div><!--.col-->
             
<?php
/* --- start: PAGE BANNER --- */
function count_page_banner($page){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_page_banner WHERE `banner_name` = '$page'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_page_banner($page){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_page_banner WHERE `banner_name` = '$page'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


if($_REQUEST['shop_cat_id'] == '15'){
   $page_banner_name = 'page-banner-1';
}else if($_REQUEST['shop_cat_id'] == '22'){
   $page_banner_name = 'page-banner-2';
}else if($_REQUEST['shop_cat_id'] == '29'){
   $page_banner_name = 'page-banner-3';
}else if($_REQUEST['shop_cat_id'] == '30'){
   $page_banner_name = 'page-banner-4';
}

$count_page_banner = count_page_banner($page_banner_name);
$get_page_banner   = get_page_banner($page_banner_name);
?>
  

          <div class="col-xs-10">        
          
             
             <?php
             if($count_page_banner['rows'] > 0){
			    
				foreach($get_page_banner as $get_page_banner){
				   //echo '<div class="col-xs-3">';
				   
				   if($get_page_banner['link'] != ''){
				      echo '<a href="'.$get_page_banner['link'].'" target="_new">';
				   }
				   
				   echo '<img src="'.$prefix_url.'admin/static/thimthumb.php?src=../'.$get_page_banner['filename'].'&h=125&w=813&q=80" class="m_b_15">';
				   //echo '</div>';
				   
				   if($get_page_banner['link'] != ''){
				      echo '</a>';
				   }
				   
				}
				
			 }
/* --- end: PAGE BANNER --- */
			 ?>

            <!--SORT & FILTERS-->
            <div class="sort clearfix">
              <div class="pull-left">
                Sort by
                <a class="<?php echo $active_new;?>" href="<?php echo $prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort_new."/".$start."/".$query_per_page;?>">New In</a>
                
                <?php
                /*
				# ----------------------------------------------------------------------
				# SORTING
				# ----------------------------------------------------------------------
				*/
				
                //if(!empty($_REQUEST['shop_sort'])){
				   
				   /* --- PRICE --- */
				   if($_REQUEST['shop_sort'] == 'price'){
				      echo '<a href="'.$prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort_price."/".$start.'/'.$query_per_page.'" class="'.$active_price.'">Price &nbsp;&uarr;</a>';
				   }else{
				      echo '<a href="'.$prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort_price."/".$start.'/'.$query_per_page.'" class="'.$active_price.'">Price &nbsp;&darr;</a>';
				   }
				   
				   /* --- ALPHABET --- */
				   if($_REQUEST['shop_sort'] == 'ztoa'){
				      echo '<a href="'.$prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort_az."/".$start.'/'.$query_per_page.'" class="'.$active_atoz.'">A-Z</a>';
				   }else{
					  echo '<a href="'.$prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort_az."/".$start.'/'.$query_per_page.'" class="'.$active_atoz.'">Z-A</a>';
				   }
				   
				//}
				?>
                
              </div>
              <div class="pull-right">
                Show <a <?php if($query_per_page=='30'){ echo 'class="active"'; }?> href="<?php echo $prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort."/".$start."/30";?>">30</a> / <a <?php if($query_per_page=='60'){ echo 'class="active"'; }?> href="<?php echo $prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort."/".$start."/60";?>">60</a> / <a <?php if($query_per_page=='90'){ echo 'class="active"'; }?> href="<?php echo $prefix_url.$default_word."-view/".$req_category.'/all/'.$req_sort."/".$start."/90";?>">90</a> per page
              </div>
            </div><!--.filters-->
            
            <!--PRODUCTS LIST-->
            <div class="row row-5">
              
			  <?php 
			  # ----------------------------------------------------------------------
			  # PRODUCTS NOT FOUND
			  # ----------------------------------------------------------------------
			  if($products[0]['product_name'] == ''){
			     echo '<div class="col-xs-12" style="text-align:center";>Products not found</div>';
			  }
			  
			  
			  foreach($products as $key=>$products){
              ?>
              
              <div class="thumb col-xs-4">
                <a href="<?php echo $prefix_url."item/".cleanurl($products['category_name'])."/".$products['product_alias']."/".$products['type_alias'];?>">
                  <div class="content">
                    <div class="loading"></div>
                    <!--<div class="thumb-label sale hidden"><img src="<?php echo $prefix_url;?>files/common/icon_sale.png"></div>-->
                    
					<?php
                    /* --- SALE LABEL --- */
					discount_label($products['promo_id'], $products['promo_start_datetime'], $products['promo_end_datetime'], $prefix_url);
					new_label($products['new_id'], $products['new_start'], $products['new_end'], $prefix_url);
					?>
                    
                    <img class="img-responsive opac" src="<?php echo $prefix_img.$products['img_src']."&h=352&w=264&q=100";?>" width="100%" style="width: 264px; height: 352px; background: #f9f9f9">
                    <!--<img class="img-responsive opac" src="<?php echo $prefix_url."admin/static/thimthumb.php?src=".$products['img_src']."&h=344&w=229&q=100";?>" width="100%">-->
                  </div>
                  <div class="info">
                    <div class="title"><?php echo $products['product_name'];?></div>
                    <div class="price">
                      
					  <?php
					  /* --- DISCOUNT --- */
					  $price = discount_price($products['promo_id'], $products['promo_value'], $products['type_price'], $products['promo_start_datetime'], $products['promo_end_datetime']);
					  if(!empty($products['promo_id']) || $products['promo_id'] = "" || $products['promo_start_datetime'] <= date('Y-m-d') and $products['promo_end_datetime'] >= date('Y-m-d')){
					     echo "<span class=\"now-price \">IDR ".price($price['now_price'])."</span> \n";
					     echo "<span class=\"was-price \">IDR ".price($price['was_price'])."</span> \n";
					  }else{
					     echo "<span class=\"normal-price \">IDR ".price($price['now_price'])."</span> \n";
					  }
					  ?>
                      
                    </div>
                    
                    <?php
                    /* --- STOCK --- */
					$total_stock = get_total_stock($products['type_id']);
					
					if($total_stock['total_stock'] == 0){
					   echo '<div><span class="label label-default">Sold Out</span></div>';
					}
					?>
                    
                  </div>
                </a>
              </div><!--.thumb-->
              <?php
              }
              ?>
            </div><!--.row-->
            
            <?php
			/* --- PAGINATION --- */
			view_pagination($total_record, $query_per_page, $req_category, $req_filter, $req_sort, $page);
			?>

          </div><!--.col-->

        </div><!--.row-->

       </div><!--.content-->
    </div><!--.container.main-->

<script type="text/javascript">
function addFilter(filter_id){

   
   var ajx       = $.ajax({
                      type: "POST",
					  url: "<?php echo $prefix_url;?>/shop_/ajax/add_filter.php",
					  data: {filter_id:filter_id},
					  error: function(jqXHR, textStatus, errorThrown) {
						        
							 }
							 
				   }).done(function(data) {	
						//alert(data);
				      if(data=='success'){
					     location.reload();
					  }
				   });
}

function resetFilter(){

   
   var ajx       = $.ajax({
                      type: "POST",
					  url: "<?php echo $prefix_url;?>/shop_/ajax/reset_filter.php",
					  data: {},
					  error: function(jqXHR, textStatus, errorThrown) {
						        
							 }
							 
				   }).done(function(data) {	
						//alert(data);
				      if(data=='success'){
					     location.reload();
					  }
				   });
}

</script>