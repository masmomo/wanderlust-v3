<?php
include("get.php");
include("update.php");
include("control.php");
include("ajax.php");
?>

<form method="post" enctype="multipart/form-data">


        <div class="" id="pop-add">
            <div class="overlay over-category">
                <div class="header">
                        <h2>Edit Category</h2> 
                        <div class="btn-placeholder">
                            <input type="button" class="btn grey main" value="Cancel" onClick="closePop()">
                            <input type="submit" class="btn red main" value="Delete" name="btn-add-recipe">
                            <input type="submit" class="btn green main" value="Save Changes" name="btn-add-recipe" id="save-changes">
                        </div>
                    </div>
                <div class="content">
                    <ul class="field-set">
                        <li class="field">
                        
                            <input type="hidden" name="category_id" id="category-id-edited">
                        
                            <label for="xxxx" class="">Change status</label>
                            <input type="radio" class="input-radio" value="Active" name="category_active" id="category_active" />&nbsp; Active
                            <input type="radio" class="input-radio" value="Inactive" name="category_active" id="category_inactive" />&nbsp; Inactive
                        </li>
                        <li class="field">
                            <label for="xxxx">Visibility</label>
                            <input type="radio" class="input-radio" value="Visible" name="category_visibility" id="category_visible" />&nbsp; Yes
                            <input type="radio" class="input-radio" value="Invisible" name="category_visibility" id="category_invisible" />&nbsp; No
                        </li>
                        <li class="field">
                            <label for="xxxx">Root category</label>
                            <select class="input-select">
                                <option disabled>Root</option>
                            </select> 
                        </li>
                        <li class="field clearfix">
                            <label>Category name</label>
                            <input type="text" class="input-text" name="category_name" id="category-name-edited">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="overlay_bg70" onClick="closePop()"></div>
        </div>

            <div class="sub-header clearfix">
                <div class="content">
                    <!-- POST-->
                    <?php if(!empty($action)){?>
                       <!--<div class="alert-message success" id="alert"><?php echo $msg;?></div>-->
                       <script>
                       $('#alert').slideDown("fast").delay(3000).slideUp("slow");
                       </script>
					<?php }?>
                    
                    
                    
                    <h2>Manage Categories</h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn green main" value="Add Category" onClick="popAdd()">
                    </div>
                </div>
            </div>

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
                                        <input type="submit" class="btn green main go" value="GO" name="btn-add-recipe" id="GO">
                                        
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="headings">
                                <th width="20"></th>
                                <th class="sort" width="650" onclick="sortBy('category_name')">Category Name<?php echo $arr_category_name;?></th>
                                <th class="sort" width="100" onclick="sortBy('total_recipes')">Recipes<?php echo $arr_total_recipes;?></th>
                                <th class="sort" width="130" onclick="sortBy('category_active')">Status<?php echo $arr_category_active;?></th>
                                <th class="sort" width="60" onclick="sortBy('category_visibility')">Visibility<?php echo $arr_category_visibility;?></th>
                            </tr>
                            <tr class="filter">
                                <th><input type="button" class="btn small reset" value="" onclick="resetSearch()"></th>
                                <th><input type="text" class="input-text" id="category_name_search" onkeyup="searchQuery('category_name')" onkeypress="return disableEnterKey(event)"></th>
                                <th><input type="text" class="input-text" id="total_recipes_search" onkeyup="searchQuery('total_recipes')" onkeypress="return disableEnterKey(event)"></th>
                                <th>
                                    <select class="input-select" id="category_active_search" onchange="searchQueryOption('category_active')">
                                        <option></option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="input-select" id="category_visibility_search" onchange="searchQueryOption('category_visibility')">
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
							foreach($listing_category as $category){
							   $row++;
							?>
                            <input type="hidden" id="category-id-edited-<?php echo $row;?>" value="<?php echo $category['category_id']?>">
                            <input type="hidden" id="category-active-edited-<?php echo $row;?>" value="<?php echo $category['category_active']?>">
                            <input type="hidden" id="category-visibility-edited-<?php echo $row;?>" value="<?php echo $category['category_visibility']?>">
                            <input type="hidden" id="category-name-edited-<?php echo $row;?>" value="<?php echo $category['category_name']?>">
                            
                            <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                                <td><input type="checkbox" name="array_category_id[]" id="<?php echo "check_".$row?>" value="<?php echo $category['category_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                                <td><a href="#" onclick="editPop(<?php echo $row;?>)"><?php echo $category['category_name']?></a></td>
                                <td class="tr"><a href="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])?>/recipe/detail"><?php echo $category['total_recipes']?></a></td>
                                <td><?php echo $category['category_active']?></td>
                                <td><?php echo $category['category_visibility']?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->
            
<script>
$('#pop-add').hide();

function popAdd(){
   $('#pop-add').fadeIn('fast');
   $('#category_active').attr('checked', 'checked');
   $('#category_visible').attr('checked', 'checked');
}
			
function closePop(){
   $('#pop-add').fadeOut('fast');
}

function editPop(i){
   $('#pop-add').fadeIn("fast");
   
   var categoryID = $('#category-id-edited-'+i).val();
   var active     = $('#category-active-edited-'+i).val();
   var visibility = $('#category-visibility-edited-'+i).val();
   var name       = $('#category-name-edited-'+i).val();
   
   $('#category-id-edited').val(categoryID);
   if(active == "Active" || active =="active"){
      $('#category_active').attr('checked', 'checked');
   }else if(active == "Inactive" || active == "inactive"){
      $('#category_inactive').attr('checked', 'checked');
   }
   if(visibility == "Visible" || visibility =="visible"){
      $('#category_visible').attr('checked', 'checked');
   }else if(visibility == "Invisible" || visibility == "invisible"){
      $('#category_invisible').attr('checked', 'checked');
   }
   $('#category-name-edited').val(name);
}

$('#page-option option[value=<?php echo $page?>]').attr('selected', 'selected');
$('#category_active_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');
$('#category_visibility_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');

function resetSearch(){
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])?>/recipe-category";
}
</script>
            
</form>

            