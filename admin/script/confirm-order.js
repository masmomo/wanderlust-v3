function sameAmount(){
   $('#modal_confirm_amount').removeClass('hidden');
   $('#modal_confirm_verify').addClass('hidden');
   $('#modal_confirm_btn_confirm').removeClass('hidden');
   
   //$('#modal_confirm_btn_cancel').after('<input type="button" class="btn btn-success btn-sm"  value="Confirm" name="btn-order-detailing" id="modal_confirm_btn_confirm">');
   $('#modal_confirm_btn_yes').remove();
}

function clickPaid(){
   var amount   = $('#modal_confirm_text_amount').val();
   var numeric  = /^[0-9]+$/;
   
   if(!numeric.test(amount)){
      $('#modal_confirm_text_amount').attr('border', '1px solid #f00');
   }
}

function sameAmountFix(){
   $('#modal_confirm_amount').addClass('hidden');
   $('#modal_confirm_verify').removeClass('hidden');
   $('#modal_confirm_btn_confirm').addClass('hidden');
}


function clickConfirmed(x){
   
   if(x === 'yes'){
      $('#btn_mark_as_paid').click();
   }else{
      var bank   = $('#id_modal_confirm_method option:selected').val();
      var name   = $('#modal_confirm_text_name').val();
      var amount = $('#modal_confirm_text_amount').val();
      var nonum  = /^[0-9]+$/;
	  
	  $('#lbl_modal_method').removeClass('has-error');
	  $('#lbl_modal_name').removeClass('has-error');
	  $('#lbl_modal_amount').removeClass('has-error');
	  
	  
	  if(bank == ''){
         $('#lbl_modal_method').addClass('has-error');
	  }else if(name == ''){
         $('#lbl_modal_name').addClass('has-error');
	  }else if(amount == '' || !nonum.test(amount)){
         $('#lbl_modal_amount').addClass('has-error');
	  }else{
         $('#btn_mark_as_paid').click();
	  }
   }
}




$("input#modal_confirm_text_amount").on({
  keyup: function(e) {
    if (e.which === 32)
      return false;
	  
   var amount   = $('#modal_confirm_text_amount').val();
   var numeric  = /^[0-9]+$/;
   
   if(!numeric.test(amount)){
      $('#modal_confirm_text_amount').attr('style', 'border:1px solid #f00');
   }else{
      $('#modal_confirm_text_amount').removeAttr('style');
   }
	  
  },
  change: function() {
    this.value = this.value.replace(/\s/g, "");
  }
});