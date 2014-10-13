<?php
include("get.php");
include("update.php");
include("control.php");
include("custom/orders/details/control.php");


/* --- CALL FUNCITON --- */
$detail_refresh = detail_order($order_number);
$pay_stat       = control_get_payment_status($detail['payment_status']);
$ful_stat       = control_fulfillment_status($detail_refresh['fulfillment_status']);
?>

<form method="post" >
  
  <!-- 
  # ----------------------------------------------------------------------
  # SHIPPING
  # ----------------------------------------------------------------------
   --->
  <div class="modal fade" id="shipping-order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header clearfix">
          <div class="pull-right">
            <input type="hidden" name="link_id" id="link-id">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" onclick="orderPopClose()">
            <input type="submit" class="btn btn-success btn-sm"  value="Confirm" name="btn-order-confirm">
          </div>
          <h4 class="modal-title pull-left" style="font-weight: 200">Deliver Item(s)</h4>
        </div>
        <div class="modal-body">
          <div class="content">
            <ul class="form-set">
              <li class="form-group row">
                <label class="control-label col-xs-3">Courier</label>
                <div class="col-xs-9">
                  <select class="form-control" name="shipping-service" id="id_shipping_service">
                    
					<?php
					foreach($courier_order as $courier_order){
					   echo "<option value=\"".$courier_order['courier_name']."\">".$courier_order['courier_name']."</option>";
					}
					?>
                    
                    </select>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3">Delivery No.</label>
                <div class="col-xs-9">
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
  
  
  
  
  <!-- 
  # ----------------------------------------------------------------------
  # CONFIRM PAYMENT
  # ----------------------------------------------------------------------
  --->
  <div class="modal fade" id="markPaid">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header clearfix">
          <div class="pull-right">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" onclick="sameAmountFix()" id="modal_confirm_btn_cancel">
            <input type="button" class="btn btn-success btn-sm"  value="Confirm" id="modal_confirm_btn_confirm" onclick="clickConfirmed()">
          </div>
          <h4 class="modal-title pull-left" style="font-weight: 200">Mark as Paid</h4>
        </div>
        <div class="modal-body clearfix">
          <div class="" id="modal_confirm_verify">
            <p class="text-center m_b_10">Is the total amount confirmed is the same as total amount paid?</p>
            <div class="outer-center">
              <div class="inner-center">
                <input type="button" class="btn btn-success btn-sm"  value="Yes" name="btn-order-detailing" onclick="clickConfirmed('yes')">
                <input type="button" class="btn btn-default" onclick="sameAmount()" value="No">
              </div>
            </div>
          </div>
          <ul class="form-set hidden" id="modal_confirm_amount">
            <li class="form-group row" id="lbl_modal_method">
              <label class="control-label col-xs-3">Payment Method</label>
              <div class="col-xs-9">
                <select class="form-control" name="modal_confirm_method" id="id_modal_confirm_method">
                  
                  <?php
                  foreach($data_account as $data_account){
				     echo '<option value="'.$data_account['account_bank'].'">'.$data_account['account_bank'].'</option>';
				  }
				  ?>
                  
                </select>
              </div>
            </li>
            <li class="form-group row" id="lbl_modal_name">
              <label class="control-label col-xs-3">Account Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" placeholder="Enter the account name" id="modal_confirm_text_name" name="modal_confirm_name">
              </div>
            </li>
            <li class="form-group row" id="lbl_modal_amount">
              <label class="control-label col-xs-3">Paid Amount</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" placeholder="Enter the total amount paid by customer" id="modal_confirm_text_amount" name="modal_confirm_amount">
              </div>
            </li>
          </ul>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  
  
  
  <!-- 
  # ----------------------------------------------------------------------
  # MARK UNPAID
  # ----------------------------------------------------------------------
  --->
  
  <div class="modal fade" id="mark_unpaid">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header clearfix">
          <div class="pull-right">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" onclick="sameAmountFix()" id="modal_confirm_btn_cancel">
            <input type="button" class="btn btn-success btn-sm"  value="Confirm" id="modal_confirm_btn_confirm" onclick="clickConfirmed()">
          </div>
          <h4 class="modal-title pull-left" style="font-weight: 200">Mark Unpaid</h4>
        </div>
        <div class="modal-body clearfix">
          <div class="" id="modal_confirm_verify">
            <p class="text-center m_b_10">Is the total amount confirmed is the same as total amount paid?</p>
            <div class="outer-center">
              <div class="inner-center">
                <input type="button" class="btn btn-success btn-sm"  value="Yes" name="btn-order-detailing" onclick="clickConfirmed()">
                <input type="button" class="btn btn-default" onclick="sameAmount()" value="No">
              </div>
            </div>
          </div>
          <ul class="form-set hidden" id="modal_confirm_amount">
            <li class="form-group row">
              <label class="control-label col-xs-3">Paid Amount</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" placeholder="Enter the total amount paid by customer" id="modal_confirm_text_amount" name="modal_confirm_amount">
              </div>
            </li>
          </ul>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  
  <!-- 
  # ----------------------------------------------------------------------
  # CANCEL ORDER
  # ----------------------------------------------------------------------
  --->
  <div class="modal fade" id="cancelOrder">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header clearfix">
          <div class="pull-right">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel">
            <input type="submit" class="btn btn-success btn-sm"  value="Confirm" name="">
          </div>
          <h4 class="modal-title pull-left" style="font-weight: 200">Cancel Order</h4>
        </div>
        <div class="modal-body clearfix">
          <div class="hidden">
            <p class="text-center m_b_10">Is the total amount confirmed is the same as total amount paid?</p>
            <div class="outer-center">
              <div class="inner-center">
                <button class="btn btn-success">Yes</button>
                <button class="btn btn-default">No</button>
              </div>
            </div>
          </div>
          <ul class="form-set">
            <li class="form-group row">
              <label class="control-label col-xs-3">Reason</label>
              <div class="col-xs-9">
                <select class="form-control">
                  <option>Customer cancelled order</option>
                  <option>Product is defected</option>
                  <option>Order can not be fulfilled</option>
                </select>
              </div>
            </li>
            <li class="checkbox col-xs-offset-3"><!--only showed up if payment status is paid and default yes-->
              <label>
                <input checked type="checkbox" value="y"> Refund payment
              </label>
            </li>
            <li class="checkbox"><!--default no if reason = product is defected & order can not be fulfilled-->
              <label>
                <input checked type="checkbox" value="y"> Restock inventory
              </label>
            </li>
            <li class="checkbox"><!--default yes-->
              <label>
                <input checked type="checkbox" value="y"> Notify customer about cancellation
              </label>
            </li>
          </ul>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <button class="btn btn-primary hidden" data-toggle="modal" data-target="#markPaid">asd</button>

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
        <input type="button" class="btn btn-default btn-sm hidden" value="Add Notes">
        <input type="button" class="btn btn-default btn-sm hidden" value="Print">
        <a href="<?php echo $prefix_url."order-detail/".$detail['order_number'];?>">
          <input type="button" class="btn btn-info btn-sm" value="Edit Order">
        </a>
        <input type="button" class="btn btn-danger btn-sm hidden" value="Cancel Order" onclick="popShow()">
      </div>
    </div>
  </div>

      <?php
      /* ALERT */
      if(!empty($_SESSION['alert'])){
        echo "<div class=\"alert ".$_SESSION['alert']."\">";
        echo "<div class=\"container\">".$_SESSION['msg']."</div>";
        echo "</div>";
      }
      ?>

  <div class="container main">

    <div class="row">

      <div class="col-xs-8">
        <div class="box row">
          <div class="desc col-xs-3">
            <h3>Payment</h3>
            <p>Payment status:</p>
            <div class="stat <?php echo $pay_stat;?>" style="margin-top: 10px" id="payment-status"><?php echo $detail['payment_status'];?></div>
          </div>
            
          <div class="content col-xs-9" style="height: 300px;">
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
                
                <?php
                /* --- PAYMENT METHOD --- */
				if(!empty($detail['order_confirm_bank'])){
				   echo '<p class="col-xs-9 control-label">Bank Transfer via '.$detail['order_confirm_bank'].'</p>';
				}else{
				   echo '<p class="col-xs-9 control-label">Bank Transfer via '.$detail['order_payment_method'].'</p>';
				}
				?>
                
                <div class="col-xs-9">
                  <select type="text" class="hidden form-control" name="order_payment_method">
                    <option value="<?php echo $detail['order_payment_method']?>">Bank Transfer via BCA</option>
                  </select>
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3" for="url-handle">Account name</label>
                <p class="col-xs-9 control-label"><?php if(!empty($detail['order_confirm_name'])){ echo $detail['order_confirm_name'];}else{ echo "N/A";}?></p>
                <div class="col-xs-9">
                  <input type="text" class="hidden form-control url" value="<?php echo $detail['user_fullname'];?>" name="order_confirm_name">
                </div>
              </li>
              <li class="form-group row">
                <label class="control-label col-xs-3">Amount</label>
                <p class="col-xs-9 control-label"><?php if(!empty($detail['order_confirm_amount'])){ echo "IDR ".number_format($detail['order_confirm_amount'],0,',','.');}else{ echo "N/A";}?></p>
                <div class="col-xs-9">
                  <input type="text" class="hidden form-control url" value="<?php echo $detail['order_total_amount']?>" name="order_confirm_amount">
                  <input type="hidden" name="redirect_order_number" value="<?php echo $detail['order_number']?>">
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
              <!--<li class="form-group row">
                  <label class="control-label col-xs-3"><div style="color:#cf4f4f">Underpaid</div></label>
                  <p class="" style="color: #cf4f4f"><?php echo price($detail['order_total_amount'] - $detail['order_confirm_amount'])?></p>
              </li>-->
            </ul>
          </div>
        </div><!--box row-->
      </div>

      <div class="col-xs-4" style="padding-left: 30px">
        <div class="box row">
          <div class="content col-xs-12" style="height: 300px">
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
              <li><?php echo preg_replace("/\n/","\n<br>",$detail['order_shipping_address']);;?></li>
              <li><?php echo $detail['order_shipping_city']?></li>
              <li><?php echo $detail['order_shipping_province']?></li>
              <li><?php echo $detail['order_shipping_country']?></li>
            </ul>
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
			if($detail['fulfillment_status'] != "Delivered"){
			   echo "<input type=\"button\" class=\"btn btn-success btn-sm\" id=\"btn-deliver-item\" onclick=\"validShippingOrder()\">";
			}
			?>

            <input type="button" class="btn btn-success btn-sm hidden" id="btn-deliver-items" data-toggle="modal" href="#shipping-order" onclick="orderPop()">
            
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
				
				foreach($product_item as $product){
				   $row++;
				?>
                
                
                <!--
                <tr class="<?php echo $tr_class;?>" id="<?php echo "row_".$row?>" <?php if($product['fulfillment_date'] == "0000-00-00 00:00:00"){?>onclick="selectRow('<?php echo $row;?>')"<?php }?>>
                <td><input type="checkbox" checked="checked" disabled="disabled" name="item_id[]" value="<?php echo $product['type_id']?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')">
                
				<?php 
				/* BACKUP DISBALED CHECKBOX */
				echo "<input type=\"hidden\" name=\"backup_item_id[]\" class=\"hidden\" value=\"".$product['type_id']."\">";
				?>
                
                </td>
                <td class="large">
                   <img src="<?php echo $prefix_url."static/thimthumb.php?src=../".$product['img_src']."&h=60&w=80&q=100";?>" width="80" height="60">
                      <div class="data">
                         <div class="name"><a href="<?php echo $prefix_url."product-details-".$product['product_alias']?>"><?php echo $product['product_name'];?></a></div>
                         <div class="attribute"><?php echo $product['type_name'];?></div>
                         <div class="attribute"><?php echo $product['stock_name'];?></div>
                         <div class="courier">
                         
                           <b><?php echo $product['services'];?></b> 
                           <?php if(!empty($product['shipping_number'])){ echo "<br># ".$product['shipping_number'];}?><br>
                           <?php if($product['fulfillment_date'] == "0000-00-00 00:00:00" ){ echo "";}else{ echo format_date($product['fulfillment_date']);}?>
                         </div>
                       </div>
                       
                     </td>
                     
                     <td class="medium">
                       <p class="currency">IDR</p>
                       <?php
					   $now_price = $item['item_price'] - $item['item_discount_price'];
					   if($product['type_price'] != $now_price){
						  echo "<p class=\"amount\" style=\"text-decoration:striketrough;\"><em><strike>".price($product['type_price'])."</strike></em></p>";
					   }
					   ?>
                       
                       <p class="amount"><?php echo price($now_price);?></p>
                     </td>
                     
                     <td class="small">
                       <div class="outer-center">
                         <div class="inner-center">
                           <p><?php echo $item['item_quantity'];?></p>
                         </div>
                       </div>
                     </td>
                     
                     <td class="medium">
                       <p class="currency">IDR</p>
                       <?php
					   $total_item        = $item['item_quantity'] * $now_price;
					   $total_item_normal = $item['item_quantity'] * $product['type_price']; 
					   $sub_total         += $total_item;
					   $discount          = $product['type_price'] - $now_price;
					   $total_discount    += $discount; 
					   ?>
                       
                       <p class="amount"><?php echo price($total_item);?></p>
                     </td>
                   </tr>
                   -->
                   
                   
<!--<tr class="<?php echo $tr_class;?>" id="<?php echo "row_".$row?>" <?php if($product['fulfillment_date'] == "0000-00-00 00:00:00"){?>onclick="selectRow('<?php echo $row;?>')"<?php }?>>-->
              
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
                      <?php
  										?>                 
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
                </td>
                <td>
                  <p class="text-center"><?php echo $item['item_quantity'];?></p>
                </td>

                <td>
                  <p class="col-xs-3 text-left">IDR</p>
                  
                  <?php
                  $total_item        = $item['item_quantity'] * $now_price;
				  ?>
                  
                  <p class="col-xs-9 text-right"><?php echo price($total_item);?></p>
                </td>
              </tr>
              
             <?php 
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

</form>


<script src="<?php echo $prefix_url.'script/confirm-order.js'?>"></script>        
<script>
$('#pop-up-order').hide();

function popShow(){
   $('#pop-up-order').fadeIn("fast");
}

function closePop(){
   $('#pop-up-order').fadeOut("fast");
}


/* SHIPPING ORDER POP UP*/
$('#shipping-order').hide();

function orderPop(){
   $('#shipping-order').fadeIn("fast");
}

function orderPopClose(){
   $('#shipping-order').fadeOut("fast");
}


/* COUNT CHECKBOX */
function checkedCount(){
   var check = $('.table input:checked').size();
   $('#btn-deliver-item').val('Deliver '+check+' item(s)');
}
checkedCount();
$(":checkbox").click(checkedCount);


// CHANGE POLICY DELIVERY

/* VALIDATION BUTTON DELIVER ITEM*/
function validShippingOrder(){
   var payment = $('#payment-status').text();
   
   //if(payment != "Paid"){
      //$('#hidden-btn-deliver').click();
   //}else{
      $('#btn-deliver-items').click();
   //}
}
</script>

<?php
/* RESET ALERT */
if($_POST['deliver-validation'] == ""){
   //unset($_SESSION['alert']);
   //unset($_SESSION['msg']);
}
?>

<?php include("custom/orders/details/index.php"); ?>