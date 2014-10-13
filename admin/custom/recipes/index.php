<?php
include("get.php");
include("update.php");
include("control.php");
include("ajax.php");
?>

<form method="post">


            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Manage Recipes <?php echo $date_server;?></h2>
                    <select class="input-select" id="category_name_search" onchange="selectCategory()">
                        <option value="top">All Categories</option>
                        
						<?php foreach($recipe_category as $category){ ?>
                        <option value="<?php echo $category['category_id']?>" <?php if($cat_name == $category['category_id']){echo 'selected="selected"';}?>><?php echo $category['category_name'];?></option>
                       <?php }?>
                    </select>
                    <div class="btn-placeholder">
                        <input type="button" class="btn green main" value="Add Recipe" onClick="addRecipes()">
                    </div>
                </div>
            </div>
            
            <script>
			function addRecipes(){
			   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])?>/add-recipe";
			}
			</script>

            <div id="main-content">

                <div class="table-wrapper">
                    <table cellpadding="0" cellspacing="0" class="actions">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fl">
                                    
                                       <div class="custom-select-all" onclick="selectAllToggle()">
                                          <input type="checkbox" id="select_all">
                                       </div><!--custom-select-all-->
                                       
                                        <div class="divider"></div>
                                        <div class="page">
                                            <p>Page</p>
                                            <select class="input-select" id="page-option" onchange="pageOption()">
                                               
                                               <?php
                                               for($i=1;$i<=$total_page;$i++){
											      echo "<option value=\"".$i."\">".$i."</option> \n";
											   }
											   ?>
                                               
                                            </select>
                                            <p>of <strong><?php echo $total_page?></strong> pages</p>
                                        </div>
                                        <div class="divider" style="margin-left: 10px"></div>
                                        <div class="page">
                                            <p>Show</p>
                                            <select class="input-select" name="query_per_page" id="query_per_page_input" onchange="changeQueryPerPage()">
                                                <option></option>
                                                <option value="25"<?php if($query_per_page =="25"){ echo "selected=\"selected\"";}?>>25</option>
                                                <option value="50" <?php if($query_per_page == "50"){ echo "selected=\"selected\"";}?>>50</option>
                                                <option value="100" <?php if($query_per_page == "100"){ echo "selected=\"selected\"";}?>>100</option>
                                            </select>
                                            <p>of <strong><?php echo $total_query;?></strong> records</p>
                                        </div>
                                    </div>
                                    <div class="fr">
                                        <p>Actions</p>
                                        <select class="input-select" name="listing-option">
                                            <option></option>
                                            <option value="delete">Delete</option>
                                            <option value="save">Save Changes</option>
                                        </select>
                                        <p>to</p>
                                        <select class="input-select" name="listing-action">
                                            <option></option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <input type="submit" class="btn green main go" value="GO" name="btn-add-recipes" id="GO">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="headings">
                                <th width="20"></th>
                                <th class="sort" width="680" onclick="sortBy('recipe_name')">Recipe Title<?php echo $arr_recipe_name;?></th>
                                <th class="sort" width="200" onclick="sortBy('recipe_date')">Date <?php echo $arr_recipe_date;?></th>
                                <th class="sort" width="60" onclick="sortBy('visibility_status')">Visibility <?php echo $arr_recipe_visibility;?></th>
                            </tr>
                            <tr class="filter">
                                <th><input type="button" class="btn small reset" value="" onclick="resetSearch()"></th>
                                <th><input type="text" class="input-text" id="recipe_name_search" onkeyup="searchQuery('recipe_name')" onkeypress="return disableEnterKey(event)"></th>
                                <th><input type="text" class="input-text" id="recipe_date_search" onkeyup="searchQuery('recipe_date')" onkeypress="return disableEnterKey(event)"></th>
                                <th>
                                    <select class="input-select" id="visibility_status_search" onchange="searchQueryOption('visibility_status')">
                                        <option></option>
                                        <option value="Visible">Yes</option>
                                        <option value="Invisible">No</option>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                        <tbody onload="loading()">
                            <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                            <?php 
							$row = 0;
							foreach($index_recipes as $recipe){
							   $row++;
						       $date_server = date('D, j M Y',strtotime($recipe['recipe_date']));
							?>
                            <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                                <td><input type="checkbox" name="array_recipe_id[]" id="<?php echo "check_".$row?>" value="<?php echo $recipe['recipe_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                                <td><a href="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])?>/recipe-detail/<?php echo cleanurl($recipe['alias']);?>"><?php echo $recipe['recipe_name']?></a></td>
                                <td><?php echo $date_server;?></td>
                                <td><?php echo $recipe['visibility_status']?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->
            
</form>
            
<script>
function resetSearch(){
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])?>/recipe";
}
</script>

            