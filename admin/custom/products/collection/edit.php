<?php
include('detail/get.php');
include('detail/update.php');
include('detail/control.php');
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-pushpin"></span> &nbsp; <a href="<?php echo $prefix_url."collection"?>">Collections</a> <span class="info">/</span> Edit Collection</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."collection"?>"><input type="button" class="btn btn-default btn-sm" value="Cancel"></a>
          <input type="submit" class="btn btn-danger btn-sm"  name="btn_detail_collection" value="Delete">
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_detail_collection" id="btn-save">
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
		
		if($_POST['btn_detail_collection'] == ''){
		   unset($_SESSION['alert']);
		   unset($_SESSION['msg']);
		}
		?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Collection Details</h3>
          <p>Your collection details.</p>
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
                  <input type="radio" value="Yes" id="collection-visible" name="visibility">
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
                <input type="text" class="form-control" id="id_collection_name" name="collection_name" value="<?php echo $detail_collection['collection_name'];?>">
                <p class="help-block">Separate by comma.</p>
              </div>
            </li>
            
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->
    
    <?php
    // INPUT HIDDEN
	echo '<input type="hidden" name="hidden_collection_id" value="'.$detail_collection['collection_id'].'">';
	echo '<input type="hidden" name="hidden_collection_name" value="'.$detail_collection['collection_name'].'">';
	?>
    
</form>


<script>
function checkbox(x){
   
   if(x == 'Yes'){
      $('#collection-visible').attr('checked', true);
   }else if(x == 'No'){
      $('#collection-invisible').attr('checked', true);
   }
   
}


function validation(){
   var name = $('#id_collection_name').val();
   
   
   $('#lbl_collection_name').removeClass('has-error');
   
   if(name == ''){
      $('#lbl_collection_name').addClass('has-error');
   }else{
      $('#btn-save').click();
   }
}


$(document).ready(function(e) {
   checkbox('<?php echo $detail_collection['collection_visibility_status'];?>');
   
   $('#btn_alias').click(function (){
      validation();
   });
});
</script>