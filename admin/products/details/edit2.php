<?php
include("control.php");
include("custom/products/add/control.php");
?>

<form name="index-order" id="add-product-form" method="post" action="" enctype="multipart/form-data" >

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-tag"></span> &nbsp;
          <a href="<?php echo $prefix_url."product"?>">Products</a> 
          <span class="info">/</span> Add Product
        </h1>
        <div class="btn-placeholder">
          <a class="btn btn-default btn-sm" href="<?php echo $prefix_url."product"?>">Cancel</a>
          <input type="button" class="btn btn-success btn-sm submit-button" value="Save Changes" onclick="validate_add()">
          <input type="submit" class="btn btn-success btn-sm submit-button hidden" value="Save Changes" name="add-product" id="id_add_product">
          <input type="submit" class="btn btn-success btn-sm submit-button hidden" value="Save Changes &amp; Exit" name="add-product" disabled>
        </div>
      </div>
    </div>

    <div class="container main" class="products">

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Basic Details</h3>
          <p>Basic details of your product</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row underlined" id="form_product_name">
              <label class="col-xs-3 control-label" for="product_name">Product Name *</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="product_name" name="product_name" onchange="getAlias(),enableButton()" value="<?php echo $data['product_name'];?>">
                <input type="hidden" id="product_id" name="product_id" value="<?php echo $data['product_id'];?>">
              </div>
            </li>
            <li class="form-group row" id="category_field" id="form_product_category">
              <label class="col-xs-3 control-label" for="category">Category *</label>
              <div class="col-xs-9">
                <select class="form-control" id="product_category" name="product_category">
                  <option value="">-- Select Category --</option>
                    <?php              
                      listCategory('0','top',$data['product_category']);
                    ?>
                </select>
              </div>
            </li>
            <li class="form-group row" id="lbl_size_type_id">
              <label class="col-xs-3 control-label" for="sizegroup">Size Group *</label>
              <div class="col-xs-9">
                <select class="form-control" id="size_type_id" name="size_type_id" onchange="changeSizeType()">
                  <option value="">-- Select Size Group --</option>
                    <?php 
                    foreach($all_size_group as $all_size_group){
					
                    echo "<option value=\"".$all_size_group['size_type_id']."\"";
					if ($data['product_size_type_id']==$all_size_group['size_type_id']){
                        echo ' selected="selected"';
                      }
					echo ">".$all_size_group['size_type_name']."</option>";
                    }
                    ?>
                </select>
              </div>
            </li>
          </ul>
        </div>
      </div><!--box-->

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Variants &amp; Inventory</h3>
          <p>Manage your product variants and inventory.</p>
        </div>
        <div class="content col-xs-9">
		  	<?php        
				  
                  foreach($all_color_group as $one_color){
					echo '<input type="hidden" id="color_image_'.$one_color["color_id"].'" name="color_image_'.$one_color["color_id"].'" value="'.$one_color["color_image"].'">';
                  
                  }    
              ?>
          <?php for($i=1;$i<=1;$i++){?>
          <ul class="form-set" id="type_group_<?php echo $i;?>">
            <li class="form-group row" id="lbl_color_id_<?php echo $i;?>">
              <label class="col-xs-3 control-label" for="color">Color Group *</label>
              <div class="col-xs-9">
                <select class="form-control" id="color_id_<?php echo $i;?>" name="color_id[<?php echo $i;?>]" onchange="changeColor(<?php echo $i;?>)">
                  <option value="No Color">-- Select Color Group --</option>
                    
					<?php 
                    foreach($all_color_group as $all_color_group){
                      echo "<option value=\"".$all_color_group['color_id']."\" ";
					  if ($data['color_id'][$i]==$one_color['color_id']){
                        echo ' selected="selected"';
                      }
					  echo ">".$all_color_group['color_name']."</option> \n";
                      echo "\n";
                    }                        
                    ?>
                    
                </select>
              </div>
            </li>
            <li class="form-group row" id="lbl_color_name">
              <label class="col-xs-3 control-label" for="color-name">Color Name</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="type_name_<?php echo $i;?>" name="type_name[<?php echo $i;?>]">
                <p class="help-block">Color name variants that belongs to the color group, e.g. Light Grey, Dark Grey</p>
              </div>
            </li>

			<li class="form-group row image-placeholder input-file hidden" id="lbl_color_image-<?=$i;?>">
              <label class="col-xs-3 control-label">Color Image</label>
              <div class="col-xs-9">
                <div class="">
                  <div class="color-thumb edit image" style="padding-left:0;" onclick="openBrowser('color-image-<?=$i;?>')" onmouseover="imageOver('color-image-<?=$i;?>')" onMouseOut="imageOut('color-image-<?=$i;?>')">
                    <div class="content" > 
                      <img width="40" height="25" class="hidden" id="upload-image-color-image-<?=$i;?>" src="<?php echo $prefix;?>files/common/img_product-1.jpg">
                      <div class="hidden" id="product-color-image-<?=$i;?>-image-wrap">
                        <input type="file" name="type_image[<?=$i;?>]" id="product-color-image-<?=$i;?>-image" onchange="readURL(this,'color-image-<?=$i;?>')" class="hidden"/>
                      </div>
                      <input type="hidden" name="type_image_delete_<?=$i;?>" id="image-delete-color-image-<?=$i;?>" value="0" />
                    </div>
                  </div>
                </div>
                <p class="help-block">Recommended dimensions of 40 x 30 px.</p>
              </div>
            </li>

			
            <li class="form-group row image-placeholder input-file">
              <label class="col-xs-3 control-label">Images</label>
              <div class="col-xs-9">
                <div class="row">
                  <?php for($j=0;$j<5;$j++){?>
					<div class="col-xs-2 image" onclick="openBrowser('<?php echo $i.'-'.$j;?>')" onmouseover="imageOver('<?php echo $i.'-'.$j;?>')" onMouseOut="imageOut('<?php echo $i.'-'.$j;?>')">
	                    <div class="content img-prod-size"> 
	                      <div>
	                        <div class="image-delete hidden" id="image-<?php echo $i.'-'.$j;?>-delete" onclick="deleteImage('<?php echo $i.'-'.$j;?>','<?php echo $i;?>','<?php echo $j;?>'); event.preventDefault();" onmouseover="deleteOver()" onmouseout="deleteOut()"><span class="glyphicon glyphicon-remove"></span></div>
	                        <div class="image-overlay"></div>
	                      </div>
						  	<?php if($data['product_image'][$i]['img_src_list'][$j]!=''){
							?>
							<img class="" id="upload-image-<?php echo $i.'-'.$j;?>" src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']).'/'.$prefix.$data['product_image'][$i]['img_src_list'][$j];?>">
							<?php	 
							 }
							 else{
							?>
                           <img class="hidden" id="upload-image-<?php echo $i.'-'.$j;?>" src="<?php echo $prefix;?>files/common/img_product-1.jpg">
                           
                           <?php } ?>

	                      
	                      <div class="hidden" id="product-<?php echo $i.'-'.$j;?>-image-wrap">
	                        <input type="file" name="product_image[<?php echo $i;?>][<?php echo $j;?>]" id="product-<?php echo $i.'-'.$j;?>-image" onchange="readURL(this,'<?php echo $i.'-'.$j;?>')" class="hidden"/>
	                      </div>
	                      <input type="hidden" name="image_id[<?php echo $i;?>][<?php echo $j;?>]" value="<?php echo $data['product_image'][$i]['image_id_list'][$j];?>" />
	                      <input type="hidden" name="image_delete[<?php echo $i;?>][<?php echo $j;?>]" id="image-delete-<?php echo $i.'-'.$j;?>" value="0" />
	                    </div>
	                  </div>
				  <!--
                  <div class="col-xs-2 image" onclick="openBrowser('<?php echo $i.'-'.$j;?>')" onmouseover="imageOver('<?php echo $i.'-'.$j;?>')" onMouseOut="imageOut('<?php echo $i.'-'.$j;?>')">
                    <div class="content img-prod-size">
                      <div>
                        <div class="image-delete hidden" id="image-<?php echo $i.'-'.$j;?>-delete" onclick="deleteImage('<?php echo $i.'-'.$j;?>','<?php echo $i;?>','<?php echo $j;?>'); event.preventDefault();" onmouseover="deleteOver()" onmouseout="deleteOut()"><span class="glyphicon glyphicon-remove"></span></div>
                        <div class="image-overlay"></div>
                      </div>
                      <?php if($data['product_image'][$i]['img_src_list'][$j]!=''){
                      ?>
                      <img class="hidden" id="upload-image-<?php echo $i.'-'.$j;?>" src="<?php echo 'http://'.$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']).'/'.$prefix.$data['product_image'][$i]['img_src_list'][$j];?>">
                        <?php  
                          }
                          else{
                        ?>
                        <img class="img-responsive invisible" id="upload-image-<?php echo $i.'-'.$j;?>" src="<?php echo $prefix;?>files/common/img_product-1.jpg">
                        <?php } ?>
                      <div class="hidden" id="product-<?php echo $i.'-'.$j;?>-image-wrap">
                        <input type="file" name="product_image[<?php echo $i;?>][<?php echo $j;?>]" id="product-<?php echo $i.'-'.$j;?>-image" onchange="readURL(this,'<?php echo $i.'-'.$j;?>')" class="hidden"/>
                      </div>
                      <input type="hidden" name="image_id[<?php echo $i;?>][<?php echo $j;?>]" value="<?php echo $data['product_image'][$i]['image_id_list'][$j];?>" />
                      <input type="hidden" name="image_delete[<?php echo $i;?>][<?php echo $j;?>]" id="image-delete-<?php echo $i.'-'.$j;?>" value="0" />
                    </div>
                  </div>
				  -->
                  <?php 
                  }
                  ?>
                </div>
                <p class="help-block">Recommended dimensions of 500 x 750 px.</p>
              </div>
            </li>

            <div id="product_stock_list_<?php echo $i;?>">
            </div>

            <li class="form-group row" id="lbl_type_weight_1">
              <label class="col-xs-3 control-label" for="weight">Weight <span class="info">(in kg)</span> *</label>
              <div class="col-xs-2">
                <input type="text" class="form-control" id="type_weight_<?php echo $i;?>" name="type_weight[<?php echo $i;?>]" placeholder="0" value="<?php echo $data['type_weight'][$i];?>">
              </div>
            </li>
            <li class="form-group clearfix underlined hidden">
              <button type="button" class="btn btn-danger btn-sm pull-right" onclick="deleteType(<?php echo $i;?>)">Remove Variant</button>
            </li>
            <input type="hidden" name="type_delete[<?php echo $i;?>]" id="type_delete_<?php echo $i;?>" value='0'/>
              <?php for ($j=0;$j<5;$j++){?>
                <input type="hidden" name="order[<?php echo $i;?>][<?php echo $j;?>]" id="order_<?php echo $i;?>_<?php echo $i;?>" value="<?php echo $j;?>" />
              <?php 
              } 
              ?>
          </ul><!--form-set-->
          <?php 
          } 
          ?>

          <ul class="form-set hidden" id="field_<?php echo $i;?>"></ul>
          <div class="hidden" id="next_type"><?php echo $i;?></div>

          <ul class="form-set">
            <li class="form-group clearfix">
              <button type="button" class="btn btn-success btn-sm pull-right" value="Add Variant" onclick="addVariant()">Add Variant</button>
            </li>
          </ul>

        </div><!--content-->
      </div><!--box-->

      <div class="box row hidden">
        <div class="desc col-xs-3">
          <h3>Visibility</h3>
          <p>Set product visibility.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <label class="control-label col-xs-3">Visibility</label>
              <div class="col-xs-9">
                <label class="control-label radio-inline">
                  <input type="radio" value="1" name="visibility_status" id="category_visibility_status_visible">
                  Yes
                </label>
                <label class="control-label radio-inline">
                  <input type="radio" value="0" name="visibility_status" id="category_visibility_status_invisible">
                  No
                </label>
              </div>
            </li>
          </ul>
        </div>
      </div><!--box-->

      <div class="box row hidden">
        <div class="desc col-xs-3">
          <h3>SEO</h3>
          <p>Search engine optimization for the product.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <label class="col-xs-3 control-label" for="page-title">Page Title</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="page_title" name="page_title">
              </div>
            </li>
            <li class="form-group row">
              <label class="col-xs-3 control-label" for="page-description">Page Description</label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="page_description" name="page_description">
              </div>
            </li>
            <li class="form-group row">
              <label class="col-xs-3 control-label" for="url-handle">URL &amp; Handle</label>
              <div class="col-xs-9">
                <table>
                  <tbody>
                    <tr>
                      <td><div class="form-url">http://sitename.com/products/</div></td>
                      <td width="100%"><div style="margin: -1px"><input type="text" class="form-control url" id="product_alias" name="product_alias" placeholder="your-product-name" onchange="forceAlias()"></div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </li>
          </ul>
        </div>
      </div><!--box-->
      
      <div id="custom">
      </div>


</form>

<script src="<?php echo $prefix_url.'script/add_product.js';?>"></script>

<?php
include('custom/products/add/index.php');
?>

