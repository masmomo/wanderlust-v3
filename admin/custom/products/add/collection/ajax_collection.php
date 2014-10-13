<?php
include("../../../../custom/static/general.php");
include('../../../../static/general.php');

//GET
function get_all_collection(){
   $conn = connDB();
   
   $sql   = "SELECT * FROM tbl_collection ORDER BY collection_order ASC";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

// Category
$all_collection = get_all_collection();
$product_collection=$_POST['a'];
?>

<li class="form-group row" id="collection_field">
  <label class="col-xs-3 control-label" for="collection">Collection *</label>
  <div class="col-xs-9">
    <select class="form-control" id="product_collection" name="product_collection">
      <option value="">-- Select Collection --</option>
        <?php 
        foreach($all_collection as $all_collection_){
        	echo "<option value=\"".$all_collection_['collection_id']."\" ";
				if ($product_collection==$all_collection_['collection_id']){ echo 'selected="selected"';}
			echo ">".$all_collection_['collection_name']."</option>";
        }
        ?>
    </select>
  </div>
</li>