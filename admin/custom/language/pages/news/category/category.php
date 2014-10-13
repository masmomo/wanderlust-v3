<?php
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


// LANGUAGE
function count_category_lang($post_id_param){
   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_category_lang WHERE `id_param` = '$post_id_param'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_category_lang($post_id_param, $post_lang_code){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_news_category_lang WHERE `id_param` = '$post_id_param' AND `language_code` = '$post_lang_code'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function count_category_lang_child($post_news_category){
   $conn   = conndB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_news_lang WHERE `news_category` = '$post_news_category'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}




/*
*---------------------------------------------
* UPDATE
*---------------------------------------------
*/

function update($post_category_name, $post_id_param){
   $conn   = connDB();
   
   $sql    = "UPDATE tbl_news_category_lang SET `category_name` = '$post_category_name' WHERE `id_param` = '$post_id_param'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}

function insert($post_category_name, $post_id_param, $post_category_active, $post_category_visibility, $post_lang_code){
   $conn   = connDB();
   
   $sql    = "INSERT INTO tbl_news_category_lang (`category_name`, `id_param`, `category_active`, `category_visibility`, `language_code`) 
                                           VALUES('$post_category_name', '$post_id_param', '$post_category_active', '$post_category_visibility', '$post_lang_code')";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
}



/*
*---------------------------------------------
* CONTROL
*---------------------------------------------
*/

// REQUEST VARIABLE
$category_id = $_REQUEST['nid'];


// DEFINED VARIABLE
$_SESSION['lang_admin'] = $_REQUEST['lang'];


// CALL FUNCTION
$check       = count_category_lang($category_id);

if($check['rows'] > 0){
   $detail_category    = get_category_lang($category_id, $_SESSION['lang_admin']);
}else{
   $detail_category    = get_category($category_id);
}

$default = get_category($category_id);



if(isset($_POST['btn_detail_news_category_lang'])){
 
   // DEFINED VARIABLE
   $category_id   = $_POST['hidden_category_id'];
   
   if(!empty($_POST['custom_lang_default_name'])){
      $category_name = 'default';
   }else{
      $category_name = stripslashes($_POST['category_name']);
   }
   
   $category_active      = $detail_category['category_active'];
   $category_visibility  = $detail_category['category_visibility'];
   $lang_code            = $_SESSION['lang_admin'];
   
   if($check['rows'] > 0){
      update($category_name, $category_id);
   }else{
	  insert($category_name, $category_id, $category_active, $category_visibility, $lang_code);
   }
   
   $_SESSION['alert'] = 'success';
   $_SESSION['msg']   = 'Changes has been successfully saved';
   
}
?> 
        

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-list"></span> &nbsp; 
          <a href="<?php echo $prefix_url."news-category"?>">News Categories</a> 
          <span class="info">/</span> Edit News Category
        </h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."news-category";?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="button" class="btn btn-success btn-sm" value="Save Changes" id="btn-alias">
          <input type="submit" class="hidden" value="Save Changes" name="btn_detail_news_category_lang" id="btn-save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_detail_news_category_lang'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3" id="custom_lang">
          <h3>Category Details</h3>
          <p>Your category details.</p>
          
          <!--custom-->
          <?php
		  include("select.php");
		  ?>
          
        </div>
        <div class="content col-xs-9">
          <ul class="form-set" id="custom_product_category">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" name="active_status" disabled>Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status" disabled>Inactive
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
                <input type="text" class="form-control" name="category_name" id="category_name" value="<?php echo $detail_category['category_name'];?>" onKeyUp="checkValue('name')">
                
                <label class="control-label" style="width: 130px;">
                  <input type="checkbox" name="custom_lang_default_name" id="id_custom_lang_default_title" style="margin-right:5px;" onclick="checkDefault('title')" <?php if($detail_category['category_name'] == "default"){ echo "checked";}?> class="control-label"> Use default value
                </label>
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->
    
    <?php
    echo '<input type="hidden" name="hidden_category_id" value="'.$_REQUEST['nid'].'">';
    echo '<input type="hidden" name="hidden_category_name" value="'.$detail_category['category_name'].'">';
	?>

</form>


        
<script>
function selected(x){
   $('#category_parent option[value="'+x+'"]').attr('selected',true);
}

function checkVisibility(x){
	
   if(x == 'Yes'){
      $('#category_visibility_status_visible').attr('checked',true);
   }else if(x == 'No'){
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


function checkValue(x){
   
   var value = $('#category_'+x).val();
   
   if(value != 'default'){
      $('#id_custom_lang_default_title').attr('checked', false);
   }else{
      $('#id_custom_lang_default_title').attr('checked', true);
   }
   
}

$(document).ready(function(e) {
	
   $('#btn-alias').click(function (){
      validation();
   });
   
   selected('<?php echo $detail_category['category_id'];?>'); 
   checkVisibility('<?php echo $detail_category['category_visibility'];?>');
});
</script>