<?php
include("get.php");
include("update.php");
include("control.php");
include("ajax.php");

//var_dump($_POST);
//echo "ROWS : ".$count_gallery['rows'];
?>

<form method="post" enctype="multipart/form-data">

            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Gallery</h2>
                    <div class="btn-placeholder">
                        <input type="submit" class="btn green main" value="Save Changes" name="btn-index-gallery">
                    </div>
                </div>
            </div>

            <div id="main-content">

                <div class="box clearfix">
                    <div class="desc">
                        <h3>Gallery</h3>
                        <p>Edit gallery images.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field input-file clearfix">
                                <label>Images</label>
                                
                                <div class="clearfix repeat" style="width: 550px; padding-bottom: 8px">
                                
                                <?php
                                $limit_gallery = 11;
								$counter = 2;
								
								for($i=1;$i<$limit_gallery;$i++){
								?>
                                    
                                    <div class="fl image" style="width: 174px; height: 116px;" onMouseOver="removeButton('<?php echo $i;?>')" id="galleries-<?php echo $i;?>">
                                        <div class="" id="remove-gallery-<?php echo $i;?>">
                                           <div class="image-delete hidden" id="btn-gallery-<?php echo $i;?>" onClick="clearImage('<?php echo $i;?>')"></div>
                                           <div class="image-overlay" onClick="openBrowser('<?php echo $i;?>')" id="image-overlay-<?php echo $id;?>"></div>
                                        </div>
                                        <img class="" id="upload-gallery-<?php echo $i;?>" width="174px" src="<?php $get_gallery = get_gallery($i); echo $get_gallery['filename'];?>">
                                        <input type="file" name="upload_gallery_<?php echo $i;?>" id="gallery-<?php echo $i;?>" onchange="readURL(this,'<?php echo $i;?>')" class="hidden"/>
                                        <input type="hidden" name="gallery_id[]" value="<?php echo $i;?>">
                                        <input type="hidden" name="gallery_flag_<?php echo $i;?>" id="gallery-flag-<?php echo $i;?>" value="<?php $get_gallery = get_gallery($i); echo $get_gallery['filename'];?>">
                                    </div>
                                
								<?php   
								}
								?>
                                
                                <script>
								
								   <?php 
								   /*
								   $all_gallery = get_galleries();
								   $all_gallery_id = $all_gallery['id'];
								   foreach($all_gallery as $all_gallery){
								      if($all_gallery['filename']){
									     
									  }
								   }
								   */ 
								   
								   for($i=2;$i<$limit_gallery;$i++){
								      $get_gallery = get_gallery($i);
									  
									  if(empty($get_gallery['filename'])){
								   ?>
								         $("#upload-gallery-<?php echo ($i+1);?>").hide();
								         $("#galleries-<?php echo ($i+1);?>").hide();
   								   <?php
								      } 
								   }//foreach
								   ?>
								   
								function readURL(input,i) {
								   
								   if (input.files && input.files[0]) {
								      var reader = new FileReader();
									  reader.onload = function (e) {
									     $("#upload-gallery-"+i).fadeIn("slow");
										 $("#upload-gallery-"+i).attr('src', e.target.result);
										 $("#gallery-flag-"+i).val('notempty');
										 $("#gallery-flag-"+(i*1+1)).removeAttr($("#galleries-"+(i*1+1)).attr('style', 'width: 174px; height: 74px;'));
									  }
									  
									  reader.readAsDataURL(input.files[0]);
								   }
								}
								
								function openBrowser(i){
								   document.getElementById("gallery-"+i).click();
								}
								
								function removeButton(i){
								   var n = $("#upload-gallery-"+i).attr('src');
								   $("#btn-gallery-"+i).hide();
								   
								   if(n != ""){
									  $("#btn-gallery-"+i).removeClass("hidden");
								   
								   }
								      $("#remove-gallery-"+i).removeClass("hidden");
								      $("#remove-gallery-"+i).fadeIn("fast");
								      $("#btn-gallery-"+i).attr('style','z-index:1000; position:absolute');
								   
								      $("#galleries-"+i).mouseleave(function(){
									     $("#btn-gallery-"+i).fadeOut("fast");
								      });
								   
								   $("#image-overlay-"+i).fadeIn("fast");
								   
								}
								
								function clearImage(i){
							       $("#upload-gallery-"+i).attr('src', '');
								   $("#upload-gallery-"+i).fadeOut("slow");
								   $("#gallery-flag-"+i).val('');
								   $("#gallery-flag-"+(i*1+1)).removeAttr($("#galleries-"+(i*1+1)).fadeOut("fast"));
								}
								
								
								</script>
                                
                                </div>
                                <p class="field-message" style="padding-top: 10px">Recommended dimensions of 640 x 426 px.</p>
                            </li>
                            
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->
            
</form>

            