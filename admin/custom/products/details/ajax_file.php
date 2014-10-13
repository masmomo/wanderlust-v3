<?php
include('../../static/general.php');
include('../../../static/general.php');


/* -- FUNCTIONS -- */
function get_products_file($post_product_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product_files WHERE `product_id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_products($post_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_alias'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


// DEFINED VARIABLE
$ajx_alias = $_POST['alias'];


// CALL FUNCTION
$data_product = get_products($ajx_alias);
$file         = get_products_file($data_product['id']);
?>

              <div class="box row">
                <div class="desc col-xs-3">
                  <h3>Files</h3>
                  <p>Manage files name.</p>
                </div>
                
                <div class="content col-xs-9">
                  <ul class="form-set">
                    
                    <li class="form-group row">
                      <label for="brand" class="control-label col-xs-3">Files <span></span></label>
                      <div class="content col-xs-9">
                        <input type="text" class="form-control" name="product_files" id="id_inspiration_name" value="<?php echo $file['files'];?>">
                      </div>
                    </li>
                    
                    <li class="form-group row">
                      <label for="brand" class="control-label col-xs-3"></label>
                      <div class="content col-xs-9">
                        <input type="file" class="" name="product_files" id="id_inspiration_name">
                      </div>
                    </li>
                    
                  </ul>
                </div>
              </div><!--box-->