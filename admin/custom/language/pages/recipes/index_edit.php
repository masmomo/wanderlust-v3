<script>

// LOAD SELECT
$('#custom_recipe_detail').html('<div id="custom_lang_select"></div>'+$('#custom_recipe_detail').html());

$('#custom_lang_select').load('../sources/language/pages/recipes/select_edit.php', function() {
	
});


// LOAD CHECKBOX
$('.custom_lang_check').each(function() {
   $('.custom_lang_check').load('sources/language/check.php');
});


</script>
<?php
echo "<input type=\"hidden\" id=\"custom_recipes_detail_rname\" value=\"".$_REQUEST['rname']."\">";
?>

