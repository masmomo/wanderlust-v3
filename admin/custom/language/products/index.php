<script>

// LOAD SELECT
$('#custom_lang').html('<div id="custom_lang_select"></div>'+$('#custom_lang').html());

$('#custom_lang_select').load('custom/language/products/select.php', function() {
	
});


// LOAD CHECKBOX
$('.custom_lang_check').each(function() {
   //$('.custom_lang_check').load('sources/language/check.php');
});


</script>
<?php
echo "<input type=\"hidden\" id=\"custom_product_alias\" value=\"".$_REQUEST['product_alias']."\">";
?>