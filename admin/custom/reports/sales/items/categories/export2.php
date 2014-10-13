<?php
/** Error reporting */
//error_reporting(E_ALL);

if ($date_start=='0000-00-00 00:00:00'){
	$date_title = 'Full';
}
else{
	$date_title = date('dm',strtotime($date_start)).' - '.date('dm',strtotime($date_end));
}

/** Include path **/
ini_set('include_path', ini_get('include_path').';../Classes/');

/** PHPExcel */
include 'static/PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include 'static/PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object
//echo date('H:i:s') . " Create new PHPExcel object\n";
$objPHPExcel = new PHPExcel();

// Set properties
//echo date('H:i:s') . " Set properties\n";
$objPHPExcel->getProperties()->setCreator("Antikode");
$objPHPExcel->getProperties()->setLastModifiedBy("Antikode");
$objPHPExcel->getProperties()->setTitle($date_title." Sales By Items (Categories)");
$objPHPExcel->getProperties()->setSubject("Sales By Items (Categories)");
$objPHPExcel->getProperties()->setDescription("Generated from the website by Antikode.");

// Add some data
//echo date('H:i:s') . " Add some data\n";
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Sales By Items (Categories)');
$objPHPExcel->getActiveSheet()->mergeCells("A1:G1");
$objPHPExcel->getActiveSheet()->SetCellValue('A2', '');
$objPHPExcel->getActiveSheet()->mergeCells("A2:G2");
$objPHPExcel->getActiveSheet()->SetCellValue('A3', date('j F Y'),strtotime($date_start).' - '.date('j F Y'),strtotime($date_end));
$objPHPExcel->getActiveSheet()->mergeCells("A3:G3");
$objPHPExcel->getActiveSheet()->mergeCells("A4:G4");

//head row
$objPHPExcel->getActiveSheet()->SetCellValue('A5', 'SKU');
$objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Item');
$objPHPExcel->getActiveSheet()->SetCellValue('C5', 'Qty.');
$objPHPExcel->getActiveSheet()->SetCellValue('D5', 'Sales Price');
$objPHPExcel->getActiveSheet()->SetCellValue('E5', 'Subtotal');
$objPHPExcel->getActiveSheet()->SetCellValue('F5', 'Discount');
$objPHPExcel->getActiveSheet()->SetCellValue('G5', 'Total');

//summary row

$objPHPExcel->getActiveSheet()->SetCellValue('A6', '');
$objPHPExcel->getActiveSheet()->SetCellValue('B6', 'All Categories');
$objPHPExcel->getActiveSheet()->SetCellValue('C6', $root_sales_detail['quantity']);
$objPHPExcel->getActiveSheet()->SetCellValue('D6', '');
$objPHPExcel->getActiveSheet()->SetCellValueExplicit('E6', price($root_sales_detail['subtotal']),PHPExcel_Cell_DataType::TYPE_STRING);
if($root_sales_detail['discount']!=0){
$objPHPExcel->getActiveSheet()->SetCellValueExplicit('F6',  "-".price($root_sales_detail['discount']),PHPExcel_Cell_DataType::TYPE_STRING);
}
$objPHPExcel->getActiveSheet()->SetCellValueExplicit('G6', price($root_sales_detail['subtotal']-$root_sales_detail['discount']),PHPExcel_Cell_DataType::TYPE_STRING);

$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A6:G6')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'bbbbbb')));

//rows
$rowxls = 6;

print_category_xls($iteration,$root,0);

function print_category_xls($iteration,$parent,$i){
	$i++;
	global $rowxls, $objPHPExcel;
	
	
	if(is_array($iteration[$parent])){
		foreach ($iteration[$parent] as $iteration_){

			//print_r($iteration_);


			$sales_detail = find_sales($iteration_['id']);
			//print_r($sales_detail);



			if ($sales_detail['quantity']>0){
				$rowxls++;
				

				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowxls, '');
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowxls, ucfirst($iteration_['name']));
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowxls, $sales_detail['quantity']);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowxls, '');
				$objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$rowxls, price($sales_detail['subtotal']),PHPExcel_Cell_DataType::TYPE_STRING);
				if($sales_detail['discount']!=0){
				$objPHPExcel->getActiveSheet()->SetCellValueExplicit('F'.$rowxls, "-".price($sales_detail['discount']),PHPExcel_Cell_DataType::TYPE_STRING);
				}
				$objPHPExcel->getActiveSheet()->SetCellValueExplicit('G'.$rowxls, price($sales_detail['subtotal']-$sales_detail['discount']),PHPExcel_Cell_DataType::TYPE_STRING);
				
				//format cell
				
				
				if ($i==1){
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowxls.':E'.$rowxls)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowxls.':E'.$rowxls)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'cccccc')));
				}
				else if ($i==2){
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowxls.':E'.$rowxls)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowxls.':E'.$rowxls)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'dddddd')));
				}
				else if($i>2){
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowxls.':E'.$rowxls)->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$rowxls.':E'.$rowxls)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'eeeeee')));
				}

				if ($iteration[$iteration_['id']]==null){

					$sales_items = find_sales_items($iteration_['id']);

					$row = 1;
					foreach ($sales_items as $sales_item){
						$rowxls++;
						

						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowxls, $sales_item['type_code']);
						$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowxls, $sales_item['product_name'].' / '. $sales_item["type_name"].' / '.$sales_item["stock_name"]);
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowxls, $sales_item['quantity']);
						$objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$rowxls, price($sales_item['item_price']),PHPExcel_Cell_DataType::TYPE_STRING);
						
						$objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$rowxls, price($sales_item['subtotal']),PHPExcel_Cell_DataType::TYPE_STRING);
						if($sales_item['discount']!=0){
						$objPHPExcel->getActiveSheet()->SetCellValueExplicit('F'.$rowxls, "-".price($sales_item['discount']),PHPExcel_Cell_DataType::TYPE_STRING);
						}
						$objPHPExcel->getActiveSheet()->SetCellValueExplicit('G'.$rowxls, price($sales_item['subtotal']-$sales_item['discount']),PHPExcel_Cell_DataType::TYPE_STRING);

						$row++;
					}

				}
			}



			print_category_xls($iteration,$iteration_['id'],$i);
		}
	} //isarray
}

//format cell

$objPHPExcel->getDefaultStyle()->getFont()
    ->setName('Helvetica')
    ->setSize(10);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);

//title
$objPHPExcel->getActiveSheet()->getStyle('A1:G3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



//header row
$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => '000000')));
$objPHPExcel->getActiveSheet()->getStyle('A5:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


for ($x=1;$x<=$rowxls;$x++){
	$objPHPExcel->getActiveSheet()->getRowDimension($x)->setRowHeight(22);
}

$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$rowxls)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A6:B'.$rowxls)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('C6:G'.$rowxls)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// Rename sheet
//echo date('H:i:s') . " Rename sheet\n";
$objPHPExcel->getActiveSheet()->setTitle($root_name);

		
// Save Excel 2007 file
//echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$objWriter->save('reports/exports/'.$date_title.' Sales By Items (Categories).xlsx');

// Echo done
//echo date('H:i:s') . " Done writing file.\r\n";
?>