<?php
include("control.php");
include("custom/products/color/control.php");

?>
<form method="post" enctype="multipart/form-data">
<?php //var_dump($_POST);?>
<script>
$(document).ready(function(){
   $("#add-color-popup").hide();
   $("#upload-image").hide();
   
   $("#btn-add-color").click(function(){
      $("#add-color-popup").fadeIn("fast");
	  $("#color-name").val("");
	  $("#col-id").val("");
   });
   
   $("#close-pop-up").click(function(){
      $("#add-color-popup").fadeOut("fast");
	  
	  $("#color-inactive-status").removeAttr('checked');
	  $("#color-active-status").removeAttr('checked');
	  
	  $("#color-invisible-status").removeAttr('checked');
	  $("#color-visible-status").removeAttr('checked');
	  
	  $('#listing').find(':checked').each(function() {
         $(this).removeAttr('checked');
      });
	  
   });
	  
});
</script>
        
        
        <div class="" id="add-color-popup">
            <div class="overlay over-color">
                <div class="header">
                        <h2 id="header-name">Add Color</h2> 
                        <div class="btn-placeholder">
                            <input type="button" class="btn grey main" value="Cancel" id="close-pop-up" name="btn-index-color" onclick="clearImage()">
                            <input type="submit" class="btn red main" value="Delete" name="btn-index-color">
                            <input type="submit" class="btn green main" value="Save Changes" name="btn-index-color">
                        </div>
                    </div>
                <div class="content">
                    <ul class="field-set">
                        <li class="field hidden">
                            <label class="">Change status</label>
                            <input type="radio" class="input-radio" value="active" id="color-active-status" name="active_status" checked="checked" />&nbsp; Active
                            <input type="radio" class="input-radio" value="inactive" id="color-inactive-status" name="active_status"/>&nbsp; Inactive
                        </li>
                        <li class="field hidden">
                            <label>Visibility</label>
                            <input type="radio" class="input-radio" value="yes" id="color-visible-status" name="visibility_status" checked="checked"/>&nbsp; Yes
                            <input type="radio" class="input-radio" value="no" id="color-invisible-status" name="visibility_status"/>&nbsp; No
                        </li>            
                            <input type="hidden" name="col_id" value="" id="col-id">           
                        <li class="field clearfix">
                            <label>Color Thumbnail</label>
                            <div class="fl color-thumb edit" id="picture" onclick="openBrowser()">
                               <img id="upload-image" src="" width="25px">
                            </div>
                            <p class="field-message fl" style="padding-left: 10px">Recommended dimensions of 24 x 24 px.</p>
                            <input type="file" name="color_image" id="color" onchange="readURL(this,'1')" class="hidden"/>
                            
                        </li>
                        <li class="field clearfix">
                            <label>Color name</label>
                            <input type="text" class="input-text" value="" id="color-name" name="color_name">
                        </li>
                    </ul>
                </div>
            </div>
            <div class="overlay_bg70"></div>
        </div>

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



            <div class="sub-header clearfix">
                <div class="content">
                
                    <h2>Manage Color</h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn green main" value="Add Color" name="btn-index-color" id="btn-add-color">
                    </div>
                </div>
            </div>

            <div id="main-content">
            <?php if(!empty($_SESSION['alert'])){?>
                   <div class="alert-message <?php echo $_SESSION['alert'];?>"><center><?php echo $_SESSION['msg'];?></center></div>
                   <?php 
           }
           if($_POST['btn-index-color'] == ""){
            $_SESSION['alert'] = "";
            $_SESSION['msg']   = "";
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
                                        <select class="input-select" name="color-action">
                                            <option value="delete">Delete</option>
                                        </select>
                                        
                                        <div class="hidden">
                                        <p>to</p>
                                        <select class="input-select" name="color-option">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                        </div>
                                        
                                        <input type="submit" class="btn green main go" value="GO" name="btn-index-color">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="headings">
                                <th width="20"></th>
                                <th width="25"></th>
                                <th class="sort" width="655" onclick="sortBy('color_name')">Color Group Name<?php echo $arr_color_name;?></th>
                                <th class="sort" width="70"  onclick="sortBy('total_product')">Products<?php echo $arr_total_product;?></th>
                                <th class="sort" width="130"  onclick="sortBy('color_active_status')">Status<?php echo $arr_color_active;?></th>
                                <th class="sort" width="60"  onclick="sortBy('color_visibility_status')">Visibility<?php echo $arr_color_visibility;?></th>
                            </tr>
                            <tr class="filter">
                                <th><a href="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/color";?>"><input type="button" class="btn small reset <?php echo $reset;?>" value=""></a></th>
                                <th></th>
                                <th><input type="text" class="input-text" id="color_name_search" onkeyup="searchQuery('color_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "color_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
                                <th><input type="text" class="input-text" disabled="disabled"></th>
                                <th>
                                    <select class="input-select" name="color_active_status" id="color_active_status_search" onchange="searchQueryOption('color_active_status')" <?php if($_REQUEST['src'] != "color_active_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                                        <option></option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </th>
                                <th>
                                    <select class="input-select" name="color_visibility_status" id="color_visibility_status_search" onchange="searchQueryOption('color_visibility_status')" <?php if($_REQUEST['src'] != "color_visibility_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                                        <option></option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                        <tbody onload="loading()" id="listing">
                            <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                            <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
                            
                            <?php
							$row=0;
							foreach($listing_order as $all_color){
							   $row++;
							   $total_product = get_all_color_total_product($all_color['color_id'], 0);
							?>
                            <tr class="" id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                            
                                <td><input type="checkbox" name="color_id[]" value="<?php echo $all_color['color_id'];?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                                <td><div class="color-thumb"><img src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/../".$all_color['color_image'];?>" alt="<?php echo $all_color['color_name'];?>" width="24px"></div></td>
                                <td><a href="#" onclick="editColor('<?php echo $all_color['color_id'];?>','<?php echo $all_color['color_name'];?>','<?php echo $all_color['color_active_status']?>','<?php echo $all_color['color_visibility_status']?>', '<?php echo "http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/".$all_color['color_image'];?>')"><?php echo $all_color['color_name'];?></a></td>
                                <td class="tr"><a href="<?php echo $prefix_url."product-view/1/top/25/product_name/color_id-".$all_color['color_id'];?>" target="_new"><?php echo $total_product['total_products'];?></a></td>
                                <td><?php echo ucwords(strtolower($all_color['color_active_status']));?></td>
                                <td><?php echo ucwords(strtolower($all_color['color_visibility_status']));?></td>
                            </tr>

                            
                            <?php }?>
                            
                            <script>
							function editColor(col_id, col_name, col_active, col_visibility, col_img){
							   $("#add-color-popup").fadeIn("fast");
							   
							   //Color ID
							   $("#col-id").val(col_id);
							   
							   // Color Name
							   $("#color-name").val(col_name);
							   
							   if(col_active == "inactive"){
							      $("#color-inactive-status").attr('checked', 'checked');
							   }else if(col_active == "active"){
							      $("#color-active-status").attr('checked', 'checked');
							   }
							   
							   if(col_visibility == "no"){
							      $("#color-invisible-status").attr('checked', 'checked');
							   }else if(col_visibility == "yes"){
							      $("#color-visible-status").attr('checked', 'checked');
							   }
							   
							   $("#upload-image").attr('src',col_img);
							   $("#upload-image").attr('style','display=block');
							   
							   $("#header-name").text("Edit Color");
							}
							</script>
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->
            
</form>

<script>
$('#color_active_status_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');
$('#color_visibility_status_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');
</script>

<?php
if($_POST['btn-index-color'] == ""){
      $_SESSION['alert'] = "";
	  $_SESSION['msg']   = "";
}
?>

<?php include("custom/products/color/index.php");?>        