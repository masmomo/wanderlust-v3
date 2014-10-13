<?php
include('../../static/general.php');
include('../../../static/general.php');


/* -- FUNCTIONS -- */
function get_products_color($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_colored($post_tag_id, $post_product_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_color WHERE `tag_id` = '$post_tag_id' AND `product_id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DEFINED VARIABLE
$ajx_alias = $_POST['alias'];


// CALL FUNCTION
$data_product = get_products_color($ajx_alias);


function listCategoryColor($level,$parent,$current_category, $data){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_tag AS cat INNER JOIN tbl_tag_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		 
		 $check          = get_colored($get_data_array['category_id'], $data);
		 
		 echo '<div class="col-xs-9 ';
		 
		 if($level !== 1){
		    echo 'hidden';
		 }
		 
		 echo ' ">';
		 echo '<input type="checkbox" ';
		 
		 if($check['rows'] > 0){
		    echo 'checked="checked" ';
		 }
		 
		 echo 'class="form-control'.$level.'" data-level="'.$level.'" id="option_level_'.$level.'"value="'.$new_parent.'" style="margin-bottom:10px;" name="tag_id[]">';
		 echo '&nbsp;';
		 for ($i=0;$i<$level;$i++){
			echo '-- ';
		 }
		 
		 echo $get_data_array["category_name"];
		 
		 echo '</div>';
		 listCategoryColor($new_level, $new_parent, $current_category, $data);
	  }
   }
}
?>


            <span id="id_color_container" data-ajax="<?php echo $data_product['id'];?>">

              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Color</h3>
                  <p>Manage color.</p>
                </div>
                
                <div class="content col-xs-9">
                  <ul class="form-set">
                    <li class="form-group row">
                      
                      <?php listCategoryColor(0,'top', '', $data_product['id']);?>
                      
                    </li>
                  </ul>
                </div>
              </div><!--box-->
              
            </span>