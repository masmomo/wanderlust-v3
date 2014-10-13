<?php
include('get.php');
include('update.php');
include("control.php");

include("custom/orders/control.php");
?>

<form name="index-order" method="post" enctype="multipart/form-data">


    <div class="subnav clearfix">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-inbox"></span> &nbsp;Orders</h1>
        <div class="btn-placeholder hidden">
          <input type="button" class="btn btn-success btn-sm" value="Place Order" name="order-index">
        </div>
        <ul class="subnav-link clearfix">
          <li><a href="<?php echo $prefix_url."order-open";?>">Open</a></li> <!--set this as default-->
          <li>/</li>
          <li><a href="<?php echo $prefix_url."order-expired";?>">Expired</a></li>
          <li>/</li>
          <li><a href="<?php echo $prefix_url."order-cancelled";?>">Cancelled</a></li>
          <li>/</li>
          <li class="active"><a href="<?php echo $prefix_url."order";?>">All</a></li> 
        </ul>
      </div>

    </div>

    <div class="container main">
      <div class="box row">
        <div class="content">
          <div class="actions clearfix">
            <div class="pull-left">
              <div class="pull-left custom-select-all" onclick="selectAllToggle()">
                <input type="checkbox" id="select_all">
              </div>
              <div class="divider"></div>
              <p>Page</p>
              <select class="form-control" id="page-option" onchange="pageOption()">
			    <?php view_page($total_page, $_REQUEST['pg']);?>
              </select>
              <p>of <strong><?php echo $total_page;?></strong> pages</p>
              <div class="divider"></div>
              <p>Show</p>
              <select class="form-control" name="query_per_page" id="query_per_page_input" onchange="changeQueryPerPage()">
                <?php view_per_page($query_per_page);?>
              </select>
              <p>of <strong><?php echo $total_query;?></strong> records</p>
            </div>
            
            <div class="pull-right">
              <p>Actions</p>
              <select class="form-control" name="option-action" id="news-action" onchange="changeOption()">
                <option value="delete">Delete</option>
                <option value="change">Set Status</option>
              </select>
              <p id="lbl-news-option" class="hidden">to</p>
              <select class="form-control" name="option-status" id="news-option" disabled="disabled" class="hidden">
                <option disabled>Payment</option>
                <option value="Unpaid">&nbsp;Unpaid</option>
                <option value="Confirmed" disabled="disabled">&nbsp;Confirmed</option>
                <option value="Paid" disabled="disabled">&nbsp;Paid</option>
                <option disabled></option>
                <option disabled>Fulfillment</option>
                <!--<option value="Unfulfilled">&nbsp;Unfulfilled</option>-->
                <option value="In Process">&nbsp;In Process</option>
                <option value="Delivered" disabled="disabled">&nbsp;Delivered</option>
                <option disabled></option>
                <option disabled>Order</option>
                <option value="Unfulfilled">&nbsp;Active</option>
                <option value="Expired">&nbsp;Expired</option>
                <option value="Cancelled">&nbsp;Cancelled</option>
              </select>
              <input type="submit" class="btn btn-success pull-left" name="index-order" value="GO">
            </div>
          </div><!--actions-->

          <table class="table">
            <thead>
              <tr class="headings">
                <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open hidden" onclick="showEye()"></span></th>
                <th class="sort" width="80" onclick="sortBy('order_number')"> Order # <?php echo $arr_order_number;?></th>
                <th class="sort" width="120" onclick="sortBy('order_date')">Date <?php echo $arr_order_date;?></th>
                <th class="sort" width="190" onclick="sortBy('order_confirm_name')">Customer <?php echo $arr_confirm_name;?></th>
                <th class="sort" width="170" onclick="sortBy('order_confirm_bank')">Payment Method <?php echo $arr_confirm_bank;?></th>
                <th class="sort" width="80"  onclick="sortBy('order_confirm_amount')">Amount <?php echo $arr_confirm_amount;?></th>
                <th class="sort" width="100" onclick="sortBy('payment_status')">Payment <?php echo $arr_payment_status;?></th>
                <th class="sort" width="100" onclick="sortBy('fulfillment_status')">Fulfillment <?php echo $arr_fulfillment_status;?></th>
              </tr>
              <tr class="filter" id="filter">
              <th>
                <a href="<?php echo $prefix_url."order"?>">
                  <button type="button" style="width: 100%;" class="btn btn-danger btn-xs reset <?php echo $reset;?>" value="">
                    <span class="glyphicon glyphicon-remove"></span>
                  </button>
                </a>
              </th>
              <th>
                <input type="text" class="form-control" id="order_number_search" onkeyup="searchQuery('order_number')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], order_number);?>>
              </th>
              <th>
                <input type="text" class="form-control" id="order_date_search" onkeyup="searchQuery('order_date')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], order_date);?>>
              </th>
              <th>
                <input type="text" class="form-control" id="order_billing_fullname_search" onkeyup="searchQuery('order_billing_fullname')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], order_billing_fullname);?>></th>
              <th>
                <select class="form-control" id="order_payment_method_search" onchange="searchQueryOption('order_payment_method')" <?php order_disabling_search($_REQUEST['src'], order_payment_method);?>>
                  <option value="All"></option>
                  <option value="BCA" <?php if($search == "order_confirm_bank=bca"){ echo 'selected="selected"';}?>>Bank Transfer via BCA</option>
                  <option value="Mandiri" <?php if($search == "order_confirm_bank=mandiri"){ echo 'selected="selected"';}?>>Bank Transfer via Mandiri</option>
                  <option value="Credit Card" <?php if($search == "order_confirm_bank=credit card"){ echo 'selected="selected"';}?>>Credit Card</option>
                  <option value="Paypal" <?php if($search == "order_confirm_bank=paypal"){ echo 'selected="selected"';}?>>PayPal</option>
                  <option value="COD" <?php if($search == "order_confirm_bank=cod"){ echo 'selected="selected"';}?>>Cash on Delivery</option>
                </select>
              </th>
              <th><input type="text" class="form-control" id="order_total_amount_search" onkeyup="searchQuery('order_total_amount')" onkeypress="return disableEnterKey(event)" disabled></th>
              <th>
                <select class="form-control" id="payment_status_search" onchange="searchQueryOption('payment_status')" <?php order_disabling_search($_REQUEST['src'], payment_status);?>>
                  <option value="All"></option>
                  <option value="Unpaid" <?php if($get_last_char_payment_status == "Unpaid"){ echo 'selected="selected"';}?>>Unpaid</option>
                  <option value="Confirmed" <?php if($get_last_char_payment_status == "Confirmed"){ echo 'selected="selected"';}?>>Confirmed</option>
                  <option value="Paid" <?php if($get_last_char_payment_status == "Paid"){ echo 'selected="selected"';}?>>Paid</option>
                </select>
              </th>
              <th>
                <select class="form-control" id="fulfillment_status_search" onchange="searchQueryOption('fulfillment_status')" <?php order_disabling_search($_REQUEST['src'], fulfillment_status);?>>
                  <option value="All"></option>
                  <option value="Unfulfilled" <?php if($get_last_char_fulfillment_status == "Unfulfilled"){ echo 'selected="selected"';}?>>Unfulfilled</option>
                  <option value="In Process" <?php if($get_last_char_fulfillment_status == "In Process"){ echo 'selected="selected"';}?>>In Process</option>
                  <option value="Partial" <?php if($get_last_char_fulfillment_status == "Partial"){ echo 'selected="selected"';}?>>Partial</option>
                  <option value="Delivered" <?php if($get_last_char_fulfillment_status == "Fulfilled"){ echo 'selected="selected"';}?>>Delivered</option>
                  <!--<option value="Cancelled" <?php if($get_last_char_fulfillment_status == "Cancelled"){ echo 'selected="selected"';}?>>Cancelled</option>
                  <option value="Expired" <?php if($get_last_char_fulfillment_status == "Expired"){ echo 'selected="selected"';}?>>Expired</option>-->
                </select>
              </th>
            </tr>
          </thead>
          
          <tbody>
		    <?php 
			if($total_query < 1){
			   echo '<tr><td class="no-record" colspan="8">No records found.</td></tr>';	
			}
			
						
			$row=0;
			
			foreach( $listing_order as $all_orders){
			   $row++;
			   
			   /* --- CALL FUNCTION --- */
			   
			   // FORMAT DATE
			   $order_date = format_date($all_orders['order_date']);
			   
			   
			   // CAPITALING BANK NAME
			   $order_confirm_bank = capitaling_bank_name($all_orders['order_confirm_bank']);
			   
			   
			   // PAYMENT STATUS STYLE
			   $payment_status = payment_status_flag($all_orders['payment_status']);
			   
			   // PAYMENT FULFILLMENT STYLE
			   
			   $fulfillment_status = fulfillment_status_flag($all_orders['fulfillment_status']);
			   
			   
			   // ORDER STATUS CONTROL
			   if($all_orders['order_status'] == 'Expired'){
			      $tr_class   = 'class="expired"';
				  $order_stat = '<span class="order-stat">EXPIRED</span>';
			   }else if($all_orders['order_status'] == 'Cancelled'){
			      $tr_class   = 'class="cancelled"';
				  $order_stat = '<span class="order-stat">CANCELLED</span>';
				  $payment_status     = 'stat grey';
				  $fulfillment_status = 'stat grey';
			   }
			   ?>
            
            <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')" <?php echo $tr_class;?>>
              <td>
                <input type="checkbox" name="checkbox[]" id="<?php echo "check_".$row?>" value="<?php echo $all_orders['order_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')">
              </td>
              <td>
                <a href="<?php echo $prefix_url."order-detailing/".$all_orders['order_number'];?>" title="<?php echo "Go to ".$all_orders['order_number']." detail";?>">
				  <?php echo $all_orders['order_number'];?>
                </a>
                <?php echo $order_stat;?>
              </td>
              <td><?php echo format_date($all_orders['order_date']);?></td>
              <td><?php echo $all_orders['order_billing_fullname'];?></td>
              <td>
                
				<?php
                echo $all_orders['order_payment_method'];
				
				if(strtolower($all_orders['payment_status']) == "confirmed"){
				   
				   echo '<div class="payment-notes">';
                   echo 'Bank Transfer via '.$all_orders['order_confirm_bank'].'<br/>';
				   echo $all_orders['order_confirm_name'].'<br/>';
				   echo $currency.' '.price($all_orders['order_confirm_amount']);
				   echo '</div>';
				}
				?>
                        
              </td>
              <td class="tr"><?php echo price($all_orders['order_total_amount']);?></td>
              <td><div class="<?php echo $payment_status;?>"><?php echo $all_orders['payment_status'];?></div></td>
              <td><div class="<?php echo $fulfillment_status?>"><?php echo $all_orders['fulfillment_status'];?></div></td>
            </tr>
            
			<?php
			}
			?>

            <!--<tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')" class="expired">
              <td>
                <input type="checkbox" name="checkbox[]" id="<?php echo "check_".$row?>" value="<?php echo $all_orders['order_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')">
              </td>
              <td>
                <a href="<?php echo $prefix_url."order-detailing/".$all_orders['order_number'];?>" title="<?php echo "Go to ".$all_orders['order_number']." detail";?>">
                NIC0201001
                </a>
                <span class="order-stat">EXPIRED</span>
              </td>
              <td>Wed, 20 Nov 2013</td>
              <td>Astaga Astaga</td>
              <td>
          
                <?php echo $all_orders['order_payment_method'];?>
                <?php if(strtolower($all_orders['payment_status']) == "confirmed"){?>
                
                <div class="payment-notes">
                  Bank Transfer via <?php echo $all_orders['order_confirm_bank']?><br/>
          
                  <?php echo $all_orders['order_confirm_name'];?><br/>
                  
                  IDR <?php echo price($all_orders['order_confirm_amount']);?>
                  
                </div>
        
                <?php
                }
                ?>
                        
              </td>
              <td class="tr"><?php echo price($all_orders['order_total_amount']);?></td>
              <td><div class="<?php echo $payment_status;?>"><?php echo $all_orders['payment_status'];?></div></td>
              <td><div class="<?php echo $fulfillment_status?>"><?php echo $all_orders['fulfillment_status'];?></div></td>
            </tr>-->
            
          </tbody>
        </table>
        
      </div><!--content-->
    </div><!--box row-->  
  </div><!--container main-->
            
</form>

<script src="<?php echo $prefix_url.'script/order_index.js'?>"></script>    
<script>
$(document).ready(function() {
   $('#order_payment_method_search option[value="<?php echo $search_value?>"]').attr('selected', 'selected');
   $('#payment_status_search option[value="<?php echo $search_value?>"]').attr('selected', 'selected');
   $('#fulfillment_status_search option[value="<?php echo $search_value?>"]').attr('selected', 'selected');
   changeOption();
});
</script>

<?php include("custom/orders/index.php"); ?>