<?php
// SHOW CATEGORY
function listCategory($level,$parent,$current_category, $prefix_url){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_tag AS cat INNER JOIN tbl_tag_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		 echo '<option data-level="'.$level.'" class="option_level_'.$level.'" data-level="'.$level.'" id="option_level_'.$level.'"';
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

if(isset($_POST['btn_add_tag'])){
$conn = connDB();
  
   $category_name        = $_POST['category_name'];
   $category_description = $_POST['category_description'];
   $post_active_status   = $_POST['active_status'];
   $visibility_status    = $_POST['visibility_status'];
   $category_parent      = $_POST['category_parent'];
   $category_id          = $_POST['cat_id'];
   $rgb_code             = $_POST['rgb_code'];
   $code                 = $_POST['code'];
   
   // ADD FOR ANTICIPATED CROWDED IMAGE NAME @ 4 November 2013
   $file_name = substr($_FILES['upload_tag_1']['name'],0,-4);
   $file_type = substr($_FILES['upload_tag_1']['name'],-4);
   
   $uploads_dir   = '../files/uploads/tag_image/';
   //$userfile_name = str_replace(array('(',')',' '),'_',$_FILES['upload_tag_1']['name']);
   $userfile_name = cleanurl($file_name).$file_type;
   $userfile_tmp  = $_FILES['upload_tag_1']['tmp_name'];
   $prefix        = 'tag_image-';
   $prod_img      = $uploads_dir.$prefix.$userfile_name;
   
   move_uploaded_file($userfile_tmp, $prod_img);
   $slider_image  = $prefix.$userfile_name;
   
   $filename      = "files/uploads/tag_image/".$slider_image;
  
   if(empty($category_id)){
      $get_order = mysql_query("SELECT * from tbl_tag ORDER BY category_order DESC",$conn);
	  
	  if (mysql_num_rows($get_order)!=null){
         $get_order_array = mysql_fetch_array($get_order);
	     $category_order  = $get_order_array["category_order"]*1+1;
      }
	  
	  mysql_query(" INSERT INTO tbl_tag
	                (category_name,category_order,category_active_status,category_visibility_status, rgb_code, image, code) 
				    VALUES('$category_name','$category_order','$post_active_status','$visibility_status', '$rgb_code', '$filename', '$code')",$conn);
   
   
      $get_id = mysql_query("SELECT * from tbl_tag WHERE category_name = '$category_name' ORDER BY category_id DESC",$conn);
   
      if (mysql_num_rows($get_id)!=null){
         $get_id_array = mysql_fetch_array($get_id);
	     $category_id  = $get_id_array["category_id"];
      }
	  
	  $parent_array = array();
	  $get_parent   = mysql_query("SELECT * from tbl_tag_relation WHERE category_child='$category_parent'",$conn);
	  
	  if (mysql_num_rows($get_parent)!=null){
	     
		 for($counter=1;$counter<=mysql_num_rows($get_parent);$counter++){
	        $get_parent_array = mysql_fetch_array($get_parent);
		    $tmp_level        = $get_parent_array["relation_level"];
		    $tmp_parent       = $get_parent_array["category_parent"];
		    $parent_array[$tmp_level]=$tmp_parent;
         }	
		 
      }
	  
	  mysql_query("INSERT INTO tbl_tag_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','1')",$conn);
	  
	  foreach($parent_array as $level => $parent){
	     $new_level = $level*1+1;
	     mysql_query("INSERT INTO tbl_tag_relation(category_child,category_parent,relation_level)VALUES('$category_id','$parent','$new_level')",$conn);
		 
		 if ($parent=='top'){
            $category_level = $level;
         }
		 
      }
	  
   //}else if(!empty($category_id)){
      mysql_query("UPDATE tbl_tag SET category_level = '$category_level' WHERE category_id = '$category_id'",$conn);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Item(s) has been successfully added.";
   }
}
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-list"></span> &nbsp; <a href="<?php echo $prefix_url."tag"?>">Color</a> <span class="info">/</span> Add Color</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."tag";?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_add_tag" id="btn-save">
        </div>
      </div>
    </div>

        <?php
        if(!empty($_SESSION['alert'])){?>
        <div class="alert <?php echo $_SESSION['alert'];?>">
          <div class="container">
             <div class="content"><?php echo $_SESSION['msg'];?></div>
          </div>
        </div>
        <?php 
		}
		
		if($_POST['btn_add_category'] == ""){
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
                  <input type="radio" value="Active" name="active_status" id="category_active_status_active" checked="checked">
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status" id="category_active_status_inactive">
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible" checked="checked">
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible">
                  No
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Color Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Blue" id="category_name">
              </div>
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-3">Color Code</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="code" placeholder="ex: 101-1" id="category_name">
              </div>
            </li>
            <li class="form-group row underlined image-placeholder input-file" style="position:relative; z-index:1;" id="tag_image">
              <label class="control-label col-xs-3">Cover Image</label>
                <div class="col-xs-9">
                  <div class="row">
                    <div class="col-xs-3 image">
                      <div class="content image-prod-size" onMouseOver="removeButton('1')" id="newer-1" style="height:105px;">
                        <div id="remove-news-1">
                          <div class="image-delete hidden" id="btn-slider-1" onClick="clearImage('1')">
                            <span class="glyphicon glyphicon-remove"></span>
                          </div>
                          
                          <div class="image-overlay" onClick="openBrowser('1')"></div>
                        </div>
                        
                        <img class="" id="upload-news-1">
                        
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
                <input type="text" class="form-control" name="rgb_code" placeholder="ex: #FFFFFF" id="category_name">
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

</form>



<script>   
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