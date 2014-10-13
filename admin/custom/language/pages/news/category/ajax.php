<?php
include("../../../../../custom/static/general.php");
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
   
   $sql    = "SELECT * FROM tbl_news_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// COUNT
function count_custom($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
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
   
   $sql    = "SELECT * FROM tbl_news_category WHERE `category_id` = '$post_category_id'";
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
  <input type="hidden" name="category_id" id="category-id" value="<?php echo $ajx_id;?>">
  <input type="hidden" name="custom_lang_code" value="<?php echo $ajx_lang?>">
  <label class="">Change status</label>
  <input type="radio" class="input-radio" value="Active" name="news-category-active-status" id="news-category-active-status" checked/>&nbsp; Active
  <input type="radio" class="input-radio" value="Inactive" name="news-category-active-status" id="news-category-inactive-status"/>&nbsp; Inactive
</li>

<li class="field hidden">
  <label>Visibility</label>
  <input type="radio" class="input-radio" value="Yes" name="news-category-visible-status" id="news-category-visible-status" checked/>&nbsp; Yes
  <input type="radio" class="input-radio" value="No" name="news-category-visible-status" id="news-category-invisible-status"/>&nbsp; No
</li>

<li class="field">
  <label>Root category</label>
  <select class="input-select" >
    <option disabled>Root</option>
  </select>
</li>

<?php
if($ajx_lang != "default"){
?>
<li class="field clearfix">
  <label>Category name</label>
  <input type="text" class="input-text" name="category_name_lang" id="cat-pop-name" value="<?php echo $lang_category_name;?>" onkeyup="uncheckDefault()">
  <input type="hidden" id="id_category_name_normalization" value="<?php echo $ajx_default;?>">
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
  <input type="text" class="input-text" name="category_name" id="cat-pop-name" value="<?php echo $def_cat_name['category_name'];?>">
  <input type="hidden" id="id_category_name_normalization" value="<?php echo $ajx_default;?>">
</li>
<?php
}
?>

 
 
<script>
$('#id_custom_select_lang option[value="<?php echo $ajx_lang?>"]').attr('selected', true);

function changeLanguage(){
   var lang      = $('#id_custom_select_lang option:selected').val();
   var def_value = $('#id_category_name_normalization').val();
   var def_id    = $('#category-id').val();
   
   var acq  = $.ajax({
	             type: "POST",
				 url: "custom/language/pages/news/category/ajax.php",
				 data: {lang:lang, def_value:def_value, def_id:def_id},
				 error: function(jqXHR, textStatus, errorThrown) {
					   
					   }
			  }).done(function(data) {
				   $('#custom_lang').html(data);	
				   $('#id_btn_save').attr('name', 'btn_pop_category');		  
			  });
   
}

function changeLanguage_ajax(){
   $('#id_custom_select_lang option[value="default"]').attr('selected', true);
   
   $('#id_custom_select_lang').trigger("change");
}


function checkDefault(){
   var def_val = $('#id_category_name_normalization').val();
   
   if($('#id_custom_default_value').is(':checked')){
	  $('#cat-pop-name').val('default');
   }else{
	  $('#cat-pop-name').val(def_val);
   }
							   
}


function uncheckDefault(){
   var value = $('#cat-pop-name').val();
   
   if(value != "default"){
      $('#id_custom_default_value').removeAttr('checked');
   }else{
      $('#id_custom_default_value').attr('checked', true);
   }
							   
}




$('#btn_close_pop').click(function(){
   //location.href = "<?php echo $prefix_url."../../../../../news-category";?>";
   changeLanguage_ajax();
});


$('.overlay_bg70').click(function(){
   //location.href = "<?php echo $prefix_url."../../../../../news-category";?>";
   changeLanguage_ajax();
});
</script>