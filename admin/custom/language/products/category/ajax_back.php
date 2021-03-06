<?php
include("../../../../custom/static/general.php");
include("../../../../static/general.php");

// SHOW CATEGORY
function listCategory($level,$parent,$current_category){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level = $level*1+1;
		 $new_parent = $get_data_array["category_id"];
		 echo '<option class="option_level_'.$level.'" data-level="'.$level.'" id="option_level_'.$level.'"';
		 if ($current_category==$new_parent."'"){
			echo "selected=selected";
		 }
		 
		 echo ' value="'.$new_parent.'">';
		 
		 for ($i=0;$i<$level;$i++){
			echo '-- ';
		 }
		 
		 echo $get_data_array["category_name"].'</option>';
		 listCategory($new_level,$new_parent,$current_category);
      }
   }
}

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

// COUNT
function count_custom($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// GET
function get_custom($post_id_param, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// CALL FUNCTION
$language = get_languages();
$check    = count_custom($ajx_id, $ajx_lang);
$get      = get_custom($ajx_id, $ajx_lang);



/* -- DEFAULT --*/

// GET
function get_default($post_cat_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_category WHERE `category_id` = '$post_cat_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// CALL FUNCTION
$default      = get_custom($ajx_id, $ajx_lang);


// CONTROL

if($check['rows'] > 0){
  $lang_category_name = $get['category_name'];
}else{
  $lang_category_name = $default['category_name'];
}


echo "<select class=\"input-select\" style=\"margin-bottom: 15px\" onChange=\"changeLanguage()\" id=\"id_custom_select_lang\" name=\"custom_option_lang\">";
echo "  <option value=\"default\">English</option>";

foreach($language as $language){
  echo "  <option value=\"".$language['language_code']."\" selected=\"selected\">".$language['language_name']."</option>";
}

echo "</select>";
?>

<li class="field hidden">
  <label class="">Change status</label>
  <input type="radio" class="input-radio" value="Active" name="active_status" id="category_active_status_active"/>&nbsp; Active
  <input type="radio" class="input-radio" value="Inactive" name="active_status" id="category_active_status_inactive"/>&nbsp; Inactive
</li>

<li class="field hidden">
  <label>Visibility</label>
  <input type="radio" class="input-radio" value="1" name="visibility_status" id="category_visibility_status_visible" />&nbsp; Yes
  <input type="radio" class="input-radio" value="0" name="visibility_status" id="category_visibility_status_invisible" />&nbsp; No
</li>

<li class="field">
  <label>Root category</label>
  <select class="input-select" name="category_parent" id="category_parent" disabled>
    <option value="top">-- Root Category --</option>
      <?php listCategory(0,'top');?>
    </select>
</li>

<li class="field clearfix">
  <label>Category name</label>
  <input type="text" class="input-text" name="category_name" placeholder="ex: Tees" id="category_name" onkeyup="uncheckDefault()">
  <!--<input type="hidden" id="id_category_name_normalization" value="<?php echo $ajx_default;?>">-->
</li>