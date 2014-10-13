<form method="post" enctype="multipart/form-data">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-list"></span> &nbsp; <a href="<?php echo $prefix_url."category"?>">Categories</a> <span class="info">/</span> Edit Category</h1>
        <div class="btn-placeholder">
          <a href="<?php echo $prefix_url."category"?>"><input type="button" class="btn btn-default btn-sm" value="Cancel" id="btn-add-category-cancel"></a>
          <input type="button" class="btn btn-danger btn-sm" value="Delete">
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn-category">
        </div>
      </div>
    </div>

    <?php
      if(!empty($_SESSION['alert'])){?>      
      <div class="alert <?php echo $_SESSION['alert'];?>">
        <div class="container"><?php echo $_SESSION['msg'];?></div>
      </div>
    <?php }?>

    <div class="container main">
            
      

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Category Details</h3>
          <p>Your category details.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set" id="custom_product_category">
            <li class="form-group row">
              <label class="control-label col-xs-3">Change Status</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="Active" name="active_status" id="category_active_status_active" <?php if(strtolower($category_detail['category_active_status']) == "active"){ echo "checked=\"checked\"";}?>>
                  Active
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="Inactive" name="active_status" id="category_active_status_inactive" <?php if(strtolower($category_detail['category_active_status']) == "inactive"){ echo "checked=\"checked\"";}?>>
                  Inactive
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="radio-inline control-label">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible" <?php if(strtolower($category_detail['category_visibility_status']) == "1"){ echo "checked=\"checked\"";}?>>
                  Yes
                </label>
                <label class="radio-inline control-label">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible" <?php if(strtolower($category_detail['category_visibility_status']) == "0"){ echo "checked=\"checked\"";}?>>
                  No
                </label>
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Category Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" name="category_name" placeholder="ex: Tees" id="category_name" value="<?php echo ucwords(strtolower($category_detail['category_name']));?>">
              </div>
            </li>
            <li class="form-group row">
              <label class="control-label col-xs-3">Root Category</label>
              <div class="col-xs-9">
                <select class="form-control" name="category_parent" id="category_parent">
                  <option value="0">-- Select Root Category --</option>
                  <option value="1">Tops</option>
                  <option>-- Tanks</option>
                  <option>-- Knit Tops</option>
                </select>
              </div>
            </li>
          </ul>
        </div>
      </div><!--.box-->

    </div><!--.container.main-->

</form>