<?php
// SHOW CATEGORY
function listCategory($level,$parent,$current_category){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_tag AS cat INNER JOIN tbl_tag_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		 
		 echo '<div class="col-xs-9 ';
		 
		 if($level !== 1){
		    echo 'hidden';
		 }
		 
		 echo ' ">';
		 echo '<input type="checkbox" class="form-control'.$level.'" data-level="'.$level.'" id="option_level_'.$level.'"value="'.$new_parent.'" style="margin-bottom:10px;" name="tag_id[]">';
		 echo '&nbsp;';
		 for ($i=0;$i<$level;$i++){
			echo '-- ';
		 }
		 
		 echo $get_data_array["category_name"].'</option>';
		 
		 echo '</div>';
		 listCategory($new_level,$new_parent,$current_category);
	  }
   }
}
?>

            <span id="id_color_container">

              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Color</h3>
                  <p>Manage color.</p>
                </div>
                
                <div class="content col-xs-9">
                  <ul class="form-set">
                    <li class="form-group row">
                      
                      <?php listCategory(0,'top', '');?>
                      
                    </li>
                  </ul>
                </div>
              </div><!--box-->
              
            </span>