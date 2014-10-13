<?php
include("control.php");
//include("ajax.php");
?>
<form method="post">
            <div class="sub-header clearfix">
                <div class="content">
                    <h2><?php echo $default_name;?></h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn grey main" value="Cancel" onclick="cancelDetail()">
                        <input type="button" class="btn orange main" value="Edit" onClick="recipeDetail()">
                        <input type="submit" class="btn red main hidden" value="Delete" name="btn-edit-recipes">
                    </div>
                </div>
            </div>

            <div id="main-content">

                <div class="box clearfix">
                    <div class="desc">
                       
                       <!--custom-->
                       <?php
					   include("select.php");
					   ?>
                       
                        <h3>Recipe Details</h3>
                        <p>Manage your recipe details from title, category, date, ingredients, sauce ingredients, and methods.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field field-select">
                                <label for="category">Category <span>*</span></label>
                                <p><?php echo $recipe_category['category_name'];?></p>
                                <select class="hidden input-select" id="category" name="category">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Events</option>
                                    <option value="xxxx">Promotions</option>
                                    <option value="xxxx">Other News</option>
                                </select>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <input type="hidden" name="recipe_id" value="<?php echo $value['recipe_id']?>" />
                                
                                <label>Title <span>*</span></label>
                                <p><?php echo $default_name;?></p>
                                <input type="text" class="hidden input-text">
                            </li>
                            <li class="field">
                                <label>Date <span>*</span></label>
                                <?php $date_server = date('D, j M Y',strtotime($value['recipe_date']));?>
                                <p><!--01/05/2013 00:00 AM--><?php echo $date_server;?></p>
                                <input type="text" class="hidden input-text" style="width: 300px">
                            </li>
                            <li class="field input-file clearfix">
                                <label>Main Image</label>
                                <div class="clearfix" style="width: 550px; padding-bottom: 8px">
                                    <div class="fl image" style="width: 174px; height: 116px">
                                        <div class="hidden"><div class="image-delete"></div><div class="image-overlay"></div></div>
                                        <img class="" src="<?php echo $prefix_url."static/thimthumb.php?src=../".$value['recipe_image']."&h=116&w=174&q=100";?>">
                                    </div>
                                </div>
                                <p class="hidden field-message" style="padding-top: 10px">Recommended dimensions of 400 x 267 px.</p>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <label>Ingredients</label>
                                <p style="padding-left: 138px"><?php echo preg_replace("/\n/","\n<br>",$default_ingredients);?></p>
                                <textarea class="hidden" rows="8"></textarea>
                            </li>
                            <li class="field">
                                <label>Sauce Ingredients</label>
                                <p style="padding-left: 138px"><?php echo preg_replace("/\n/","\n<br>",$default_sauce);?></p>
                                <textarea class="hidden" rows="8"></textarea>
                            </li>
                            <li class="field">
                                <label>Methods</label>
                                <p style="padding-left: 138px"><?php echo preg_replace("/\n/","\n<br>",$default_method);?></p>
                                <textarea class="hidden" rows="8"></textarea>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->
</form>


            
<script>
function cancelDetail(){
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe";?>"
}

function recipeDetail(){
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$_REQUEST['lang']."-recipe-edit/".$recipe_alias;?>"
}
</script>

            