<?php
include("get.php");
include("update.php");
include("control.php");
?>


<form method="post" enctype="multipart/form-data">


  <!-- 
  # ----------------------------------------------------------------------
  # ADD PRODUCT
  # ----------------------------------------------------------------------
   --->
  <div class="modal fade" id="shipping-order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header clearfix">
          <div class="pull-right">
            <input type="hidden" name="link_id" id="link-id">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" onclick="orderPopClose()">
            <input type="submit" class="btn btn-success btn-sm"  value="Add Product" name="btn-edit-order">
          </div>
          <h4 class="modal-title pull-left" style="font-weight: 200">Add Product(s)</h4>
        </div>
        <div class="modal-body">
          <div class="content">
            <ul class="form-set">
              <li class="form-group row">
                <label class="control-label col-xs-3">Product</label>
                <div class="col-xs-9">
                  <select class="form-control btn-xs" name="payment_method" id="id_shipping_service">
                    
					<?php
					foreach($modal_data_product as $modal_data_product){
					   echo "<option value=\"".$modal_data_product['id']."\">".$modal_data_product['product_name']."</option>";
					}
					?>
                    
                    </select>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3">Type</label>
                <div class="col-xs-5">
                  <select class="form-control">
                     <option value="0">White</option>
                     <option value="1">Blue</option>
                     <option value="2">Black</option>
                  </select>
               
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3">Size</label>
                <div class="col-xs-2">
                  <select class="form-control">
                     <option value="0">S</option>
                     <option value="1">M</option>
                     <option value="2">L</option>
                  </select>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3">qty</label>
                <div class="col-xs-2">
                  <input type="text" class="form-control" name="order_shipping_number">
                </div>
              </li>
              <li class="form-group row">
                <div class="col-lg-offset-3 col-lg-9">
                  <div class="checkbox">
                    <label>
                      <input checked type="checkbox" value="y" name="notify-deliver"> Notify customer
                    </label>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="subnav">
    <div class="container clearfix">
      <h1>
        <span class="glyphicon glyphicon-inbox"></span> &nbsp;
        <a href="<?php echo $prefix_url."order"?>">Orders</a> 
        <span class="info">/</span> Order #<?php echo $detail['order_number'];?>
        
        <?php
        if($detail['order_status'] == 'Expired'){
		   echo '<span class="expired">Expired</span>';
		}else if($detail['order_status'] == 'Cancelled'){
		   echo '<span class="cancelled">Cancelled</span>';
		}
		?>
        
      </h1> 
      <div class="btn-placeholder">
        <a href="<?php echo $prefix_url."order-detailing/".$detail['order_number'];?>">
          <input type="button" class="btn btn-default btn-sm " value="Cancel">
        </a>
        <input type="submit" class="btn btn-info btn-sm btn-success" value="Save Changes" name="btn-edit-order">
      </div>
    </div>
  </div>
  
  <?php
  if(!empty($_SESSION['alert'])){
     echo "<div class=\"alert ".$_SESSION['alert']."\">";
	 echo "  <div class=\"container\">".$_SESSION['msg']."</div>";
	 echo "</div>";
  }
  
  if(empty($_POST['btn-edit-order'])){
     unset($_SESSION['alert']);
	 unset($_SESSION['msg']);
  }
  ?>
  
  <div class="container main">
    <div class="row">
      <div class="col-xs-8">
        <div class="box row" id="box_row_left">
          <div class="desc col-xs-3">
            <h3>Payment</h3>
            <p>Payment status:</p>
            <div class="stat <?php echo $pay_stat;?>" style="margin-top: 10px" id="payment-status"><?php echo $detail['payment_status'];?></div>
          </div>
            
          <div class="content col-xs-9">
            <div class="btn-placeholder" style="position: absolute; top: 20px; right: 15px; z-index:2;">
              <?php 
			  if($detail['payment_status'] != "Paid"){
			  ?>
              <input type="button" class="btn btn-success btn-sm" value="Mark as Paid" data-toggle="modal" data-target="#markPaid" onclick="sameAmountFix()">
              <input type="hidden" name="mark_as_paid" value="<?php echo $detail['order_id']?>">
              <!--</form>-->
              <?php 
              }else if($detail['payment_status'] == 'Paid'){
			  ?>
              <input type="button" class="btn btn-danger btn-sm" value="Mark as Unpaid" data-toggle="modal" data-target="#mark_unpaid" onclick="sameAmountFix()">
              <input type="hidden" name="mark_as_paid" value="<?php echo $detail['order_id']?>">
              <!--</form>-->
              <?php
			  }
              ?>
            </div>
            <ul class="form-set">
              <li class="form-group row underlined">
                <label class="control-label col-xs-3">Amount Due</label>
                <p class="col-xs-9 control-label"><b>IDR <?php echo price($detail['order_total_amount']);?></b></p>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3">Payment method</label>
                <div class="col-xs-9">
                  <select type="text" class="form-control" name="order_payment_method">
                    
					<?php
                    foreach($data_bank as $data_bank){
					   echo '<option value="'.$data_bank['account_bank'].'"';
					   if($data_bank['account_bank'] == $detail['order_confirm_bank']){
					      echo ' selected="selected" ';
					   }
					   echo '>'.$data_bank['account_bank'].'</option>';
					}
					?>
                    
                  </select>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3" for="url-handle">Account name</label>
                <p class="col-xs-9 control-label hidden"><?php if(!empty($detail['order_confirm_name'])){ echo $detail['order_confirm_name'];}else{ echo "N/A";}?></p>
                <div class="col-xs-9">
                  <input type="text" class="form-control url" value="<?php echo $detail['order_confirm_name'];?>" name="order_confirm_name">
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3">Amount</label>
                <p class="col-xs-9 control-label hidden"><?php if(!empty($detail['order_confirm_amount'])){ echo "IDR ".price($detail['order_confirm_amount']);}else{ echo "N/A";}?></p>
                <div class="col-xs-9">
                  <input type="text" class=" form-control url" value="<?php echo price($detail['order_confirm_amount']);?>" name="order_confirm_amount">
                  <?php 
                  if($detail['order_total_amount'] > $detail['order_confirm_amount'] and $detail['payment_status'] != "Unpaid"){
                     echo '<p class="help-block" style="color: #cd1207"> Underpaid: '.price($detail['order_total_amount'] - $detail['order_confirm_amount']).'</p> <br>';
                     //echo '</li> <br>';
                  }else if($detail['order_total_amount'] < $detail['order_confirm_amount'] and $detail['payment_status'] != "Unpaid"){
                     echo '<p class="help-block" style="color: #48bc3c"> Overpaid: '.price($detail['order_confirm_amount'] - $detail['order_total_amount']).'</p> <br>';
                     //echo '</li> <br>';
                  }
                  ?>
                </div>
              </li>
              
              <?php 
              if($detail['order_confirm_amount'] > 0){
                 //flag_paid($detail['order_confirm_amount'], $detail['order_total_amount']);
              }
              ?>
            </ul>
          </div>
        </div><!--box row-->
      </div>

      <div class="col-xs-4" style="padding-left: 30px">
        <div class="box row" id="box_row_right">
          <div class="content col-xs-12">
            <ul class="form-set">
              <li class="form-group row underlined">
                <div class="col-xs-12">
                  <h4><a href="<?php echo $prefix_url."customer/".cleanurl(strtolower($detail['user_alias']));?>"><?php echo $detail['user_first_name']." ".$detail['user_last_name'];?></a></h4>
                  <p><a href="mailto:<?php echo $detail['user_email'];?>"><?php echo $detail['user_email'];?></a></p>
                  <p><?php echo $detail['user_phone'];?></p>
                  <p><?php echo $detail['user_status'];?></p>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3" for="page-description">Ship to</label>
                <!--<p class="control-label col-xs-9">Address 1</p>-->
                <div class="col-xs-9">
                  <select type="text" class="form-control" disabled="disabled">
                    <option>Address 1</option>
                  </select>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3" for="page-description">Address</label>
                
                <div class="col-xs-9">
                  <textarea name="order_shipping_address" class="form-control" rows="5">
			         <?php echo $detail['order_shipping_address'];?>
                  </textarea>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3" for="page-description">Country</label>
                <div class="col-xs-9">
			      <select class="form-control" name="order_shipping_country" id="id_order_shipping_country" onchange="ajax_province()">
                    <?php
                    foreach($country as $country){
					   echo '<option value="'.$country['country_name'].'" ';
					   
					   if($country['country_name'] == $detail['order_shipping_country']){
					      echo 'selected="selected"';
					   }
					   
					   echo'>'.$country['country_name'].'</option>';
					}
					?>
                  </select>
                </div>
			    <?php //echo $detail['order_shipping_country']?>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3" for="page-description">Province</label>
                <div class="col-xs-9">
			      <select class="form-control" name="order_shipping_province" id="id_order_shipping_province" onchange="ajax_city()">
                    
					<?php
                    foreach($province as $province){
					   echo '<option value="'.$province['province_name'].'" ';
					   
					   if($province['province_name'] == $detail['order_shipping_province']){
					      echo 'selected="selected"';
					   }
					   
					   echo'>'.$province['province_name'].'</option>';
					}
					?>
                    
                  </select>
                </div>
				<?php //echo $detail['order_shipping_city']?>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3" for="page-description">City</label>
                <div class="col-xs-9">
			      <select class="form-control" name="order_shipping_city" id="id_order_shipping_city">
                    
					<?php
                    foreach($city as $city){
					   echo '<option value="'.$city['city_name'].'" ';
					   
					   if($city['city_name'] == $detail['order_shipping_city']){
					      echo 'selected="selected"';
					   }
					   
					   echo'>'.$city['city_name'].'</option>';
					}
					?>
                    
                  </select>
                </div>
			    <?php //echo $detail['order_shipping_province']?>
              </li></ul>
          </div>
        </div><!--box-row-->
      </div>

    </div><!--row-->
    
                
    <form method="post">

      <div class="box row">
        <div class="desc col-xs-2">
          <h3>Fulfillment</h3>
          <p>Fulfillment status:</p>
          <div class="stat <?php echo $ful_stat;?>" style="margin-top: 10px"><?php echo $detail_refresh['fulfillment_status'];?></div>
        </div>
                    
        <div class="content col-xs-10">
          <div class="btn-placeholder" style="position: absolute; top: 20px; right: 20px; z-index:2;"> 
            <?php 
			//if($detail['fulfillment_status'] != "Delivered"){
			   //echo "<input type=\"button\" class=\"btn btn-success btn-sm\" id=\"btn-deliver-item\" onclick=\"validShippingOrder()\" value=\"Add Product\">";
			//}
			?>

            <input type="button" class="btn btn-success btn-sm" id="btn-deliver-items" data-toggle="modal" href="#shipping-order" onclick="orderPop()" value="Add Product">
            
            <?php
            /* BUTTON FOR SENDING $_SESSION['alert'] AND $_SESSION['msg']*/
			echo "<input type=\"submit\" name=\"deliver-validation\" id=\"hidden-btn-deliver\" value=\"validation\" class=\"hidden\">";
			
            /* --- MARK AS PAID BUTTON --- */
			echo '<input type="submit" class="btn btn-success btn-sm hidden" value="Mark as Paid" id="btn_mark_as_paid" name="btn-order-detailing">';
			
			/* GET ORDER INFORMATION */
			echo "<input type=\"hidden\" name=\"hidden_order_id\" value=\"".$detail['order_id']."\" >";
			echo '<input type="hidden" name="hidden_order_status" value="'.$detail['order_status'].'">';
			echo '<input type="hidden" name="hidden_order_confirm_name" value="'.$detail['order_confirm_name'].'">';
			echo '<input type="hidden" name="hidden_order_confirm_bank" value="'.$detail['order_confirm_bank'].'">';
			echo '<input type="hidden" name="hidden_order_confirm_amount" value="'.$detail['order_confirm_amount'].'">';
			echo '<input type="hidden" name="hidden_order_purchase_amount" value="'.$detail['order_purchase_amount'].'">';
			echo '<input type="hidden" name="hidden_order_shipping_amount" value="'.$detail['order_shipping_amount'].'">';
			echo '<input type="hidden" name="redirect_order_number" value="'.$detail['order_number'].'">';
			echo '<input type="hidden" name="hidden_order_shipping_method" id="id_hidden_order_shipping_method" value="'.$detail['shipping_method'].'">';
			?>
            
          </div>
                        
          <ul class="form-set">
            <li class="form-group row underlined">
              <label class="control-label col-xs-3" for="url-handle">Shipping preference</label>
              <p class="control-label col-xs-9"><?php echo $detail['shipping_method'];?></p>
              <!--
              <div class="col-xs-9">
                <select type="text" class="form-control">
                  <option>JNE Regular</option>
                  <option>JNE Express</option>
                </select>
              </div>
              -->
            </li>
          </ul>

          <table class="table">
            <thead>
              <tr class="headings">
                <th width="5%"></th>
                <th width="45%">Item(s)</th>
                <th width="20%" style="text-align: center">Price</th>
                <th width="10%" style="text-align: center">Qty.</th>
                <th width="20%" style="text-align: center">Total</th>
              </tr>
            </thead>
                
            <tbody>
                
             <?php
			 $detail_item = detail_order_item($detail['order_id']);
			 $row=0;
			 
			 foreach($detail_item as $item){
				$tr_ful_stat = $item['fulfillment_status'];
				
				if($tr_ful_stat == "Unfulfilled"){
				   $tr_class = "";
				   $checked  = "";
				}else if($tr_ful_stat == "Partial" || $tr_ful_stat == "Delivered"){
				   $tr_class = "delivered";
				}
				
				// CALL FUNCTION
				$product_item = detail_order_item_product($item['type_id'], $detail['order_id']);
				
				foreach($product_item as $key=>$product){
				   $row++;
				?>
              
              <tr class="<?php echo $tr_class;?>" id="<?php echo "row_".$row?>">
              
                <td><input type="checkbox" checked="checked" disabled="disabled" name="item_id[]" value="<?php echo $product['type_id']?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')">
                
                <?php 
				/* BACKUP DISBALED CHECKBOX */
				echo "<input type=\"hidden\" name=\"backup_item_id[]\" value=\"".$product['type_id']."\">";
				?>
                </td>
                                      
                <td>
                  <img class="pull-left img-order-size" src="<?php echo $prefix_url."../".$product['img_src'];?>">
                  <div>
                    <p><a href="<?php echo $prefix_url."product-details-".$product['product_alias']?>"><?php echo $product['product_name'];?></a></p>
                    <p><?php echo $product['type_name'];?></p>
                    <p><?php echo $product['stock_name'];?></p>
                    <div class="courier">              
                      <b><?php echo $product['services'];?></b> 
                      <?php if(!empty($product['shipping_number'])){ echo "<br># ".$product['shipping_number'];}?><br>
                      <?php if($product['fulfillment_date'] == "0000-00-00 00:00:00" ){ echo "";}else{ echo format_date($product['fulfillment_date']);}?>
                    </div>
                  </div>
                </td>

                <td>
                  <p class="col-xs-3 text-left">IDR</p>
                  
                  <?php
				  if(!empty($product['promo_item_id']) and $product['promo_start_datetime'] <= date('Y-m-d') and $product['promo_end_datetime'] >= date('Y-m-d')){
                     $now_price = get_price($product['promo_id'], $product['promo_value'], $product['type_price']);
					 
					 echo "<p class=\"amount\" style=\"text-decoration:striketrough;\"><em><strike>".price($product['type_price'])."</strike></em></p>";
				  }else if($product['order_voucher_value'] != 0){
				     $now_price = $product['type_price'] - $product['item_discount_price'];
				     echo "<p class=\"amount\" style=\"text-decoration:striketrough;\"><em><strike>".price($product['type_price'])."</strike></em></p>";
				  }else{
				     $now_price = $product['type_price'];
				  }
				  ?>
                  
                  <p class="col-xs-9 text-right"><?php echo price($now_price);?></p>
                  <?php
                  echo '<input type="hidden" id="id_hidden_price_item_'.$row.'" value="'.$product['type_price'].'">';
				  ?>
                </td>
                <td>
                  <p class="text-center">
				    <input type="text" class="form-control" name="product_qty_<?php echo $product['item_id'];?>" value="<?php echo $item['item_quantity'];?>" id="id_qty_<?php echo $row;?>" onkeyup="check_qty('<?php echo $product['item_id'];?>')" onkeypress="check_stock('<?php echo $product['item_id'];?>')"/>
				    <input type="hidden" value="<?php echo $item['item_quantity'];?>" id="id_hidden_qty_<?php echo $product['item_id'];?>"/>
                    <input type="checkbox" id="id_chk_qty_<?php echo $product['item_id'];?>" value="<?php echo $product['item_id'];?>" name="chk_qty[]" class="hidden">
                    <p id="id_alert_stock_<?php echo $product['item_id'];?>" class="hidden">Available only:</p>
                  </p>
                </td>

                <td>
                  <p class="col-xs-3 text-left">IDR</p>
                  
                  <?php
                  $total_item        = $item['item_quantity'] * $now_price;
				  $total_weight      += $product['type_weight']*$item['item_quantity'];
				  ?>
                  
                  <p class="col-xs-9 text-right"><?php echo price($total_item);?></p>
                </td>
              </tr>
              
             <?php 
			 
				echo '<input type="hidden" id="id_hidden_item_weight_'.$row.'" name="hidden_item_weight_'.$row.'" value="'.$product['type_weight'].'">';
				echo '<input type="hidden" id="id_hidden_item_stock_'.$row.'" value="'.$product['stock_quantity'].'" name="hidden_item_stock_'.$product['item_id'].'">';
				
				}// foreach($product_item as $product)
			 
			 }// foreach($detail_item as $item)
			 ?>
             
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4">
                  <p class="text-right">Subtotal</p>
                </td>
                <td>
                  <p class="col-xs-3 text-left">IDR</p>
                  <p class="col-xs-9 text-right"><?php echo price($detail['order_purchase_amount']);?></p>
                </td>
              </tr>
              <tr class="hidden">
                <td colspan="4">
                  <p class="text-right">Discount</p>
                </td>
                <td>
                  <p class="col-xs-3 text-left">IDR</p>
                  <p class="col-xs-9 text-right"><?php echo price($detail['order_discount_amount']);?></p>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <p class="text-right">Shipping</p>
                </td>
                <td>
                  <p class="col-xs-3 text-left">IDR</p>
                  <p class="col-xs-9 text-right"><?php echo price($detail['order_shipping_amount']);?></p>
                </td>
              </tr>
              <tr>
                <td colspan="4">
                  <p class="text-right">Total</p>
                </td>
                <td>
                  <p class="col-xs-3 text-left">IDR</p>
                  <p class="col-xs-9 text-right"><b><?php echo price($detail['order_total_amount']);?></b></p>
                </td>
              </tr>
            </tfoot>
          </table>

        </div>

      </div><!--container main-->
    </div><!--main-content-->
    
    <?php
	/* --- GET ORDER ITEM INFORMATION --- */
    echo '<input type="hidden" name="hidden_total_weight" id="id_hidden_total_weight" value="'.$total_weight.'">';
    echo '<input type="hidden" name="hidden_total_purchase" id="id_hidden_total_purchase" value="'.$detail['order_purchase_amount'].'">';
	?>
</form>

<script src="<?php echo $prefix_url;?>script/order_detail.js"></script>
<script>
same_height();
total_weight();
</script>
