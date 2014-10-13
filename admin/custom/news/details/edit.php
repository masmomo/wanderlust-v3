<?php
include_once("xeditor/ckeditor_php5.php");

include("get.php");
include("update.php");
include("control.php");

include("custom/bridge/news/control_bridge.php");
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
                  <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn-edited-news">
                </div>
              </div>
            </div>

            <?php
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '<div class="container">'.$_SESSION['msg'].'</div>';
			   echo '</div>';
			}
			
			if($_POST['btn-edited-news'] == ''){
			   unset($_SESSION['alert']);
			   unset($_SESSION['msg']);
			}
			?>
            
            <div class="container main">
            
              <div class="box row">
                <div class="desc col-xs-3" id="custom_lang">
                  <h3>News Details</h3>
                  <p>Manage your news details from title, category, date, and content.</p>
                </div>
                <div class="content col-xs-9">
                  <ul class="form-set">
                    <li class="form-group row underlined" id="lbl_category">
                      <label class="control-label col-xs-3" for="category">Category <span>*</span></label>
                      <div class="col-xs-9">
                        <select class="form-control" id="category" name="category">
                          
						  <?php 
						  foreach($all_news_category as $category){
						  ?>
                          
                          <option value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
                          
						  <?php }?>
                          
                        </select>
                      </div>
                    </li>
                    
                    <li class="form-group row" id="lbl_title">
                      <label class="control-label col-xs-3">Title <span>*</span></label>
                      <div class="col-xs-9">
                        <input type="text" class="form-control" name="news_title" id="news-title" value="<?php echo $news_detail['news_title'];?>">
                      </div>
                    </li>
                    
                    <li class="form-group row" id="lbl_date">
                      <label class="control-label col-xs-3">Date <span>*</span></label>
                      <div class="col-xs-9">
                        <input type="text" class="form-control" style="width: 300px" name="news_date" id="news-date" value="<?php echo $news_detail['news_date'];?>">
                      </div>
                    </li>
                    
                    
                    <li class="form-group row underlined image-placeholder input-file" style="position:relative; z-index:1;">
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
                              
                              <img class="" id="upload-news-1" src="<?php echo $prefix_url.'static/thimthumb.php?src=../'.$news_detail['news_image'].'&h=105&w=156&q=100';?>">
                              <span id="img_replace">
                                <input type="file" name="upload_news_1" id="news-1" onchange="readURL(this,'1')" class="hidden"/>
                              </span><!--img_replace--> 
                              
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
						$code = $CKEditor->editor("news_content", $initialValue);
						?>
                        
                      </div>
                    </li>
                  </ul>
                </div>
              </div><!--box-->
              
            </div><!--main-content-->
            
			<?php
            // HIDDEN INPUT
			echo '<input type="hidden" name="hidden_id" value="'.$news_detail['news_id'].'">';
			echo '<input type="hidden" name="hidden_title" value="'.$news_detail['news_title'].'">';
			echo '<input type="hidden" name="hidden_image_value" value="'.$news_detail['news_image'].'">';
			echo '<input type="hidden" name="hidden_image" id="id_hidden_image">';
			?>
            
          </form>
            
            
            
<script>
function readURL(input,i) {
                                  
   if (input.files && input.files[0]) {
      var reader = new FileReader();
	  reader.onload = function (e) {
	     $("#upload-news-"+i).removeClass("hidden");
		 $("#upload-news-"+i).attr('src', e.target.result);
		 //$("#news-flag-"+i).val('notempty');
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
   //$("#upload-news-"+i).attr('src', '');
   $("#upload-news-"+i).fadeOut("slow");
   $("#news-flag-"+i).val('');
   
   $('#id_hidden_image').val('delete');
   $('#img_replace').html('<input type="file" name="upload_news_1" id="news-1" onchange="readURL(this,"1")" class="hidden"/>');
}

function selectOption(x){
   $('#category option[value="'+x+'"]').attr('selected', true);
}

$(function() {
   $("#news-date").datepicker({
      altField:'#news-date',
	  altFormat: "yy/mm/dd",
   });
});


$(document).ready(function(e) {
   selectOption(<?php echo $news_detail['news_category'];?>);
});
</script>


<!--custom-->
<?php
include("custom/language/pages/news/index.php");
?> 

            