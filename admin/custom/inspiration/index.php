<?php
include("get.php");
include("update.php");
include("control.php");
?>

          <form name="index-order" method="post" enctype="multipart/form-data">
            
            <div class="subnav">
              <div class="container clearfix">
                <h1><span class="glyphicon glyphicon-list"></span> &nbsp; Manage Project</h1>
                <select class="form-control" id="category_name_search" onchange="selectCategory()" style="width: 150px;">
                  <option value="top">All Category</option>
                  
                  <?php
                  foreach($category as $get_category){
				     echo '<option value="'.$get_category['category_id'].'">'.$get_category['name'].'</option>';
				  }
				  ?>
                  
                </select>
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url."add-project";?>">
                    <input type="button" class="btn btn-success btn-sm" value="Add Project">
                  </a>
                </div>
              </div>
            </div><!--subnav-->

            <?php 
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '<div class="container">'.$_SESSION['msg'].'</div>';
			   echo '</div>';
			}
			
			if($_POST['btn_index_inspiration'] == ''){
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
                    <input type="submit" class="btn btn-success pull-left" value="GO" name="btn_index_inspiration">
                  </div>
                </div><!--actions-->
                
                <table cellpadding="0" cellspacing="0" class="table">
                  <thead>
                    <tr class="headings">
                      <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open" onclick="showEye()"></span></th>
                      <th class="sort" width="600" onclick="sortBy('name')">Name <?php echo $arr_name;?></th>
                      <th class="sort" width="150" onclick="sortBy('date_created')">Date Created <?php echo $arr_date_created;?></th>
                      <th class="sort hidden" width="130" onclick="sortBy('category_active_status')">Status <?php echo $arr_active;?></th>
                      <th class="sort" width="60" onclick="sortBy('inspiration_visibility')">Visibility <?php echo $arr_visibility;?></th>
                    </tr>
                    <tr class="filter hidden" id="filter">
                      <th>
                        <a href="<?php echo $prefix_url.'project';?>">
                          <button type="button" style="width: 100%;" class="btn btn-danger btn-xs <?php echo $reset;?>">
                            <span class="glyphicon glyphicon-remove"></span>
                          </button>
                        </a>
                      </th>
                      <th><input type="text" class="form-control" id="name_search" name="name" onkeyup="searchQuery('name')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], 'name');?>></th>
                      <th><input type="text" class="form-control" id="date_created_search" name="date_created" onkeyup="searchQuery('date_created')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], 'date_created');?>></th>
                      
                      <th class=" hidden">
                        <select class="form-control" id="active_search" onchange="searchQueryOption('active')" <?php order_disabling_search($_REQUEST['src'], 'active');?>>
                          <option></option>
                          <option value="1">Active</option>
                          <option  value="0">Inactive</option>
                        </select>
                      </th>
                      <th>
                        <select class="form-control" id="inspiration_visibility_search" onchange="searchQueryOption('inspiration_visibility')" <?php order_disabling_search($_REQUEST['src'], 'inspiration_visibility');?>>
                          <option></option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                        </select>
                      </th>
                    </tr>
                  </thead>
                  
                  <tbody onload="loading()">
                    <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                    
					<?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                    
					<?php
					$row=0;
					foreach($data as $inspiration){
					   $loop_data = get_inspiration($inspiration['inspiration_id']);
					?>
                    
                    <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                      <td width="38"><input type="checkbox" value="<?php echo $inspiration['inspiration_id']?>" name="inspiration_id[]" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                      <td width="652"><a href="<?php echo $prefix_url."project-detail/".$inspiration['inspiration_id'];?>"><?php echo $inspiration['name'];?></a></td>
                      <td width="135"><?php echo format_date($inspiration['date_created']);?></td>
                      <td width="135" class="hidden"><?php echo view_status('active', $loop_data['active']);?></td>
                      <td width="135"><?php echo view_status('inspiration_visibility', $loop_data['inspiration_visibility']);?></td>
                    </tr>
                    
					<?php
					   $row++;
					}
					?>
                    
                  </tbody>
                </table>
              
              </div><!--.content-->
            </div><!--.box-->
          </div><!--.container.main-->
            
            
            
</form>
<!-- END FORM -->
            
<script>
function changeAction(){
	  var action_ = document.getElementById('product-index-action').value;
		 	
	  if (action_=='delete'){
		 $("#product-index-option").addClass('hidden');
		 $("#product-index-conj").addClass('hidden');
	  }
	  else{
		 $("#product-index-option").removeClass('hidden');
		 $("#product-index-conj").removeClass('hidden');
	  }
}


function listingOption(){
   var option = $('#id_select_action option:selected').val();
   var action = $('#id_select_option option:selected').val();
   //var to     = $('#id_to')
   
   if(option == "delete"){
      $('#id_to').addClass("hidden");
	  $('#id_select_option option[value="yes"]').attr('selected', true);
	  $('#id_select_option').addClass("hidden");
   }else{
      $('#id_to').removeClass("hidden");
	  $('#id_select_option').removeClass("hidden");
   }
   
}

$(function() {
   $("#date_created_search").datepicker({
      altField:'#date_created_search',
	  altFormat: "yy/mm/dd",
	  onSelect: function () {
	     document.all ? $(this).get(0).fireEvent("onchange") : $(this).change();
         searchQueryOption('date_created');
		 //$('#id_hidden_date_from').val('filled');
      },
   });
});

<?php
// CALL FUNCTION
if(!empty($_REQUEST['srcval']) && $_REQUEST['src'] == "active" || $_REQUEST['src'] == "visibility"){
?>

// Select Option
function selectOption(i){
   $('#'+i+'_search option[value="<?php echo $_REQUEST['srcval'];?>"]').attr('selected', true);
}

selectOption('<?php echo $_REQUEST['src']?>');
<?php
}
?>

function selectCategories(x){
   $('#category_name_search option[value="'+x+'"]').attr('selected', true);
}


$(document).ready(function(e) {
   selectCategories(<?php echo $_REQUEST['cat'];?>);
});
</script>