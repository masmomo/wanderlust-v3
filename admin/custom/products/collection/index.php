<?php
include("get.php");
include("update.php");
include("control.php");
include("ajax.php");

$max_collection_id = get_latest_id();
$collection_id     = $max_collection_id['collection_id'];
?>

<form method="post" enctype="multipart/form-data">

            <div class="subnav">
              <div class="container main">
                <h1><span class="glyphicon glyphicon-pushpin"></span> &nbsp; Collections</h1>
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url."add-collection"?>"><input type="button" class="btn btn-success btn-sm" value="Add Collection"></a>
                </div>
              </div>
            </div>

            <?php 
			if(!empty($_SESSION['alert'])){
			   echo '<div class="alert '.$_SESSION['alert'].'">';
			   echo '  <div class="container">'.$_SESSION['msg'].'</div>';
               echo '</div>';
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
                           for($i=0;$i<=$total_page;$i++){
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
                    <option value="change">Set Visibility</option>
					<option value="order">Set Order</option>
                  </select>
                  <p id="lbl-news-option" class="hidden">to</p>
                  <select class="form-control" name="category-option" id="news-option" disabled="disabled" class="hidden">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                  </select>
                  <input type="submit" class="btn btn-success pull-left" value="GO" name="btn-collection-index">
                </div>
                  </div><!--actions-->
                  
                    <table class="table" id="table_collection">
                      <thead>
                        <tr class="headings">
                          <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open" onclick="showEye()"></span></th>
                          <th class="sort" width="85%" onclick="sortBy('collection_name')">Collection Name <?php echo $arr_collection_group_name;?></th>
                          
                          <th class="sort" width="10%"  onclick="sortBy('total_product')">Products <?php echo $arr_total_product;?></th>
                          <!--<th class="sort" width="130" onclick="sortBy('active_status')">Status <?php echo $arr_active_status;?></th>-->
                          <th class="sort" width="5%"  onclick="sortBy('visibility_status')">Visibility <?php echo $arr_visibility_status;?></th>
                        </tr>
                        
                        <tr class="filter hidden" id="filter">
                          <th>
                            <a href="<?php echo $prefix_url."collection";?>">
                              <button type="button" style="width: 100%;" class="btn btn-danger btn-xs <?php echo $reset;?>"><span class="glyphicon glyphicon-remove"></span></button>
                            </a>
                          </th>
                          <th>
                            <input type="text" class="form-control" id="collection_name_search" onkeyup="searchQuery('collection_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "collection_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>>
                          </th>
                          
                          <th><input type="text" class="form-control" id="total_product_search" onkeyup="searchQueryExact('total_product')" onkeypress="return disableEnterKey(event)" disabled="disabled"></th>
                          <!--<th>
                          <select class="form-control" id="collection_active_status_search" onchange="searchQueryOption('collection_active_status')" <?php if($_REQUEST['src'] != "collection_active_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                            <option></option>
                            <option value="Active" <?php if($search == "collection_active_status= 'Active'" ){ echo 'selected="selected"';}?>>Active</option>
                            <option value="Inactive" <?php if($search == "collection_active_status= 'Inactive'" ){ echo 'selected="selected"';}?>>Inactive</option>
                          </select>
                        </th>-->
                        
                        <th>
                          <select class="form-control" id="collection_visibility_status_search" onchange="searchQueryOption('collection_visibility_status')" <?php if($_REQUEST['src'] != "collection_visibility_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                            <option></option>
                            <option value="Yes" <?php if($search == "collection_visibility_status= 'Yes'" ){ echo 'selected="selected"';}?>>Yes</option>
                            <option value="No" <?php if($search == "collection_visibility_status= 'No'" ){ echo 'selected="selected"';}?>>No</option>
                          </select>
                        </th>
                      </tr>
                    </thead>
                    
                    <tbody id="checkbox">
                      <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                      
					  <?php
					  $row = 0;
					
					  foreach($listing_order as $list_collection){
						
					     $row++;
						 
						 //$total_product = checkDelete($list_collection['collection_id']);
						 $related_product = totalCollection($list_collection['collection_id']);
					  ?>
                         <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                            
                            <td id="get_collection_id"><input type="checkbox" name="collection_id[]" id="<?php echo "check_".$row?>" value="<?php echo $list_collection['collection_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                            <td id="get_collection_name_<?php echo $row;?>"><a href="<?php echo $prefix_url.'collection-detail/'.$list_collection['collection_id'].'/'.cleanurl($list_collection['collection_group_name']);?>"><?php echo $list_collection['collection_name'];?></a></td>
                            
                            <td class="text-right"><a href="<?php echo $prefix_url."product-view/1/top/25/product_name/product_collection-".$list_collection['collection_id'];?>"><?php echo $related_product['total_product'];?></a></td>
                            <!--<td id="get_active_status_<?php echo $row;?>"><?php echo $list_collection['active_status'];?></td>-->
                            <td id="get_visibility_status_<?php echo $row;?>"><?php echo $list_collection['visibility_status'];?></td>
                        	<?php
							// INPUT HIDDEN FOR ORDER				
							echo '<input type="hidden" name="hidden_collection_id[]" value="'.$list_collection['collection_id'].'">';
							?>  
						</tr>
							
							
                       <?php }?>
                     </tbody>
                   </table>
                   
                 </div><!--.content-->
               </div><!--.box.row-->
               
             </div><!--.container.main-->
			
			<?php
			//ORDER
			foreach($listing_order as $list_collection){
				echo '<input type="hidden" name="collection_order[]" value="'.$list_collection['collection_order'].'">';
			}
			?>
</form>            
            
            
<script>
$("#page-option option[value=<?php echo $page;?>]").attr('selected','selected');
$('#collection_active_status_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');
$('#collection_visibility_status_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');

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

$(document).ready(function(e) {
   changeOption();

	// DRAGTABLE
	   $("#table_collection").tableDnD();
});
</script>

<?php
if($_POST['btn-collection-index'] == ""){
   $_SESSION['alert'] = "";
   $_SESSION['msg']   = "";
}
?>

           