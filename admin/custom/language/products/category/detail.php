<?php
$_SESSION['lang_admin'] = $_REQUEST['lang'];

// Detail Category
$category_id = $_REQUEST['cid'];


// SHOW CATEGORY
function listCategory($level,$parent,$current_category){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		 
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


// DEFAULT VALUE
function get_default($post_cat_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_category WHERE `category_id` = '$post_cat_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_lang($post_id_param){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_category_lang WHERE `id_param` = '$post_id_param'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function check_lang($post_id_param){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_category_lang WHERE `id_param` = '$post_id_param'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function insert($post_id_param, $post_category_name, $post_category_description, $post_category_level, $post_category_order, $post_active, $post_visibility, $post_lang_code){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_category_lang (`id_param`, `category_name`, `category_description`, `category_level`, `category_order`, `active`, `visibility`, `language_code`)
             VALUES('$post_id_param', '$post_category_name', '$post_category_description', '$post_category_level', '$post_category_order', '$post_active', '$post_visibility', '$post_lang_code')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
   
   return $result;
}


function update($post_category_name, $post_category_description, $post_category_level, $post_category_order, $post_active, $post_visibility, $post_lang_code, $post_id_param){
   $conn  = connDB();
   $sql   = "UPDATE tbl_category_lang set `category_name` = '$post_category_name', 
                                          `category_description` = '$post_category_description', 
										  `category_level` = '$post_category_level', 
										  `category_order` = '$post_category_order', 
										  `active` = '$post_active', 
										  `visibility` = '$post_visibility', 
										  `language_code` = '$post_lang_code'
		     WHERE `id_param` = '$post_id_param'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
   
   return $result;
}


// CALL FUNCTION
$detail_category = get_default($category_id);
$check           = check_lang($category_id);
$lang            = get_lang($category_id);


if($check['rows'] > 0){
   $detail_category['category_name'] = $lang['category_name'];
}else{
   $detail_category['category_name'] = $detail_category['category_name'];
}


if(isset($_POST['btn_lang_detail_category'])){
   
   if(!empty($_POST['category_name'])){
      
	  if(!empty($_POST['custom_lang_default_name'])){
	     $cat_name = 'default';
	  }else{
	     $cat_name = $_POST['category_name'];
	  }
      
   }else{
      $cat_name = 'default';
   }
   
   $cat_desc    = $detail_category['category_description'];
   $cat_level   = $detail_category['category_level'];
   $cat_order   = $detail_category['category_order'];
   $cat_active  = $detail_category['category_active_status'];
   $cat_visible = $detail_category['category_visibility_status'];
   $lang_code   = $_REQUEST['lang'];
   
   if($check['rows'] > 0){
      update($cat_name, $cat_desc, $cat_level, $cat_order, $cat_active, $cat_visible, $lang_code, $category_id);
   }else{
      insert($category_id, $cat_name, $cat_desc, $cat_level, $cat_order, $cat_active, $cat_visible, $lang_code);
   }
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Changes successfully saved';
   
}
?> 
        

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-list"></span> &nbsp; 
          <a href="<?php echo $prefix_url."category"?>">Categories</a> 
          <span class="info">/</span> Edit Category
        </h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."category";?>">
            <input type="hidden" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel">
          </a>
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_lang_detail_category" id="btn-save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_lang_detail_category'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Category Details</h3>
          <p>Your category details.</p>
          
          <?php
          include('select.php');
		  ?>
          
        </div>
        <div class="content col-xs-9">
          <ul class="form-set" id="custom_product_category">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" name="active_status" id="category_active_status_active" 
                  <?php if(strtolower($detail_category['category_active_status']) == "active"){ echo "checked=\"checked\"";}?>>
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status" id="category_active_status_inactive" 
                  <?php if(strtolower($detail_category['category_active_status']) == "inactive"){ echo "checked=\"checked\"";}?>>
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input disabled type="radio" value="1" name="visibility_status" id="category_visibility_status_visible" 
                  <?php if(strtolower($detail_category['category_visibility_status']) == "1"){ echo "checked=\"checked\"";}?>>
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input disabled type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible" 
                  <?php if(strtolower($detail_category['category_visibility_status']) == "0"){ echo "checked=\"checked\"";}?>>
                  No
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Category Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Tees" id="value_title" value="<?php echo $detail_category['category_name'];?>" id="value_title" onkeyup="uncheckDefault('title')">
                
                <input type="hidden" id="id_normalization_title" value="<?php echo $detail_category['category_name'];?>">
              
                <label class="control-label" style="width: 130px;">
                  <input type="checkbox" name="custom_lang_default_name" id="id_custom_lang_default_title" style="margin-right:5px;" onclick="checkDefault('title')" <?php if($detail_category['category_name'] == "default"){ echo "checked";}?> class="control-label"> Use default value
                </label>
                
				<?php
				// HIDDEN VALUE
				echo '<input type="hidden" name="hidden_category_id" value="'.$_REQUEST['cid'].'" class="form-control">';
				?>
                
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Root Category</label>
              <div class="col-xs-9">
                <select class="form-control" name="category_parent" id="category_parent" disabled>
                  <option value="top">-- Root Category --</option>
                  <?php listCategory(0,'top');?>
                </select>
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>


        
<script>
function selected(x){
   $('#category_parent option[value="'+x+'"]').attr('selected',true);
} 


function checkDefault(i){
   var def_val = $('#id_normalization_'+i).val();
   
   if($('#id_custom_lang_default_'+i).is(':checked')){
	  $('#value_'+i).val('default');
   }else{
	  $('#value_'+i).val(def_val);
   }
							   
}

function uncheckDefault(i){
   var value = $('#value_'+i).val();
   
   if(value != "default"){
      $('#id_custom_lang_default_'+i).removeAttr('checked');
   }else{
      $('#id_custom_lang_default_'+i).attr('checked', true);
   }
							   
} 

$(document).ready(function(e) {
   selected(<?php echo $category_id;?>); ;
});
</script>



