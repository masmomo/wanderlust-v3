// JavaScript Document
function validateConfirm(){
   var order  = $('#id_order_number').val();
   var bank   = $('#id_order_confirm_bank').val();
   var name   = $('#id_order_confirm_name').val();
   var amount = $('#id_order_confirm_amount').val();
   
   var alphanum = /^[A-Za-z0-9\.]+$/;
   var alpha    = /^[A-Za-z]+$/;
   var numeric  = /^[0-9]+$/;
   
   $('#lbl_order_number').removeClass("has-error");
   $('#lbl_order_confirm_bank').removeClass("has-error");
   $('#lbl_order_confirm_name').removeClass("has-error");
   $('#lbl_order_confirm_amount').removeClass("has-error");
   
   if(order == "" || !alphanum.test(order)){
      $('#lbl_order_number').addClass("has-error");
   }else if(bank == "" || !alphanum.test(bank)){
      $('#lbl_order_confirm_bank').addClass("has-error");
   }else if(name == ""){
      $('#lbl_order_confirm_name').addClass("has-error");
   }else if(amount == "" || !numeric.test(amount)){
      $('#lbl_order_confirm_amount').addClass("has-error");
   }else{
      $('#id_btn_confirm').click();
   }
   
}


$("input#id_order_number").on({
  keydown: function(e) {
    if (e.which === 32)
      return false;
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});