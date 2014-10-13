<?php
include("get.php");
include("update.php");
include("control.php");
?>

<form method="post" enctype="multipart/form-data">

            <div class="subnav">
              <div class="container clearfix">
                <h1><span class="glyphicon glyphicon-list"></span> &nbsp; Add Project</h1>
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url."project"?>">
                    <input type="button" class="btn btn-default btn-sm" value="Cancel">
                  </a>
                  
                  <input type="button" class="btn btn-success btn-sm" value="Save Changes" onclick="validate('save')">
                  <input type="button" class="btn btn-success btn-sm hidden" value="Save Changes &amp; Exit" onclick="validate('exit')">
                  <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes" name="btn_add_inspiration" id="id_btn_save">
                  <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes &amp; Exit" name="btn_add_inspiration" id="id_btn_exit">
                </div>
              </div>
            </div>
            
			<?php
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '<div class="container">'.$_SESSION['msg'].'</div>';
			   echo '</div>';
			}
			
			
			if($_POST['btn_add_inspiration'] == ""){
			   unset($_SESSION['alert']);
			   unset($_SESSION['msg']);
			}
			?>

            <div class="container main">
              
              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Project</h3>
                  <p>Manage project name.</p>
                </div>
                
                <div class="content col-xs-9">
                  <ul class="form-set">
                    <li class="form-group row">
                      <label for="brand" class="control-label col-xs-3">Project Category <span>*</span></label>
                      <div class="content col-xs-9">
                        <select class="form-control" name="inspiration_category" id="id_inspiration_category">
                         
                          <?php
                          foreach($category as $category){
						     echo '<option value="'.$category['category_id'].'">'.$category['name'].'</option>';
						  }
						  ?>
                         
                        </select>
                      </div>
                    </li>
                    
                    <li class="form-group row" id="lbl_inspiration_name">
                      <label for="brand" class="control-label col-xs-3">Project Name <span>*</span></label>
                      <div class="content col-xs-9">
                        <input type="text" class="form-control" name="inspiration_name" id="id_inspiration_name">
                      </div>
                    </li>
                  </ul>
                </div>
              </div><!--box-->
              
              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Banner</h3>
                  <p>Add project page banners.</p>
                </div>
                
                <div class="content col-xs-9">
                  <li class="form-group row image-placeholder input-file">
                    <label class="control-label col-xs-3">Cover Image</label>
                      <div class="col-xs-9">
                        <div class="row">
                        
						<?php
						for($i=0;$i<6;$i++){
						?>
                        
                        <div class="col-xs-4 image">
                          <div class="content image-prod-size" id="newer-<?php echo $i;?>" style="height:105px;">
                            <div id="remove-news-<?php echo $i;?>">
                              <div class="image-delete hidden" id="btn-slider-<?php echo $i;?>" onClick="clearImage('<?php echo $i;?>')">
                              <span class="glyphicon glyphicon-remove"></span>
                            </div>
                            
                            <div class="image-overlay" onclick="openBrowser('<?php echo $i;?>')"></div>
                          </div>
                          
                          <img class="" id="upload-news-<?php echo $i;?>">
                          <div id="img_replacer_<?php echo $i;?>">
                            <input type="file" name="upload_news_<?php echo $i;?>" id="news-<?php echo $i;?>" onchange="readURL(this,'<?php echo $i;?>')" class="hidden"/>
                          </div><!--img_replacer--> 
                          
                          <input type="checkbox" class="hidden" name="check_banner[]" value="<?php echo $i;?>" id="id_hidden_project_<?php echo $i;?>">   
                        </div>
                      </div>
                      
					  <?php
						}
					  ?>
                        
                          <p class="help-block" style="padding-top: 10px">Recommended dimensions of 228 x 152 px.</p>
                        </div>
                      </div>
                      
                  </li>
                </div>
              </div>
              
              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Featured Products</h3>
                  <p>Edit project featured products.</p>
                </div>
              
                <div class="content col-xs-9">
                  <ul class="form-set">
                  
				    <?php
				    foreach($products as $key=>$products){
				    ?>
                    
                    <li class="form-group row">
                      <input type="checkbox" name="product_featured[]" value="<?php echo $products['id'];?>" class="control-label">
                      &nbsp;
                      <label for="product-name" class="control-label"><?php echo $products['product_name'];?> <?php echo $a;?></label>
                    </li>
                    
					<?php
					}
					?>
                    
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
		 
	     $("#upload-news-"+i).attr('src', e.target.result).fadeOut("fast").removeClass("hidden").fadeIn("fast");
	     $('#id_hidden_project_'+i).attr('checked',true);
		 $('#btn-slider-'+i).removeClass("hidden");
		 $('#newer-'+i).attr('onmouseout','removeButton('+i+')');
		 $('#newer-'+i).attr('onmouseover','showDelete('+i+')');
	  }
		 
      reader.readAsDataURL(input.files[0]);
   }
	  
}

function showDelete(i){
   $('#btn-slider-'+i).removeClass('hidden');
}

function openBrowser(i){
   document.getElementById("news-"+i).click();
}


function removeButton(i){
   $('#btn-slider-'+i).addClass('hidden');
}

function clearImage(i){
   $('#img_replacer_'+i).html('<input type="file" name="upload_news_'+i+'" id="news-'+i+'" onchange="readURL(this,'+i+')" class="hidden"/>');
   $('#upload-news-'+i).attr('src', '');
   $('#btn-slider-'+i).addClass('hidden');
   $('#id_hidden_project_'+i).attr('checked',false);
   $('#newer-'+i).removeAttr('onmouseout','removeButton('+i+')');
   $('#newer-'+i).removeAttr('onmouseover','showDelete('+i+')');
}


function validate(i){
   
   var name     = $('#id_inspiration_name').val();
   
   if(name == ""){
      $('#lbl_inspiration_name').addClass("has-error");
   }else{
      $('#lbl_inspiration_name').removeClass("has-error");
	  
	  if(i == "save"){
	     $('#id_btn_save').click();
	  }else if(i == "exit"){
		 $('#id_btn_exit').click();
	  }
	  
   }
   
}
</script>