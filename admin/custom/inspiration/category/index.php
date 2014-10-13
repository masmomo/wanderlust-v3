<?php
include("get.php");
include("update.php");
include("control.php");
?>

          <form method="post" enctype="multipart/form-data">

            <div class="subnav">
                <div class="container clearfix">
                    <h1><span class="glyphicon glyphicon-list"></span> &nbsp; Manage Project Categories</h1>
                    <div class="btn-placeholder">
                      <a href="<?php echo $prefix_url.'add-project-category';?>">
                        <input type="button" class="btn btn-success btn-sm" value="Add Category">
                      </a>
                    </div>
                </div>
            </div>

            <?php 
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '<div class="container">'.$_SESSION['msg'].'</div>';
			   echo '</div>';
			}
			
			if($_POST['btn_pop_category'] == ''){
			   unset($_SESSION['alert']);
			   unset($_SESSION['msg']);
			}
			?>

            <div class="container main">

              <div class="box row">
                <div class="content">

                  <div class="actions clearfix">
                    <div class="pull-left">
                      <div class="pull-left custom-select-all" onclick="selectAllToggle()">
                        <input type="checkbox" id="select_all">
                      </div>
                      <div class="divider"></div>
                      <p>Page</p>
                      <select class="form-control" id="page-option" onchange="pageOption()">
                      
                        <?php
                        for($i=1;$i<=$total_page;$i++){
                          echo "<option value=\"".$i."\">".$i."</option> \n";
                        }
                        ?>
                        
                      </select>
                      <p>of <strong><?php echo $total_page;?></strong> pages</p>
                      <div class="divider"></div>
                      <p>Show</p>
                      <select class="form-control" name="query_per_page" id="query_per_page_input" onchange="changeQueryPerPage()">
                        <option value="25"<?php if($query_per_page =="25"){ echo "selected=\"selected\"";}?>>25</option>
                        <option value="50" <?php if($query_per_page == "50"){ echo "selected=\"selected\"";}?>>50</option>
                        <option value="100" <?php if($query_per_page == "100"){ echo "selected=\"selected\"";}?>>100</option>
                      </select>
                      <p>of <strong><?php echo $total_query;?></strong> records</p>
                    </div>
                    <div class="pull-right">
                    <p>Actions</p>
                    <select class="form-control" name="option-action" id="product-index-action" onchange="changeAction()"> 
                      <option value="delete">Delete</option>
                      <option value='visibility'>Set Visibility</option>
                    </select>
                    <p id="product-index-conj" class="hidden">to</p>
                    <select class="form-control hidden" name="option-option" id="product-index-option">
                      <option value="yes">Yes</option>
                      <option value="no">No</option>
                    </select>
                      <input type="submit" class="btn btn-success pull-left" name="btn_pop_category" value="GO">
                    </div>
                  </div><!--actions-->

                    <table class="table">
                      <thead>
                        <tr class="headings">
                          <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open" onclick="showEye()"></span></th>
                          <th class="sort" width="680" onclick="sortBy('category_name')">Category Name<?php echo $arr_category_name;?></th>
                          <th class="sort" width="70">Projects</th>
                          <th class="sort hidden" width="130" onclick="sortBy('category_active')">Status <?php echo $arr_category_active;?></th>
                          <th class="sort" width="60" onclick="sortBy('visibility')">Visibility<?php echo $arr_category_visibility;?></th>
                        </tr>
                        <tr class="filter hidden" id="filter">
                          <th>
                            <a href="<?php echo $prefix_url.'project-category';?>">
                              <button type="button" style="width: 100%;" class="btn btn-danger btn-xs <?php echo $reset;?>">
                                <span class="glyphicon glyphicon-remove"></span>
                              </button>
                            </a>
                          </th>
                          <th><input type="text" class="form-control" id="category_name_search" onkeyup="searchQuery('category_name')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], category_name);?>></th>
                          <th><input type="text" class="form-control" disabled="disabled"></th>
                          <th class="hidden">
                              <select class="form-control">
                                  <option>Active</option>
                                  <option>Inactive</option>
                              </select>
                          </th>
                          <th>
                              <select class="form-control" id="visibility_search" onchange="searchQueryOption('visibility')" <?php order_disabling_search($_REQUEST['src'], category_visibility);?>>
                                  <option value="1">Yes</option>
                                  <option value="0">No</option>
                              </select>
                          </th>
                        </tr>
                      </thead>
                      
                      <tbody onload="loading()" id="checkbox">
                        <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                        <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                        
						<?php
						$row = 0;
						foreach($all_news as $list_category){
						   $row++;
						   
						   if($list_category['visibility'] == 1){
						      $list_category['visibility'] = 'Yes';
						   }else{
						      $list_category['visibility'] = 'No';
						   }
						   
						   // CALL FUNCTION
						   $child = get_inspirations($list_category['category_id']);
						?>
                        
                        <tr class="" id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                          <td><input type="checkbox" name="cat_id[]" id="<?php echo "check_".$row?>" value="<?php echo $list_category['category_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                          <td>
                            <a href="<?php echo $prefix_url.'project-category-detail/'.$list_category['category_id'];?>">
                              <?php echo $list_category['name'];?>
                            </a>
                          </td>
                          <td class="tr">
                            <a href="<?php echo $prefix_url.'view-project/1/'.$list_category['category_id'].'/25/name/-';?>">
							  <?php echo $child['rows'];?>
                            </a>
                          </td>
                          <td class="hidden" id="cat_active_stat_<?php echo $list_category['category_id'];?>"><?php echo $list_category['category_active'];?></td>
                          <td id="cat_visible_stat_<?php echo $list_category['category_id'];?>"><?php echo $list_category['visibility'];?></td>
                        </tr>
                        
						<?php
						}
						?>
                        
                      </tbody>
                    </table><!--</div>table-wrapper-->
                    
                  </div><!--.content-->
                </div><!--.box-->
                
              </div><!--.container.main-->
              
            </form>


        
<script>
function changeAction(){
   var action = $('#product-index-action option:selected').val();
   
   if (action == 'delete'){
      $("#product-index-option").addClass('hidden');
	  $("#product-index-conj").addClass('hidden');
   }else{
	  $("#product-index-option").removeClass('hidden');
	  $("#product-index-conj").removeClass('hidden');
   }
   
}
</script>

            