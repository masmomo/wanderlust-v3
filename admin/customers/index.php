<?php
include("custom/customers/control.php");
include("control.php");

?>

<!-- FORM -->
<form name="index-order" method="post" action="" enctype="multipart/form-data">         
            
  <div class="subnav">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-user"></span> &nbsp; Customers</h1>
      <div class="btn-placeholder">
         <a href="<?php echo $prefix_url."add-customer";?>">
          <input type="button" class="btn btn-success btn-sm" value="Add Customer">
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
  
  if($_POST['btn-index-customer'] == ""){
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
            <select class="form-control" name="option-action" id="news-action" onchange="changeOption()">
              <option value="delete">Delete</option>
            </select>
            <input type="submit" class="btn btn-success pull-left" value="GO" name="btn-index-customer">
          </div>
        </div><!--actions-->

        <table class="table">
          <thead>
            <tr class="headings">
              <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open hidden" onclick="showEye()"></span></th>
              <th class="sort" width="230" onclick="sortBy('user_fullname')">Name<?php echo $arr_user_fullname;?></th>
              <!--<th class="sort" width="86" onclick="sortBy('user_status')">Class <?php echo $arr_user_status;?></th>-->
              <th class="sort" width="226" onclick="sortBy('user_country')">Location <?php echo $arr_user_country;?></th>
              <th class="sort" width="80" onclick="sortBy('total_spent')">Money Spent <?php echo $arr_total_spent;?></th> <!--onclick="sortBy('order_confirm_amount')"-->
              <th class="sort" width="20" onclick="sortBy('total_order')">Orders <?php echo $arr_total_order;?></th> <!-- onclick="sortBy('order_id')" -->
              <th class="sort" width="200" onclick="sortBy('last_order')">Last Order <?php echo $arr_last_order;?></th>
            </tr>
            <tr class="filter" id="filter">
              <th>
                 <a href="<?php echo $prefix_url."customer";?>"><input type="button" class="btn small reset <?php echo $reset;?>"></a></th>
              <th><input type="text" class="form-control" id="user_fullname_search" onkeyup="searchQuery('user_fullname')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "user_fullname"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
              <!--<th>
                  <select class="form-control" name="user_status" id="user_status_search" onchange="searchQueryOption('user_status')" <?php if($_REQUEST['src'] != "user_status" and !empty($_REQUEST['src'])){ echo "disabled";}?>>
                     <option></option>
                     <option value="All">All</option>
                     <option value="normal">Normal</option>
                     <option value="member">Member</option>
                  </select>
              </th>-->
              <th><input type="text" class="form-control" id="user_country_search" onkeyup="searchQuery('user_country')" onkeypress="return disableEnterKey(event)" placeholder="Country" <?php if($_REQUEST['src'] == "user_country"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
              <th><input type="text" class="form-control tr" disabled></th>
              <th><input type="text" class="form-control" disabled></th>
              <th><input type="text" class="form-control" id="last_order_search" onkeyup="searchQuery('last_order')" onkeypress="return disableEnterKey(event)" disabled="disabled"></th>
            </tr>
          </thead>
          <tbody onload="loading()">
            <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
            <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
            
            <?php
              $row=0;
              foreach($customers as $customers){
                 $row++;
                
                 $day   = substr($customers['latest_order_date'],8,2);
                 $month = substr($customers['latest_order_date'],5,2);
                 $year  = substr($customers['latest_order_date'],0,4);
                 
                 $latest_order_date = date("D", mktime(0, 0, 0, $month, $day, $year))." on ".$day." ".date("M", mktime(0, 0, 0, $month, $day, $year))." ".$year;
                 
                 $user_province_country = $customers['user_province'].", ".$customers['user_country'];
                 
                 $date_server = date('D, j M Y',strtotime($customers['last_order']));
              ?>
              
            <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
              <td><input type="checkbox" name="user_id[]" value="<?php echo $customers['user_id'];?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
              <td>
                <a href="<?php echo $prefix_url."customer/".$customers['user_alias'];?>">
                   <?php echo $customers['user_first_name']." ".$customers['user_last_name'];?>
                </a>
              </td>
              <!--<td><?php echo $customers['user_status'];?></td>-->
              <td><?php echo $user_province_country;?></td>
              <td class="tr"><?php echo price($customers['total_purchase']);?></td>
              <td class="tr"><?php echo $customers['total_order'];?></td>
              <td><a href="<?php echo $prefix_url."order-detail/".$customers['latest_order_number'];?>"><?php echo $customers['latest_order_number'];?></a> 
			  <?php if(empty($customers['last_order'])){ echo "N/A";}else{ echo format_date($customers['last_order']);}?></td>
            </tr>
              
            <?php }?>
          </tbody>
        </table>

      </div><!--.content-->
    </div><!--.box.row-->

  </div><!--.container.main-->
            
<script>
$(function() {
   $("#last_order_search").datepicker({
      altField:'#last_order_search',
	  altFormat: "yy/mm/dd",
	  onSelect: function () {
		           document.all ? $(this).get(0).fireEvent("onchange") : $(this).change();
				   searchQueryOption('last_order_search');
	            },
   });
});


$('#user_status_search option[value=<?php echo $search_value?>]').attr('selected', 'selected');
</script>

<?php
include('custom/customers/index.php');
?>
           