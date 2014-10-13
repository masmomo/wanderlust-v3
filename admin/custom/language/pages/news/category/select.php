<?php
include("../../../../../custom/static/general.php");
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

echo "<select class=\"form-control\" style=\"margin-top: 15px\" onChange=\"changeLanguage()\" id=\"id_custom_select_lang\">";
echo "  <option value=\"default\">English</option>";

foreach($language as $language){
  echo "  <option value=\"".$language['language_code']."\">".$language['language_name']."</option>";
}

echo "</select>";
?>

<script>
$('#id_custom_select_lang option[value="<?php echo $_SESSION['lang_admin'];?>"]').attr('selected', true);

function changeLanguage(i, x){
   var lang = $('#id_custom_select_lang option:selected').val();
   var nid  = $('#custom_news_detail_nid').val();
   var nn   = $('#custom_news_detail_nn').val();
   
   if(lang != "default"){
      location.href = "<?php echo $prefix_url;?>../../../../../"+lang+"-news-category-detail/"+nid+"/"+nn;
   }else{
      location.href = "<?php echo $prefix_url.'news-category-detail/'.$_REQUEST['nid'].'/'.cleanurl($default['category_name']);?>";
   }
   
}
</script>
