<?
// Detail Category
$category_id = $_REQUEST['cid'];


// SHOW CATEGORY
function listCategory($level,$parent,$current_category){
   $conn = connDB();
   
   $get_data = mysql_query("SELECT * from tbl_category AS cat INNER JOIN tbl_category_relation AS cat_rel ON cat.category_id = cat_rel.category_child
	                        WHERE cat.category_level = '$level' AND cat_rel.category_parent = '$parent' ORDER BY category_order",$conn);

   if (mysql_num_rows($get_data)!=null && mysql_num_rows($get_data)!=0){
      
	  for($counter=1;$counter<=mysql_num_rows($get_data);$counter++){
	     $get_data_array = mysql_fetch_array($get_data);
		 $new_level      = $level*1+1;
		 $new_parent     = $get_data_array["category_id"];
		 
		 echo '<option class="option_level_'.$level.'" data-level="'.$level.'" id="option_level_'.$level.'"';
		 if ($current_category==$new_parent){
		    echo 'selected="selected"';
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


function get_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_root($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_category_relation WHERE `category_child` = '$post_category_id' AND relation_level='1'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result['category_parent'];
}


function count_category($post_category_id){
   $conn   = conndB();
   
   $sql    = "SELECT * FROM tbl_category WHERE `category_id` = '$post_category_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


if(isset($_POST['btn_detail_category'])){
   
   if($_POST['btn_detail_category'] == 'Delete'){
      
   }else if($_POST['btn_detail_category'] == 'Save Changes'){
      update_category();
   }
   
}


// CALL FUNCTION
$detail_category = get_category($category_id);
//print_r($detail_category);
$root_category = get_root($category_id);


// NEW
function update_category(){
	$conn = connDB();
  
   $category_name        = $_POST['category_name'];
   $category_description = $_POST['category_description'];
   $visibility_status    = $_POST['visibility_status'];
   $category_parent      = $_POST['category_parent'];
   $category_id          = $_POST['hidden_category_id'];
  
   //if(empty($category_id)){
   
   //category level
   if ($category_parent=='top'){
      $category_level='0';
   }else{
      $get_level = mysql_query("SELECT * from tbl_category WHERE category_id = '$category_parent'",$conn);
		  
      if (mysql_num_rows($get_level)!=null){
	     $get_level_array = mysql_fetch_array($get_level);
	     $category_level = $get_level_array["category_level"]*1+1;
	  }
	  
   }
   
   $get_order = mysql_query("SELECT * from tbl_category ORDER BY category_order DESC",$conn);
	  
   if (mysql_num_rows($get_order)!=null){
      $get_order_array = mysql_fetch_array($get_order);
      $category_order = $get_order_array["category_order"]*1+1;
   }
   
   mysql_query(" UPDATE tbl_category  SET category_name = '$category_name',
                                          category_level = '$category_level',
										  category_visibility_status = '$visibility_status',
										  category_description='$category_description' 
                 WHERE category_id='$category_id'
			   ",$conn);
   
   
   update_category_relation($category_id,$category_parent);
   
}


function update_category_relation($category_id,$category_parent){
   $conn = connDB();
   
   //delete all category relation with this as child
   mysql_query("DELETE FROM tbl_category_relation WHERE category_child='$category_id'",$conn);
	
   //add category relation
   add_category_relation($category_id,$category_parent,1);
	
   //get all category where category parent is this, get the relation order
   $categories=array();
   $get_categories = mysql_query("SELECT * from tbl_category_relation WHERE category_parent='$category_id'",$conn);
   
   if (mysql_num_rows($get_categories)!=null){
	  
	  for($counter=1;$counter<=mysql_num_rows($get_categories);$counter++){
	     $get_categories_array = mysql_fetch_array($get_categories);
		 $categories[$counter]["relation_level"] = $get_categories_array["relation_level"];
		 $categories[$counter]["category_child"] = $get_categories_array["category_child"];
	  }
		 
   }
   
   //print_r($categories);
   foreach($categories as $category){
      $tmp_level = $category['relation_level'];
      $tmp_child = $category['category_child'];
	  
	  //remove all with relation order more than that
	  mysql_query("DELETE FROM tbl_category_relation WHERE category_child='$tmp_child' AND relation_level>='$tmp_level'" ,$conn);
	  
	  //add relation
	  add_category_relation($tmp_child,$category_id,$tmp_level);
   }
	  
}


function add_category_relation($category_id,$category_parent,$level_init){
   $conn = connDB();
   
   if ($category_parent=='top'){
      mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','$level_init')",$conn);
   }else{
      $parent_array=array();
	  $get_parent = mysql_query("SELECT * from tbl_category_relation WHERE category_child='$category_parent'",$conn);
	  
	  if (mysql_num_rows($get_parent)!=null){
		 
		 for($counter=1;$counter<=mysql_num_rows($get_parent);$counter++){
		    $get_parent_array = mysql_fetch_array($get_parent);
		    $tmp_level = $get_parent_array["relation_level"];
		    $tmp_parent = $get_parent_array["category_parent"];
		    $parent_array[$tmp_level]=$tmp_parent;
         }	
		 
      }
	  
	  mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level) VALUES('$category_id','$category_parent','$level_init')",$conn);
	  
	  foreach($parent_array as $level => $parent){
	     $new_level = $level*1+$level_init;
	     mysql_query("INSERT INTO tbl_category_relation(category_child,category_parent,relation_level) VALUES('$category_id','$parent','$new_level')",$conn);
		 
		 if ($parent=='top'){
            $category_level = $new_level-1;
         }
		 
      }
	  
   }
   
   mysql_query("UPDATE tbl_category SET category_level='$category_level' WHERE category_id='$category_id'");
}
?> 

<?php
include("custom/products/category/control.php");
?>
        

<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-list"></span> &nbsp; <a href="<?php echo $prefix_url."category"?>">Categories</a> <span class="info">/</span> Edit Category</h1>
        <div class="btn-placeholder">
          <input type="hidden" name="cat_id" id="category_id"/>
          <a href="<?php echo $prefix_url."category";?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_detail_category" id="btn-save">
        </div>
      </div>
    </div>
    
	<?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="content">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_detail_category'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3" id="custom_lang">
          <h3>Category Details</h3>
          <p>Your category details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set" id="custom_product_category">
            <li class="form-group row hidden">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" name="active_status" id="category_active_status_active" 
                  <?php if(strtolower($detail_category['category_active_status']) == "active"){ echo "checked=\"checked\"";}?>>
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status" id="category_active_status_inactive" 
                  <?php if(strtolower($detail_category['category_active_status']) == "inactive"){ echo "checked=\"checked\"";}?>>
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible" 
                  <?php if(strtolower($detail_category['category_visibility_status']) == "1"){ echo "checked=\"checked\"";}?>>
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible" 
                  <?php if(strtolower($detail_category['category_visibility_status']) == "0"){ echo "checked=\"checked\"";}?>>
                  No
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Root Category</label>
              <div class="col-xs-9">
                <select class="form-control" name="category_parent" id="category_parent">
                  <option value="top">-- Root Category --</option>
                  <?php listCategory(0,'top',$root_category);?>
                </select>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Category Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Tees" id="category_name" value="<?php echo $detail_category['category_name'];?>">
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->
    
    <?php
    echo '<input type="hidden" name="hidden_category_id" value="'.$detail_category['category_id'].'">';
	?>

</form>


        
<script>
function selected(x){
	
   var level = <?php echo $detail_category['category_level'];?>;
   
   if(level == '0'){
      x = 'top';
   }else{
      x = x;
   }
   
   //$('#category_parent option[value="'+x+'"]').attr('selected',true);
}

function freechecked(){
   $('input[type="checkbox"]').attr('checked',false);
}

selected('<?php echo $detail_category['category_id'];?>');   
</script>



<?php
include("custom/products/category/index.php");
?>