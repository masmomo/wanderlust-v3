<?php
include('../../static/general.php');
include('../../../static/general.php');

include('../../../xeditor/ckeditor_php5.php');

function get_product_how($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}



function get_how($post_product_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_custom WHERE `product_id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DEFINED VARIABLE
$ajax_alias = $_POST['alias'];


// CALL FUNCTION
$data_product = get_product_how($ajax_alias);
$how          = get_how($data_product['id']);
?>

    <span id="id_custom_container">
    
      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Content</h3>
          <p>Descriptions about your information.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
          
            <li class="form-group row underlined">
              <label class="control-label col-xs-12">How To Use</label><br /><br />
              <div class="col-xs-12">
                <?php
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$initialValue = $how['how'];
				$code = $CKEditor->editor("how", $initialValue);
				?>
              </div>
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-12">Technical Data</label><br /><br />
              <div class="col-xs-12">
                <?php
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$initialValue = $how['technical'];
				$code = $CKEditor->editor("technical", $initialValue);
				?>
              </div>
            </li>
            
          </ul>
        </div>
      </div><!--box-->
      
    </span>