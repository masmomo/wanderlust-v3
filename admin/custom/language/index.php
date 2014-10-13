<script>
// LOAD SELECT
$('#custom_lang_select').load('sources/language/select.php', function() {
	//alert( "Load was performed." );
});


// LOAD CHECKBOX
$('.custom_lang_check').each(function() {
   $('.custom_lang_check').load('sources/language/check.php');
});
</script>

