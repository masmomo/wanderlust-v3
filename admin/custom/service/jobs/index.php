<?php
include('get.php');
include('update.php');
include('control.php');
?>


          <form method="post">
            <div class="subnav clearfix">
              <div class="container clearfix">
                <h1><span class="glyphicon glyphicon-list"></span> &nbsp; Service</h1>
                <select class="form-control" id="category_name_search" onchange="selectCategory()" style="width:125px;">
                  <option value="all">All City</option>
                  
				  <?php
                  foreach($category as $category){
				     echo '<option value="'.$category['category_name'].'">'.$category['category_name'].'</option>';
				  }
				  ?>
                  
                </select>
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url."add-service"?>">
                    <input type="button" class="btn btn-success btn-sm" value="Add Store">
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
			
			if($_POST['btn_index_service_job'] == ''){
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
                     <input type="submit" class="btn btn-success pull-left" value="GO" name="btn_index_service_job">
                   </div>
                 </div><!--actions-->
                 
                 <table class="table">
                   <thead>
                     <tr class="headings">
                       <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open" onclick="showEye()"></span></th>
                       <th class="sort" width="85%" onclick="sortBy('career_name')">Store Name<?php echo $arr_order_number;?></th>
                       <!--<th class="sort" width="10%" onclick="sortBy('total_product')">Jobs</th>-->
                       <th class="sort" width="10%">City</th>
                       <th class="sort" width="5%" onclick="sortBy('visibility')">Visibility</th>
                     </tr>
                     
                     <tr class="filter hidden" id="filter">
                       <th>
                         <a href="<?php echo $prefix_url."service-view"?>">
                           <button type="button" style="width: 100%;" class="btn btn-danger btn-xs <?php echo $reset;?>">
                             <span class="glyphicon glyphicon-remove"></span>
                           </button>
                         </a>
                       </th>
                       <th>
                         <input type="text" class="form-control" id="career_name_search" onkeyup="searchQuery('career_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "career_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>>
                       </th>
                       <th>
                         <input type="text" class="form-control" id="total_product_search" onkeyup="searchQuery('total_product')" onkeypress="return disableEnterKey(event)" disabled="disabled">
                       </th>
                       <th>
                         <select class="form-control" name="visibility" id="visibility_search" onchange="searchQueryOption('visibility')" <?php if($_REQUEST['src'] != "visibility" and !empty($_REQUEST['src'])){ echo "disabled";}?> disabled="disabled">
                           <option value="1">Yes</option>
                           <option value="0">No</option>
                         </select>
                       </th>
                     </tr>
                   </thead>
                   
                   <tbody>
                     
					 <?php 
				     if($total_query < 1){
				        echo '<tr><td class="no-record" colspan="8">No records found.</td></tr>';
				     }
				   
				     $row = 0;
				     foreach($listing_order as $all_category){
				        $row++;
					  
					    // CALL FUNCTION
					    $detail = get_detail($all_category['career_id']);
					 ?>
                     
                     <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                     <td>
                       <input type="checkbox" name="category_id[]" value="<?php echo $all_category['career_id'];?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')">
                     </td>
                     <td>
					   <a href="<?php echo $prefix_url.'service-detail/'.$all_category['career_id'].'/'.cleanurl($all_category['career_name']);?>">
                         <?php echo $all_category['career_name'];?>
                       </a>
                     </td>
                     <td><?php echo $all_category['category_name'];?></td>
                     <td>
                     
					   <?php 
					   if($detail['visibility'] == 1){ 
					      echo "Yes";
					   }else if($detail['visibility'] == 0){ 
					      echo "No";
					   }
					   ?>
                       
                     </td>
                   </tr>
                   
				   <?php 
				   }
				   ?>
                   
                 </tbody>
               </table>
               
                </div><!--.table-->

              </div><!--.content-->
            </div><!--.box.row-->

          </div><!--.container.main-->
          
        </form>
          
          
          
<script>
function selectDepartment(x){
   var dept = x;
   
   $('#category_name_search option[value="'+x+'"]').attr('selected',true);
}


function selectFilterVisibility(x){
   $('#visibility_search option[value="'+x+'"]').attr('selected', true);
}


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


$(document).ready(function(e) {
   selectDepartment('<?php echo $_REQUEST['cat'];?>');
   selectFilterVisibility('<?php echo $_REQUEST['srcval'];?>');
});
</script>