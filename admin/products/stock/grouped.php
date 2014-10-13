<?php
include("grouped/get.php");
include("grouped/update.php");
include("grouped/control.php");
?>

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-tasks"></span> &nbsp; Stock Control</h1>
        <ul class="subnav-link clearfix">
          <li><a href="<?php echo $prefix_url."stock-manager";?>">Single</a></li> 
          <li>/</li>
          <li class="active"><a href="<?php echo $prefix_url."stock-grouped";?>">Grouped</a></li>
        </ul>
      </div>
    </div>

    <div class="alert alert-success hidden">
      <div class="container">
        <strong>Success!</strong> Stock was successfully updated.
      </div>
    </div>

    <div class="container main">

      <div class="row">
        <ul class="nav nav-tabs nav-justified">
          <?php
          foreach($size_group as $key=>$size_group){
		     echo "<li id=\"".$size_group['size_type_id']."\">";
			 echo "  <a href=\"".$prefix_url."stock-grouped#group-".$size_group['size_type_id']."\" data-toggle=\"tab\" id=\"tab_id_".$size_group['size_type_id']."\">".$size_group['size_type_name']."</a>";
			 echo "</li> \n";
		  }
		  ?>
        </ul>
      </div>


        <div class="tab-content box row" style="margin-top: 0">
          
          <?php
          foreach($size_tab as $size_tab){
		     /*
			 |--------------------|
			 |      SORTING       |
			 |--------------------|
			 */
			 
			 $equal_search     = array();
			 $default_sort_by  = "product_name";
			 
			 $pgdata = page_init($equal_search,$default_sort_by); // static/general.php
			 
			 $page             = $pgdata['page'];
			 $query_per_page   = $pgdata['query_per_page'];
			 $sort_by          = $pgdata['sort_by'];
			 $first_record     = $pgdata['first_record'];
			 $search_parameter = $pgdata['search_parameter'];
			 $search_value     = $pgdata['search_value'];
			 $search_query     = $pgdata['search_query'];
			 $search           = $pgdata['search'];
			 
			 $full_order  = count_product($size_tab['size_type_id'], $search_query, $sort_by ,$query_per_page);
			 $total_query = $full_order['total_query'];
			 $total_page  = $full_order['total_page']; // RESULT
			 
			 // CALL FUNCTION
			 $listing_order = get_product($size_tab['size_type_id'], $search_query, $sort_by ,$first_record, $query_per_page);
		  ?>
          
          <div id="group-<?php echo $size_tab['size_type_id'];?>" class="tab-pane fade active in content">

            <div class="actions clearfix">
              <div class="pull-left">
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
                Size Group: <strong><?php echo $size_tab['size_type_name'];?></strong>
              </div>
            </div><!--actions-->

            <table class="table table-hover">
              <thead>
                <tr class="headings">
                  <th width="30"></th>
                  <th class="sort" width="200" onclick="sortBy('product_name')">Item<?php echo $arr_product_name;?><span class="sort-arrow-down"></span></th>
                  <th class="sort" width="100" onclick="sortBy('type_name')">Variants<?php echo $arr_type_name;?></th>
                  
                  <?php
                  // CALL FUNCTION
				  $stock_name = get_size_name($size_tab['size_type_id']);
				  
				  foreach($stock_name as $stock_name){
				     echo '<th width="10" style="text-align: center">'.$stock_name['size_name'].'</th>';
				  }
				  ?>
                  <th width="40"></th>
                </tr>
                <tr class="filter hidden">
                  <th><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></th>
                  <th><input type="text" class="form-control"></th>
                  <th><input type="text" class="form-control"></th>
                  <th><input type="text" class="form-control" disabled></th>
                  <th><input type="text" class="form-control" disabled></th>
                  <th><input type="text" class="form-control" disabled></th>
                  <th><input type="text" class="form-control" disabled></th>
                  <th><input type="text" class="form-control" disabled></th>
                  <th><input type="text" class="form-control" disabled></th>
                  <th><input type="text" class="form-control" disabled></th>
                </tr>
              </thead>
              <tbody>
              
                <?php if($total_query < 1){?><tr><td class="no-record" colspan="20">No records found.</td></tr><?php }?>
              
                <?php 
				$row = 1;
                foreach($listing_order as $products){
				?>
                <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                  <td><img class="table-image" src="<?php echo $prefix_url.'static/thimthumb.php?src=../'.$products['img_src'].'&h=45&w=30&q=80';?>"></td>
                  <td><a href="<?php echo $prefix_url.'product-details-'.$products['product_alias'];?>"><?php echo $products['product_name'];?></a></td>
                  <td><?php echo $products['type_name'];?></td>
                  
                  <?php
				  $product_stocks = get_stock($products['type_id']);
                  foreach($product_stocks as $product_stocks){
				     echo '<td>';
					 echo '<input type="text" class="form-control form-edit custom_'.$products['type_id'].'" tabindex="1" value="'.$product_stocks['stock_quantity'].'" name="value_'.$product_stocks['stock_id'].'" id="id_value_'.$product_stocks['stock_id'].'" onfocus="focusValue('.$product_stocks['stock_quantity'].','.$product_stocks['stock_id'].')" onkeyup="qtySync('.$product_stocks['stock_id'].','.$product_stocks['stock_quantity'].','.$product_stocks['type_id'].')">';
					 echo '</td>';
				  }
				  ?>
                  <td><button type="button" class="btn btn-success pull-right" disabled="disabled" data-loading-text="Saving..." id="btn_save_<?php echo $product_stocks['type_id'];?>" onclick="saveStock(<?php echo $products['type_id'];?>)">Save</button></td>
                </tr>
                <?php
				   $row++;
                }
                ?>
              </tbody>
            </table>

          </div><!--content-->
          
          <?php
		  }
		  ?>

        </div><!--box-->


    </div><!--container main-->
    
    <span id="data_dumping">
    </span>

<script>
<?php
$default_click = get_size_grouping();
?>

function disable(){
   
}

function focusValue(x, y){
	
   var total_dump = $('.dump').size();
   
   $('input[type="text"]').click(function(){
	   
	  var check = $('#id_dump_'+y).size();
	  
	  if(check > 0){
	  
	  }else{
	  
	     if(total_dump > 0){
            $('#data_dumping').html($('#data_dumping').html()+'<input type="hidden" id="id_dump_'+y+'" class="dump" value="'+x+'" data-id="'+y+'">');
		 }else{
            $('#data_dumping').html('<input type="hidden" id="id_dump_'+y+'" class="dump" value="'+x+'" data-id="'+y+'">');
		 }
		 
	  }
	  
   });
   
}

function clickDefault(){
   $('#tab_id_<?php echo $default_click['size_type_id'];?>').click();
   
   $('input').click(function (){
      $(this).select();
   });
}

function qtySync(x, y, z){
   var value = $('#id_value_'+x).val();
   
   $('#id_dump_'+x).val(value);
   
   if(value != y){
      $('#btn_save_'+z).attr('disabled',false);
   }
}

$(document).ready(function(e) {
   clickDefault();
   $('#tab_id_<?php echo $default_click['size_type_id'];?>').click();
});



function saveStock(x){
   var type  = x;
   var value = [];
   var id    = [];
   
   $('.dump').each(function() {
      value.push($(this).val());
	  id.push($(this).attr('data-id'));
   });
   
   
   $.ajax({
      type : "POST",
	  url  : "products/stock/grouped/ajax.php",
	  data : {type:type, value:value, id:id},
	  error: function(jqXHR, textStatus, errorThrown) {
	            
			 }
			 
   }).done(function(msg) {
      $('button').each(function(index, element) {
         $(this).attr('disabled',true);
	  });
   });
}
</script>

    
