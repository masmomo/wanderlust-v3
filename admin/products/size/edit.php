<?php
include('detail/get.php');
include('detail/update.php');
include('detail/control.php');
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-pushpin"></span> &nbsp; <a href="<?php echo $prefix_url."size"?>">Size Groups</a> <span class="info">/</span> Edit Size Group</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."size"?>"><input type="button" class="btn btn-default btn-sm" value="Cancel"></a>
          <input type="submit" class="btn btn-danger btn-sm"  name="btn_detail_size" value="Delete">
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_detail_size" id="btn-save">
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
		
		if($_POST['btn_detail_size'] == ''){
		   unset($_SESSION['alert']);
		   unset($_SESSION['msg']);
		}
		?>

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
                  <input type="radio" value="Yes" id="size-visible" name="visibility">
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
                <input type="text" class="form-control" id="id_size_type_name" name="size_type_name" value="<?php echo $detail_size['size_type_name'];?>">
                <p class="help-block">Separate by comma.</p>
              </div>
            </li>
            <li class="form-group row" id="lbl_size_group_name">
              <label class="control-label col-xs-3">Size Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" 
                value="<?php 
				       $total_size = count($size);
				       foreach($size as $key=>$size){
						  
						  if($key == ($total_size - 1)){
						     echo $size['size_name'];
						  }else{
						     echo $size['size_name'].',';
						  }
						  
					   }
					   ?>" 
                placeholder="XS, S, M, etc." id="id_size_group_name" name="size_group_name">
                <p class="help-block">Separate by comma.</p>
              </div>
            </li>
            <li class="form-group row" id="lbl_size_sku">
              <label class="control-label col-xs-3">Size Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" value="<?php 
				       $total_sku = count($sku);
				       foreach($sku as $key=>$size){
						  
						  if($key == ($total_size - 1)){
						     echo $size['size_sku'];
						  }else{
						     echo $size['size_sku'].',';
						  }
						  
					   }
					   ?>" 
                placeholder="01, 02, 03, etc." id="id_size_sku" name="size_sku">
                <p class="help-block">Size SKU adds another code behind your original product SKU. For example, if you put 01 as the size SKU for XS, product with SKU ANT01BLK will be saved as ANT01BLK01.</p>
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->
    
    <?php
    // INPUT HIDDEN
	echo '<input type="hidden" name="hidden_size_id" value="'.$detail_size['size_type_id'].'">';
	echo '<input type="hidden" name="hidden_size_name" value="'.$detail_size['size_type_name'].'">';
	?>
    
</form>


<script>
function checkbox(x){
   
   if(x == 'Yes'){
      $('#size-visible').attr('checked', true);
   }else if(x == 'No'){
      $('#size-invisible').attr('checked', true);
   }
   
}


function validation(){
   var name = $('#id_size_type_name').val();
   var size = $('#id_size_group_name').val();
   var sku  = $('#id_size_sku').val();
   
   $('#lbl_size_type_name').removeClass('has-error');
   $('#lbl_size_group_name').removeClass('has-error');
   $('#lbl_size_sku').removeClass('has-error');
   
   if(name == ''){
      $('#lbl_size_type_name').addClass('has-error');
   }else if(size == ''){
      $('#lbl_size_group_name').addClass('has-error');
   }else if(sku == ''){
      $('#lbl_size_sku').addClass('has-error');
   }else{
      $('#btn-save').click();
   }
}


$(document).ready(function(e) {
   checkbox('<?php echo $detail_size['size_type_visibility'];?>');
   
   $('#btn_alias').click(function (){
      validation();
   });
});
</script>