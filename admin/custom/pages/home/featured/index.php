<?php
include('../../../static/general.php');
include('control.php');
?>

<div class="box clearfix">
    <div class="desc">
        <h3>Featured Products</h3>
        <p>Edit home featured products.</p>
    </div>
    <div class="content">
        <ul class="field-set">
        
        <?php
        function get_feature_product(){
		   $conn   = connDB();
		   
		   $sql    = "SELECT prod.id, prod.product_name,
		                     type.type_id, type.type_name
					  FROM tbl_product AS prod INNER JOIN tbl_product_type AS type
					  ON prod.id = type.product_id
					  GROUP BY `id`
					 ";
		   $query  = mysql_query($sql, $conn);
		   $row    = array();
		   
		   while($result = mysql_fetch_array($query)){
		      array_push($row, $result);
		   }
		   
		   return $row;
		}
		
		$get_featured = get_feature_product();
		
        for($i=1;$i<9;$i++){
		   $get_featured_alias_id = get_featured($i);
		?>
            <li class="field">
                <label for="product-name">Product <?php echo $i?></label>
                <select class="input-select" id="product-name-<?php echo $i;?>" name="product-name[]">
                  <option>Product Name</option>
                  <?php
                  foreach($get_featured as $featured){
				     echo "<option value=\"".$featured['type_id']."\" id=\"".$featured['type_id']."\">".$featured['product_name']." - ".$featured['type_name']."</option>";
				  }
				  ?>
                  
                  <input type="hidden" name="check_featured<?php echo $i?>" id="check-featured-<?php echo $i?>" value="<?php if(!empty($check_featured['featured_alias_id'])){echo $i;}else{ echo "filled";}?>">
                </select>
            </li>
        
        <script>
		$('#product-name-<?php echo $i;?> option[value=<?php echo $get_featured_alias_id['featured_type_id'];?>]').attr('selected', 'selected');
        </script>
            
        <?php }//END FOR?>
        
        
        </ul>
    </div>
</div><!--box-->