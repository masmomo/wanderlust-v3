<?php
include_once("xeditor/ckeditor_php5.php");

include("get.php");
include("update.php");
include("control.php");
include("ajax.php");
?>

          <form method="post" enctype="multipart/form-data">
          
            <div class="subnav">
              <div class="container clearfix">
                <h1>
                  <span class="glyphicon glyphicon-list"></span> &nbsp; 
                  <a href="<?php echo $prefix_url."news"?>">News</a> 
                  <span class="info">/</span> Edit News
                </h1>
                
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url.'news';?>">
                    <input type="button" class="btn btn-default btn-sm" value="Cancel">
                  </a>
                  <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_custom_news_lang">
                </div>
              </div>
            </div>

            <?php
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '<div class="container">'.$_SESSION['msg'].'</div>';
			   echo '</div>';
			}
			
			if($_POST['btn_custom_news_lang'] == ''){
			   unset($_SESSION['alert']);
			   unset($_SESSION['msg']);
			}
			?>

            <div class="container main">
            
              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>News Details</h3>
                  <p>Manage your news details from title, category, date, and content.</p>
                
                  <!--custom-->
                  <?php
				  include("select_edit.php");
				  ?>
                  
                </div>
                
                <div class="content col-xs-9">
                  <ul class="form-set">
                  
                    <li class="form-group row underlined">
                      <label class="control-label col-xs-3" for="category">Category <span>*</span></label>
                      
                      <div class="col-xs-9">
                        <select class="form-control" id="category" name="category" disabled>
                        
						  <?php 
						  foreach($all_news_category as $category){
							 // CALL FUNCTION
							 $check_cat_lang = check_news_cat_lang($category['category_id'], $_SESSION['lang_admin']);
							 
							 if($check_cat_lang['rows'] > 0){
							    // CALL FUNCTION
								$categories = get_category_lang($category['category_id'], $_SESSION['lang_admin']);
								
						        $category['id_param']      = $categories['id_param'];
						        $category['category_name'] = $categories['category_name'];
							 }else{
						        $category['id_param']      = $category['category_id'];
						        $category['category_name'] = $category['category_name'];
							 }
							 
							 echo "<option value=\"".$category['id_param']."\">".$category['category_name']."</option>";
						  }
						  ?>
                          
                        </select>
                      </div>
                    </li>
                    
                    <li class="form-group row">
                      <label class="control-label col-xs-3">Title <span>*</span></label>
                      <div class="col-xs-9">
                         <input type="text" class="form-control" value="<?php echo $news_detail['news_title'];?>" name="ct_post_news_title" id="value_title" onkeyup="uncheckDefault('title')">
                         
                         <input type="text" class="hidden" id="id_normalization_title" value="<?php echo $news_detail['news_title'];?>">
                         
                         <label class="control-label" style="width: 130px;">
                           <input type="checkbox" name="custom_lang_default_name" id="id_custom_lang_default_title" style="margin-right:5px;" onclick="checkDefault('title')" <?php if($news_detail['news_title'] == "default"){ echo "checked";}?> class="control-label"> Use default value
                         </label>
                      </div>
                    </li>
                    
                    <li class="form-group row">
                      <label class="control-label col-xs-3">Date <span>*</span></label>
                      <div class="col-xs-9">
                        <input type="text" class="form-control" style="width: 300px" value="<?php echo $news_detail['news_date'];?>" name="news_date" disabled>
                      </div>
                    </li>
                    
                    <li class="form-group row image-placeholder input-file" style="position:relative; z-index:1;">
                      <label class="control-label col-xs-3">Cover Image</label>
                      <div class="col-xs-9">
                        <div class="row">
                          <div class="col-xs-3 image">
                            <div class="content image-prod-size" onMouseOver="removeButton('1')" id="newer-1" style="height:105px;">
                              
                              <img id="upload-news-1" src="<?php echo $prefix_url.'static/thimthumb.php?src=../'.$news_detail['news_image'].'&h=105&w=156&q=100';?>">
                              
                            </div>
                          </div>
                        </div>
                          
                        <p class="help-block" style="padding-top: 10px">Recommended dimensions of 228 x 152 px.</p>
                      </div>
                    </li>
                    
                    <li class="form-group row" id="lbl_content">
                      <label class="control-label col-xs-3">Content <span>*</span></label>
                      <div class="col-xs-9">
                        <!--<textarea class="form-control" rows="8" id="news-content" name="news_content"><?php echo $news_detail['news_content'];?></textarea>-->
                        
						<?php
						$path = get_dirname($_SERVER['PHP_SELF']);
						$CKEditor = new CKEditor();
						$initialValue = $news_detail['news_content'];
						$code = $CKEditor->editor("ct_post_news_content", $initialValue);
						?>
                        
                        <label class="control-label" style="width: 130px;; margin-bottom:20px; float:none;">
                          <input type="checkbox" name="custom_lang_default_content" id="id_custom_lang_default_content" style="margin-right:5px;" onclick="checkDefault('content')"  class="control-label" <?php if($news_detail['news_content'] == "default"){ echo "checked";}?>> Use default value
                        </label>
                        
                      </div>
                    </li>
                    
                  </ul>
                </div>
              </div><!--box-->

            </div><!--main-content-->
            
            <?php
			// HIDDEN VALUE
            echo '<input type="hidden" name="news_id" value="'.$_REQUEST['nid'].'">';
            echo '<input type="hidden" name="news_cat_id" value="'.$news_detail['news_category'].'">';
			?>
            
          </form>
            
            
            
<script>
function cancelEdit(){
  location.href="<?php echo $prefix_url.$_SESSION['lang_admin']."-news-detail/".$news_id."/".cleanurl($news_title)?>";
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
   $('#category option[value=<?php echo $news_detail['news_category']?>]').attr('selected','selected');
});
</script>

            