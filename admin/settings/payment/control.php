<?php
// CALL FUNCTION
$payment = get_payments();

if(isset($_POST['btn_payment'])){
	
   // DEFINED VARIABLE
   $payment_id     = $_POST['account_id'];
   $payment_bank   = clean_alphabet($_POST['bank_name']);
   $payment_number = clean_alphanumeric($_POST['bank_number']);
   $payment_name   = clean_alphabet($_POST['bank_account']);
   
   update_account($payment_bank, $payment_number, $payment_name, $payment_id);
   
   $_SESSION['alert'] = "success";
   $_SESSION['msg']   = "Changes successfully saved.";
   
}
?>