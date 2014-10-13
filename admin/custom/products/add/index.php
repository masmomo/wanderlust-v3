<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/multiple_insert_product/multiple.js"></script>-->
<!--
<input type="hidden" id="init_gender" value="<?=$custom_data['product_gender'];?>"/>
<input type="hidden" id="init_artist" value="<?=$custom_data['product_artist'];?>"/>
<input type="hidden" id="init_series" value="<?=$custom_data['product_series'];?>"/>-->
<input type="hidden" id="init_collection" value="<?=$custom_data['product_collection'];?>"/>
<?php
//print_r($custom_data['type_sizefit'];?>);
?>
<!--
<input type="hidden" id="init_story" value="<?=$custom_data['product_story'];?>"/>
-->

<input type="hidden" id="init_collection" value="<?=$custom_data['product_collection'];?>"/>

<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/custom.js"></script>
<!--
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/multiple_insert_product/multiple.js">
</script>


<!--gender module-->
<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/gender/gender.js"></script>

<!--artist module-->
<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/artist/artist.js"></script>

<!--series module-->
<!--<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/series/series.js"></script>

<!--collection module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/collection/collection.js"></script>



<!--story module-->
<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/story/story.js"></script>


<!--image module-->
<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/image/image.js"></script>

<!--sizefit module-->
<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/sizefit/sizefit.js"></script>-->

<!--USD Module-->
<!--<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/usd/ajax_usd.js"></script>

<!--USD Module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/sizefit/sizefit.js"></script>
<?php
include("sizefit/control.php");
?>

<script>
// HIDDEN ADD VARIANT BUTTON
//$('button[value="Add Variant"]').addClass('hidden');

// ADD FILES BOX
/*
$(document).ready(function(){
	$.ajax({
		type: "POST",
		url: "custom/products/add/custom.php",
		error: function(jqXHR, textStatus, errorThrown) {
			
			   }
		}).done(function(msg) {
			$("#custom").html(msg);
		});	


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

});	

$(document).ajaxStop(function () {
   $('#lbl_size_qty').addClass('hidden');      // STOCK
   $('#stock_qty_0').val('1');
});
*/
</script>