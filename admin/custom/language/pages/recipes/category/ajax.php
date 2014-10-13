<?php
include("../../../../../static/general.php");

$ajx_lang    = $_POST['lang'];
$ajx_default = $_POST['def_value'];
$ajx_id      = $_POST['def_id'];

//$_SESSION['lang_admin'] = $ajx_lang;

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

// GET
function get_custom($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_recipes_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// COUNT
function count_custom($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_recipes_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// CALL FUNCTION
$language = get_languages();
$check    = count_custom($ajx_id, $ajx_lang);
$get      = get_custom($ajx_id, $ajx_lang);

if($check['rows'] > 0){
  $lang_category_name = $get['category_name'];
}else{
  $lang_category_name = $ajx_default;
}


/* -- DEFAULT -- */

function get_default($post_category_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// CALL FUNCTION
$def_cat_name = get_default($ajx_id);


echo "<select class=\"input-select\" style=\"margin-bottom: 15px\" onChange=\"changeLanguage()\" id=\"id_custom_select_lang\" name=\"custom_option_lang\">";
echo "  <option value=\"default\">English</option>";

foreach($language as $language){
  echo "  <option value=\"".$language['language_code']."\">".$language['language_name']."</option>";
}

echo "</select>";
?>
<li class="field hidden">
   <input type="hidden" name="category_id" id="category-id-edited" value="<?php echo $ajx_id;?>">
   <input type="hidden" name="custom_lang_code" value="<?php echo $ajx_lang?>">
   
   <label class="">Change status</label>
   <input type="radio" class="input-radio" value="Active" name="category_active" id="category_active" checked />&nbsp; Active
   <input type="radio" class="input-radio" value="Inactive" name="category_active" id="category_inactive" />&nbsp; Inactive
</li>

<li class="field hidden">
   <label>Visibility</label>
   <input type="radio" class="input-radio" value="Visible" name="category_visibility" id="category_visible" checked/>&nbsp; Yes
   <input type="radio" class="input-radio" value="Invisible" name="category_visibility" id="category_invisible" />&nbsp; No
</li>

<li class="field">
   <label>Root category</label>
   <select class="input-select">
      <option disabled>Root</option>
   </select> 
</li>

<?php
if($ajx_lang != "default"){
?>
<li class="field clearfix">
  <label>Category name</label>
  <input type="text" class="input-text" name="category_name_lang" id="category-name-edited" value="<?php echo $lang_category_name;?>" onkeyup="uncheckDefault()">
</li>

<li class="field">
  <label class="">Use Default Value</label>
  <input type="checkbox" class="input-radio" value="yes" name="custom_default_value" id="id_custom_default_value" onclick="checkDefault()"/>&nbsp;
</li>
<?php
}else{
?>

<li class="field clearfix">
  <label>Category name</label>
  <input type="text" class="input-text" name="category_name" id="category-name-edited" value="<?php echo $def_cat_name['category_name'];?>">
</li>
<?php
}
?>

<div id="close">

</div>

 
 
<script>
$('#id_custom_select_lang option[value="<?php echo $ajx_lang?>"]').attr('selected', true);

function changeLanguage(){
   var lang      = $('#id_custom_select_lang option:selected').val();
   var def_value = $('#id_category_name_normalization').val();
   var def_id    = $('#category-id-edited').val();
   
   var acq  = $.ajax({
	             type: "POST",
				 url: "sources/language/pages/recipes/category/ajax.php",
				 data: {lang:lang, def_value:def_value, def_id:def_id},
				 error: function(jqXHR, textStatus, errorThrown) {
					   
					   }
			  }).done(function(data) {
				   $('#custom_recipes_category').html(data);	
				   $('#save-changes').attr('name', 'btn-add-recipe');	
				   //normalization();
				   $('#btn_delete_pop').removeClass("hidden");
				   //$('#id_category_name_normalization').val(<?php echo $ajx_default;?>);  
			  });
   
}

function changeLanguage_ajax(){
   $('#id_custom_select_lang option[value="default"]').attr('selected', true);
   
   $('#id_custom_select_lang').trigger("change");
}

function normalization(){
	var value = $('#category-name-edited').val();
   $('#id_category_name_normalization').val();
}

function checkDefault(){
   var def_val = $('#id_category_name_normalization').val();
   
   if($('#id_custom_default_value').is(':checked')){
	  $('#category-name-edited').val('default');
   }else{
	  $('#category-name-edited').val(def_val);
   }
							   
}


function uncheckDefault(){
   var value = $('#category-name-edited').val();
   
   if(value != "default"){
      $('#id_custom_default_value').removeAttr('checked');
   }else{
      $('#id_custom_default_value').attr('checked', true);
   }
							   
}

$('#btn_close_pop').click(function(){
   //location.href = "<?php echo $prefix_url."../../../../../recipe-category";?>";
   changeLanguage_ajax();
});


$('.overlay_bg70').click(function(){
   //location.href = "<?php echo $prefix_url."../../../../../recipe-category";?>";
   changeLanguage_ajax();
});
</script>