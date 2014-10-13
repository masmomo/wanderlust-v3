<?php
include("get.php");
include("update.php");
include("control.php");
?>

<form method="post" enctype="multipart/form-data">

   <script>
   function readURL(input) {
      
	  if (input.files && input.files[0]) {
	     var reader = new FileReader();
		 reader.onload = function (e) {
		    $('#upload-image').fadeIn("slow");
		    $('#upload-image').attr('src', e.target.result);
	     }
		 
		 reader.readAsDataURL(input.files[0]);
	  }
	  
   }
   
   function openBrowser(){
      document.getElementById("color").click();
   }
   
   function clearImage(){
	   document.getElementById("upload-image").removeAttribute('src');
	   $("#upload-image").fadeOut("slow");
   }
   </script>



            <div class="subnav">
                <div class="container clearfix">
                    <h1><span class="glyphicon glyphicon-tint"></span> &nbsp; Color Groups</h1>
                    <div class="btn-placeholder">
                        <a href="<?php echo $prefix_url."add-color"?>"><input type="button" class="btn btn-success btn-sm" value="Add Color" name="btn-index-color" id="btn-add-color"></a>
                    </div>
                </div>
            </div>
            
			<?php if(!empty($_SESSION['alert'])){?>
            <div class="alert <?php echo $_SESSION['alert'];?>">
            <div class="container"><?php echo $_SESSION['msg'];?></div>
            </div>
            <?php 
			}
			
            if($_POST['btn-index-color'] == ""){
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
                    <option value="change">Set Visibility</option>
                    <option value="order">Set Order</option>
                  </select>
                  <p id="lbl-news-option" class="hidden">to</p>
                  <select class="form-control" name="category-option" id="news-option" disabled="disabled" class="hidden">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                  </select>
                  <input type="submit" class="btn btn-success pull-left" value="GO" name="btn-index-color">
                </div>
              </div><!--actions-->

                    <table class="table" id="tbl_color">
                        <thead>
                            <tr class="headings">
                                <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open" onclick="showEye()"></span></th>
                                <th width="25"></th>
                                <th class="sort" width="85%" onclick="sortBy('color_name')">Color Group Name<?php echo $arr_color_name;?></th>
                                <th class="sort" width="10%"  onclick="sortBy('total_product')">Products<?php echo $arr_total_product;?></th>
                                <!--<th class="sort" width="130"  onclick="sortBy('color_active_status')">Status<?php echo $arr_color_active;?></th>-->
                                <th class="sort" width="5%"  onclick="sortBy('color_visibility_status')">Visibility<?php echo $arr_color_visibility;?></th>
                            </tr>
                            <tr class="filter hidden" id="filter">
                                <th><a href="<?php echo $prefix_url."color";?>"><button type="button" style="width: 100%;" class="btn btn-danger btn-xs <?php echo $reset;?>"><span class="glyphicon glyphicon-remove"></span></button></a></th>
                                <th></th>
                                <th><input type="text" class="form-control" id="color_name_search" onkeyup="searchQuery('color_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "color_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
                                <th><input type="text" class="form-control" disabled="disabled"></th>
                                <!--<th>
                                    <select class="form-control" name="color_active_status" id="color_active_status_search" onchange="searchQueryOption('color_active_status')" <?php if($_REQUEST['src'] != "color_active_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                                        <option></option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </th>-->
                                <th>
                                    <select class="form-control" name="color_visibility_status" id="color_visibility_status_search" onchange="searchQueryOption('color_visibility_status')" <?php if($_REQUEST['src'] != "color_visibility_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                                        <option></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="listing">
                            <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                            
                            <?php
							$row=0;
							foreach($listing_order as $all_color){
							   $row++;
							   $total_product = get_all_color_total_product($all_color['color_id']);
							?>
                            <tr class="" id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                            
                                <td><input type="checkbox" name="color_id[]" value="<?php echo $all_color['color_id'];?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                                <td>
                                  <div class="color-thumb">
                                    <img src="<?php echo $prefix_url."static/thimthumb.php?src=../".$all_color['color_image'].'&h=23&w=23&q=80';?>" alt="<?php echo $all_color['color_name'];?>">
                                  </div>
                                </td>
                                <td><a href="<?php echo $prefix_url.'color-detail/'.$all_color['color_id'].'/'.cleanurl($all_color['color_name']);?>"><?php echo $all_color['color_name'];?></a></td>
                                <td class="tr">
                                  <a href="<?php echo $prefix_url."product-view/1/top/25/product_name/color_id-".$all_color['color_id'];?>" target="_new">
								    <?php echo $total_product['total_products'];?>
                                  </a>
                                </td>
                                <!--<td><?php echo ucwords(strtolower($all_color['color_active_status']));?></td>-->
                                <td>
								<?php 
								echo ucwords(strtolower($all_color['color_visibility_status']));
								
								// INPUT HIDDEN FOR ORDERING
								echo '<input type="hidden" name="color_order[]" value="'.$all_color['color_order'].'">';
								echo '<input type="hidden" name="hidden_color_id[]" value="'.$all_color['color_id'].'">';								
								?></td>
                            </tr>

                            
                            <?php 
							}
							?>
                        </tbody>
                    </table>

                  </div><!--.content-->
                </div><!--.box.row-->

            </div><!--.container.main-->
            
</form>

<script>
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
   $("#tbl_color").tableDnD();
});
</script>

<?php
if($_POST['btn-index-color'] == ""){
      $_SESSION['alert'] = "";
	  $_SESSION['msg']   = "";
}
?>

            