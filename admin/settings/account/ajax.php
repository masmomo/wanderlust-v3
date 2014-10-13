<?php
include("../../custom/static/general.php");
include("../../static/general.php");


// FUNCTIONS
function get_payment($post_payment_id){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_account WHERE id = '$post_payment_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// DEFINED VARIABLE
$ajx_id = $_POST['bank'];


// CALL FUNCTION
$bank = get_payment($ajx_id);
?>

<li class="form-group row">
  <label class="control-label col-xs-3" for="">Bank Name</label>
  <div class="col-xs-9">
    <input type="text" class="form-control" id="id_bank_name" name="bank_name" value="<?php echo $bank['account_bank'];?>">
    <p class="help-block">The name of the bank, e.g. BCA, Mandiri</p>
  </div>
</li>

<li class="form-group row">
  <label class="control-label col-xs-3" for="">Bank Account No.</label>
  <div class="col-xs-9">
    <input type="text" class="form-control" id="id_bank_number" name="bank_number" value="<?php echo $bank['account_number'];?>">
      <p class="help-block">The account no. of the account, e.g. 60406xxxxx</p>
  </div>
</li>

<li class="form-group row">
  <label class="control-label col-xs-3" for="">Bank Account Name</label>
  <div class="col-xs-9">
    <input type="text" class="form-control" id="id_bank_account" name="bank_account" value="<?php echo $bank['account_name'];?>">
    <p class="help-block">The name on the bank account, e.g. John Doe</p>
  </div>
</li>

<input type="hidden" name="account_id" value="<?php echo $bank['id']?>">