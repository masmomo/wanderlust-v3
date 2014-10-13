<?php
include('get.php');
include('update.php');
include('control.php');
?>

<form method="post">

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-list"></span> &nbsp; 
          <a href="<?php echo $prefix_url."filter"?>">Filter</a> 
          <span class="info">/</span> 
		  <?php echo $category['filter_name'];?>
        </h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."filter";?>">
            <input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel">
          </a>
          <input type="submit" class="btn btn-danger btn-sm" value="Delete" name="btn_detail_filter">
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn_alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_detail_filter" id="btn_save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_detail_filter'] == ''){
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
                <label class="radio-inline">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible">Yes
                </label>
                <label class="radio-inline">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible">No
                </label>
              </div>
            </li>
            
            <li class="form-group row" id="lbl_category_name">
              <label class="control-label col-xs-3">Filter Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Jakarta" id="category_name" value="<?php echo $category['filter_name'];?>">
              </div>
            </li>
            
            <li class="form-group row image-placeholder input-file" style="position:relative; z-index:1;">
              <label class="control-label col-xs-3">Cover Image</label>
                <div class="col-xs-9">
                  <div class="row">
                    <div class="col-xs-4 image">
                      <div class="content image-prod-size" onmouseover="removeButton('1')" id="newer-1" style="height:105px;">
                      
                        <div id="remove-news-1">
                          <div class="image-delete hidden" id="btn-slider-1" onClick="clearImage('1')">
                            <span class="glyphicon glyphicon-remove"></span>
                          </div>
                          
                          <div class="image-overlay" onClick="openBrowser('1')"></div>
                        </div>
                        
                        <img class="" id="upload-news-1" src="<?php echo $prefix_url.'static/thimthumb.php?src=../'.$category['image'].'&h=105&w=208&q=100';?>">
                        
                        <div id="img_replacer">
                          <input type="file" name="upload_news_1" id="news-1" onchange="readURL(this,'1')" class="hidden"/>
                        </div><!--img_replacer-->    
                        
                      </div>
                    </div>
                  </div>
                <p class="help-block" style="padding-top: 10px">Recommended dimensions of 273 x 130 px.</p>
              </div>
            </li>
            
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Root Category</label>
              <div class="col-xs-9">
                <select class="form-control" name="category_parent" id="category_parent">
                  <option value="top">-- Root Category --</option>
                  <?php //listCategory(0,'top');?>
                </select>
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->
    
    <?php
    echo "<input type=\"hidden\" name=\"jobs\" value=\"".$check['rows']."\">";
    echo "<input type=\"hidden\" name=\"cat_id\" value=\"".$category_id."\">";
    echo "<input type=\"hidden\" name=\"hidden_name\" value=\"".cleanurl($category['filter_name'])."\">";
	?>
    
</form>

<?php
if($_POST['btn_detail_city'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

<style>
.has-error {
border-color: #b94a48;
}
</style>

<script>
function initial(x){
   
   $('#category_active_status_active').attr('checked', true);
   if(x == '1'){
	  $('#category_visibility_status_visible').attr('checked', true);
   }else{
	  $('#category_visibility_status_invisible').attr('checked', true);
   }
   $('#category_name').focus();
}

function validation(){
  var category_name = $('#category_name').val();
  
  $('#category_name').val();
  
  $('#lbl_category_name').removeClass('has-error');
  
  if(category_name == ""){
     $('#lbl_category_name').addClass('has-error');
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
   $("#btn-slider-"+i).removeClass("hidden");
   $("#btn-slider-"+i).fadeIn("fast");
   $("#btn-news-"+i).attr('style','z-index:1000; position:absolute');
                            	  
   $("#newer-"+i).mouseleave(function(){
      $("#btn-slider-"+i).fadeOut("fast");
   });
}


function clearImage(i){		
   $('#upload-news-'+i).addClass('hidden');					   
   $('#img_replacer').html('<input type="file" name="upload_news_'+i+'" id="news-'+i+'" onchange="readURL(this,'+i+')" class="hidden"/>');
}


$(document).ready(function(e) {
   initial(<?php echo $category['visibility']?>);
   
   $('#btn_alias').click(function (){
      validation()
   });
});
</script>