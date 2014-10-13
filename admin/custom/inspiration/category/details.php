<?


/*
*---------------------------------------------
* GET
*---------------------------------------------
*/

function get_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_inspiration_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_inspiration_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}




/*
*---------------------------------------------
* UPDATE
*---------------------------------------------
*/

function update($post_category_name, $post_description, $post_category_visibility, $post_category_id){
   $conn   = conndB();
   
   $sql    = "UPDATE tbl_inspiration_category SET `name` = '$post_category_name',
                                                  `description` = '$post_description',
									              `visibility` = '$post_category_visibility'
			  WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}



/*
*---------------------------------------------
* CONTROL
*---------------------------------------------
*/

// REQUEST VARIABLE
$category_id = $_REQUEST['ins_id'];


// CALL FUNCTION
$category    = get_category($category_id);



if(isset($_POST['btn_detail_project_category'])){
 
 // DEFINED VARIABLE
 $category_id   = $_POST['hidden_category_id'];
 $category_name = addslashes($_POST['category_name']);
 $description   = '';
 $visibility    = $_POST['visibility_status'];
 
 update($category_name, $description, $visibility, $category_id);
 
 $_SESSION['alert'] = 'success';
 $_SESSION['msg']   = 'Changes has been successfully saved';
   
}


// CALL FUNCTION
$detail_category = get_category($category_id);
?> 
        

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-list"></span> &nbsp; 
          <a href="<?php echo $prefix_url."project-category"?>">Project Categories</a> 
          <span class="info">/</span> Edit Project Category
        </h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."project-category";?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn-alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_detail_project_category" id="btn-save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_detail_project_category'] == ''){
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
                  <input type="radio" value="Yes" name="visibility_status" id="category_visibility_status_visible">Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="No" name="visibility_status" id="category_visibility_status_invisible">No
                </label>
              </div>
            </li>
            <li class="form-group row" id="lbl_category_name">
              <label class="control-label col-xs-3">Category Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $detail_category['name'];?>">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->
    
    <?php
    echo '<input type="hidden" name="hidden_category_id" value="'.$detail_category['category_id'].'">';
    echo '<input type="hidden" name="hidden_category_name" value="'.$detail_category['name'].'">';
	?>

</form>


        
<script>
function selected(x){
   $('#category_parent option[value="'+x+'"]').attr('selected',true);
}

function checkVisibility(x){
	
   if(x == '1'){
      $('#category_visibility_status_visible').attr('checked',true);
   }else if(x == '0'){
      $('#category_visibility_status_invisible').attr('checked',true);
   }
}


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
   
   selected('<?php echo $detail_category['category_id'];?>'); 
   checkVisibility('<?php echo $detail_category['visibility'];?>');
});
</script>