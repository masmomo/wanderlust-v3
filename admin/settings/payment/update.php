<?php
/*--------------------*/
/*      ACCOUNTS      */
/*--------------------*/

function insert_account($post_account_bank, $post_account_number, $post_account_name){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_account (`account_bank`, `account_number`, `account_name`) VALUES ('$post_account_bank', '$post_account_number', '$post_account_name')";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update_account($post_account_bank, $post_account_number, $post_account_name, $post_account_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_account SET `account_bank` = '$post_account_bank', 
                                    `account_number` = '$post_account_number', 
								    `account_name` = '$post_account_name'
             WHERE `id` = '$post_account_id'
			 ";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>