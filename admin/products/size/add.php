<?php
include('add/get.php');
include('add/update.php');
include('add/control.php');
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-pushpin"></span> &nbsp; <a href="<?php echo $prefix_url."size"?>">Size Groups</a> <span class="info">/</span> Add Size Group</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."size"?>"><input type="button" class="btn btn-default btn-sm" value="Cancel"></a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_add_size" id="btn-save">
        </div>
      </div>
    </div>

        <?php
        if(!empty($_SESSION['alert'])){
		?>
        <div class="alert <?php echo $_SESSION['alert'];?>">
          <div class="container"><?php echo $_SESSION['msg'];?></div>
        </div>
        <?php }?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Size Group Details</h3>
          <p>Your size group details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" id="size-active" name="size_active" checked="checked">
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" id="size-inactive" name="size_active">
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Yes" id="size-visible" name="visibility" checked="checked">
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="No" id="size-invisible" name="visibility">
                  No
                </label>
              </div>
            </li>
            <li class="form-group row" id="lbl_size_type_name">
              <label class="control-label col-xs-3">Size Group Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="id-size-type-name" name="size_type_name">
                <p class="help-block hidden">Separate by comma.</p>
              </div>
            </li>
            <li class="form-group row" id="lbl_size_group_name">
              <label class="control-label col-xs-3">Size Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="" placeholder="XS, S, M, etc." id="id-size-group-name" name="size_group_name">
                <p class="help-block">Separate by comma.</p>
              </div>
            </li>
            <li class="form-group row" id="lbl_size_sku">
              <label class="control-label col-xs-3">SKU Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="" placeholder="01, 02, 03, etc." id="id-size-sku" name="size_sku">
                <p class="help-block">Size SKU adds another code behind your original product SKU. For example, if you put 01 as the size SKU for XS, product with SKU ANT01BLK will be saved as ANT01BLK01.</p>
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>

<script>
function validation(){
   var name  = $('#id-size-type-name').val();
   var items = $('#id-size-group-name').val();
   var sku   = $('#id-size-sku').val();
   
   $('#lbl_size_type_name').removeClass('has-error');
   $('#lbl_size_group_name').removeClass('has-error');
   $('#lbl_size_sku').removeClass('has-error');
   
   if(name == ''){
      $('#lbl_size_type_name').addClass('has-error');
   }else if(items == ''){
      $('#lbl_size_group_name').addClass('has-error');
   }else if(sku == ''){
      $('#lbl_size_sku').addClass('has-error');
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