<?
/*
*---------------------------------------------
* GET
*---------------------------------------------
*/

function get_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_news_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}




/*
*---------------------------------------------
* UPDATE
*---------------------------------------------
*/

function insert($post_category_name, $post_category_active, $post_category_visibility){
   $conn   = conndB();
   
   $sql    = "INSERT INTO tbl_news_category (`category_name`, `category_active`, `category_visibility`)
                                      VALUES('$post_category_name', '$post_category_active', '$post_category_visibility')
			 ";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}



/*
*---------------------------------------------
* CONTROL
*---------------------------------------------
*/

if(isset($_POST['btn_insert_news_category'])){
 
 // DEFINED VARIABLE
 $category_name = stripslashes($_POST['category_name']);
 $active        = 'Active';
 $visibility    = $_POST['visibility_status'];
 
 insert($category_name, $active, $visibility);
 
 $_SESSION['alert'] = 'success';
 $_SESSION['msg']   = 'Item has been successfully saved';
   
}
?> 
        

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-list"></span> &nbsp; 
          <a href="<?php echo $prefix_url."news-category"?>">News Categories</a> 
          <span class="info">/</span> Add News Category
        </h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."news-category";?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn-alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_insert_news_category" id="btn-save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_insert_news_category'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Category Details</h3>
          <p>Your category details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set" id="custom_product_category">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" name="active_status" checked>Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status">Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Yes" name="visibility_status" id="category_visibility_status_visible" checked>Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="No" name="visibility_status" id="category_visibility_status_invisible">No
                </label>
              </div>
            </li>
            <li class="form-group row" id="lbl_category_name">
              <label class="control-label col-xs-3">Category Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category name">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>


        
<script>
function validation(){
  var name = $('#category_name').val();
  
  $('#lbl_category_name').removeClass('has-error');
  
  if(name == ''){
     $('#lbl_category_name').addClass('has-error');
  }else{
     $('#btn-save').click();
  }
}

$(document).ready(function(e) {
	
   $('#btn-alias').click(function (){
      validation();
   });
});
</script>