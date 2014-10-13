<script>
// FILTER
/*
function getAlias(alias){
	$.ajax({
		type: "POST",
		url : "custom/products/details/ajax_filter.php",
		data: {alias:alias},
		error: function(jqXHR, textStatus, errorThrown) {
			
			   }
		}).done(function(msg) {
			$("#id_filter_container").html(msg);
		});	
}


function getAliasFile(alias){
	$.ajax({
		type: "POST",
		url : "custom/products/details/ajax_file.php",
		data: {alias:alias},
		error: function(jqXHR, textStatus, errorThrown) {
			
			   }
		}).done(function(msg) {
			$("#id_file_container").html(msg);
		});	
}


function getAliasColor(alias){
	$.ajax({
		type: "POST",
		url : "custom/products/details/ajax_color.php",
		data: {alias:alias},
		error: function(jqXHR, textStatus, errorThrown) {
			
			   }
		}).done(function(msg) {
			$('#id_color_container').html(msg);
		});	
}


function getAliasCustom(alias){
	$.ajax({
		type: "POST",
		url : "custom/products/details/ajax_how.php",
		data: {alias:alias},
		error: function(jqXHR, textStatus, errorThrown) {
			
			   }
		}).done(function(msg) {
			$('#id_custom_container').html(msg);
			//alert(msg);
		});	
}



// HIDDEN ADD VARIANT BUTTON
$('button[value="Add Variant"]').addClass('hidden');

// ADD FILES BOX
$(document).ready(function(){
	$.ajax({
		type: "POST",
		url: "custom/products/details/custom.php",
		error: function(jqXHR, textStatus, errorThrown) {
			
			   }
		}).done(function(msg) {
			$("#custom").html(msg);
		});	
		
   
   getAlias('<?php echo $_REQUEST['product_alias'];?>');
   getAliasFile('<?php echo $_REQUEST['product_alias'];?>');
   getAliasColor('<?php echo $_REQUEST['product_alias'];?>');
   getAliasCustom('<?php echo $_REQUEST['product_alias'];?>');
   

   // TRIGGER SIZE GROUP INTO GENERAL
   $('#size_type_id').val('43').trigger('change'); // SIZE GROUP
   $('#color_id_1').val('16').trigger('change');   // TYPE


   // CLASS HIDDEN
   $('#lbl_color_id_1').addClass('hidden');    // TYPE GROUP
   $('#lbl_type_weight_1').addClass('hidden'); // WEIGHT
   $('#lbl_size_type_id').addClass('hidden');  // SIZE GROUP
   $('#lbl_color_name').addClass('hidden');    // TYPE
   $('#lbl_color_price').addClass('hidden');   // PRICE


   // DEFAULT VALUE
   $('#type_weight_1').val('1');
   
   $('button[name="remove_variant"]').addClass('hidden');
   
   // DUAL LANGUAGE
   function getLanguage(file_dir){
      $('#custom_lang').html($('#custom_lang').html()+'<div id="custom_lang_select"></div>');
   
      $('#custom_lang_select').load('custom/language/products/select.php');
   }
   
   function selectOptionLanguage(x){
   
      if(x != ''){
         $('#id_custom_select_lang option[value="'+x+'"]').attr('selected', true);
	  }else{
         $('#id_custom_select_lang option[value="default"]').attr('selected', true);
	  }

   }
   
   getLanguage('custom/language/select.php');
   selectOptionLanguage('<?php echo $_SESSION['lang_admin'];?>');
   
});	


$(document).ajaxStop(function () {
   $('#lbl_size_qty').addClass('hidden');      // STOCK
   $('#stock_qty_0').val('1');

});
*/
</script>