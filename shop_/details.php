<?php
/*
# ----------------------------------------------------------------------
# FUNCTIONS
# ----------------------------------------------------------------------
*/

function get_product($post_product_alias, $post_type_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category AS cat_ LEFT JOIN tbl_product AS prod_ ON cat_.category_id = prod_.product_category
                                                 LEFT JOIN tbl_product_type AS type_ ON prod_.id = type_.product_id
												 LEFT JOIN tbl_product_image AS img_ ON type_.type_id = img_.type_id
												 LEFT JOIN tbl_promo_item AS promo_ ON type_.type_id = promo_. product_type_id
												 LEFT JOIN tbl_new_arrival AS new_ ON type_.type_id = new_.new_type_id
			  WHERE `product_alias` = '$post_product_alias' 
			  AND `type_alias` = '$post_type_alias'
			  ";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_default_image($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_image WHERE `type_id` = '$post_type_id' AND `image_order` = '0'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_product_images($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_image WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_product_type($post_product_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type AS type_ LEFT JOIN tbl_product AS prod_ ON type_.product_id = prod_.id
                                                      LEFT JOIN tbl_category AS cat_ ON prod_.product_category = cat_.category_id
              WHERE `product_id` = '$post_product_id'
			 ";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_product_stock($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_stock WHERE `type_id` = '$post_type_id' ORDER BY `stock_id` ASC";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_product_sold_out($post_type_id){
   $conn   = connDB();
   
   $sql    = "SELECT SUM(stock_quantity) AS total_stock FROM tbl_product_stock WHERE `type_id` = '$post_type_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function view_sold_out($post_total_stock){
   
   if(empty($post_total_stock) || $post_total_stock == 0){
      echo '<p class="pull-left">Sorry this item is currently sold out.</p>';
	  echo '<button type="button" data-toggle="modal" href="#bagViewer" class="btn btn-primary pull-right m_t_10 hidden" onclick="addBag()">Add to Bag</button>';
   }else{
	  echo '<button type="button" data-toggle="modal" href="#bagViewer" class="btn btn-primary pull-right m_t_10" onclick="addBag()">Add to Bag</button>';
      
	  /* --- WISHLIST --- */
	  echo '<button type="button" data-toggle="modal" ';
	  if($_SESSION['user_id']!=null){
		echo 'href="#bagViewer" ';
	  }
	  
	
	  echo 'class="btn btn-primary-2 pull-right m_t_10 m_r_10" onclick="addWishlist()">Add to Wishlist</button>';
   }
   
}



/*
# ----------------------------------------------------------------------
# DEFINED REQUEST
# ----------------------------------------------------------------------
*/

$product_alias = $_REQUEST['prod_name'];
$type_alias    = $_REQUEST['prod_type'];



/*
# ----------------------------------------------------------------------
# CALL FUNCTION
# ----------------------------------------------------------------------
*/

$product       = get_product($product_alias, $type_alias);
$default_image = get_default_image($product['type_id']);


/* -- PRODUCT THUMBNAILS ON MD LG --- */
$images        = get_product_images($product['type_id']);


/* --- PRODUCT THUMBNAILS ON XS SM --- */
$images_xs     = get_product_images($product['type_id']);
$types         = get_product_type($product['id']);
$stock         = get_product_stock($product['type_id']);
$sold_out      = get_product_sold_out($product['type_id']);


/* --- DISCOUNT --- */
$price = discount_price($product['promo_id'], $product['promo_value'], $product['type_price'], $product['promo_start_datetime'], $product['promo_end_datetime']);



/*
# ----------------------------------------------------------------------
# DEFINED VALUE
# ----------------------------------------------------------------------
*/

if($sold_out['total_stock'] >= 9){
   $control_qty = 9;
}else{
   $control_qty = $sold_out['total_stock'];
}

if($sold_out['total_stock'] > 0){
   $hidden_class = '';
}else{
   $hidden_class = ' hidden ';
}



/*
# ----------------------------------------------------------------------
# HIDDEN INPUT VALUE
# ----------------------------------------------------------------------
*/

echo '<input type="hidden" name="hidden_total_stock" id="id_hidden_total_stock" value="'.$sold_out['total_stock'].'">';// TOTAL STOCK 
echo '<input type="hidden" name="hidden_type_id" id="id_hidden_type_id" value="'.$product['type_id'].'">';// TYPE ID
echo '<input type="hidden" name="hidden_stock_id" id="id_hidden_stock">'; // STOCK ID
echo '<input type="hidden" name="hidden_qty" id="id_hidden_qty">'; // QTY



/*
# ----------------------------------------------------------------------
# MODAL DATA FEEDER
# ----------------------------------------------------------------------
*/

echo '<input type="hidden" id="md_product_name" value="'.$product['product_name'].'">'; // MODAL PRODUCT NAME
echo '<input type="hidden" id="md_product_image" value="'.$prefix_url."admin/static/thimthumb.php?src=../".$default_image['img_src']."&h=150&w=100&q=80".'">'; // MODAL IMAGE
echo '<input type="hidden" id="md_type_name" value="'.$product['type_name'].'">'; // MODAL TYPE NAME
echo '<input type="hidden" id="md_stock_name">'; // MODAL STOCK NAME
?>

    <div class="container main">
      <img src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-sm-7">
            <div class="row row-5">

              <!-- PRODUCT THUMBNAILS ON MD LG -->
              <div class="col-md-2 hidden-xs hidden-sm">
                
				<?php 
                foreach($images as $images){
                ?>
                  <div class="thumb m_b_10">
                    <div class="loading"></div>
                    <img class="img-responsive" src="<?php echo $prefix_url."admin/static/thimthumb.php?src=../".$images['img_src']."&w=85&q=80";?>" width="100%" onclick="viewThumb('<?php echo $prefix_url."admin/static/thimthumb.php?src=../".$images['img_src']."&w=720&q=100";?>')">
                  </div>
                <?php
                }
                ?>
                
              </div>


              <!-- PRODUCT IMAGE -->
              <div class="col-xs-12 col-md-10">
                <div class="thumb">
                  <div class="content">
                    <div class="loading"></div>
                    <img class="img-responsive" src="<?php echo $prefix_url."admin/static/thimthumb.php?src=../".$default_image['img_src']."&w=720&q=80";?>" width="100%" id="id_default_image">
                  </div>
                </div>
              </div>

              <!--PRODUCT THUMBNAILS ON XS SM-->
              <div class="col-xs-12 visible-xs visible-sm">
                <div class="row">
                  
				  <?php 
				  foreach($images_xs as $images){
                  ?>
                  
                  <div class="col-xs-3">
                    <div class="thumb">
                      <div class="loading"></div>
                      <img class="img-responsive" src="<?php echo $prefix_url."admin/static/thimthumb.php?src=../".$images['img_src']."&w=165&q=100";?>" width="100%" onclick="viewThumb('<?php echo $prefix_url."admin/static/thimthumb.php?src=../".$images['img_src']."&w=720&q=80";?>')">
                    </div>
                  </div>
                <?php
                }
                ?>
                
                </div>
              </div>
            </div><!--.row-->
          </div><!--.col-->
          
          
          <div class="prod-details col-xs-12 col-sm-5">

            <!-- PRODUCT DETAILS -->
            <div class="head">
              <h1 class="name" id="id_product_name"><?php echo $product['product_name'];?></h1>
              <p class="price">
			  
			  <?php
			  /*
			  # ----------------------------------------------------------------------
			  # DISCOUNT LABEL
			  # ----------------------------------------------------------------------
			  */
			  
			  if(!empty($product['promo_id']) || $product['promo_id'] = "" || $product['promo_start_datetime'] <= date('Y-m-d') and $product['promo_end_datetime'] >= date('Y-m-d')){
			     echo "<span class=\"now-price \">IDR ".price($price['now_price'])."</span> \n";
				 echo "<span class=\"was-price \">IDR ".price($price['was_price'])."</span> \n";
			  }else{
			     echo "<span class=\"normal-price \">IDR ".price($price['now_price'])."</span> \n";
			  }
			  ?>
              
              </p>
            </div><!--.head-->
            
            <!--<div class="desc">
              <p class="heading">Description</p class="heading">
              <p><?php echo preg_replace("/\n/","\n<br>",$product['type_description']);?></p>
            </div>-->
            
            <div class="content">
              <div class="desc">
                <h3 class="h6">Description</h3>
               	<p><?php echo preg_replace("/\n/","\n<br>",$product['type_description']);?></p>
			  </div>
              <div class="desc ">
                <h3 class="h6 ">Size &amp; Fit</h3>
                <p>
                  <?=$product['type_sizefit'];?>
                  <!--<a data-toggle="modal" href="#sizeFit">See size help &amp; product measurements</a>  -->
                </p>
              </div>
            </div><!--.content-->
            
            <ul class="form-set row row-5">
              <li class="form-group col-xs-7">
                <label class="hidden-xs">Color</label>
                <!--<select class="form-control" id="id_option_type" onchange="redirType()">
    				      <?php
						  /*
                      foreach($types as $types){
    				     echo "<option value=\"".$prefix_url."item/".cleanurl($types['category_name'])."/".$types['product_alias']."/".$types['type_alias']."\"";
						if ($types['type_alias']==$type_alias){
							echo " selected=\"selected\"";
						}
						echo ">".$types['type_name']."</option> \n";
        				  }
						  */
        				  ?>
                </select>-->
                
                <div class="row-n color-box">
                
                  <?php
                  foreach($types as $types){
				     echo '<a href="'.$prefix_url.'item/'.cleanurl($product['category_name']).'/product/'.cleanurl($types['type_name']).'" class="col-xs-3"><img src="'.$prefix_img.$types['type_image'].'&h=34&q=80"></a>';
				  }
				  ?>
                  
                  <!--
                  <a href="" class="col-xs-3 active"><img src="<?php echo $prefix_url;?>script/holder.js/100%x34"></a>
                  <a href="" class="col-xs-3"><img src="<?php echo $prefix_url;?>script/holder.js/100%x34"></a>
                  <a href="" class="col-xs-3"><img src="<?php echo $prefix_url;?>script/holder.js/100%x34"></a>
                  <a href="" class="col-xs-3"><img src="<?php echo $prefix_url;?>script/holder.js/100%x34"></a>
                  -->
                </div>
              </li>
              
              <li class="form-group col-xs-3">
                <label class="hidden-xs">Size</label>
                <select class="form-control" id="id_option_stock" onchange="getStock()">
        				  <?php
                          foreach($stock as $stock){
        				     echo '<option value="'.$stock['stock_id'].'" md_name="'.$stock['stock_name'].'" ';
        					 
        					 if($stock['stock_quantity'] < 1){
        					    echo 'disabled="disabled"';
        					 }
        					 
        					 echo '>'.$stock['stock_name'].'</option> \n';
        				  }
        				  ?>
                </select>
              </li>
              
              <li class="form-group col-xs-2">
                <label class="hidden-xs">Qty.</label>
                <select class="form-control" id="id_option_qty" onchange="getQty()">
                  
				  <?php
                  for($i=1;$i<=$control_qty;$i++){
				     echo '<option value="'.$i.'">'.$i.'</option>';
				  }
				  ?>
                  
                </select>
              </li>
            </ul>
            
            <div class="desc clearfix">
              <?php view_sold_out($sold_out['total_stock']);?>
            </div>

          </div><!--.prod-details-->

        </div><!--.row-->

      </div><!--.content-->
    </div><!--.container.main-->

    <div class="modal fade" id="bagViewer">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <p class="modal-title" id="modal_title">1 item(s) has been added to bag.</p>
          </div>
          <div class="modal-body clearfix">
            <img id="modal_image" class="pull-left" src="<?php echo$prefix_url?>holder.js/100x150">
            <p style="margin-bottom: 3px; font-size: 13px;"><strong><span id="modal_product_name">Product Name</span></strong></p>
            <p style="color: #999">
              <span id="modal_type_name">Black</span> / 
              <span id="modal_stock_name">S</span>
            </p>
            <p class="m_t_5" style="color: #999" id="modal_qty">1 pc(s)</p>
            <div class="btn-placeholder">
              <a href="<?php echo $prefix_url."bag";?>" class="btn btn-primary" id="modal_view_button">View Bag</a>
              <a data-dismiss="modal" class="btn btn-default">Continue Shopping</a>
            </div>
          </div>
        </div><!--.modal-content -->
      </div><!--.modal-dialog -->
    </div><!--.modal -->

    <!--<div class="modal fade" id="sizeFit">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <p class="modal-title" id="modal_sizefit"><strong>SIZE HELP &amp; PRODUCT MEASUREMENT</strong></p>
          </div>
          <div class="modal-body">
            <table class="table striped"> 
              <thead> 
                <tr> 
                  <th>Size</th> 
                  <th>Chest</th>
                  <th>Length</th>
                  <th>Sleeve</th>
                </tr> 
              </thead>
              <tbody>
                <tr> 
                  <td>S</td>
                  <td>40”/101.6cm</td> 
                  <td>27.5”/69.8cm</td> 
                  <td>9”/22.9cm</td> 
                </tr>
                <tr> 
                  <td>M</td>
                  <td>42”/106.7cm</td> 
                  <td>28.5”/72.4cm</td>
                  <td>9.5”/24.1cm</td> 
                </tr>
                <tr> 
                  <td>L</td> 
                  <td>44”/111.8cm</td> 
                  <td>29.5”/74.9cm</td> 
                  <td>10”/25.4cm</td>
                </tr> 
                <tr> 
                  <td>XL</td> 
                  <td>47”/119cm</td> 
                  <td>30.5”/77.5cm</td>
                  <td>10.5”/26.7cm</td> 
                </tr> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>-->
    
<script src="<?php echo $prefix_url."script/add_bag.js"?>"></script>
<!--WISHLIST-->
<script src="<?php echo $prefix_url."script/add_wishlist.js"?>"></script>
<div class="hidden" id="prefix_redirect">http://<?=$_SERVER['HTTP_HOST'];?><?php echo get_dirname($_SERVER['PHP_SELF']);?></div>


