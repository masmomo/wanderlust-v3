<?php
include("get.php");
include("update.php");
include("control.php");
?>

<form method="post">

  <div class="subnav clearfix">
    <div class="container clearfix">
      <h1><span class="glyphicon glyphicon-tasks"></span> &nbsp; Stock Manager</h1>
      
      <select class="form-control" id="category_name_search" onchange="selectCategory()">
        <option value="top">All Category</option>
      <?php listCategory(0,'top',' ');?>
      </select>
      
      <!--<div class="btn-placeholder">
        <input type="button" class="btn btn-success btn-sm hidden" value="Add Product">
      </div>-->

      <ul class="subnav-link clearfix">
        <li class="active"><a href="<?php echo $prefix_url;?>stock-manager">Single</a></li> 
        <li>/</li>
        <li><a href="<?php echo $prefix_url;?>stock-grouped">Grouped</a></li>
      </ul>
    </div>
  </div>

  <?php if(!empty($_SESSION['alert'])){?>
    <div class="alert <?php echo $_SESSION['alert'];?>">
      <div class="container">
        <?php echo $_SESSION['msg'];?>
      </div>
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
            <select class="form-control" name="stock_action" id="id_stock_action" onchange="changeOption()"> 
              <!--<option value="delete">Delete</option>-->
              <option value="save">Save Changes</option>
            </select>
            <input type="submit" class="btn btn-success pull-left" name="btn_index_stock" value="GO">
          </div>
        </div><!--actions-->

        <table class="table table-hover">
          <thead>
            <tr class="headings">
              <th width="20"><span id="eyeopen" class="glyphicon glyphicon-eye-open" onclick="showEye()"></span></th>
              <th width="30"></th>
              <th class="sort" width="620" onclick="sortBy('product_name')">Item <?php echo $arr_product_name;?></th>
              <th class="sort" width="130" onclick="sortBy('type_name')">Variants <?php echo $arr_type_name;?></th>
              <th class="sort" width="130" onclick="sortBy('type_price')">Price <?php echo $arr_type_price;?></th>
              <th class="sort" width="60" onclick="sortBy('stock_name')">Size <?php echo $arr_stock_name;?></th>
              <th class="sort" width="60" onclick="sortBy('stock_quantity')">Qty. <?php echo $arr_stock_quantity;?></th>
            </tr>
            <tr class="filter hidden" id="filter">
              <th><a href="<?php echo $prefix_url."stock-manager";?>"><button type="button" class="btn btn-danger btn-xs <?php echo $reset;?>"><span class="glyphicon glyphicon-remove"></span></button></a></th>
              <th><input type="text" class="form-control" disabled></th>
              <th><input type="text" class="form-control" id="product_name_search" onkeyup="searchQuery('product_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "product_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
              
              <th><input type="text" class="form-control" id="type_name_search" onkeyup="searchQuery('type_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "type_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
              
              <th><input type="text" class="form-control" id="type_price_search" onkeyup="searchQuery('type_price')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "type_price"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?> disabled="disabled"></th>
              
              <th><input type="text" class="form-control" id="stock_name_search" onkeyup="searchQuery('stock_name')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "stock_name"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
              
              <th><input type="text" class="form-control" id="stock_quantity_search" onkeyup="searchQuery('stock_quantity')" onkeypress="return disableEnterKey(event)" <?php if($_REQUEST['src'] == "stock_quantity"){ echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";}else if(!empty($_REQUEST['src'])){ echo "disabled";}?>></th>
            </tr>
          </thead>
          <tbody>
            
            <?php if($total_query < 1){?><tr><td class="no-record" colspan="8">No records found.</td></tr><?php }?>
            
            <?php
            $row = 0;
            foreach($all_product as $product){
               $row++;
            ?>
            <tr id="<?php echo "row_".$row?>" onclick="selectRow('<?php echo $row;?>')">
                <td><input type="checkbox" name="prod_id[]" value="<?php echo $product['stock_id'];?>" id="<?php echo "check_".$row?>" onmouseover="downCheck()" onmouseout="upCheck()" onclick="selectRowCheck('<?php echo $row;?>')"></td>
                <td><img class="table-image" src="<?php echo $prefix_url."static/thimthumb.php?src=../".$product['img_src']."&h=45&w=30&q=100";?>"></td>
                <td><a href="<?php echo $prefix_url."product-details-".$product['product_alias'];?>"><?php echo $product['product_name']?></a></td>
                <td><?php echo $product['type_name'];?></td>
                <td class="tr"><?php echo price($product['type_price']);?></td>
                <td class="tr"><?php echo $product['stock_name'];?></td>
                <td class="tr"><input type="text" class="form-control" style="width: 50px" value="<?php echo $product['stock_quantity'];?>" name="stock_quantity_<?php echo $product['stock_id'];?>"></td>
            </tr>
            <?php
            }
            ?>
          </tbody>
        </table>

      </div><!--content-->
    </div><!--box-->

  </div><!--container main-->

</form>


<script>
$(document).ready(function(e) {
   var category = "<?php echo $_REQUEST['cat'];?>";
   
   if(category == ""){
      var cat = "top";
   }else{
      var cat = category;
   }
   
   $('#category_name_search option[value="'+cat+'"]').attr('selected',true);
   $('#page-option option[value=<?php echo $_REQUEST['pg'];?>]').attr('selected', true);
   
   //changeOption();
   selectAll();
});

function selectAll(){
   $('input').click(function (){
      $(this).select();
   });
}
</script>

<?php
unset($_SESSION['msg']);
unset($_SESSION['alert']);
?>
