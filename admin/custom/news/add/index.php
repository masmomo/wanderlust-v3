<?php
include_once("xeditor/ckeditor_php5.php");

include("get.php");
include("update.php");
include("control.php");
?>

<form method="post" enctype="multipart/form-data">

            <div class="subnav">
                <div class="container clearfix">
                    <h1><span class="glyphicon glyphicon-list"></span> &nbsp; Add News</h1>
                    <div class="btn-placeholder">
                        <input type="button" class="btn btn-default btn-sm" value="Cancel" onclick="buttonCancel()">
                        <input type="button" class="btn btn-success btn-sm" value="Save Changes" name="btn-add-news" onclick="validationAddNews('save')">
                        <input type="submit" class="hidden" value="Save Changes" name="btn-add-news" id="btn_save">
                        <input type="submit" class="hidden" value="Save Changes &amp; Exit" name="btn-add-news" id="btn_exit">
                    </div>
                </div>
            </div>

            <?php
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '<div class="container">'.$_SESSION['msg'].'</div>';
			   echo '</div>';
			}
			
			if($_POST['btn-add-news'] == ''){
			   unset($_SESSION['alert']);
			   unset($_SESSION['msg']);
			}
			?>

            <div class="container main">

                <div class="box row">
                    <div class="desc col-xs-3">
                        <h3>News Details</h3>
                        <p>Manage your news details from title, category, date, and content.</p>
                    </div>
                    <div class="content col-xs-9">
                        <ul class="form-set">
                            <li class="form-group row underlined" id="lbl_category">
                                <label class="control-label col-xs-3" for="category">Category <span>*</span></label>
                                <div class="col-xs-9">
                                  <select class="form-control" id="category" name="category">
                                      <?php foreach($category as $category){?>
                                      <option value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
                                      <?php }?>
                                  </select>
                                </div>
                            </li>
                            <li class="form-group row" id="lbl_title">
                                <label class="control-label col-xs-3">Title <span>*</span></label>
                                <div class="col-xs-9">
                                  <input type="text" class="form-control" name="news_title" id="news-title" onkeypress="checkTitle()">
                                </div>
                            </li>
                            <li class="form-group row" id="lbl_date">
                                <label class="control-label col-xs-3">Date <span>*</span></label>
                                <div class="col-xs-9">
                                  <input type="text" class="form-control" style="width: 300px" name="news_date" id="news-date">
                                </div>
                            </li>
                            <li class="form-group row underlined image-placeholder input-file" style="position:relative; z-index:1;">
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
                                           <input type="file" name="upload_news_1" id="news-1" onchange="readURL(this,'1')" class="hidden"/>
                                        </div><!--img_replacer-->    
                                                                        
                                      </div>
                                    </div>
                                  </div>
                                  <p class="help-block" style="padding-top: 10px">Recommended dimensions of 228 x 152 px.</p>
                                </div>
                            </li>
                            
                            <li class="form-group row" id="lbl_content">
                              <label class="control-label col-xs-3">Content <span>*</span></label>
                              <div class="col-xs-9">
                                <!--<textarea class="form-control hidden" rows="8" id="news-content" name="news_content"></textarea>-->
                                
								<?php
								$path = get_dirname($_SERVER['PHP_SELF']);
								$CKEditor = new CKEditor();
								$initialValue = '';
								$code = $CKEditor->editor("news_content", $initialValue);
								?>
                                
                              </div>
                            </li>
                          </ul>
                        </div>
                      </div><!--box-->
                      
                    </div><!--main-content-->
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
   /*
   $("#upload-news-"+i).attr('src', '');
   $("#upload-news-"+i).fadeOut("slow");
   $("#news-flag-"+i).val('');
   */
								   
   $('#img_replacer').html('<input type="file" name="upload_news_'+i+'" id="news-'+i+'" onchange="readURL(this,'+i+')" class="hidden"/>');
}

function buttonCancel(){
   location.href = "<?php echo $prefix_url."news"?>";
}

function validationAddNews(){
   var category = $('#category option:selected').val();
   var title    = $('#news-title').val();
   var date     = $('#news-date').val();
   var content  = $('#news-content').val();
   
   if(category == ''){
      $('#lbl_category').addClass('has-error');
   }else if(title == ''){
      $('#lbl_title').addClass('has-error');
   }else if(date == ''){
	  $('#lbl_date').addClass('has-error');
   }else if(content == ''){
	  $('#lbl_content').addClass('has-error');
   }else{
      /*
	  if(x == 'save'){
	    $('#btn_save').click();
	  }else{ if(x == 'exit'){
	    $('#btn_exit').click();
	  }*/
	  
	  $('#btn_save').click();
	  
   }
   
}

$(function() {
   $("#news-date").datepicker({
      altField:'#news-date',
	  altFormat: "yy/mm/dd",
   });
});
</script>

            
