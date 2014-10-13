<?php
include("../../../../../static/general.php");
function get_languages(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_language";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


// CALL FUNCTION
$language = get_languages();


echo "<select class=\"input-select\" style=\"margin-bottom: 15px\" onChange=\"changeLanguage()\" id=\"id_custom_select_lang\">";
echo "  <option value=\"default\">English</option>";

foreach($language as $language){
  echo "  <option value=\"".$language['language_code']."\">".$language['language_name']."</option>";
}

echo "</select>";
?>

<script>
if($('#id_custom_default_value').is(':checked')){
   $('#category-name-edited').attr('disabled');
}else{
   $('#category-name-edited').removeAttr('disabled');
}

function changeLanguage(){
   var lang      = $('#id_custom_select_lang option:selected').val();
   var def_value = $('#category-name-edited').val();
   var def_id    = $('#category-id-edited').val();
   
   var acq  = $.ajax({
	             type: "POST",
				 url: "sources/language/pages/recipes/category/ajax.php",
				 data: {lang:lang, def_value:def_value, def_id:def_id},
				 error: function(jqXHR, textStatus, errorThrown) {
					   
					   }
			  }).done(function(data) {
			    $('#custom_recipes_category').html(data);
				$('#save-changes').attr('name', 'btn_save_lang_recipe');
				$('#btn_delete_pop').addClass("hidden");
				$('#id_category_name_normalization').val(def_value);			  
			  });
   
}
</script>
