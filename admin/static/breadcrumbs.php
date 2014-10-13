<?php
/* FUNCTIONS */

// PRODUCT
function breadcrumbs_get_product_name($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// CUSTOMER
function breadcrumbs_get_user_name($post_user_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_alias` = '$post_user_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DATA FEEDER
$standard_redirect = "product";

$breadcrumbs_product_name = breadcrumbs_get_product_name($_REQUEST['product_alias']);
$breadcrumbs_user_name    = breadcrumbs_get_user_name($_REQUEST['cid']);


$order_id     = $_REQUEST['oid']; // Get order number
$product_name = $_REQUEST['pid']; // Get product name

$clean        = ucfirst($_REQUEST['pid']);
$prod_name    = preg_replace("/[\/_|+ -]+/", ' ', $clean);

$clean        = ucwords(strtolower($_REQUEST['cid']));
$user_name    = ucwords(strtolower(preg_replace("/[\/_|+ -]+/", ' ', $clean)));
?>

<div class="breadcrumbs">
    <div class="content">
        <ul class="clearfix">
        
           <?php 
		   
		   if(empty($_REQUEST['act'])){
		      echo "<li><a href=\"".$prefix_url.$standard_redirect."\">Home</a></li>";
			  
		   /* -- ORDERS -- */
		   }else if($_REQUEST['act'] == "orders/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Orders</li>";
		   	  
		   }else if($_REQUEST['act'] == "orders/details/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order\">Orders</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">".$order_id."</li>";
			  
		   }else if($_REQUEST['act'] == "orders/details/edit"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order\">Orders</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/order-detailing/".$order_id."\">".$order_id."</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Edit - ".$order_id."</li>";
			  
			  
		   /* -- PRODUCTS -- */
		   }else if($_REQUEST['act'] == "products/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li  class=\"selected\">Products</li>";
			  
		   }else if($_REQUEST['act'] == "products/details/edit"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product\">Products</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li  class=\"selected\">".'Edit: '.ucwords(strtolower($detail_prod_name))."</li>";
			  
		   }else if($_REQUEST['act'] == "products/add/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product\">Products</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li  class=\"selected\">Add Product</li>";
		   
		   
		   /* -- CUSTOMER -- */	  
		   }else if($_REQUEST['act'] == "customers/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">All Customer</li>";
			  
		   }else if($_REQUEST['act'] == "customers/add/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer\">All Customer</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Add Customer</li>";
			  
		   }else if($_REQUEST['act'] == "customers/details/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer\">All Customer</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">".$breadcrumbs_user_name['user_fullname']."</li>";
			  
		   }else if($_REQUEST['act'] == "customers/details/edit"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer\">All Customer</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/customer/".strtolower(cleanurl($user_name))."\">".$user_name."</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Edit - ".$breadcrumbs_user_name['user_fullname']."</a></li>";
		   }
		   
		   
		   /* -- CATEGORY -- */
		   else if($_REQUEST['act'] == "products/category/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product\">Products</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Category</a></li>";
		   
		   
		   /* -- COLOR -- */
		   }else if($_REQUEST['act'] == "products/color/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product\">Products</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Color</a></li>";
		   
		   
		   /* -- SIZE -- */
		   }else if($_REQUEST['act'] == "products/size/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/product\">Products</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Size</a></li>";
		   
		   
		   /* ABOUT */
		   }else if($act == "pages/about"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/about\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">About</li>";
		   
		   
		   /* CONTACT */
		   }else if($act == "pages/contact"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/contact\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Contact</li>";
		   
		   
		   /* -- ACCOUNT -- */
		   }else if($_REQUEST['act'] == "settings/account"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Settings</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Accounts</li>";
		   
		   /* -- PAGES - HOME -- */	  
		   }else if($_REQUEST['act'] == "pages/home"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Home</li>";
		   }
		   
		   /* -- SHIPPING -- */
		   else if($act == "settings/shipping/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping\">Settings</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Shipping</li>";
		   
		   }else if($act == "settings/shipping/add/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping\">Settings</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping\">Shipping</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Add Shipping</li>";
			  
		   }else if($act == "settings/shipping/detail/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping\">Settings</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping\">Shipping</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">".$courier_name['courier_name']."</li>";
		   
		   }else if($act == "settings/shipping/detail/edit"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping\">Settings</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping\">Shipping</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/shipping/".$courier_name['courier_id']."\">".$courier_name['courier_name']."</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Edit: ".$courier_name['courier_name']."</li>";
		   
		   /* STOCK MANAGER */
		   }else if($act == "products/stock/sizemanager"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/stock-manager\">Products</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Stock Manager</a></li>";
		   }
		
			include('custom/static/breadcrumbs.php');
		   ?>
        </ul>
    </div>
</div>