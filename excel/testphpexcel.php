
<?php
// Include PHPExcel
require 'PHPExcel-1.8\Classes\PHPExcel.php';  // If you installed via Composer
// Or include manually: require 'path_to_phpexcel/PHPExcel.php';


// Create a new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Your Name")
    ->setLastModifiedBy("Your Name")
    ->setTitle("PHPExcel Test Document")
    ->setSubject("PHPExcel Test")
    ->setDescription("Test document for PHPExcel, generated using PHP classes.")
    ->setKeywords("phpexcel test php")
    ->setCategory("Test result file");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Hello')  // Add data in cell A1
    ->setCellValue('B1', 'World')  // Add data in cell B1
    ->setCellValue('A2', 'PHPExcel') // Add data in cell A2
    ->setCellValue('B2', 'Test');  // Add data in cell B2

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple Test');

// Save Excel 2007 file (XLSX format)
$excelFileName = 'test_phpexcel.xlsx';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save($excelFileName);

// Save Excel 5 file (XLS format)
$excelFileNameOld = 'test_phpexcel.xls';
$objWriterOld = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriterOld->save($excelFileNameOld);

// Success message
echo "Test files created successfully: $excelFileName and $excelFileNameOld";
?>