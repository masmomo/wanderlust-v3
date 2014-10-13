<script>
$('#custom_recipes_category').html('<li class="field-set"><div id="custom_lang_select"></div></li>'+$('#custom_recipes_category').html());

var custom_dml = $('#category-id').val();

// LOAD SELECT
$('#custom_lang_select').load('sources/language/pages/recipes/category/select.php', function() {
	//alert( "Load was performed." );
});


// LOAD CHECKBOX
$('.custom_lang_check').each(function() {
   $('.custom_lang_check').load('sources/language/check.php');
});
</script>

