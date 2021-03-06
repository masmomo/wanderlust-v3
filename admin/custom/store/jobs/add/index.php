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
          <a href="<?php echo $prefix_url."store"?>">Partner</a> 
          <span class="info">/</span> Add Partner
        </h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."store";?>">
            <input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel">
          </a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_add_store_job" id="btn_save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_add_store_job'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Partner Details</h3>
          <p>Your partner details.</p>
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
            
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible">Yes
                </label>
                <label class="radio-inline">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible">No
                </label>
              </div>
            </li>
            
            <li class="form-group row hidden" id="lbl_category_department">
              <label class="control-label col-xs-3">City</label>
              <div class="col-xs-9">
                <select class="form-control" name="category_department" id="category_department">
                  <?php
                  foreach($department as $department){
				     echo '<option value="'.$department['category_id'].'">'.$department['category_name'].'</option>';
				  }
				  ?>
                </select>
              </div>
            </li>
            
            <li class="form-group row" id="lbl_category_name">
              <label class="control-label col-xs-3">Store Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Jakarta" id="id_category_name">
              </div>
            </li>
            
            <li class="form-group row" id="lbl_career_description">
              <label class="control-label col-xs-3">Address</label>
              <div class="col-xs-9">
                <!--<input type="text" class="form-control" name="category_name" placeholder="ex: Jakarta" id="category_name">-->
                <textarea class="form-control" name="career_description" id="id_career_description" rows="5"></textarea>
              </div>
            </li>
            
            <li class="form-group row" id="lbl_category_name">
              <label class="control-label col-xs-3">Website</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_maps" id="id_category_maps" placeholder="google.com">
              </div>
            </li>
            
            
            <li class="form-group row" id="lbl_category_name">
              <label class="control-label col-xs-3">Email</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="career_email" id="id_career_email">
              </div>
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-3">Image</label>
              <div class="col-xs-9 image">
                <div class="content img-about-size" id="picture" onclick="openBrowser()" style="background:#eee url(<?php echo $prefix_url;?>files/common/icon_camera@2x.png) no-repeat center;">
                   <img class="hidden" id="upload-image" width="100%" src="">
                </div>
                <p class="help-block">Recommended dimensions of 174 x 120 px.</p>
                <span id="tester">
                <input type="file" name="color_image" id="color_files" onchange="readURL(this)" class="hidden"/>
                </span><!--tester-->
              </div>
              <input type="hidden" name="hidden_logo" value="<?php echo $general['logo'];?>">
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
function initial(){
   $('#category_active_status_active').attr('checked', true);
   $('#category_visibility_status_visible').attr('checked', true);
   $('#id_category_name').focus();
}

function validation(){
  
  var dept = $('#category_department option:selected').val();
  var job  = $('#id_category_name').val();
  var desc = $('#id_career_description').val();
  
  $('#lbl_category_department').removeClass('has-error');
  $('#lbl_category_name').removeClass('has-error');
  $('#lbl_career_description').removeClass('has-error');
  
  if(dept == 'empty'){
     $('#lbl_category_department').addClass('has-error');
  }else if(job == ''){
     $('#lbl_category_name').addClass('has-error');
  }else if(desc == ''){
     $('#lbl_career_description').addClass('has-error');
  }else{
     $('#btn_save').click();
  }
  
}


$(document).ready(function(e) {
   initial();
   
   $('#btn_alias').click(function (){
      validation()
   });
});


function openBrowser(){
   document.getElementById("color_files").click();
}


function readURL(input) {
      
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
	     $('#upload-image').removeClass("hidden");
		 $('#upload-image').attr('src', e.target.result);
	  }
	  
	  reader.readAsDataURL(input.files[0]);
   }
	  
}
</script>