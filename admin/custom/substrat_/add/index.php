<?php
include('get.php');
include('update.php');
include('control.php');
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-list"></span> &nbsp; 
          <a href="<?php echo $prefix_url."filter-substrat"?>"> Filter (Substrat)</a> 
          <span class="info">/</span> Add Filter
        </h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."filter-substrat";?>">
            <input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel">
          </a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_add_filter_sub" id="btn_save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_add_filter_sub'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Filter Details</h3>
          <p>Your filter details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set" id="custom_product_category">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline">
                  <input type="radio" value="Active" name="active_status" id="category_active_status_active" checked>Active
                </label>
                <label class="radio-inline">
                  <input type="radio" value="Inactive" name="active_status" id="category_active_status_inactive">Inactive
                </label>
              </div>
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible" checked>Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible">No
                </label>
              </div>
            </li>
            
            <li class="form-group row" id="lbl_category_name">
              <label class="control-label col-xs-3">Filter Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" id="id_category_name">
              </div>
            </li>
            
            <li class="form-group row hidden" id="lbl_career_description">
              <label class="control-label col-xs-3">Description</label>
              <div class="col-xs-9">
                <textarea class="form-control" name="career_description" id="id_career_description" rows="5"></textarea>
              </div>
            </li>
            
            <li class="form-group row image-placeholder input-file" style="position:relative; z-index:1;">
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
                  <p class="help-block" style="padding-top: 10px">Recommended dimensions of 273 x 130 px.</p>
                </div>
              </li>
            
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>

<style>
.has-error {
border-color: #b94a48;
}
</style>

<script>

function validation(){
  
  //var dept = $('#category_department option:selected').val();
  var job  = $('#id_category_name').val();
  //var desc = $('#id_career_description').val();
  
  //$('#lbl_category_department').removeClass('has-error');
  $('#lbl_category_name').removeClass('has-error');
  //$('#lbl_career_description').removeClass('has-error');
  
  //if(dept == 'empty'){
     //$('#lbl_category_department').addClass('has-error');
  /*}else*/ if(job == ''){
     $('#lbl_category_name').addClass('has-error');
  //}else if(desc == ''){
     //$('#lbl_career_description').addClass('has-error');
  }else{
     $('#btn_save').click();
  }
  
}



function readURL(input,i) {
                                  
   if (input.files && input.files[0]) {
      var reader = new FileReader();
	  reader.onload = function (e) {
	     $("#upload-news-"+i).removeClass("hidden");
		 $("#upload-news-"+i).attr('src', e.target.result);
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
   $('#img_replacer').html('<input type="file" name="upload_news_'+i+'" id="news-'+i+'" onchange="readURL(this,'+i+')" class="hidden"/>');
}


$(document).ready(function(e) {
   
   $('#btn_alias').click(function (){
      validation()
   });
   
});
</script>