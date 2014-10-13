<script>

// LOAD SELECT
$('#custom_lang').html('<div id="custom_lang_select"></div>'+$('#custom_lang').html());

$('#custom_lang_select').load('../../custom/language/pages/news/select_edit.php', function() {
	
});


// LOAD CHECKBOX
$('.custom_lang_check').each(function() {
   $('.custom_lang_check').load('sources/language/check.php');
});


</script>
<?php
echo "<input type=\"hidden\" id=\"custom_news_detail_nid\" value=\"".$_REQUEST['nid']."\">";
echo "<input type=\"hidden\" id=\"custom_news_detail_nn\" value=\"".$_REQUEST['nn']."\">";
?>

