<?php
//if(empty($_SESSION['user_id'])){
   //include("account_/login.php");
//}else{
?>

<?php
/* -- GET -- */
function get($post_user_id){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM tbl_user_purchase AS purchase INNER JOIN tbl_order AS order_ ON purchase.order_id = order_.order_id 
                                                         INNER JOIN tbl_order_item AS item ON order_.order_id = item.order_id
             WHERE `user_id` = '$post_user_id'
			 GROUP BY item.order_id
		     ORDER BY item.order_id DESC
			";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function count_get($post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user_purchase AS purchase INNER JOIN tbl_order AS order_ ON purchase.order_id = order_.order_id WHERE `user_id` = '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


/* -- UPDATE -- */
/* -- CONTROL -- */
function payment_flag($status){
   
   if($status == "Unpaid"){
      $flag = "red";
   }else if($status == "Confirmed"){
      $flag = "orange";
   }else if($status == "Paid"){
      $flag = "green";
   }else{
      $flag = "green";
   }
   
   return $flag;
   
}

// CALL FUNCTION
$order = get($global_user['user_id']);
$count = count_get($global_user['user_id']);
?>

<div class="container main">
  <div class="content">

      <ul class="breadcrumb">
        <li><a href="<?php echo $prefix_url."account/".md5($global_user['user_alias']);?>">Account</a></li>
        <li class="active">Order History</li>
      </ul>

      <div class="row">

        <div class="col-xs-12 orderhistory">
          <form>
            <table class="table table-hover">
              <thead>
                <tr class="hidden-xs">
                  <th class="th-no hidden-xs">#</th>
                  <th class="th-orderno">Order #</th>
                  <th class="th-date hidden-xs">Date</th>
                  <th class="th-status hidden-xs">Status</th>
                  <th class="th-amount hidden-xs">Amount</th>
                  <th class="th-shipinfo hidden-xs">Shipping Info</th>
                </tr>
              </thead>
              <tbody>
        				<?php
        				  $row = 1;
        	              foreach($order as $order){
        					 $flag = payment_flag($order['payment_status']);
        				  ?>
        					<tr>
	                  	<td class="td-no hidden-xs"><?php echo $row;?></td>
		                  <td class="td-orderno hidden-xs"><a class="orderno" href="<?php echo $prefix_url."order-detail/".$order['order_number'];?>"><?php echo $order['order_number'];?></a></td>
		                  <td class="td-date hidden-xs"><?php echo format_date($order['order_date']);?></td>
		                  <td class="td-status <?php echo $flag;?> hidden-xs"><?php echo $order['payment_status'];?></td>
		                  <td class="td-amount hidden-xs"><?=$order['currency'];?> <?php echo price($order['order_total_amount']);?></td>
		                  <td class="td-shipinfo hidden-xs"><?php echo $order['services']." - ".$order['shipping_number'];?></td>

	                  <td class="m-orderhistory visible-xs">
	                    <p><span class="m-caption">Order #</span> <a class="orderno" href="<?php echo $prefix_url."order-detail/".$order['order_number'];?>"><?php echo $order['order_number'];?></a></p>
	                    <p><span class="m-caption">Date</span> <?php echo format_date($order['order_date']);?></p>
	                    <p class="td-status <?php echo $flag;?>"><span class="m-caption">Status</span> <?php echo $order['payment_status'];?></p>
	                    <p><span class="m-caption">Amount</span> <?php echo price($order['order_total_amount']);?></p>
	                    <p><span class="m-caption">Shipping Info</span> <?php echo $order['services']." - ".$order['shipping_number'];?></p>
	                  </td>
	                </tr>

	              <?php
				     $row++;
    				  }
    				  ?>              </tbody>
            </table>
            <a href="<?php echo $prefix_url."account/".$global_user['user_alias'];?>" class="btn btn-primary pull-right">Back to My Account</a>
          </form>
        </div>

      </div> <!--row-->

  </div><!--.content-->
</div><!--.container.main-->

<?php
	//}
?>