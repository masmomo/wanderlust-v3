<?php
include("get.php");
include("update.php");
include("control.php");
?>



            <div class="subnav">
              <div class="container clearfix">
                <h1><span class="glyphicon glyphicon-list"></span> &nbsp; Manage News</h1>
                <select class="form-control" id="category_name_search" onchange="selectCategory()" style="width: 150px;">
                  <option value="top">All Category</option>
                  
                  <?php
                  if($count_category['rows'] > 0){
				     
					 foreach($get_category as $get_category){
					    echo '<option value="'.$get_category['category_id'].'">'.$get_category['category_name'].'</option>';
					 }
					 
				  }
				  ?>
                  
                </select>
                <div class="btn-placeholder">
                  <a href="<?php echo $prefix_url.'add-news';?>">
                    <input type="button" class="btn btn-success btn-sm" value="Add News">
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
			
			if($_POST['btn-index-news-listing'] == ''){
			   unset($_SESSION['alert']);
			   unset($_SESSION['msg']);
			}
			?>
            
            <form method="post">
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
                    <input type="submit" class="btn btn-success pull-left" value="GO" name="btn-index-news-listing">
                  </div>
                </div><!--actions-->
                    <table class="table">
                      <thead>
                        <tr class="headings">
                          <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open hidden" onclick="showEye()"></span></th>
                          <th class="sort" width="680" onclick="sortBy('news_title')">News Title<span class="sort-arrow-up"></span></th>
                          <th class="sort" width="200" onclick="sortBy('news_created_date')">Date</th>
                          <th class="sort" width="60" onclick="sortBy('news_visibility')">Visibility</th>
                        </tr>
                        
                        <tr class="filter" id="filter">
                          <th>
                            <a href="<?php echo $prefix_url.'news';?>">
                              <button type="button" style="width: 100%;" class="btn btn-danger btn-xs <?php echo $reset;?>">
                              <span class="glyphicon glyphicon-remove"></span></button>
                            </a>
                          </th>
                          <th><input type="text" class="form-control" id="news_title_search" onkeyup="searchQuery('news_title')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], news_title);?>></th>
                          <th><input type="text" class="form-control" id="news_created_date_search" onkeyup="searchQuery('news_created_date')" onkeypress="return disableEnterKey(event)" <?php order_disabling_search($_REQUEST['src'], news_created_date);?>></th>
                          <th>
                            <select class="form-control" id="news_visibility_search" onchange="searchQueryOption('news_visibility')" <?php order_disabling_search($_REQUEST['src'], news_created_date);?>>
                              <option></option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>
                            </select>
                          </th>
                        </tr>
                      </thead>
                      
                      <tbody >
                      <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                      
                      <?php 
					  $row = 0;
					  foreach($all_news as $all_news){
					     $row++;
					  ?>
                      
                      <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                        <td><input type="checkbox" name="news_id[]" id="<?php echo "check_".$row?>" value="<?php echo $all_news['news_id'];?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                        <td><a href="<?php echo $prefix_url.'news-edit/'.$all_news['news_id']."/".cleanurl($all_news['news_title']);?>"><?php echo $all_news['news_title'];?></a></td>
                        <td><?php echo format_date($all_news['news_created_date']);?></td>
                        <td class="text-right"><?php echo ucwords(strtolower($all_news['news_visibility']));?></td>
                      </tr>
                      <?php
					  }
					  ?>
                      
                      </tbody>
                    </table>
                  <!--</div>table-wrapper-->
                  
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


function selectCategoryOption(x){
   var category = $('#category_name_search option[value="'+x+'"]').attr('selected', true);
}


function selectFilter(x){
   
   if(typeof x !== 'undefined'){
      var category = $('#news_visibility_search option[value="'+x+'"]').attr('selected', true);
   }
   
}

$(function() {
   $("#news_created_date_search").datepicker({
      altField:'#news_created_date',
	  altFormat: "yy/mm/dd",
	  onSelect: function () {
	     document.all ? $(this).get(0).fireEvent("onchange") : $(this).change();
         searchQueryOption('news_created_date');
      },
   });
});



$(document).ready(function() {
   changeAction();
   selectCategoryOption('<?php echo $_REQUEST['cat']?>');
   selectFilter('<?php echo $_REQUEST['srcval'];?>');
});
</script>           