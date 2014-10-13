<?php
include('../../static/general.php');
include('../../../static/general.php');

/* -- FUNCTIONS -- */
function get_filter(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_filter ORDER BY `filter_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


function get_products($post_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_filtered($post_product_id, $post_filter_id){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_filter_item WHERE `filter_param` = '$post_filter_id' AND `product_param` = '$post_product_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



// DEFINED VARIABLE
$ajx_alias = $_POST['alias'];


// CALL FUNCTIONS
$filter       = get_filter();
$data_product = get_products($ajx_alias);
?>
            <span id="id_filter_container">
            
              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Filter</h3>
                  <p>Manage filter.</p>
                </div>
                
                <div class="content col-xs-9">
                  <ul class="form-set">
                    <li class="form-group row">
                      
					  <?php
					  foreach($filter as $filter){
					     
						 $filtered = get_filtered($data_product['id'], $filter['filter_id']);
						   
					     echo '<div class="col-xs-4">';
						 echo '<input type="checkbox" id="id_filter_'.$filter['filter_id'].'" ';
						 
						 if($filtered['rows'] > 0){
						    echo 'checked = "checked" ';
						 }
						 
						 echo 'class="form-control-'.$filter['filter_id'].'" style="margin-bottom:10px;" name="filter_id[]" value="'.$filter['filter_id'].'"> &nbsp;'.$filter['filter_name'];
						 echo '</div>';
					  }
					  ?>
                      
                    </li>
                  </ul>
                </div>
              </div><!--box-->
              
            </span>
              
<script>
</script>