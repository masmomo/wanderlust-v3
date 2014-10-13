<?php
include("get.php");
include("update.php");
include("control.php");

$_SESSION['lang_admin'] = $_REQUEST['lang'];
?>

          <form method="post" enctype="multipart/form-data">

            <div class="sub-header clearfix">
                <div class="content">
                  
                    <!--custom-->
                    <?php
				    include("select.php");
				    ?>
                  
                    <h2>Manage News Categories</h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn green main hidden" value="Add Category" onClick="addPop()">
                    </div>
                </div>
            </div>

            <div id="main-content">
            
            <?php
            if(!empty($_SESSION['alert'])){
			?>
            <div class="alert-message <?php echo $_SESSION['alert']?>"><?php echo $_SESSION['msg'];?></div>
            <?php
			}
			?>

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
                                            <p>of <strong><?php echo $total_page;?></strong> pages</p>
                                        </div>
                                        <div class="divider" style="margin-left: 10px"></div>
                                        <div class="page">
                                            <p>Show</p>
                                            <select class="input-select" name="query_per_page" id="query_per_page_input" onchange="changeQueryPerPage()">
                                                <option value="25"<?php if($query_per_page =="25"){ echo "selected=\"selected\"";}?>>25</option>
                                                <option value="50" <?php if($query_per_page == "50"){ echo "selected=\"selected\"";}?>>50</option>
                                                <option value="100" <?php if($query_per_page == "100"){ echo "selected=\"selected\"";}?>>100</option>
                                            </select>
                                            <p>of <strong><?php echo $total_query;?></strong> records</p>
                                        </div>
                                    </div>
                                    <div class="fr">
                                        <p>Actions</p>
                                        <select class="input-select" name="category_listing_action" id="news-action" onchange="changeOption()">
                                            <option value="delete">Delete</option>
                                        </select>
                                        <p id="lbl-news-option" class="hidden">to</p>
                                        <select class="input-select hidden" name="category_listing_option" id="news-option">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        <input type="submit" class="btn green main go" value="GO" name="btn_pop_category">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="headings">
                                <th width="20"></th>
                                <th class="sort" width="680" onclick="sortBy('category_name')">Category Name<?php echo $arr_category_name;?>
                                </th>
                                <th class="sort" width="70"  onclick="sortBy('total_news')">News</th>
                                <th class="sort" width="130" onclick="sortBy('category_active')">Status <?php echo $arr_category_active;?></th>
                                <th class="sort" width="60"  onclick="sortBy('category_visibility')">Visibility<?php echo $arr_category_visibility;?></th>
                            </tr>
                            <tr class="filter">
                                <th><input type="button" class="btn small reset <?php echo $reset?>" value="" onclick="resetSort()"></th>
                                <th><input type="text" class="input-text" id="category_name_search" onkeyup="searchQuery('category_name')" onkeypress="return disableEnterKey(event)"></th>
                                <th><input type="text" class="input-text" disabled="disabled"></th>
                                <th>
                                    <select class="input-select" name="category_active" id="category_active_search" onchange="searchQueryOption('category_active')">
                                        <option></option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="input-select" name="category_visibility" id="category_visibility_search" onchange="searchQueryOption('category_visibility')">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                        <tbody onload="loading()" id="checkbox">
                        <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                            <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                        
                        <?php
						$row = 0;
                        foreach($list_category as $list_category){
						   $row++;
						?>
                        
                            <tr class="" id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                                <td><input type="checkbox" name="cat_id[]" id="<?php echo "check_".$row?>" value="<?php echo $list_category['category_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                                <td><a href="#" id="category_listing_<?php echo $list_category['category_id'];?>" onclick="editCategory('<?php echo $list_category['category_id'];?>')"><?php echo $list_category['category_name'];?></a></td>
                                <td class="tr"><a href=""><?php echo $list_category['total_news'];?></a></td>
                                <td id="cat_active_stat_<?php echo $list_category['category_id'];?>"><?php echo ucwords(strtolower($list_category['category_active']));?></td>
                                <td id="cat_visible_stat_<?php echo $list_category['category_id'];?>"><?php echo ucwords(strtolower($list_category['category_visibility']));?></td>
                            </tr>
                            
                         <?php }?>
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->
            
          </form>
          
          

<?php
if($_POST['btn_pop_category_lang'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>

        
<script>
$("#pop-category").hide();
$("#btn-delete").hide();

function resetSort(){
   location.href = "http://<?php echo $_SERVER['HTTP_HOST'],get_dirname($_SERVER['PHP_SELF'])."/news-category"?>";
}
		
function addPop(){
   $("#pop-category").fadeIn("fast");
   $("#pop-title").text("Add Category");
   $("#news-category-active-status").attr('checked', 'checked');
   $("#news-category-visible-status").attr('checked','checked');
}

function closePop(){
   $("#pop-category").fadeOut("fast");
   $("#pop-title").val('');
   $("#btn-delete").hide();
   
   $("#category-id").val('');
   $("#news-category-active-status").attr('checked', 'checked');
   $("#news-category-visible-status").attr('checked', 'checked');
   $("#cat-pop-name").val('');
   
   $('#checkbox').find(':checked').each(function() {
      $(this).removeAttr('checked');
   });
   
}

function editCategory(i){
   $("#pop-category").fadeIn("fast");
   $("#pop-title").text("Edit Category");
   $("#btn-delete").fadeIn("fast");
   
   var cat_id  = i;
   var active  = $("#cat_active_stat_"+i).text();
   var visible = $("#cat_visible_stat_"+i).text();
   var name    = $("#category_listing_"+i).text();
   
   $("#category-id").val(cat_id);
   
   if(active == "Active"){
      $("#news-category-active-status").attr('checked', 'checked');
   }else{
      $("#news-category-inactive-status").attr('checked', 'checked');
   }
   
   if(visible == "Yes"){
      $("#news-category-visible-status").attr('checked', 'checked');
   }else{
      $("#news-category-invisible-status").attr('checked', 'checked');
   }
   
   $("#cat-pop-name").val(name);
}

$('#category_active_search option[value=<?php echo $search_value?>]').attr('selected','selected');
$('#category_visibility_search option[value=<?php echo $search_value?>]').attr('selected','selected');
									
									function changeOption(){
									   var action = $('#news-action option:selected').val();
									   
									   if(action == "delete"){
									      $('#news-option').addClass("hidden");
										  $('#lbl-news-option').addClass("hidden");
									   }else{
									      $('#news-option').removeClass("hidden");
									      $('#lbl-news-option').removeClass("hidden");
									   }
									   
									}
									</script>