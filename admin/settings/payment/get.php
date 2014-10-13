<?php
/*--------------------*/
/*      PAYMENT      */
/*--------------------*/


function count_payment(){
   $conn = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_account";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_payment($post_payment_id){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_account WHERE `id` = '$post_payment_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_payments(){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_account ORDER BY `account_bank`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}
?>