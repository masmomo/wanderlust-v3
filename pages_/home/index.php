<?php
# ----------------------------------------------------------------------
# SLIDESHOW
# ----------------------------------------------------------------------

// COUNT SLIDESHOWS
function count_slideshow(){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_slideshow ORDER BY `order_`";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// GET SLIDESHOWS
function get_slideshows(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_slideshow ORDER BY `order_`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}



# ----------------------------------------------------------------------
# FEATURED
# ----------------------------------------------------------------------

// COUNT FEATURED
function count_featured(){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_featured AS feat_ INNER JOIN tbl_product_type AS type_ ON feat_.featured_type_id = type_.type_id
                                                                 INNER JOIN tbl_product AS prod_ ON type_.product_id = prod_.id
																 INNER JOIN tbl_category AS category_ ON prod_.product_category = category_.category_id
																 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
																 LEFT JOIN tbl_product_stock AS stock_ ON type_.type_id = stock_.type_id
																 LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_.product_type_id
			 WHERE type_.type_visibility = '1' AND type_.type_delete != '1'
		     ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// GET FEATURED
function get_featured(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_featured AS feat_ INNER JOIN tbl_product_type AS type_ ON feat_.featured_type_id = type_.type_id
                                                  INNER JOIN tbl_product AS prod_ ON type_.product_id = prod_.id
												  INNER JOIN tbl_category AS category_ ON prod_.product_category = category_.category_id
												  LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
												  LEFT JOIN tbl_product_stock AS stock_ ON type_.type_id = stock_.type_id
												  LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_.product_type_id
			 WHERE type_.type_visibility = '1' AND type_.type_delete != '1'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// COUNT STOCK
function count_stock_featured($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT SUM(stock_quantity) AS total_stock FROM tbl_product_stock WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


# ----------------------------------------------------------------------
# PAGE BANNER
# ----------------------------------------------------------------------

function count_page_banner(){
   $conn   = conndB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_promo_banner";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function count_page_banner_default($order){
   $conn   = conndB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_promo_banner WHERE `order` = '$order'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_page_banner($order){
   $conn   = conndB();
   $sql    = "SELECT * FROM tbl_promo_banner WHERE `order` != '$order'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

function get_page_banner_default($order){
   $conn   = conndB();
   $sql    = "SELECT * FROM tbl_promo_banner WHERE `order` = '$order'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



/* -- CONTROL -- */

# ----------------------------------------------------------------------
# CALL FUNCTION
# ----------------------------------------------------------------------

/* --- SLIDESHOW --- */
$count_slideshow = count_slideshow();
$get_slideshow   = get_slideshows();


/* --- FEATURED --- */
$count_featured  = count_featured();
$get_featured    = get_featured();


/* --- PAGE BANNER --- */
$count_banner         = count_page_banner();
$count_banner_default = count_page_banner_default(1);
$get_banner           = get_page_banner(1);
$get_banner_default   = get_page_banner_default(1);
?>

    <div class="container">
      <div class="content">
        
        <!--CAROUSEL-->

		<script type="text/javascript">
		$(document).ready(function () {
		    $('.carousel').carousel({
		        interval: 3000
		    });

		    $('.carousel').carousel('cycle');
		});
		</script>
		
        <div id="main-carousel" class="carousel slide m_b_10">
          <ol class="carousel-indicators">
            <?php
            $total_banner = $count_slideshow['rows'];
    				for($i=0;$i<$total_banner;$i++){
    				   echo "<li data-target=\"#main-carousel\" data-slide-to=\"".$i."\"></li>";
    				}
    				?>
          </ol>
          <div class="carousel-inner">
            
			<?php
            foreach($get_slideshow as $key=>$slideshow){
			
			   if($key == 0){
			      $count = 'active';
			   }else{
			      $count = '';
			   }
	  
			   echo "<div class=\"item ".$count."\" ".$key."> \n";
			   
			   if($slideshow['link'] != ''){
			      echo '<a href="'.$slideshow['link'].'">';
			   }
			   
			   echo "  <img class=\"img-responsive\" src=\"".$prefix_img.$slideshow['filename']."&h=461&w=1150&q=100\">";
			   
			   if($slideshow['link'] != ''){
			      echo '</a>';
			   }
			   
               echo "</div>";
			}
			?>
            
          </div>
          <a class="left carousel-control" href="#main-carousel" data-slide="prev">
            <span class="icon-prev"></span>
          </a>
          <a class="right carousel-control" href="#main-carousel" data-slide="next">
            <span class="icon-next"></span>
          </a>
        </div>
        
        <?php
        # ----------------------------------------------------------------------
		# PAGE BANNER
		# ----------------------------------------------------------------------
		
		/* --- PAGE BANNER LONG --- */
		if($count_banner_default['rows'] > 0){
			    
		   if($banner['link'] != ''){
		      echo '<a href="'.$get_banner_default['link'].'">';
		   }
		   
		   echo '<a href="'.$get_banner_default['link'].'">';
		   echo '<img class="img-responsive m_b_10" src="'.$prefix_img.$get_banner_default['filename'].'&h=130&q=100" width="100%">';
				
		   if($get_banner_default['link'] != ''){
		      echo '</a>';
		   }
		   
		}else{
		   echo '<img class="img-responsive m_b_10" src="'.$prefix_url.'files/common/img_small-0.jpg" width="100%">';
		}
		?>

        <!--SUB BANNERS-->
        <div class="row row-5">
          <?php
          # ----------------------------------------------------------------------
		  # PAGE BANNER
		  # ----------------------------------------------------------------------
		  
		  /* --- SUB PAGE BANNER --- */
		  foreach($get_banner as $key=>$banner){
			  
		     if($count_banner['rows'] > 0){
			    
				if($banner['link'] != ''){
			       echo '<a href="'.$banner['link'].'">';
				}
				
		        echo '<div class="col-xs-4"><img class="img-responsive m_b_10" src="'.$prefix_img.$banner['filename'].'&h=220&q=100" width="100%"></div>';
				
				if($banner['link'] != ''){
			       echo '</a>';
				}
				
			 }else{
		        echo '<div class="col-xs-4"><img class="img-responsive" src="'.$prefix_url.'files/common/img_small-'.($key+1).'.jpg" width="100%"></div>';
			 }
			 
		  }
		  ?>
        </div>

        <!--FEATURED ITEMS-->
        <div class="row">
          <?php 
		      foreach($get_featured as $featured){
		     
    			// CALL FUNCTION
    			$product_stock = count_stock_featured($featured['featured_type_id']);
          ?>
          <div class="thumb col-xs-3">
            <a href="<?php echo $prefix_url."item/".$featured['category_alias']."/".$featured['product_alias']."/".$featured['type_alias'];?>">
              <div class="content">
                <div class="loading"></div>
                
                <?php
                discount_label($featured['promo_item_id'], $featured['promo_start_datetime'], $featured['promo_end_datetime'], $prefix_url);
			          ?>
                
                <img class="img-responsive opac" src="<?php echo $prefix_img.$featured['img_src']."&h=405&w=270&q=100";?>" width="100%">
              </div>
              <div class="info">
                <p class="title"><?php echo $featured['product_name'];?></p>
                
                <?php
                // DISCOUNT CONTROL
        				$discount = discount_price($featured['promo_id'], $featured['promo_value'], $featured['type_price'], $featured['promo_start_datetime'], $featured['promo_end_datetime']);
        				?>

                <p class="price">
                  <?php
                  if(!empty($featured['promo_item_id']) || $featured['promo_item_id'] != "" and $featured['promo_start_datetime'] <= date('Y-m-d') || $featured['promo_end_datetime']  >= date('Y-m-d')){
                  echo "<span class=\"now-price\">Rp ".price($discount['now_price'])."</span>";
                  echo "<span class=\"was-price\">Rp ".price($discount['was_price'])."</span>";
                  }else{
	               echo "<span class=\"normal-price\">Rp ".price($discount['now_price'])."</span>";
                  }
                  ?>
                </p>
                
                <?php
                if($product_stock['total_stock'] <= 0){
				        echo "<p><span class=\"label label-default\">Sold Out</span></p>";
        				}
        				?>
              
              </div>
            </a>
          </div><!--.thumb-->
          <?php
          }
          ?>
        </div><!--.row-->

      </div><!--.content-->
    </div><!--.container.main-->

    