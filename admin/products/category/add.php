<?php
// SHOW CATEGORY
function listCategory($level,$parent,$current_category, $prefix_url){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for ($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		 echo '<option class="option_level_'.$level.'" data-level="'.$level.'" id="option_level_'.$level.'"';
		 if ($current_category==$new_parent."'"){
			echo "selected=selected";
		 }
		 
		 echo ' value="'.$new_parent.'">';
		 
		 for ($i=0;$i<$level;$i++){
			echo '-- ';
		 }
		 
		 echo $get_data_array["category_name"].'</option>';
		 listCategory($new_level,$new_parent,$current_category);
      }
   }
}

if(isset($_POST['btn_add_category'])){
$conn = connDB();
  
   $category_name        = $_POST['category_name'];
   $category_description = $_POST['category_description'];
   $post_active_status   = $_POST['active_status'];
   $visibility_status    = $_POST['visibility_status'];
   $category_parent      = $_POST['category_parent'];
   $category_id          = $_POST['cat_id'];
  
   if(empty($category_id)){
      $get_order = mysql_query("SELECT * from tbl_category ORDER BY category_order DESC",$conn);
	  
	  if (mysql_num_rows($get_order)!=null){
         $get_order_array = mysql_fetch_array($get_order);
	     $category_order  = $get_order_array["category_order"]*1+1;
      }
	  
	  mysql_query(" INSERT INTO tbl_category
	                (category_name,category_order,category_active_status,category_visibility_status) 
				    VALUES('$category_name','$category_order','$post_active_status','$visibility_status')",$conn);
   
   
      $get_id = mysql_query("SELECT * from tbl_category WHERE category_name = '$category_name' ORDER BY category_id DESC",$conn);
   
      if (mysql_num_rows($get_id)!=null){
         $get_id_array = mysql_fetch_array($get_id);
	     $category_id  = $get_id_array["category_id"];
      }
	  
	  $parent_array = array();
	  $get_parent   = mysql_query("SELECT * from tbl_category_relation WHERE category_child='$category_parent'",$conn);
	  
	  if (mysql_num_rows($get_parent)!=null){
	     
		 for($counter=1;$counter<=mysql_num_rows($get_parent);$counter++){
	        $get_parent_array = mysql_fetch_array($get_parent);
		    $tmp_level        = $get_parent_array["relation_level"];
		    $tmp_parent       = $get_parent_array["category_parent"];
		    $parent_array[$tmp_level]=$tmp_parent;
         }	
		 
      }
	  
	  mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','1')",$conn);
	  
	  foreach($parent_array as $level => $parent){
	     $new_level = $level*1+1;
	     mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level)VALUES('$category_id','$parent','$new_level')",$conn);
		 
		 if ($parent=='top'){
            $category_level = $level;
         }
		 
      }
	  
   //}else if(!empty($category_id)){
      mysql_query("UPDATE tbl_category SET category_level = '$category_level' WHERE category_id = '$category_id'",$conn);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Item(s) has been successfully added.";
   }
}
?>

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-list"></span> &nbsp; <a href="<?php echo $prefix_url."category"?>">Categories</a> <span class="info">/</span> Add Category</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."category";?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_add_category" id="btn-save">
        </div>
      </div>
    </div>

        <?php
        if(!empty($_SESSION['alert'])){?>
        <div class="alert <?php echo $_SESSION['alert'];?>">
          <div class="container">
             <div class="content"><?php echo $_SESSION['msg'];?></div>
          </div>
        </div>
        <?php 
		}
		
		if($_POST['btn_add_category'] == ""){
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
                  <input type="radio" value="Active" name="active_status" id="category_active_status_active" checked="checked">
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status" id="category_active_status_inactive">
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible" checked="checked">
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible">
                  No
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Root Category</label>
              <div class="col-xs-9">
                <select class="form-control" name="category_parent" id="category_parent">
                  <option value="top">-- Root Category --</option>
                  <?php listCategory(0,'top');?>
                </select>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Category Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Tees" id="category_name">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>