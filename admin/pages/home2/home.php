<?php
include("control.php");
include("custom/pages/home/control.php");
?>

<form method="post" enctype="multipart/form-data">

  <div class="modal fade" id="link-pops" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header clearfix">
          <div class="pull-right">
            <input type="hidden" name="link_id" id="link-id">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" id="btn_cancel">
            <input type="submit" class="btn btn-danger btn-sm" value="Delete" id="btn_pop_delete">
            <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn-link-banner" id="btn_pop_save">
          </div>
          <h4 class="modal-title pull-left" style="font-weight: 200">Image Link</h4>
        </div>
        <div class="modal-body">
          <div class="content">
            <ul class="form-set">
              <li class="form-group row" id="lbl_name_link">
                <label class="col-xs-3 control-label">Link</label>
                <div class="col-xs-9">
                  <input type="text" class="form-control" id="name-link" name="name_link">
                  <p class="help-block">Paste your link here.</p>
                </div>
              </li>
              
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  </form>
  
  <form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-home"></span> &nbsp; Home</h1>
        <div class="btn-placeholder">
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn-pages-home">
        </div>
      </div>
    </div>

    <?php
    /* -- ALERT -- */
    if(!empty($_SESSION['alert'])){
       echo "<div class=\"alert alert-".$_SESSION['alert']."\">";
       echo "<div class=\"container\">".$_SESSION['msg']."</div>";
       echo "</div>";
    }
	
	/* -- RESET ALERT -- */
	if($_POST['btn-pages-home'] == ""){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
    ?>

    <div class="container main">

      <div class="box row" id="pages_banner">
        <div class="desc col-xs-3">
          <h3>Banners</h3>
          <p>Edit home page banners.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="field-set">
            <li class="form-group row image-placeholder underlined">
              <label class="control-label col-xs-3">Main Banners</label>
              <div class="col-xs-9">
                <div class="row" id="row_slide">
                      
                  <style>
				  #sortable { list-style-type: none;}
				  #sortable li { float: left; /*width: 198px; height: 105px;*/}
				  </style>
                  
				  <script>
				  $(function() {
				     $("#sortable").sortable();
					 $("#sortable").disableSelection();
				  });
				  </script>
                  
                  <ul id="sortable">
                  <?php
				  $row = 1;
				  foreach($slideshow_get as $slider){
				  ?>
                  
                  <!-- NEED STYLING "col-xs-4 image" ga actual drag-nya kalo ga "#sortable li { float: left; width: 198px; height: 105px;}" -->                    
                  
                  <li class="col-xs-4 image">
                    <div class="" onMouseOver="removeButton('<?php echo $slider['id'];?>')" id="slide-<?php echo $slider['id'];?>">
                      <div class="content img-about-size">
                        <div class="hidden" id="remove-slider-<?php echo $slider['id'];?>">
                           <div class="image-delete" id="btn-slider-<?php echo $slider['id'];?>" onClick="clearImage('<?php echo $slider['id'];?>')"><span class="glyphicon glyphicon-remove"></span></div>
                           <div class="image-link <?php if(!empty($slider['link'])){ echo "linked";}?>" data-toggle="modal" href="#link-pops" onclick="showLink('<?php echo $slider['id'];?>')" id="btn-link-<?php echo $slider['id'];?>"></div>
                           <div class="image-overlay" onClick="openBrowser('<?php echo $slider['id'];?>')"></div>
                           <input type="hidden" name="link_slide_<?php echo $slider['id'];?>" id="link-slide-<?php echo $slider['id'];?>">
                        </div>
                        <img class="" id="upload-slider-<?php echo $slider['id'];?>" src="<?php echo $prefix_url."static/thimthumb.php?src=../".$slider['filename']."&h=105&w=198&q=100";?>">
                        
                        <span id="tester">
                          <input type="file" name="upload_slider_<?php echo $slider['id'];?>" id="slider-<?php echo $slider['id'];?>" onchange="readURL(this,'<?php echo $slider['id'];?>')" class="hidden"/>
                        </span><!--tester-->
                        
                        <input type="checkbox" name="slideshow_id[]" class="hidden"  value="<?php echo $slider['id'];?>" id="id_slideshow_<?php echo $slider['id'];?>">
                        <input type="hidden" name="flag_<?php echo $slider['id'];?>" id="slideshow-flag-<?php echo $slider['id'];?>" value="<?php echo $slider['filename'];?>">
                        <input type="hidden" name="link_<?php echo $slider['id'];?>" id="link-<?php echo $slider['id'];?>" value="<?php echo $slider['link'];?>">
                        <input type="text" name="order_image[]" class="hidden" value="<?php echo $slider['id'];?>" /> 
                      </div>
                    </div>
                  </li>
                  
                  <?php
				  }
				  echo '</ul>' /* -- sortable -- */;
				  ?>
                  
                  
                  
                  <?php
				  // EMPTY SPACE
				  $max_slideshow = 6;
				  $total_left    = $max_slideshow - $count_slideshow['rows'];
				  $asd           = $new_id['new_id'];
				  
				  for($i=1;$i<=$total_left;$i++){
				     $new_id = $i + $asd;
				  ?>
                  
                  <div class="col-xs-4 image" onMouseOver="removeButton('<?php echo $new_id;?>')" id="slide-<?php echo $new_id;?>">
                    <div class="content img-about-size">
                      <div class="hidden" id="remove-slider-<?php echo $new_id;?>">
                        <div class="image-delete hidden" id="btn-slider-<?php echo $new_id;?>" onClick="clearImage('<?php echo $new_id;?>')">
                          <span class="glyphicon glyphicon-remove"></span>
                        </div>
                        <div class="image-link hidden" data-toggle="modal" href="#link-pops" onclick="showLink('<?php echo $new_id;?>')" id="btn-link-<?php echo $new_id;?>"></div>
                        <div class="image-overlay" onClick="openBrowser('<?php echo $new_id;?>')"></div>
                        <input type="hidden" name="link_slide_<?php echo $slider['id'];?>" id="link-slide-<?php echo $new_id;?>">
                      </div>
                      
                      <img class="hidden" id="upload-slider-<?php echo $new_id;?>">
                      
                      <span id="tester-<?php echo $new_id;?>">
                        <input type="file" name="upload_slider_<?php echo $new_id;?>" id="slider-<?php echo $new_id;?>" onchange="readURL(this,'<?php echo $new_id;?>')" class="hidden"/>
                      </span><!--tester-->
                      
                      <input type="checkbox" name="slideshow_id[]" class="hidden"  value="<?php echo $new_id;?>" id="id_slideshow_<?php echo $new_id;?>">
                      <input type="hidden" name="flag_<?php echo $new_id;?>" id="slideshow-flag-<?php echo $new_id;?>">
                      <input type="hidden" name="link_<?php echo $new_id;?>" id="link-<?php echo $new_id;?>">
                    </div>
                  </div>
                  
				  <?  
				  }
				  ?>
                  
                </div><!--row-->
              <p class="help-block">Recommended dimensions of 960 x 500 px.</p>
            </div><!--col-xs-9-->
            
          </li><!--form-group-->
        
        </ul><!--field-set-->
        
      </div><!--content-->
      
    </div><!--box-->
    
  </div><!--container main-->
            
</form>

<?php
include("script/slideshow-js.php");
include("custom/pages/home/index.php");
?>             