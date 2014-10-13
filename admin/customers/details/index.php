<form method="post" enctype="multipart/form-data">

<?php
include("control.php");
include("custom/customers/details/control.php");
?>

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-user"></span> &nbsp; 
            <a href="<?php echo $prefix_url."customer"?>">Customers</a>
          <span class="info">/</span> Customer Details
        </h1>
        <input type="hidden" name="user_id" value="<?php echo $user_detail['user_id']?>">
        <div class="btn-placeholder">
          <a href="mailto:<?php echo $user_detail['user_email'];?>">
          <input type="button" class="btn btn-default btn-sm" value="Send Email" name="btn-detail-customer" onclick="mailto:<?php echo $user_detail['user_email'];?>">
          </a>
          <a href="<?php echo $prefix_url."edit-customer/".$_REQUEST['cid'];?>">
             <input type="button" class="btn btn-warning btn-sm" value="Edit Customer">
          </a>
          <input type="submit" class="btn btn-danger btn-sm" value="Delete" name="btn-detail-customer">
        </div>
      </div>
    </div>

    <div class="container main">
	  <?php
      if(!empty($_SESSION['alert'])){?>
      <div class="content">
        <div class="alert <?php echo $_SESSION['alert'];?>"><center><?php echo $_SESSION['msg'];?></center></div>
      </div>
      <?php }?>

      <div class="row">

        <div class="col-xs-4" style="padding-right: 30px">
          <div class="box row">
            <div class="content" id="id_content_left">
              <ul class="form-set">
                <li class="form-group clearfix" style="border-bottom: 1px solid #eee; margin-bottom: 15px; padding-bottom: 8px">
                  <h4 id="username"><a href="<?php echo $current_url;?>"><?php echo $user_detail['user_fullname'];?></a></h4>
                  <p style="color: #999; padding-top: 0"><a href="mailto:<?php echo $user_detail['user_email'];?>"><?php echo $user_detail['user_email'];?></a></p>
                  <p style="color: #999; padding-top: 0"><?php echo $user_detail['user_phone'];?></p>
                  <p style="color: #999; padding-top: 0"><?php echo $user_detail['user_status'];?></p>
                </li>
                <li class="form-group">
                  <label class="hidden" style="width: 50px; color: #999">Ship to</label>
                  <p class="">Address 1</p>
                  <select type="text" class="form-control hidden" style="width: 182px">
                      <option>Address 1</option>
                  </select>
                </li>
                <li><?php echo preg_replace("/\n/","\n<br>",$user_detail['user_address']);?></li>
                <li><?php echo $user_detail['user_country'];?></li>
                <li><?php echo $user_detail['user_province'];?></li>
                <li><?php echo $user_detail['user_city'];?></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-xs-8">
          <div class="box row">
            <div class="content" id="id_content_right">
              <div class="row cust-data">
                <div class="col-xs-4">
                  <p>
                    <span class="h3"><?php if(empty($user_detail['total_spent'])){ echo price($user_detail['total_purchase']);}else{ echo price($user_detail['total_spent']);}?></span><br/>
                    Total Paid Orders
                  </p>
                </div>

                <div class="col-xs-4">
                  <p>
                    <span class="h3"><?php echo price($user_detail['total_order'])?></span><br/>
                    Total Orders
                  </p>
                </div>

                <div class="col-xs-4">     
                  <p>
                    <span class="h3"><?php if(empty($user_detail['order_date'])){ echo "N/A";}else{echo format_date($user_detail['order_date']);;}?></span><br/>
                    Last Order
                  </p>
                </div>
              </div><!--.row-->
            </div><!--.content-->
          </div><!--.box.row-->
        </div><!--.col-xs-7-->

      </div><!--.row-->

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
                <?php
                for($i=1;$i<=$total_page;$i++){
                echo "<option value=\"".$i."\">".$i."</option> \n";
               }
               ?>
              </select>
              <p>of <strong><?php echo $total_page;?></strong> pages</p>
              <div class="divider"></div>
              <p>Show</p>
              <select class="form-control" name="query_per_page" id="query_per_page_input" onchange="changeQueryPerPage()">
                <option value="25"<?php if($query_per_page =="25"){ echo "selected=\"selected\"";}?>>25</option>
                <option value="50" <?php if($query_per_page == "50"){ echo "selected=\"selected\"";}?>>50</option>
                <option value="100" <?php if($query_per_page == "100"){ echo "selected=\"selected\"";}?>>100</option>
              </select>
              <p>of <strong><?php echo $user_detail['total_record'];?></strong> records</p>
            </div>
            <div class="pull-right">
              <p>Actions</p>
              <select class="form-control" name="option-action" onchange="changeOption()" id="order-action"> 
                <option value="delete">Delete</option>
                <option value="change">Set Status</option>
              </select>
              <p id="order-label" class="hidden">to</p>
              <select class="form-control hidden" name="option-status" id="order-option" disabled="disabled">
                <option disabled>Payment</option>
                <option value="Unpaid">&nbsp;Unpaid</option>
                <option value="Confirmed" disabled="disabled">&nbsp;Confirmed</option>
                <option value="Paid">&nbsp;Paid</option>
                <option disabled></option>
                <option disabled>Fulfillment</option>
                <!--<option value="Unfulfilled">&nbsp;Unfulfilled</option>-->
                <option value="In Process">&nbsp;In Process</option>
                <option value="Delivered">&nbsp;Delivered</option>
                <option disabled></option>
                <option disabled>Order</option>
                <option value="Unfulfilled">&nbsp;Active</option>
                <option value="In Process">&nbsp;Expired</option>
                <option value="Delivered">&nbsp;Cancelled</option>
              </select>
              <input type="submit" class="btn btn-success pull-left" name="btn-detail-customer" value="GO">
            </div>
          </div><!--actions-->

          <table class="table">
            <thead>
              <tr class="headings">
                <th width="20"></th>
                <th class="sort" width="80" onclick="sortBy('order_number')"> Order # <?php echo $arr_order_number;?></th>
                <th class="sort" width="120" onclick="sortBy('order_date')">Date <?php echo $arr_order_date;?></th>
                <th class="sort" width="190" onclick="sortBy('order_confirm_name')">Customer <?php echo $arr_confirm_name;?></th>
                <th class="sort" width="170" onclick="sortBy('order_confirm_bank')">Payment Method <?php echo $arr_confirm_bank;?></th>
                <th class="sort" width="80"  onclick="sortBy('order_confirm_amount')">Amount <?php echo $arr_confirm_amount;?></th>
                <th class="sort" width="100" onclick="sortBy('payment_status')">Payment <?php echo $arr_payment_status;?></th>
                <th class="sort" width="100" onclick="sortBy('fulfillment_status')">Fulfillment <?php echo $arr_fulfillment_status;?></th>
              </tr>
              <tr class="filter">
                <th>
                  <a href="<?php echo $current_url;?>">
                    <button type="button" class="btn btn-danger btn-xs reset <?php echo $reset?>"><span class="glyphicon glyphicon-remove"></button>
                  </a>
                </th>
                <th><input type="text" class="form-control" id="order_number_search" onkeyup="searchQuery('order_number')" onkeypress="return disableEnterKey(event)"  <?php if($_REQUEST['src'] == "order_number"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
                <th><input type="text" class="form-control" id="order_date_search" onkeyup="searchQuery('order_date')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "order_date"){ echo "value=\"".$_REQUEST['srcval']."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
                <th><input type="text" class="form-control" id="order_confirm_name_search" onkeyup="searchQuery('order_confirm_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "order_billing_fullname"){ echo "value=\"".$_REQUEST['srcval']."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
                <th>
                  <select class="form-control" id="order_payment_method_search" onchange="searchQueryOption('order_payment_method')" <?php if($_REQUEST['src'] == "order_payment_method"){ echo "value=\"".$_REQUEST['srcval']."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled=\"disabled\"";}?>>
                    <option value="All"></option>
                    <option value="BCA" <?php if($search == "order_payment_method=bca"){ echo 'selected="selected"';}?>>Bank Transfer via BCA</option>
                    <option value="Mandiri" <?php if($search == "order_payment_method=mandiri"){ echo 'selected="selected"';}?>>Bank Transfer via Mandiri</option>
                    <option value="Credit Card" <?php if($search == "order_payment_method=credit card"){ echo 'selected="selected"';}?>>Credit Card</option>
                    <option value="Paypal" <?php if($search == "order_payment_method=paypal"){ echo 'selected="selected"';}?>>PayPal</option>
                    <option value="COD" <?php if($search == "order_payment_method=cod"){ echo 'selected="selected"';}?>>Cash on Delivery</option>
                  </select>
                </th>
                <th><input type="text" class="form-control" id="order_total_amount_search" onkeyup="searchQuery('order_total_amount')" onkeypress="return disableEnterKey(event)" disabled></th>
                <th>
                  <select class="form-control" id="payment_status_search" onchange="searchQueryOption('payment_status')" <?php if($_REQUEST['src'] == "payment_status"){ echo "value=\"".$_REQUEST['srcval']."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled=\"disabled\"";}?>>
                    <option value="All"></option>
                    <option value="Unpaid" <?php if($get_last_char_payment_status == "Unpaid"){ echo 'selected="selected"';}?>>Unpaid</option>
                    <option value="Confirmed" <?php if($get_last_char_payment_status == "Confirmed"){ echo 'selected="selected"';}?>>Confirmed</option>
                    <option value="Paid" <?php if($get_last_char_payment_status == "Paid"){ echo 'selected="selected"';}?>>Paid</option>
                  </select>
                </th>
                <th>
                  <select class="form-control" id="fulfillment_status_search" onchange="searchQueryOption('fulfillment_status')" <?php if($_REQUEST['src'] == "fulfillment_status"){ echo "value=\"".$_REQUEST['srcval']."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled=\"disabled\"";}?>>
                    <option value="All"></option>
                    <option value="Unfulfilled" <?php if($get_last_char_fulfillment_status == "Unfulfilled"){ echo 'selected="selected"';}?>>Unfulfilled</option>
                    <option value="In Process" <?php if($get_last_char_fulfillment_status == "In Process"){ echo 'selected="selected"';}?>>In Process</option>
                    <option value="Partial">Partial</option>
                    <option value="Delivered" <?php if($get_last_char_fulfillment_status == "Delivered"){ echo 'selected="selected"';}?>>Delivered</option>
                    <!--<option value="Cancelled" <?php if($get_last_char_fulfillment_status == "Cancelled"){ echo 'selected="selected"';}?>>Cancelled</option>
                    <option value="Expired" <?php if($get_last_char_fulfillment_status == "Expired"){ echo 'selected="selected"';}?>>Expired</option>-->
                  </select>
                </th>
              </tr>
            </thead>
            <tbody onload="loading()">
              <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
              <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
              
              <?php
			  $row=0;
			  foreach($listing_order as $user_orders){
			     $row++;
				 
				 /* PAYMENT STATUS */
				 if($user_orders['payment_status'] == "Paid"){
				    $payment_status = "stat green";
				 }else if($user_orders['payment_status'] == "Confirmed"){
				    $payment_status = "stat yellow";
				 }else if($user_orders['payment_status'] == "Unpaid"){
				    $payment_status = "stat red";
				 }
				 
				 
				 /* FULFILLMENT STATUS */
				 if($user_orders['fulfillment_status'] == "Unfulfilled"){
					$fulfillment_status = "stat grey";
				 }else if($user_orders['fulfillment_status'] == "In Process" || $all_orders_result['fulfillment_status'] == "Partial"){
				    $fulfillment_status = "stat yellow";
				 }else if($user_orders['fulfillment_status'] == "Delivered"){
				    $fulfillment_status = "stat green";
				 }else if ($user_orders['fulfillment_status'] == "Cancelled" || $all_orders_result['fulfillment_status'] == "Expired"){
				    $fulfillment_status = "stat red";
				 }
				 ?>
              <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                <td><input type="checkbox" name="order_id[]" value="<?php echo $user_orders['order_id'];?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                <td><a href="<?php echo $prefix_url."order-detailing/".$user_orders['order_number'];?>"><?php echo $user_orders['order_number'];?></a></td>
                <td><?php echo format_date($user_orders['order_date']);?></td>
                <td><?php echo $user_orders['order_billing_fullname'];?></td>
                <td><?php echo $user_orders['order_payment_method'];?>
                  <?php if($user_orders['payment_status'] == "Confirmed"){?>
                  <div class="payment-notes">
                      Bank Transfer via <?php echo $user_orders['order_confirm_bank']?><br/>
                      <?php echo $user_orders['order_confirm_name'];?><br/>
                      IDR <?php echo price($user_orders['order_confirm_amount']);?>
                  </div>
                  <?php }?>
                </td>
                <td class="tr"><?php echo price($user_orders['order_total_amount']);?></td>
                <td><div class="<?php echo $payment_status;?>"><?php echo $user_orders['payment_status'];?></div></td>
                <td><div class="<?php echo $fulfillment_status;?>"><?php echo $user_orders['fulfillment_status'];?></div></td>
              </tr>
              <?php }?>
            </tbody>
          </table>
        </div><!--.content-->

      </div><!--.box.row-->

    </div><!--.container.main-->

</form>



<script>
$(function() {
   $("#order_date_search").datepicker({
      altField:'#order_date_search',
	  altFormat: "yy/mm/dd",
	  onSelect: function () {
	     document.all ? $(this).get(0).fireEvent("onchange") : $(this).change();
         searchQueryOption('order_date');
      },
   });
});

$('#order_payment_method_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');
$('#payment_status_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');
$('#fulfillment_status_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');

function changeOption(){
   var action = $('#order-action option:selected').val();
   
   if(action == "delete" || action == ""){
      $('#order-option').addClass("hidden");
      $('#order-label').addClass("hidden");
	  $('#order-option').attr('disabled', true);
   }else if(action == "change"){
      $('#order-option').removeClass("hidden");
      $('#order-label').removeClass("hidden");
	  $('#order-option').removeAttr('disabled', true);
   }
   
}


function sameHeight(){
   var left  = $('#id_content_left').height();
   var right = $('#id_content_right').height();
   
   if(left < right){
      $('#id_content_left').css('height', (right+35)+'px');
   }else if(left > right){
      $('#id_content_right').css('height', (left+35)+'px');
   }
   
}

$(document).ready(function() {
   changeOption();
   sameHeight();
});
</script>

<?php
if($_POST['btn-detail-customer'] == ""){
   $_SESSION['alert'] = "";
   $_SESSION['msg']   = "";
}
?>

<?php
include('custom/customers/details/index.php');
?>
