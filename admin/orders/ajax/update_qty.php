<?php
include('../../custom/static/general.php');
include('../../static/general.php');


function update_item($qty, $item_id){
   $conn  = connDB();
   $sql   = "UPADTE tbl_order_item SET `item_quantity` = '$qty' WHERE `item_id` = '$item_id'";
   $query = mysql_query($sql, $query);
}
?>