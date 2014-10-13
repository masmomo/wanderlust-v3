<?php
include("get.php");
include("update.php");
include("control.php");
?>
<style>
#sortable li { float: left;}
</style>

          <form name="index-order" method="post" enctype="multipart/form-data">
          
            <div class="subnav">
              <div class="container clearfix">
                <h1>
                  <span class="glyphicon glyphicon-list"></span> &nbsp; 
                  <a href="<?php echo $prefix_url."project"?>">Project</a> 
                  <span class="info">/</span> Edit Project
                </h1>
                
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url."project"?>">
                    <input type="button" class="btn btn-default btn-sm" value="Cancel">
                  </a>
                  <input type="button" class="btn btn-success btn-sm" value="Save Changes" onclick="validate('save')">
                  <input type="button" class="btn btn-success btn-sm hidden" value="Save Changes &amp; Exit" onclick="validate('exit')">
                  <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes" name="btn_edit_inspiration" id="id_btn_save">
                  <input type="submit" class="btn btn-success btn-sm hidden" value="Save Changes &amp; Exit" name="btn_edit_inspiration" id="id_btn_exit">
                </div>
              </div>
            </div>
            
			<?php
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '<div class="container">'.$_SESSION['msg'].'</div>';
			   echo '</div>';
			}
			
			if($_POST['btn_edit_inspiration'] == ""){
			   unset($_SESSION['alert']);
			   unset($_SESSION['msg']);
			}
			?>
            
            <div class="container main">
            
              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Project</h3>
                  <p>Manage Project name.</p>
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
                      <label for="brand" class="control-label col-xs-3">Inspiration Name <span>*</span></label>
                      <div class="content col-xs-9">
                        <input type="text" class="form-control"name="inspiration_name" id="id_inspiration_name" value="<?php echo $inspiration['name'];?>">
                      </div>
                    </li>
                  </ul>
                </div>
              </div><!--box-->
              
              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Banner</h3>
                  <p>Add inspiration page banners.</p>
                </div>
                
                <div class="content col-xs-9">
                  <ul class="form-set">
                    <li class="form-group row image-placeholder">
                      <label class="control-label col-xs-3">Banners</label>
                      <div class="col-xs-9">
                        
                        <div class="row">
                          <ul id="sortable">
                          
                            <!-- LOOP-->
							<?php
							//$row = 1;
						    foreach($banner as $banner){
						       $i = $banner['inspiration_image_id'];
						    ?>
                            
                            <li class="col-xs-4 image">
                              <div class="" id="fl_banner_<?php echo $i;?>" onmouseover="showDelete(<?php echo $i;?>)" onmouseout="hideDelete(<?php echo $i;?>)">
                                <div class="content img-about-size">
                                  <div class="" id="wrapper_btn_<?php echo $i;?>">
                                    <div class="image-delete hidden" id="delete_btn_<?php echo $i;?>" onclick="removeButton(<?php echo $i;?>)">
                                      <span class="glyphicon glyphicon-remove"></span>
                                    </div>
                                    
                                    <div class="image-overlay" onclick="openBrowser(<?php echo $i?>)"></div>
                                  </div>
                                  
                                  <span id="wrap_remove_<?php echo $i;?>">
                                    <img class="" src="<?php echo $prefix_url."static/thimthumb.php?src=../".$banner['image']."&h=80&w=172&q=100";?>" id="img_banner_<?php echo $i?>">
                                    <input type="file" name="upload_image_<?php echo $i?>" id="file_<?php echo $i?>" onchange="readURL(this,'<?php echo $i?>')" class="hidden"/>
                                    <input type="checkbox" name="check_banner[]" id="id_check_<?php echo $i?>" value="<?php echo $i;?>" class="hidden"/>
                                    <input type="hidden" name="order_banner[]" value="<?php echo $i;?>"/>
                                  </span>
                                </div>
                              </div>
                            </li>
                          
						    <?php
							   $row++;
						    }
						    ?>
                            
                          </ul><!--sortable-->
                          
						  <?php
						  $total_banner = (6 - $count_images['rows']);
						  for($i=($latest_id_img['latest_id'] + 1);$i<=($total_banner + $latest_id_img['latest_id']);$i++){
						  ?>
                          
                          <div class="col-xs-4 image" id="fl_banner_<?php echo $i;?>" onmouseover="showDelete(<?php echo $i;?>)" onmouseout="hideDelete(<?php echo $i;?>)">
                            <div class="content img-about-size">
                              <div class="" id="wrapper_btn_<?php echo $i;?>">
                                <div class="image-overlay" onclick="openBrowser(<?php echo $i?>)"></div>
                              </div>
                            
                              <span id="wrap_remove_<?php echo $i;?>">
                                <img class="hidden" id="img_banner_<?php echo $i?>">
                                <input type="file" name="upload_image_<?php echo $i?>" id="file_<?php echo $i?>" onchange="readURL(this,'<?php echo $i?>')" class="hidden"/>
                                <input type="checkbox" name="check_banner[]" id="id_check_<?php echo $i?>" value="<?php echo $i;?>" class="hidden"/>
                              </span>
                            </div>
                          </div>
                          
						  <?php
						  }
						  ?>
                          
                        </div> <!--row-->
                      <p class="field-message" style="padding-top: 10px">Recommended dimensions of 980 x 500 px.</p>
                    </div> <!--content col-xs-9-->
                  </li>
                </ul>
              </div><!--content col-xs-9-->
            </div><!--box-->
            
            <div class="box row">
              <div class="desc col-xs-3">
                <h3>Featured Products</h3>
                <p>Edit project featured products.</p>
              </div>
              
              <div class="content col-xs-9">
                <ul class="form-set">
                
				  <?php
				  foreach($products as $key=>$products){
				     $existed = get_product($inspiration_id, $products['id']);
				  ?>
                  
                  <li class="form-group row">
                    <input type="checkbox" name="product_featured[]" value="<?php echo $products['id'];?>" <?php if($existed['param_inspiration_id'] != ''){ echo 'checked="checked"';}?>class="control-label">
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
            
            <input type="hidden" name="inspiration_id" value="<?php echo $_REQUEST['ins_id'];?>" />
            
</form>
            
<script>
$(function() {
   $("#sortable").sortable();
   $("#sortable").disableSelection();
});


function ajaxDeleteBanner(i){
   var bid = i;
   
   var ajx   = $.ajax({
	           type: "POST",
			   url: "../custom/inspiration/detail/ajax/delete.php",
			   data: {bid:bid},
			   error: function(jqXHR, textStatus, errorThrown) {
					   
					  }
						 
			   }).done(function(data) {	
			      
			   });
}


function readURL(input,i) {
   
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
		 
	     $("#img_banner_"+i).attr('src', e.target.result).fadeOut("fast").removeClass("hidden").fadeIn("fast");
	     $('#id_check_'+i).attr('checked',true);
		 $('#wrapper_btn_'+i).removeClass("hidden");
		 $('#wrapper_btn_'+i).html('<div class="image-delete hidden" id="delete_btn_'+i+'" onclick="removeButton('+i+')"></div>'+$('#wrapper_btn_'+i).html());
	  }
		 
      reader.readAsDataURL(input.files[0]);
   }
	  
}

function showDelete(i){
   $('#delete_btn_'+i).removeClass("hidden");
   $('#delete_btn_'+i).fadeIn("fast");
}

function hideDelete(i){
   $('#delete_btn_'+i).fadeOut("fast");
   $('#delete_btn_'+i).addClass("hidden");
}


function openBrowser(i){
   document.getElementById("file_"+i).click();
}


function removeButton(i){
   $('#wrap_remove_'+i).html('<img class="hidden" src="" id="img_banner_'+i+'"><input type="file" name="upload_slider_'+i+'" id="file_'+i+'" onchange="readURL(this,'+i+')" class="hidden"/><input type="checkbox" name="check_banner[]" id="id_check_'+i+'" class="hidden"/>');
   
   $('#wrapper_btn_'+i).html('<div class="image-overlay" onclick="openBrowser('+i+')"></div>');
   ajaxDeleteBanner(i);
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


function selectedCategory(x){
   $('#id_inspiration_category option[value="'+x+'"]').attr('selected', true);
}

$(document).ready(function(e) {
   selectedCategory(<?php echo $inspiration['category'];?>);
});
</script>