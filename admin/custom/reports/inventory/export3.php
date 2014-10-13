<?php
include("control.php");

/*
--------------------
|     DATABASE     |
--------------------
*/

// CONNECT DATABASE
function connDB($host="localhost:3306", $user="root", $pass=""){
   $conn = @mysql_pconnect($host, $user, $pass)
			     Or die ("Database Error : ".mysql_error());
   
   if($conn){
	  return $conn;
   }
   
}

// DISCONNECT DATABASE
function disconnect() {
   $conn = @mysql_pconnect($host, $user, $pass)
           Or die ("Database Error : ".mysql_error());
   mysql_close($conn);
}

function db($sql){
	$conn = connDB();
	//echo $sql.'<br><br>';

	$query  = mysql_query($sql, $conn);
	$row    = array();
          while($result = mysql_fetch_array($query)){
		     array_push($row, $result);
		  }
    return $row;

}

function get_info(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_infos";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_general(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_general";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function get_customer_global($get_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_id` = '$get_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

// CALL FUNCTION
$conn    = connDB();


// SELECT DATABASE
mysql_select_db("presentation",$conn);

// GET DIRNAME
function get_dirname($path){
   $current_dir = dirname($path);
   
   if($current_dir == "/" || $current_dir == "\\"){
      $current_dir = '';
   }
   
   return $current_dir;
}

//STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/reporting/inventory\">\n";
?>

<?php
/** Error reporting */
//error_reporting(E_ALL);

/** Include path **/
ini_set('include_path', ini_get('include_path').';../Classes/');

/** PHPExcel */
include '../../static/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include '../../static/PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object
echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Antikode");
$objPHPExcel->getProperties()->setLastModifiedBy("Antikode");
$objPHPExcel->getProperties()->setTitle(date('dm')."Inventory Report (".$root_name.")");
$objPHPExcel->getProperties()->setSubject("Inventory Report (".$root_name.")");
$objPHPExcel->getProperties()->setDescription("Generated from the website.");


// Add some data
echo date('H:i:s') . " Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Inventory Report');
$objPHPExcel->getActiveSheet()->mergeCells("A1:E1");
$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Category : '.$root_name);
$objPHPExcel->getActiveSheet()->mergeCells("A2:E2");
$objPHPExcel->getActiveSheet()->SetCellValue('A3', date('j F Y'));
$objPHPExcel->getActiveSheet()->mergeCells("A3:E3");

//head row
$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'SKU');
$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Item');
$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Qty.');
$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Value');
$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Total Value');

//summary row
$objPHPExcel->getActiveSheet()->SetCellValue('A6', '');
$objPHPExcel->getActiveSheet()->SetCellValue('B6', $root_name);
$objPHPExcel->getActiveSheet()->SetCellValue('C6', $root_sales_detail['quantity']);
$objPHPExcel->getActiveSheet()->SetCellValue('D6', '');
$objPHPExcel->getActiveSheet()->SetCellValue('E6', number_format($root_sales_detail['subtotal'],0,',','.'));

//rows
$rowxls = 6;

print_category($iteration,$root,0);

function print_category($iteration,$parent,$i){
	$i++;
	global $rowxls, $objPHPExcel;
	echo 'row xls '.$rowxls.'<br/>';
	if ($iteration!=null){
	if(is_array($iteration[$parent])){
		foreach ($iteration[$parent] as $iteration_){

			print_r($iteration_);


			$sales_detail = find_sales($iteration_['id']);
			//print_r($sales_detail);



			if ($sales_detail['quantity']>0){
				$rowxls++;
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowxls, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowxls, ucfirst($iteration_['name']));
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowxls, $sales_detail['quantity']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowxls, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowxls, number_format($sales_detail['subtotal'],0,',','.'));

				if ($iteration[$iteration_['id']]==null){

					$sales_items = find_sales_items($iteration_['id']);

					$row = 1;
					foreach ($sales_items as $sales_item){
						$rowxls++;
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowxls, $sales_item['type_code']);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowxls, $sales_item['product_name'].' / '. $sales_item["type_name"].' / '.$sales_item["stock_name"]);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowxls, $sales_item['quantity']);
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowxls, number_format($sales_item['type_price'],0,',','.'));
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowxls, number_format($sales_item['subtotal'],0,',','.'));

						$row++;
					}

				}
			}



			print_category($iteration,$iteration_['id'],$i);
		}
	} //isarray
	} //iteration null
	else{

		$sales_items = find_sales_items($parent);
		
		$row = 1;
		foreach ($sales_items as $sales_item){
		 	$rowxls++;
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowxls, $sales_item['type_code']);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowxls, $sales_item['product_name'].' / '. $sales_item["type_name"].' / '.$sales_item["stock_name"]);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowxls, $sales_item['quantity']);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowxls, number_format($sales_item['type_price'],0,',','.'));
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowxls, number_format($sales_item['subtotal'],0,',','.'));
		
			$row++;
		}
	}
}



// Rename sheet
echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle($root_name);

		
// Save Excel 2007 file
echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));

// Echo done
echo date('H:i:s') . " Done writing file.\r\n";
?>