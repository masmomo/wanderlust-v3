<?php
include("control.php");
include("ajax.php");
?>

<form method="post" enctype="multipart/form-data">

            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Edit Recipe</h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn grey main" value="Cancel" onclick="cancelEdit()">
                        <input type="submit" class="btn green main" value="Save Changes" name="custom_btn_edit_recipes">
                        <input type="submit" class="btn green main" value="Save Changes &amp; Exit" name="custom_btn_edit_recipes">
                    </div>
                </div>
            </div>

            <div class="info-header">
                <div class="content">
                    Edit Mode
                </div>
            </div>

            <div id="main-content">

                <div class="box clearfix">
                    <div class="desc">
                       
                       <!--custom-->
                       <?php
					   include("select_edit.php");
					   ?>
                       
                        <h3>Recipe Details</h3>
                        <p>Manage your recipe details from title, category, date, ingredients, sauce ingredients, and methods.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field field-select">
                            
                                <input type="hidden" name="recipe_id" value="<?php echo $value['recipe_id'];?>">
                            
                                <label for="category">Category<span>*</span></label>
                                <input type="text" class="input-text" name="category" disabled="disabled" value="<?php echo $recipe_category['category_name'];?>">
                                <!--
                                <select class="input-select" id="category" name="category" disabled>
                                    <option selected value="xxxx"></option>
                                    <?php
                                    //foreach($recipe_category as $category){
									   //echo "<option value=\"".$category['category_id']."\">".ucwords(strtolower($category['category_name']))."</option>";
									//}
									?>
                                </select>
                                -->
                            </li>
                            <li class="field-divider"></li>
                            <li class="field  clearfix">
                                <label>Title <span>*</span></label>
                                <input type="text" class="input-text" name="recipe_name" value="<?php echo $value['recipe_name'];?>" id="value_name" onkeyup="uncheckDefault('name')">
                                <input type="text" class="hidden" id="id_normalization_name" value="<?php echo $value['recipe_name'];?>">
                                <label class="check" style="width: 130px; margin-left: 138px;">
                                   <input type="checkbox" name="custom_lang_default_name" id="id_custom_lang_default_name" style="margin-right:5px;" onclick="checkDefault('name')" <?php if($value['recipe_name'] == "default"){ echo "checked";}?>> Use default value
                                </label>
                            </li>           
                            
                            <li class="field">
                                <label>Date <span>*</span></label>
                                <input type="text" id="datepicker" class="input-text" style="width: 300px" name="recipe_date" value="<?php echo $value['recipe_date'];?>" disabled>
                            </li>
                            <li class="field input-file clearfix">
                                <label>Main Image</label>
                                <div class="clearfix" style="width: 550px; padding-bottom: 8px">
                                    <div class="fl image" style="width: 174px; height: 116px">
                                        <img class="" src="<?php echo $prefix_url."static/thimthumb.php?src=../".$value['recipe_image']."&h=116&w=174&q=100";?>" id="upload-recipes-1">
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 10px">Recommended dimensions of 400 x 267 px.</p>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <label>Ingredients</label>
                                <textarea rows="8" name="recipe_ingredients" id="value_ingredients" onkeyup="uncheckDefault('ingredients')"><?php echo $value['recipe_ingredients'];?></textarea>
                                <textarea rows="8" id="id_normalization_ingredients" class="hidden"><?php echo $value['recipe_ingredients'];?></textarea>
                                <label class="check" style="width: 130px; margin-left: 138px; margin-bottom:20px; float:none;">
                                   <input type="checkbox" name="custom_lang_default_ingredients" id="id_custom_lang_default_ingredients" style="margin-right:5px;" onclick="checkDefault('ingredients')"> Use default value
                                </label>
                            </li>
                            <li class="field">
                                <label>Sauce Ingredients</label>
                                <textarea rows="8" name="recipe_sauce" id="value_sauce" onkeyup="uncheckDefault('sauce')"><?php echo $value['recipe_sauce'];?></textarea>
                                <textarea rows="8" id="id_normalization_recipe" class="hidden"><?php echo $value['recipe_sauce'];?></textarea>
                                <label class="check" style="width: 130px; margin-left: 138px; margin-bottom:20px; float:none;">
                                   <input type="checkbox" name="custom_lang_default_sauce" id="id_custom_lang_default_sauce" style="margin-right:5px;" onclick="checkDefault('sauce')"> Use default value
                                </label>
                            </li>
                            <li class="field">
                                <label>Methods</label>
                                <textarea rows="8" name="recipe_method" id="value_method" onkeyup="uncheckDefault('method')"><?php echo $value['method'];?></textarea>
                                <textarea rows="8" id="id_normalization_method" class="hidden"><?php echo $value['method'];?></textarea>
                                <label class="check" style="width: 130px; margin-left: 138px; margin-bottom:20px;">
                                   <input type="checkbox" name="custom_lang_default_method" style="margin-right:5px;" id="id_custom_lang_default_method" onclick="checkDefault('method')"> Use default value
                                </label>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->
            
            
</form>


            
<script>
$('#category option[value=<?php echo $value['category_recipes']?>]').attr('selected', 'selected');
 
$(function() {
   $("#datepicker").datepicker({
	   altField:'#datepicker',
	   altFormat: "yy-mm-dd"
   });
});



function readURL(input,i) {
   
   if (input.files && input.files[0]) {
      var reader = new FileReader();
	  reader.onload = function (e) {
	     $("#upload-recipes-"+i).removeClass("hidden");
		 $("#upload-recipes-"+i).attr('src', e.target.result);
		 $('#recipes-flag').val('filled');
	  }
	  
	  reader.readAsDataURL(input.files[0]);
   }
	  
}

function openBrowser(i){
   document.getElementById("recipes-file-"+i).click();
}

function removeButton(i){
   $("#remove-recipes-"+i).removeClass("hidden");
   $("#remove-recipes-"+i).fadeIn("fast");
   $("#btn-news-"+i).attr('style','z-index:1000; position:absolute');
	  
   $("#recipes-"+i).mouseleave(function(){
      $("#remove-recipes-"+i).fadeOut("fast");
   });
}

function clearImage(i){
   $("#upload-recipes-"+i).attr('src', '');
   $("#upload-recipes-"+i).addClass("hidden");
   $('#custom-recipe').html('<input type="file" name="upload_news_1" id="news-1" onchange="readURL(this,1)" class="hidden"/>');
   $("#recipes-flag").val('');
}

function cancelEdit(){
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$_REQUEST['lang']."-recipe-detail/".$recipe_alias;?>";
}

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
</script>
            