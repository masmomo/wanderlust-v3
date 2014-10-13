<?php
// CATEGORY PARENT
$category_id = $_GET["category_id"];
if ($category_id==""){
	$category_id = "top";
}

$categories = array();
if ($category_id!=0){
   $get_condition = mysql_query(" SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_parent
	                              WHERE cat_rel.category_child = '$category_id'
								  ORDER BY category_level",$con);
   array_push($categories,$category_id);
   
   if (mysql_num_rows($get_condition)!=null && mysql_num_rows($get_condition)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_condition);$counter++){
	     $get_condition_array = mysql_fetch_array($get_condition);
		 array_push($categories,$get_condition_array["category_id"]);
	  }
	  
   }

}else{
   array_push($categories,'top');
}

// CATEGORY CHILD
function iterateCategory($level,$parent,$categories){
   include("../../static/connect_database.php");
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order ",$con);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level = $level*1+1;
		 $new_parent = $get_data_array["category_id"];
		 echo '<div class="under_'.$parent;
		 
		 if (!in_array($parent,$categories)&&$level>0){
		    echo ' hidden';
		 }
		 
		 echo '">';
		 echo '<div class="level_'.$level.' sidebar_menu';
		 
		 if ($new_parent==$categories[0]){
			echo " sidebar_menu_selected";
		 }
		 
		 echo '" id="slideshow_side_menu" ><div class="arrow_sidebar';
		 
		 if ($new_parent==$categories[0]){
		    echo " arrow_sidebar_selected";
		 }
		 
		 if (in_array($new_parent,$categories)){
		    echo ' open_arrow';
			
			if ($new_parent==$categories[0]){
			   echo " open_arrow_selected";
			}
		 }
		 
		 echo '" id="arrow_sidebar_'.$new_parent.'" onclick="toggleChild('.$new_parent.')"></div><a href="'.$url.'?category_id='.$new_parent.'" class="sidebar_link">'.$get_data_array["category_name"].'</a></div>';
		 
		 iterateCategory($new_level,$new_parent,$categories);
		 echo '</div>';
		 echo '<div class="hidden" id="status_'.$new_parent.'">';
		 
		 if (in_array($new_parent,$categories)){
			echo 'open';
		 }else{
			echo 'close';
		 }
		
		 echo '</div>';
		 echo '<div class="hidden" id="selected_'.$new_parent.'">';
		 
		 if ($new_parent==$categories[0]){
			echo "1";
		 }else{
			echo "0";
		 }
		 
		 echo '</div>';
      }
	
   }
}

function listCategory($level,$parent,$categories,$current_category){
   include("../../static/connect_database.php");
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$con);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level = $level*1+1;
		 $new_parent = $get_data_array["category_id"];
		 echo '<option class="option_level_'.$level.'" ';
		 
		 if ($current_category==$new_parent){
			echo "selected=selected";
		 }
		 
		 echo ' value="'.$new_parent.'">';
		 
		 for ($i=0;$i<$level;$i++){
			echo '&nbsp;&nbsp;&nbsp;';
		 }
		 
		 echo $get_data_array["category_name"].'</option>';
		 listCategory($new_level,$new_parent,$categories,$current_category);
      }
   }
}
?>