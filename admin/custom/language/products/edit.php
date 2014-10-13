<?php
include("control.php");
?>


    
  <form name="product-detail" method="post" enctype="multipart/form-data">
            
    <div class="subnav">
      <div class="container clearfix">
        <h1>
          <span class="glyphicon glyphicon-tag"></span> &nbsp; 
          <a href="<?php echo $prefix_url."product"?>">Products</a> 
          <span class="info">/</span> Edit Product
        </h1>
        <div class="btn-placeholder">
          <a class="btn btn-default btn-sm hidden" href="<?php echo $prefix_url."product"?>">Cancel</a>
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn_product_lang">
          <input type="submit" class="btn btn-danger btn-sm hidden" name="btn-product-detail" value="Delete">
        </div>
      </div>
    </div>

    <?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_product_lang'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>
    
    <div class="container main" class="products">
    
      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Basic Details</h3>
          <p>Basic details of your product.</p>
          
		  <?php 
		  include("select.php");
		  ?>
          
        </div>
        
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row underlined">
              <label for="product-name" class="col-xs-3 control-label">Product Name <span>*</span></label>
              <div class="col-xs-9">
                <input type="text" class="form-control" id="value_name" name="lang_product_name" value="<?php echo $page_product['product_name'];?>">
                <input type="hidden" value="<?php echo $page_product['product_name'];?>" id="id_normalization_name">
                
                <label class="control-label" style="width: 130px;">
                  <input type="checkbox" name="custom_lang_default_name" id="id_custom_lang_default_name" style="margin-right:5px;" onclick="checkDefault('name')" <?php if($page_product['product_name'] == "default"){ echo "checked";}?> class="control-label"> Use default value
                </label>
              </div>
            </li>
          </ul>
          
          <ul class="form-set">
            <li class="form-group row hidden">
              <label for="brand" class="col-xs-3 control-label">Brand <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="brand" name="brand">
                  <option selected value="xxxx"></option>
                  <option value="xxxx">Monstore</option>
                </select>
                
                <p class="field-message error hidden">Content required</p>
              </div>
            </li>
            
            <li class="form-group row">
              <label for="category" class="col-xs-3 control-label">Product Category <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="category" name="category" disabled>
                  <option selected value="xxxx"><?php echo $page_product['category_name'];?></option>
                </select>
              </div>
            </li>
            
            <li class="form-group row hidden">
              <label for="sizegroup" class="col-xs-3 control-label">Size Group <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="sizegroup" name="sizegroup" disabled>
                  <option selected value="xxxx"><?php echo $page_product['size_type_name'];?></option>
                </select>
              </div>
            </li>
            
            <li class="form-group row hidden">
              <label for="gender" class="col-xs-3 control-label">Gender <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="gender" name="gender">
                  <option selected value="xxxx"></option>
                  <option value="xxxx">Unisex</option>
                  <option value="xxxx">Male</option>
                  <option value="xxxx">Female</option>
                  <option value="xxxx">Neither</option>
                </select>
              </div>
            </li>
            
            <li class="form-group row hidden">
              <label for="collection" class="col-xs-3 control-label">Collection <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="collection" name="collection">
                  <option selected value="xxxx"></option>
                  <option value="xxxx">2012 Illusion</option>
                </select>
              </div>
              <div class="btn row grey hidden hidden">+</div>
            </li>
            
            <li class="form-group row hidden">
              <label for="collection" class="col-xs-3 control-label">Series <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="series" name="series">
                  <option selected value="xxxx"></option>
                  <option value="xxxx">Series 1</option>
                </select>
              </div>
            </li>
            
            <li class="form-group row hidden">
              <label for="artist" class="col-xs-3 control-label">Artist <span>*</span></label>
              <div class="col-xs-9">
                <select class="form-control" id="artist" name="artist">
                  <option selected value="xxxx"></option>
                  <option value="xxxx">Artist 1</option>
                </select>
              </div>
            </li>
            
            <li class="form-group row hidden">
              <label for="story" class="col-xs-3 control-label">Story</label>
              <div class="col-xs-9">
                <textarea rows="5" id="story" name="story" class="form-control"></textarea>
              </div>
            </li>
          </ul>
        </div>
      </div><!--box-->
      
      <div class="box row">
        
        <div class="desc col-xs-3">
          <h3>Variants</h3>
          <p>Variations of your products such as in color. You can add as may variants as you want.</p>
        </div>
        
        <div class="content col-xs-9">
        
		  <?php
		  foreach($page_type as $page_type){
		     $page_color       = page_get_color($page_type['color_id']);
			 $page_count_image = page_count_image($page_type['type_id']);
			 $page_image       = page_get_image($page_type['type_id']);
			 $page_size        = page_get_size($page_product['product_size_type_id']);
			 $page_stock       = page_get_stock($page_type['type_id']);
			 $type_lang        = get_type_lang($page_type['type_id'], $_REQUEST['lang']);
			 $count_type_langs = counting_type_lang($ct_default['id'], $page_type['type_id'], $_REQUEST['lang']);
			 
			 if($count_type_lang['rows'] == 0 || empty($type_lang['type_name'])){
			    $page_type['type_name'] = $page_type['type_name'];
			 }else{
			    $page_type['type_name'] = $type_lang['type_name'];
			 }
		  ?>
             
           <ul class="form-set">
           
             <li class="form-group row hidden">
               <label for="color" class="col-xs-3 control-label">Color Group <span>*</span></label>
               <div class="col-xs-9">
                 <select class="form-control" id="color" name="color" disabled>
                   <option selected value="xxxx"><?php echo $page_color['color_name'];?></option>
                 </select>
                 <div class="btn row grey hidden">+</div>
               </div>
             </li>
             
             <li class="form-group row hidden">
               <label for="color-name" class="col-xs-3 control-label">Color Name</label>
               <div class="col-xs-9">
                 <input type="text" class="form-control" id="value_type_<?php echo $page_type['type_id'];?>" name="type_name_<?php echo $page_type['type_id'];?>" value="<?php echo $page_type['type_name'];?>" onkeyup="uncheckDefaults('name',<?php echo $page_type['type_id'];?>)">
                 <input type="hidden" value="<?php echo $page_type['type_name'];?>" id="id_normalization_type_<?php echo $page_type['type_id'];?>">
                 <input type="hidden" value="<?php echo $page_type['type_id'];?>" name="type_id[]">
                 
                 <label class="control-label" style="width: 130px;">
                   <input type="checkbox" name="custom_lang_default_type" id="id_custom_lang_default_type_<?php echo $page_type['type_id'];?>" style="margin-right:5px;" onclick="checkDefaults('type',<?php echo $page_type['type_id'];?>)" <?php if($value['news_title'] == "default"){ echo "checked";}?> class="control-label"> Use default value
                 </label>
                 
				 <?php
				 if($count_type_lang['rows'] = 0 || empty($type_lang['type_name']) || $type_lang['type_name'] == "default"){
				 ?>
                 
				   <script>
				   $('#id_custom_lang_default_type_<?php echo $page_type['type_id'];?>').attr('checked', true); 
				   </script>
                   
				 <?php
				 }
				 ?>
                 
               </div>
             </li>
             
             <li class="form-group row">
               <label for="sku" class="col-xs-3 control-label">SKU</label>
               <div class="col-xs-9">
                 <input type="text" class="form-control" id="sku" name="sku" value="<?php echo $page_type['type_code'];?>" disabled>
               </div>
             </li>
             
             <li class="form-group row hidden">
               <label for="price" class="col-xs-3 control-label">Price <span>*</span></label>
               <div class="col-xs-9">
                 <input type="text" class="form-control" id="price" name="price" value="<?php echo price($page_type['type_price']);?>" disabled>
                 <p class="field-message">Excluding tax</p>
               </div>
             </li>
             
			 <?php
			 if($count_type_langs['rows'] == 0){
			    $page_type['type_description'] = $page_type['type_description'];
			 }else{
			    $page_type['type_description'] = $type_lang['type_description'];
			 }
			 ?>
             
             <li class="form-group row">
               <label for="product-desc" class="col-xs-3 control-label">Product Description</label>
               <div class="col-xs-9">
                 
				 <?php
				 include_once("xeditor/ckeditor.php");
				 $path               = get_dirname($_SERVER['PHP_SELF']);
				 $CKEditor           = new CKEditor();
				 $CKEditor->basePath = $path.'/xeditor/';
				 $initialValue       = $page_type['type_description'];
				 $code               = $CKEditor->editor("type_description_".$page_type['type_id']."", $initialValue);
				 ?>
                 
                 <label class="control-label" style="width: 130px;">
                   <input type="checkbox" name="custom_lang_default_description" id="id_custom_lang_default_description_<?php echo $page_type['type_id'];?>" style="margin-right:5px;" onclick="checkDefaults('description', <?php echo $page_type['type_id'];?>)" <?php if($page_type['type_description'] == "default"){ echo "checked";}?>> Use default value
                 </label>
               </div>
             </li>
             
             <li class="form-group row image-placeholder input-file">
               <label for="xxxx" class="col-xs-3 control-label">Main Image</label>
               <div class="col-xs-9">
                 <div class="row">
                 
				   <?php
				   foreach($page_image as $page_image){
				   ?>
                 
                   <div class="col-xs-2 image">
                     <div class="hidden">
                       <div class="image-delete"></div>
                       <div class="image-overlay"></div>
                     </div>
                     <img src="<?php echo $prefix_url."static/thimthumb.php?src=../".$page_image['img_src']."&h=150&w=100&q=100";?>">
                   </div>
                   
				   <?php
				   }
				   ?>
                   
                 </div>
                 <p class="field-message" style="padding-top: 10px">Recommended dimensions of 500 x 750 px.</p>
               </div>
           </li>
           
		   <?php
		   $row = 0;
		   foreach($page_stock as $page_stock){
		   ?>
           
           <li class="form-group row hidden">
             <label for="sizes" <?php if($row != 0){ echo "class=\"hidden\"";}?> class="col-xs-3 control-label">Sizes</label>
             <div class="col-xs-9"> 
               <div class="form-group row">
                 <label class="col-xs-2 control-label"><?php echo $page_stock['stock_name'];?></label>
                 <div class="col-xs-2">
                   <input type="text" class="form-control" id="sizes" name="sizes" placeholder="0" style="width:50px; text-align:right" value="<?php echo $page_stock['stock_quantity']?>" disabled>
                 </div>
               </div>
             </div>
           </li>
           
		   <?php
		      $row++;
		   }
		   ?>
           
           <li class="form-group row hidden">
             <label for="weight" class="col-xs-3 control-label">Weight <span>*</span></label>
             <div class="col-xs-2"> 
               <input type="text" class="form-control" id="weight" name="weight" placeholder="0" style="width:90px; text-align:right" value="<?php echo $page_type['type_weight'];?>" disabled>
             </div>
           </li>
           
           <li class="form-group clearfix">
             <button type="button" class="btn btn-danger btn-sm pull-right hidden" name="remove_variant" onclick="deleteType(<?php echo $i;?>)">Remove Variant</button>
           </li>
           
         </ul>
         
		 <?php
		  // END PAGE TYPE
		  }
		  ?>
          
          <ul class="form-set hidden">
            <li class="form-group clearfix">
              <button type="button" class="btn btn-success btn-sm pull-right" value="Add Variant" onclick="addVariant()">Add Variant</button>
            </li>
          </ul>
        </div>
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
      
      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Content</h3>
          <p>Descriptions about your information.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
          
            <li class="form-group row underlined">
              <label class="control-label col-xs-12">How To Use</label><br /><br />
              <div class="col-xs-12">
                <?php
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$initialValue = $how['how'];
				$code = $CKEditor->editor("how", $initialValue);
				?>
				
				<label class="control-label" style="width: 130px;">
				  <input type="checkbox" name="custom_lang_default_how" id="id_custom_lang_default_how_<?php echo $page_type['type_id'];?>" style="margin-right:5px;" onclick="checkDefaults('description', <?php echo $page_type['type_id'];?>)" <?php if($how['how'] == "default"){ echo "checked";}?>> Use default value
				</label>
		      </div>
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-12">Technical Data</label><br /><br />
              <div class="col-xs-12">
                <?php
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$initialValue = $how['technical'];
				$code = $CKEditor->editor("technical", $initialValue);
				?>
				
				<label class="control-label" style="width: 130px;">
				  <input type="checkbox" name="custom_lang_default_technical" id="id_custom_lang_default_technical_<?php echo $page_type['type_id'];?>" style="margin-right:5px;" onclick="checkDefaults('description', <?php echo $page_type['type_id'];?>)" <?php if($how['technical'] == "default"){ echo "checked";}?>> Use default value
				</label>
              </div>
            </li>
            
          </ul>
        </div>
      </div><!--box-->
      
      <div class="box row hidden">
        <div class="desc col-xs-3">
          <h3>SEO</h3>
          <p>Data for Search Engine Optimization.</p>
        </div>
        
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row">
              <label for="page-title" class="col-xs-3 control-label">Page Title</label>
              <div class="col-xs-9"> 
                <input type="text" class="form-control" id="page-title" name="page-title">
              </div>
            </li>
            
            <li class="form-group row">
              <label for="page-description" class="col-xs-3 control-label">Page Description</label>
              <div class="col-xs-9"> 
                <input type="text" class="form-control" id="page-description" name="page-description">
              </div>
            </li>
            
            <li class="form-group row">
              <label class="col-xs-3 control-label" for="url-handle">URL &amp; Handle</label>
              <div class="col-xs-9">
                <table>
                  <tbody>
                    <tr>
                      <td><div class="form-url">http://sitename.com/products/</div></td>
                      <td width="100%"><div style="margin: -1px"><input type="text" class="form-control url" id="product_alias" name="product_alias" placeholder="your-product-name" onchange="forceAlias()" value="<?php echo $_REQUEST['product_alias'];?>"></div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </li>
            
          </ul>
        </div>
      </div>
      
    </div><!--main-content-->
    
  </form>

<script>
$('#id_custom_select_lang option[value="<?php echo $_SESSION['lang_admin'];?>"]').attr('selected', true);

function checkDefault(i){
   var def_val = $('#id_normalization_'+i).val();
   
   if($('#id_custom_lang_default_'+i).is(':checked')){
	  $('#value_'+i).val('default');
   }else{
	  $('#value_'+i).val(def_val);
   }
							   
}

function uncheckDefault(i){
   var value = $('#value_'+i).val();
   
   if(value != "default"){
      $('#id_custom_lang_default_'+i).removeAttr('checked');
   }else{
      $('#id_custom_lang_default_'+i).attr('checked', true);
   }
							   
}

function checkDefaults(i,x){
   var def_val = $('#id_normalization_'+i+'_'+x).val();
   
   if($('#id_custom_lang_default_'+i+'_'+x).is(':checked')){
	  $('#value_'+i+'_'+x).val('default');
   }else{
	  $('#value_'+i+'_'+x).val(def_val);
   }
							   
}

function uncheckDefaults(i,x){
   var value = $('#value_'+i+'_'+x).val();
   
   if(value != "default"){
      $('#id_custom_lang_default_'+i+'_'+x).removeAttr('checked');
   }else{
      $('#id_custom_lang_default_'+i+'_'+x).attr('checked', true);
   }
							   
}

<?php
if($count_product_lang['rows'] = 0 || empty($product_lang['product_name']) || $product_lang['product_name'] == "default"){
?>
$('#id_custom_lang_default_name').attr('checked', true);   
<?php
}
?>


$.ajax({
   type: "POST",
   url: "custom/products/details/custom.php",
   error: function(jqXHR, textStatus, errorThrown) {
			
          }
}).done(function(msg) {
   $("#custom").html(msg);
   $('#id_filter_container').addClass('hidden');
   $('#id_color_container').addClass('hidden');
});

//getAliasCustom('<?php echo $pre_product_alias;?>');
</script>