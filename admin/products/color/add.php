<?php
include('add/get.php');
include('add/update.php');
include('add/control.php');
?>
<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-tint"></span> &nbsp; <a href="<?php echo $prefix_url."color";?>">Color Groups</a> <span class="info">/</span> Add Color</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."color"?>"><input type="button" class="btn btn-default btn-sm" value="Cancel"></a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_add_color" id="btn-save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){?>
    <div class="alert <?php echo $_SESSION['alert'];?>">
      <div class="container"><?php echo $_SESSION['msg'];?></div>
    </div>
    <?php 
	}
	
	if($_POST['btn_add_color'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Color Details</h3>
          <p>Your color details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="active" id="color-active-status" name="active_status" checked="checked">
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="inactive" id="color-inactive-status" name="active_status">
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="yes" id="color-visible-status" name="visibility_status" checked="checked">
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="no" id="color-invisible-status" name="visibility_status">
                  No
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Color Thumbnail</label>
              <div class="col-xs-9">
                <div class="color-thumb edit" id="picture" onclick="openBrowser()">
                   <img class="hidden" id="upload-image" width="25px">
                </div>
                <p class="help-block">Recommended dimensions of 24 x 24 px.</p>
                <span id="tester">
                <input type="file" name="color_image" id="color_files" onchange="readURL(this)" class="hidden"/>
                </span><!--tester-->
              </div>
            </li>
            <li class="form-group row" id="lbl_color_name">
              <label class="control-label col-xs-3">Color Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="id_color_name" name="color_name">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>

<script>
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

function validation(){
   var name = $('#id_color_name').val();
   
   $('#lbl_color_name').removeClass('has-error');
   
   if(name == ''){
      $('#lbl_color_name').addClass('has-error');
   }else{
	  $('#btn-save').click();
   }
   
}


$(document).ready(function(e) {
   $('#btn_alias').click(function(){
      validation();
   });
});
</script>