<?
// Detail Category
$category_id = $_REQUEST['cid'];


// SHOW CATEGORY
function listCategory($level,$parent,$current_category){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_tags AS cat INNER JOIN tbl_tags_relation AS cat_rel ON cat.category_id = cat_rel.category_child
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


function get_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_tags WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_tags WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


if(isset($_POST['btn_detail_tagging'])){
   
   if($_POST['btn_detail_tagging'] == 'Delete'){
      
   }else if($_POST['btn_detail_tagging'] == 'Save Changes'){
      update_category();
	  
	  $_SESSION['alert'] = 'success';
	  $_SESSION['msg']   = 'Changes successfully saved.';
   }
   
}


// CALL FUNCTION
$detail_category = get_category($category_id);



// NEW
function update_category(){
   $conn = connDB();
  
   $category_name        = $_POST['category_name'];
   $category_description = $_POST['category_description'];
   $visibility_status    = $_POST['visibility_status'];
   $category_parent      = $_POST['category_parent'];
   $category_id          = $_POST['hidden_category_id'];
   
   // CUSTOM
   $rgb_code             = $_POST['rgb_code'];
   $code                 = $_POST['code'];
   $existing_image       = $_POST['hidden_image'];
   
   if(!empty($_FILES['upload_tag_1']['name'])){
   
      // ADD FOR ANTICIPATED CROWDED IMAGE NAME @ 4 November 2013
	  $file_name = substr($_FILES['upload_tag_1']['name'],0,-4);
	  $file_type = substr($_FILES['upload_tag_1']['name'],-4);
	  
	  $uploads_dir   = '../files/uploads/tagging_image/';
	  //$userfile_name = str_replace(array('(',')',' '),'_',$_FILES['upload_tag_1']['name']);
	  $userfile_name = cleanurl($file_name).$file_type;
	  $userfile_tmp  = $_FILES['upload_tag_1']['tmp_name'];
	  $prefix        = 'tag_image-';
	  $prod_img      = $uploads_dir.$prefix.$userfile_name;
	  
	  move_uploaded_file($userfile_tmp, $prod_img);
	  $slider_image  = $prefix.$userfile_name;
	  
	  $filename      = "files/uploads/tagging_image/".$slider_image;
   }else{
      
	  if($_POST['hidden_image_flag'] == 'deleted'){
		 
		 unlink('../'.$existing_image);
	     $filename      = '';
	  }else{
	     $filename      = $existing_image;
	  }
   }
   
  
   //if(empty($category_id)){
   
   //category level
   if ($category_parent=='top'){
      $category_level='0';
   }else{
      $get_level = mysql_query("SELECT * from tbl_tags WHERE category_id = '$category_parent'",$conn);
		  
      if (mysql_num_rows($get_level)!=null){
	     $get_level_array = mysql_fetch_array($get_level);
	     $category_level = $get_level_array["category_level"]*1+1;
	  }
	  
   }
   
   $get_order = mysql_query("SELECT * from tbl_tags ORDER BY category_order DESC",$conn);
	  
   if (mysql_num_rows($get_order)!=null){
      $get_order_array = mysql_fetch_array($get_order);
      $category_order = $get_order_array["category_order"]*1+1;
   }
   
   mysql_query(" UPDATE tbl_tags SET category_name = '$category_name',
                                     category_level = '$category_level',
									 category_visibility_status = '$visibility_status',
									 category_description='$category_description', 
									 rgb_code = '$rgb_code', 
									 image = '$filename', 
									 code = '$code'
                 WHERE category_id = '$category_id'
			   ",$conn) or die(mysql_error());
   
   
   update_category_relation($category_id,$category_parent);
   
}


function update_category_relation($category_id,$category_parent){
   $conn = connDB();
   
   //delete all category relation with this as child
   mysql_query("DELETE FROM tbl_tags_relation WHERE category_child = '$category_id'",$conn);
	
   //add category relation
   add_category_relation($category_id,$category_parent,1);
	
   //get all category where category parent is this, get the relation order
   $categories=array();
   $get_categories = mysql_query("SELECT * from tbl_tags_relation WHERE category_parent = '$category_id'",$conn);
   
   if (mysql_num_rows($get_categories) != null){
	  
	  for($counter=1;$counter<=mysql_num_rows($get_categories);$counter++){
	     $get_categories_array = mysql_fetch_array($get_categories);
		 $categories[$counter]["relation_level"] = $get_categories_array["relation_level"];
		 $categories[$counter]["category_child"] = $get_categories_array["category_child"];
	  }
		 
   }
   
   //print_r($categories);
   foreach($categories as $category){
      $tmp_level = $category['relation_level'];
      $tmp_child = $category['category_child'];
	  
	  //remove all with relation order more than that
	  mysql_query("DELETE FROM tbl_tags_relation WHERE category_child = '$tmp_child' AND relation_level >= '$tmp_level'" ,$conn);
	  
	  //add relation
	  add_category_relation($tmp_child,$category_id,$tmp_level);
   }
	  
}


function add_category_relation($category_id,$category_parent,$level_init){
   $conn = connDB();
   
   if ($category_parent=='top'){
      mysql_query("INSERT INTO tbl_tags_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','$level_init')",$conn);
   }else{
      $parent_array=array();
	  $get_parent = mysql_query("SELECT * from tbl_tags_relation WHERE category_child='$category_parent'",$conn);
	  
	  if (mysql_num_rows($get_parent)!=null){
		 
		 for($counter=1;$counter<=mysql_num_rows($get_parent);$counter++){
		    $get_parent_array = mysql_fetch_array($get_parent);
		    $tmp_level        = $get_parent_array["relation_level"];
		    $tmp_parent       = $get_parent_array["category_parent"];
		    $parent_array[$tmp_level] = $tmp_parent;
         }	
		 
      }
	  
	  mysql_query("INSERT INTO tbl_tags_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','$level_init')",$conn);
	  
	  foreach($parent_array as $level => $parent){
	     $new_level = $level*1+$level_init;
	     mysql_query("INSERT INTO tbl_tags_relation(category_child,category_parent,relation_level) VALUES('$category_id','$parent','$new_level')",$conn);
		 
		 if ($parent=='top'){
            $category_level = $new_level-1;
         }
		 
      }
	  
   }
   
   mysql_query("UPDATE tbl_tags SET category_level = '$category_level' WHERE category_id = '$category_id'");
}
?> 
        

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-list"></span> &nbsp; 
          <a href="<?php echo $prefix_url."tag"?>">Color</a> 
          <span class="info">/</span> Edit Color</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."tagging";?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_detail_tagging" id="btn-save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_detail_tagging'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Color Details</h3>
          <p>Your color details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set" id="custom_product_category">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" name="active_status" id="category_active_status_active" checked="checked"/>Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status" id="category_active_status_inactive" />Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible" 
                  <?php if(strtolower($detail_category['category_visibility_status']) == "1"){ echo "checked=\"checked\"";}?>>
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible" 
                  <?php if(strtolower($detail_category['category_visibility_status']) == "0"){ echo "checked=\"checked\"";}?>>
                  No
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Color Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Tees" id="category_name" value="<?php echo $detail_category['category_name'];?>">
              </div>
            </li><li class="form-group row">
              <label class="control-label col-xs-3">Color Code</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="code" placeholder="ex: 101-1" id="category_name" value="<?php echo $detail_category['code'];?>">
              </div>
            </li>
            <li class="form-group row underlined image-placeholder input-file" style="position:relative; z-index:1;" id="tag_image">
              <label class="control-label col-xs-3">Cover Image</label>
                <div class="col-xs-9">
                  <div class="row">
                    <div class="col-xs-3 image">
                      <div class="content image-prod-size" onMouseOver="removeButton('1')" id="newer-1" style="height:105px;">
                        <div id="remove-news-1">
                          <div class="image-delete" id="btn-slider-1" onClick="clearImage('1')">
                            <span class="glyphicon glyphicon-remove"></span>
                          </div>
                          
                          <div class="image-overlay" onClick="openBrowser('1')"></div>
                        </div>
                        
                        <img class="" src="<?php echo $prefix_url.'static/thimthumb.php?src=../'.$detail_category['image'].'&h=105&w=156&q=100';?>" id="upload-news-1">
                        
                        <div id="img_replacer">
                          <input type="file" name="upload_tag_1" id="news-1" onchange="readURL(this,'1')" class="hidden"/>
                        </div><!--img_replacer-->  
                        
                      </div>
                    </div>
                  </div>
                  
                  <p class="help-block" style="padding-top: 10px">Recommended dimensions of 228 x 152 px.</p>
                </div>
              </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-3">RGB Code</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="rgb_code" placeholder="ex: #FFFFFF" id="category_name" value="<?php echo $detail_category['rgb_code'];?>">
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Root Category</label>
              <div class="col-xs-9">
                <select class="form-control" name="category_parent" id="category_parent" onchange="hiddenImage()">
                  <option value="top">-- Root Category --</option>
                  <?php listCategory(0,'top');?>
                </select>
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->
    
    <?php
    echo '<input type="hidden" name="hidden_category_id" value="'.$detail_category['category_id'].'">';
	echo '<input type="hidden" name="hidden_image" value="'.$detail_category['image'].'">';
	echo '<input type="hidden" name="hidden_image_flag" id="id_hidden_image_flag">';
	?>

</form>


        
<script>
function selected(x){
   $('#category_parent option[value="'+x+'"]').attr('selected',true);
}

function freechecked(){
   $('input[type="checkbox"]').attr('checked',false);
}

selected(<?php echo $detail_category['category_id'];?>);   

function readURL(input,i) {
                                  
   if (input.files && input.files[0]) {
      var reader = new FileReader();
	  reader.onload = function (e) {
		                 $("#upload-news-"+i).removeClass("hidden");
						 $("#upload-news-"+i).attr('src', e.target.result);
						 //$("#news-flag-"+i).val('notempty');
						 $('#btn-slider-1').removeClass('hidden');
				      }
                            		 
   reader.readAsDataURL(input.files[0]);
   
   }
                            	  
}


function openBrowser(i){
   document.getElementById("news-"+i).click();
}


function removeButton(i){
   $("#remove-news-"+i).removeClass("hidden");
   $("#remove-news-"+i).fadeIn("slow");
   $("#btn-news-"+i).attr('style','z-index:1000; position:absolute');
   
   $("#new-"+i).mouseleave(function(){
      $("#remove-news-"+i).fadeOut("slow");
   });
}


function clearImage(i){
   $("#upload-news-"+i).attr('src', '');
   $("#upload-news-"+i).fadeOut("slow");
   $('#id_hidden_image_flag').val('deleted');
   
   /*$("#news-flag-"+i).val('');*/
   
   $('#img_replacer').html('<input type="file" name="upload_news_'+i+'" id="news-'+i+'" onchange="readURL(this,'+i+')" class="hidden"/>');
}



function hiddenImage(){
   var selected = $('#category_parent option:selected').attr('data-level');
   
   if(selected != 'option_level_0'){
      $('#tag_image').addClass('hidden');
   }else{
      $('#tag_image').removeClass('hidden');
   }
   
}
</script>