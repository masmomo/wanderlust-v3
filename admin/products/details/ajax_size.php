<?php
	include("../../custom/static/general.php");
	include('../../static/general.php');
	include("get.php");
	
	$_GET["product_alias"]=$_POST["product_alias"];
	$data = get_product_details();
	
	$size_type_id = $_POST["size_type_id"];
	$type_order = $_POST["type_order"];
	
	//echo $size_type_id;
	
	$conn = connDB();
	$check = mysql_query("
		SELECT * from tbl_size 
		WHERE size_type_id='$size_type_id' 
		ORDER BY size_order
		",$conn);
	

	if (mysql_num_rows($check)!=null){
		for($i=0;$i<mysql_num_rows($check);$i++){
			$check_array = mysql_fetch_array($check);
?>
			<!--<li class="field">
                <label for="sizes" <?php if ($i>0){?>class="invisible"<?php } ?>>Sizes</label>
                <div>
                     <p class="row-label"><?php echo $check_array["size_name"];?></p>
                     <input type="text" class="input-text" id="" name="stock_quantity[<?php echo $type_order;?>][]" placeholder="0"  style="width:50px; text-align:right" value="<?php $size_name=$check_array["size_name"];echo $data['quantity'][$type_order][$size_name];?>"/>
                     <input type="hidden" class="input-text" id="" name="stock_name[<?php echo $type_order;?>][]" value="<?php echo $check_array["size_name"]?>"/>
                </div>
            </li>-->
            
	    <div class="form-group row" id="lbl_size_qty">
	      <label class="col-xs-3 control-label <?php if ($i>0){?>invisible<?php } ?>" for="sizes" >Sizes</label>
	      <div class="col-xs-9">
	        <div class="form-group row">
	          <label class="col-xs-2 control-label"><?php echo $check_array["size_name"]?></label>
	          <div class="col-xs-2">
	            <input type="text" class="form-control" id="stock_qty_<?php echo $i;?>" name="stock_quantity[<?php echo $type_order;?>][]" placeholder="0" value="<?php $size_name=$check_array["size_name"];echo $data['quantity'][$type_order][$size_name];?>">
	            <input type="hidden" class="input-text" id="" name="stock_name[<?php echo $type_order;?>][]" value="<?php echo $check_array["size_name"]?>"/>
	          </div>
	        </div>
	      </div>
	    </div>
		<?php			
		}
	}
	?>
							