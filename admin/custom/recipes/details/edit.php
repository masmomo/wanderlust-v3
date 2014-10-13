<?php
include("get.php");
include("update.php");
include("control.php");
include("ajax.php");

//var_dump($_POST);
?>

<form method="post" enctype="multipart/form-data">

            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Edit Recipe</h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn grey main" value="Cancel" onclick="cancelEdit()">
                        <input type="submit" class="btn green main" value="Save Changes" name="btn-edit-recipes">
                        <input type="submit" class="btn green main" value="Save Changes &amp; Exit" name="btn-index-recipes">
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
                        <h3>Recipe Details</h3>
                        <p>Manage your recipe details from title, category, date, ingredients, sauce ingredients, and methods.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field field-select">
                            
                                <input type="hidden" name="recipe_id" value="<?php echo $recipeDetails['recipe_id']?>">
                            
                                <label for="category">Category <span>*</span></label>
                                <select class="input-select" id="category" name="category">
                                    <option selected value="xxxx"></option>
                                    <?php
                                    foreach($recipe_category as $category){
									   echo "<option value=\"".$category['category_id']."\">".ucwords(strtolower($category['category_name']))."</option>";
									}
									?>
                                </select>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <label>Title <span>*</span></label>
                                <input type="text" class="input-text" name="recipe_name" value="<?php echo $recipeDetails['recipe_name'];?>">
                            </li>
                            <li class="field">
                                <label>Date <span>*</span></label>
                                <input type="text" id="datepicker" class="input-text" style="width: 300px" name="recipe_date" value="<?php echo $recipeDetails['recipe_date'];?>">
                            </li>
                            <li class="field input-file clearfix">
                                <label>Main Image</label>
                                <div class="clearfix" style="width: 550px; padding-bottom: 8px">
                                    <div class="fl image" style="width: 174px; height: 116px" onMouseOver="removeButton('1')" id="recipes-1">
                                        <div class="" id="remove-recipes-1">
                                           <div class="image-delete" id="btn-recipes-1" onClick="clearImage('1')"></div>
                                           <div class="image-overlay" onClick="openBrowser('1')"></div>
                                        </div>
                                        <img class="" src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/../".$recipeDetails['recipe_image']?>" id="upload-recipes-1">
                                        <input type="file" name="upload_recipes_1" id="recipes-file-1" onchange="readURL(this,'1')" class="hidden"/>
                                          
                                        <input type="hidden" name="recipes_images" id="recipes-flag">
                                        <input type="hidden" name="recipes_unlink" id="recipes-unlink" value="<?php echo $recipeDetails['recipe_image']?>"> 
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 10px">Recommended dimensions of 400 x 267 px.</p>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <label>Ingredients</label>
                                <textarea rows="8" name="recipe_ingredients"><?php echo $recipeDetails['recipe_ingredients'];?></textarea>
                            </li>
                            <li class="field">
                                <label>Sauce Ingredients</label>
                                <textarea rows="8" name="recipe_sauce"><?php echo $recipeDetails['recipe_sauce'];?></textarea>
                            </li>
                            <li class="field">
                                <label>Methods</label>
                                <textarea rows="8" name="recipe_method"><?php echo $recipeDetails['method'];?></textarea>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->
            
            
</form>
            
<script>
$('#category option[value=<?php echo $recipeDetails['category_recipes']?>]').attr('selected', 'selected');
 
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
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-detail/".$request_recipe_name;?>";
}
</script>

<?php
   $sql   = "UPDATE tbl_recipes SET `category_recipes` = '$post_category_recipes',
                                    `recipe_name` = '$post_recipe_name',
									`recipe_image` = '$post_recipe_image',
									`recipe_date` = '$post_recipe_date',
									`recipe_ingredients` = '$post_recipe_ingredients',
									`recipe_sauce` = '$post_recipe_sauce',
									`method` = '$post_recipe_method',
									`alias` = '$post_recipe_alias',
									`visibility_status` = '$post_recipe_visibility',
									`additional` = '$post_recipe_additional'
			 WHERE `recipe_id` = '$post_recipe_id'";
			 
			 echo $sql;
?>

            