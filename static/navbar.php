<?php
function header_count_bag(){
   $total = $_SESSION['cart_type_id'];
   $qty   = $_SESSION['cart_qty'];   
   
   if(isset($_SESSION['cart_type_id'])){
      
	  foreach($total as $key=>$total){
         $get_total_bag += $qty[$key];
	  }
	  
	  $total_bag = $get_total_bag;
	  
   }else{
      $total_bag = '0';
   }
   
   echo $total_bag;
}

//WISHLIST
function count_wishlists($user_id){
	$conn   = connDB();

	   $sql    = "SELECT * FROM tbl_wishlist
	              WHERE user_id = '$user_id'
				  ORDER BY wishlist_date DESC
				 ";
	   $query  = mysql_query($sql, $conn);
	   
	   return mysql_num_rows($query);
}

//CATEGORY MENU
function get_category_navbar(){
	$conn   = connDB();
	
	$sql    =  "SELECT * from tbl_category 
		        WHERE category_level = '0' AND category_visibility_status = '1'  ORDER BY category_order";
		
	$query  = mysql_query($sql, $conn);
	$row    = array();

	   while($result = mysql_fetch_array($query)){
		  array_push($row, $result);
	   }
	   return $row;
}

function check_sale(){
	   $conn   = connDB();

	    $now    = date('Y-m-d');
		$sql    = "SELECT COUNT(*) AS rows FROM tbl_category AS cat_ LEFT JOIN tbl_product AS prod_ ON cat_.category_id = prod_.product_category
				                                                 LEFT JOIN tbl_category_relation AS rel_ ON cat_.category_id = rel_.category_child
																 LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
																 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
																 LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_. product_type_id
																 LEFT JOIN tbl_new_arrival AS new_ ON type_.type_id = new_.new_type_id
							  WHERE `type_delete` != '1'
							  AND `type_visibility` = '1'
							  AND promo_start_datetime <= '$now' 
							  AND promo_end_datetime >= '$now'
							  GROUP BY `product_id`
							 ";
	   $query  = mysql_query($sql, $conn);
	   $result = mysql_num_rows($query);

	   return $result;
}

$navbar_cats = get_category_navbar();
?>

<!--<div class="nav-ribbon">
  <div class="container">
    Free shipping on orders above IDR 500.000
  </div>
</div>-->

<div class="navbar navbar-static-top" role="navigation">
  <div class="container">

    <!--NAVBAR ECOMMERCE 1-->
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-data">
        <!--<span class="sr-only">Toggle Navigation</span>-->
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <div class="navbar-top clearfix">
        <a href="<?php echo $prefix_url."home";?>" class="navbar-brand"><img src="<?php echo $prefix_url;?>files/common/logo.png" alt="logo" height="70"></a>

        <ul class="nav navbar-nav navbar-right hidden-xs">
          
		  <?php
		  if(!empty($_SESSION['user_id'])){
		     echo "<li><a href=\"".$prefix_url."logout\">Logout</a></li>";
		  }else{
		     echo "<li><a href=\"".$prefix_url."login\">Login</a></li>";
		  }
		  
		  
		  if(empty($_SESSION['user_id'])){
		     echo '<li><a href=\''.$prefix_url.'account/'.md5('empty').'\'>Register</a></li>';
		  }else{
		     echo '<li><a href=\''.$prefix_url.'account/'.md5($global_user['user_alias']).'\'>My Account</a></li>';
		  }
		  ?>
          
          <li><a href="<?php echo $prefix_url;?>confirm">Confirm Payment</a></li>
          <li><a>|</a></li>

		  <?php //if($_SESSION['user_id']!=null){?>
          <li><a href="<?php echo $prefix_url;?>wishlist">Wishlist &nbsp;<strong><?=count_wishlists($_SESSION['user_id']);?></strong></a></li>
		  <?php //} ?>
          <li><a href="<?php echo $prefix_url;?>bag">My Bag &nbsp;<strong class="shop-count" id="id_shop_count"><?php header_count_bag();?></strong></a></li>
        </ul>

      </div><!--.navbar-top-->

    <div class="navbar-bottom clearfix">
      <ul class="navbar-collapse collapse navbar-data clearfix" role="navigation">
        <div class="nav navbar-nav pull-left">
		  <?php
		  //shop category
		  if($_REQUEST['shop_root']=='1'){
			$_SESSION['root_cat']=$_REQUEST['shop_cat_id'];

		}
		
		  foreach($navbar_cats as $navbar_cat){
				if ($navbar_cat['category_id']=='15'){
					$navbar_alias = 'wanderboys';
				}
				else if ($navbar_cat['category_id']=='22'){
					$navbar_alias = 'wanderlust';
				}
				else if ($navbar_cat['category_id']=='29'){
					$navbar_alias = 'wanderer';
				}
				else if ($navbar_cat['category_id']=='30'){
					$navbar_alias = 'wandering';
				}
		  ?>
				<li id="nav_cat_<?=$navbar_cat['category_id'];?>" class="navbar_category 
				<?php
					if($_SESSION['root_cat']==$navbar_cat['category_id'] && strpos($act, 'shop')!== false){echo ' active';}
				?>
				" ><a href="<?php echo $prefix_url;?>shop/<?=$navbar_alias;?>"><?=$navbar_cat['category_name'];?></a></li>
				
				
		  <?php
		  }
		  ?>
          <!--
          <li><a href="<?php echo $prefix_url;?>shop">Men</a></li>
          <li><a href="<?php echo $prefix_url;?>shop">Kids</a></li>
          <li><a href="<?php echo $prefix_url;?>shop">Accessories</a></li>-->
		  <?php
		  $check_sale=check_sale();
		  if($check_sale>0){	
		  ?>
          	<li class="nav-sale"><a href="<?php echo $prefix_url;?>sale">Sale</a></li>
		  <?php
	  	  }
		  ?>
        </div>

        <div class="nav navbar-nav pull-right">
        	<li
				<?php
					if($act=='pages_/about/index'){echo 'class="active"';}
				?>
		  ><a href="<?php echo $prefix_url;?>about">About</a></li>
          <li
				<?php
					if($act=='pages_/contact/index'){echo 'class="active"';}
				?>
		   ><a href="<?php echo $prefix_url;?>contact">Contact</a></li>
		  	<!--<li id="sb-search" class="sb-search">
		  	    <form>
		  	        <input class="sb-search-input" placeholder="Enter your search term..." type="search" value="" name="search" id="search">
		  	        <input class="sb-search-submit" type="submit" value="">
		  	        <span class="sb-icon-search"></span>
		  	    </form>
		  	</li>-->
          
        </div>
      </ul>
    </div><!--.navbar-header-->

  </div><!--.container-->
</div><!--.navbar-->

<style type="text/css">
#nav_cat_15.active a, #nav_cat_15 a:hover{
	color:#20a4d5;
}
#nav_cat_22.active a, #nav_cat_22 a:hover{
	color:#f16fb9;
}
#nav_cat_29.active a, #nav_cat_29 a:hover{
	color:#fffc17;
}
#nav_cat_30.active a, #nav_cat_30 a:hover{
	color:#1da654;
}
</style>
<?php
//echo $_SESSION['root_cat'];
/*
if ($_SESSION['root_cat']=='15' && strpos($act, 'shop')!== false){
?>
		<script type="text/javascript">
			$('.navbar_category.active a').css({'color':'#20a4d5'});
		</script>

		
		
<?php	
}
else if ($_SESSION['root_cat']=='22' && strpos($act, 'shop')!== false){
	?>
		<script type="text/javascript">
			$('.navbar_category.active a').css({'color':'#f16fb9'});
		</script>

		
<?php	

}
else if ($_SESSION['root_cat']=='29' && strpos($act, 'shop')!== false){
	?>
		<script type="text/javascript">
			$('.navbar_category.active a').css({'color':'#1da654'});
		</script>

<?php	

}
else if ($_SESSION['root_cat']=='30' && strpos($act, 'shop')!== false){
	?>
		<script type="text/javascript">
			$('.navbar_category.active a').css({'color':'#3cc4bc'});
		</script>

<?php	

}
*/
?>

