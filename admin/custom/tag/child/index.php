<?php
include("sources/language/products/category/control.php");
?>

<?php
include("get.php");
include("update.php");
include("control.php");
?>

          <form method="post" enctype="multipart/form-data">      

            <div class="subnav clearfix">
              <div class="container clearfix">
                <h1>
                  <span class="glyphicon glyphicon-list"></span> &nbsp; 
                  <a href="<?php echo $prefix_url."category"?>">Color</a> 
                  <span class="info">/</span> <?php echo $parent['category_name'];?>
                </h1>
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url."tag";?>"><input type="button" class="btn btn-default btn-sm" value="Back" id="btn-add-category-cancel"></a>
                  <a href="<?php echo $prefix_url."add-tag"?>"><input type="button" class="btn btn-success btn-sm" value="Add Category" name="btn-index-category" id="btn-add-category"></a>
                </div>
              </div>
            </div>

             <?php 
			 if(!empty($_SESSION['alert'])){
			 ?>
               <div class="alert <?php echo $_SESSION['alert'];?>">
                 <div class="container"><?php echo $_SESSION['msg'];?></div>
               </div>
             <?php 
			 }
             if($_POST['btn_child_category'] == ""){
                $_SESSION['alert'] = "";
                $_SESSION['msg']   = "";
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
                     <select class="form-control" name="category-action" id="news-action" onchange="changeOption()"> 
                       <option value="delete">Delete</option>
                       <option value="order">Set Order</option>
                     </select>
                     <p id="lbl-news-option" class="hidden">to</p>
                     <select class="form-control hidden" name="category-option" id="news-option" disabled="disabled">
                       <option value="yes">Yes</option>
                       <option value="no">No</option>
                     </select>
                     <input type="submit" class="btn btn-success pull-left" value="GO" name="btn_child_category">
                   </div>
                 </div><!--actions-->
                 
                 <table class="table" id="tbl_category">
                   <thead>
                     <tr class="headings">
                       <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open" onclick="showEye()"></span></th>
                       <th class="sort" width="85%" onclick="sortBy('category_name')">Color Name<?php echo $arr_order_number;?></th>
                       <th class="sort" width="10%">Products</th>
                       <!--<th class="sort" width="10%" onclick="sortBy('total_product')">Products</th>-->
                       <!--<th class="sort" width="130" onclick="sortBy('category_active_status')">Status</th>-->
                       <th class="sort" width="5%" onclick="sortBy('category_visibility_status')">Visibility</th>
                     </tr>
                     
                     <tr class="filter hidden" id="filter">
                       <th><a href="<?php echo $prefix_url."child-tag/".$_REQUEST['cid']."/".$_REQUEST['cname'];?>"><button type="button" style="width: 100%;" class="btn btn-danger btn-xs <?php echo $reset;?>"><span class="glyphicon glyphicon-remove"></span></button></a></th>
                       <th><input type="text" class="form-control" id="category_name_search" onkeyup="searchQuery('category_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "category_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
                       <th><input type="text" class="form-control" id="total_product_search" onkeyup="searchQuery('total_product')" onkeypress="return disableEnterKey(event)" disabled="disabled"></th>
                       <!--<th>
                       <select class="form-control" name="category_active_status" id="category_active_status_search" onchange="searchQueryOption('category_active_status')" <?php if($_REQUEST['src'] != "category_active_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                         <option></option>
                         <option value="active">Active</option>
                         <option value="inactive">Inactive</option>
                       </select>
                       </th>-->
                       
                       <th>
                         <select class="form-control" name="category_visibility_status" id="category_visibility_status_search" onchange="searchQueryOption('category_visibility_status')" <?php if($_REQUEST['src'] != "category_visibility_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                           <option></option>
                           <option value="1">Yes</option>
                           <option value="0">No</option>
                         </select>
                       </th>
                     </tr>
                   </thead>
                   
                   <tbody>
                   
				   <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                   <?php
				   // Loop 1
				   $row = 0;
				   foreach($listing_order as $all_category){
				      $row++;
				      $getTotal = count_products($all_category['category_id']);
				   ?>
                      <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                        <td>
                          <input type="checkbox" name="category_id[]" value="<?php echo $all_category['category_id'];?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')">
                        </td>
                        <td>
                          <a href="<?php echo $prefix_url."child-tag/".$all_category['category_id']."/".cleanurl($all_category['category_name']);?>" onclick="freechecked()">
						     <?php for($i=0;$i<$all_category['category_level'];$i++){ echo "-- ";} echo $all_category['category_name'];?></a> &nbsp;
                             
                             <a href="<?php echo $prefix_url."detail-tag/".$all_category['category_id']."/".cleanurl($all_category['category_name']);?>">
                               <span class="glyphicon glyphicon-cog" style="color: #999"></span>
                             </a>
                         </td>
                         <td>
                           <a href="<?php echo $prefix_url."product-view/1/top/25/product_name/product_category-".$all_category['category_id'];?>">
						      <?php echo $getTotal['rows'];?>
                           </a>
                         <td>
						    <?php if($all_category['category_visibility_status'] == 1){ echo "Yes";}else{ echo "No";}?>
                            <?php
                            // ORDER
							echo '<input type="hidden" name="category_order[]" value="'.$all_category['category_order'].'">';
							echo '<input type="hidden" name="hidden_category_id[]" value="'.$all_category['category_id'].'">';
							?>
                         </td>
                       </tr>
                       
                       <input type="hidden" id="listing_category_name_<?php echo $all_category['category_id'];?>" value="<?php echo $all_category['category_name'];?>">
                       <input type="hidden" id="listing_active_<?php echo $all_category['category_id'];?>" value="<?php echo $all_category['category_active_status'];?>">
                       
					   <?php //$root = getParent($all_category['category_id']);?>
                       <input type="hidden" id="listing_option_<?php echo $all_category['category_id'];?>" value="<?php echo $root['category_parent'];?>">
                       <input type="hidden" id="listing_cat_id_<?php echo $all_category['category_id'];?>" value="<?php echo $all_category['category_id'];?>">
                       <input type="hidden" id="listing_visible_<?php echo $all_category['category_id'];?>" value="<?php echo $all_category['category_visibility_status'];?>">
                       <input type="hidden" id="link-category-<?php echo $all_category['category_id'];?>" value="<?php echo $all_category['category_id'];?>">
				   <?php 
				   }
				   ?>
                   </tbody>
                 </table>
               </div><!--.table-->
               
             </div><!--.content-->
           </div><!--.box.row-->
         
         </div><!--.container.main-->
         
		 <?php
		 // INPUT HIDDEN
		 echo '<input type="hidden" name="hidden_category_parent_id" value="'.$_REQUEST['cid'].'">';
		 echo '<input type="hidden" name="hidden_category_parent" value="'.$_REQUEST['cname'].'">';
		 ?>
</form>



<script>
<?php if($search_parameter == "category_visibility_status"){?>
$('#category_visibility_status_search option[value=<?php echo $search_value;?>]').attr('selected', 'selected');
<?php }?>


<?php if($search_parameter == "category_active_status"){?>
$('#category_active_status_search option[value=<?php echo $search_value;?>]').attr('selected', 'selected');
<?php }?>


function changeOption(){
   var action = $('#news-action option:selected').val();
   
   if(action == "delete" || action == ""){
      $('#news-option').addClass("hidden");
	  $('#lbl-news-option').addClass("hidden");
	  $('#news-option').attr('disabled', true);
   }else if(action == "change"){
	  $('#news-option').removeClass("hidden");
	  $('#lbl-news-option').removeClass("hidden");
	  $('#news-option').removeAttr('disabled');
   }
   
}

function freechecked(){
   $('input[type="checkbox"]').attr('checked',false);
}

$(document).ready(function(e) {
   changeOption();
   // DRAGTABLE
   $("#tbl_category").tableDnD();
});
</script>

<!--custom-->
<?php
include("sources/language/products/category/index.php");
?>