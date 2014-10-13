<?php
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

// CALL FUNCTIONS
$filter      = get_filter();
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
						   
					     echo '<div class="col-xs-4">';
						 echo '<input type="checkbox" id="id_filter_'.$filter['filter_id'].'" ';
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
function test(x){
  alert(x)
}

$(document).ready(function(e) {
   //test(<?php echo $_REQUEST['product_alias'];?>);
});
</script>