<?php
include('add/get.php');
include('add/update.php');
include('add/control.php');
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-pushpin"></span> &nbsp; <a href="<?php echo $prefix_url."collection"?>">Collections</a> <span class="info">/</span> Add Collection</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."collection"?>"><input type="button" class="btn btn-default btn-sm" value="Cancel"></a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_add_collection" id="btn-save">
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
          <h3>Collection Details</h3>
          <p>Your collection group details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" id="collection-active" name="collection_active_status" checked="checked">
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" id="collection-inactive" name="collection_active_status">
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Yes" id="collection-visible" name="visibility" checked="checked">
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="No" id="collection-invisible" name="visibility">
                  No
                </label>
              </div>
            </li>
            <li class="form-group row" id="lbl_collection_name">
              <label class="control-label col-xs-3">Collection Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="id-collection-name" name="collection_name">
                <p class="help-block hidden">Separate by comma.</p>
              </div>
            </li>

			<!--
            <li class="form-group row" id="lbl_collection_group_name">
              <label class="control-label col-xs-3">Collection Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="" placeholder="XS, S, M, etc." id="id-collection-group-name" name="collection_group_name">
                <p class="help-block">Separate by comma.</p>
              </div>
            </li>
            <li class="form-group row" id="lbl_collection_sku">
              <label class="control-label col-xs-3">SKU</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="" placeholder="01, 02, 03, etc." id="id-collection-sku" name="collection_sku">
                <p class="help-block">Collection SKU adds another code behind your original product SKU. For example, if you put 01 as the collection SKU for XS, product with SKU ANT01BLK will be saved as ANT01BLK01.</p>
              </div>
            </li>
			-->
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>

<script>
function validation(){
   var name  = $('#id-collection-name').val();
  
   
   $('#lbl_collection_name').removeClass('has-error');
   
   
   if(name == ''){
      $('#lbl_collection_name').addClass('has-error');
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