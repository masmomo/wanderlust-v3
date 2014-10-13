<?php
include('../../../static/general.php');
include('../../../../static/general.php');
include('control.php');


/*
# ----------------------------------------------------------------------
# PAGES BANNER
# ----------------------------------------------------------------------
*/

echo '<li class="form-group row image-placeholder">';
echo '<p>PAGES BANNER</p>';
echo '</li>';

foreach($page_banner as $slider){
   
   if($slider['banner_name'] == 'page-banner-1'){
      $page_label = 'Men';
   }else if($slider['banner_name'] == 'page-banner-2'){
      $page_label = 'Woman';
   }else if($slider['banner_name'] == 'page-banner-3'){
      $page_label = 'Kids';
   }else if($slider['banner_name'] == 'page-banner-4'){
      $page_label = 'Accessories';
   }else if($slider['banner_name'] == 'page-banner-5'){
      $page_label = 'Sale';
   }
   
?>
<li class="form-group row image-placeholder underlined">
  <label class="control-label col-xs-3"><?php echo ucfirst(str_replace('-',' ',$page_label));?></label>
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
        <li class="col-xs-4 image">
          <div class="" onMouseOver="removeButton('<?php echo $slider['banner_name'];?>')" id="slide-<?php echo $slider['banner_name'];?>">
            <div class="content img-about-size-2">
              <div class="hidden" id="remove-slider-<?php echo $slider['banner_name'];?>">
                <div class="image-delete" id="btn-slider-<?php echo $slider['banner_name'];?>" onClick="clearImage('<?php echo $slider['banner_name'];?>')">
                  <span class="glyphicon glyphicon-remove"></span>
                </div>
                <div class="image-link <?php if(!empty($slider['link'])){ echo "linked";}?>" data-toggle="modal" href="#link-pops" onclick="showLink('<?php echo $slider['banner_name'];?>')" id="btn-link-<?php echo $slider['banner_name'];?>"></div>
                <div class="image-overlay" onClick="openBrowser('<?php echo $slider['banner_name'];?>')"></div>
                <input type="hidden" name="link_slide_<?php echo $slider['banner_name'];?>" id="link-slide-<?php echo $slider['banner_name'];?>">
              </div>
              <img class="" id="upload-slider-<?php echo $slider['banner_name'];?>" src="<?php echo $prefix_url."../../../../static/thimthumb.php?src=../".$slider['filename']."&h=198&w=198&q=100";?>">
              
              <span id="tester">
                <input type="file" name="upload_slider_<?php echo $slider['banner_name'];?>" id="slider-<?php echo $slider['banner_name'];?>" onchange="readURL(this,'<?php echo $slider['banner_name'];?>')" class="hidden"/>
              </span><!--tester-->
              
            <input type="hidden" name="flag_<?php echo $slider['banner_name'];?>" id="slideshow-flag-<?php echo $slider['banner_name'];?>" value="<?php echo $slider['filename'];?>">
            <input type="hidden" name="link_<?php echo $slider['banner_name'];?>" id="link-<?php echo $slider['banner_name'];?>" value="<?php echo $slider['link'];?>">
          </div>
        </div>
      </li>
    </ul>
  </div><!--row-->
  
  <p class="help-block">
  	<?php 
	if($slider['banner_name']=='banner-1'||$slider['banner_name']=='banner-5'){
	   echo 'Recommended dimensions of 280 x 125 px.';
	}else if($slider['banner_name']=='banner-2'||$slider['banner_name']=='banner-6'){
	   echo 'Recommended dimensions of 280 x 125 px.';
	}else{
	   echo 'Recommended dimensions of 280 x 125 px.';
	}
	?>
  </p>
</div><!--col-xs-9-->

</li><!--form-group-->

<?php
}
?>