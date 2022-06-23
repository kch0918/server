<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPExcel-1.8/Classes/PHPExcel.php");
require_once($_SERVER['DOCUMENT_ROOT']."/include/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php");
require_once($_SERVER['DOCUMENT_ROOT']."/mail/excel_mail.php");

header('Content-Type: text/html; charset=utf-8');
$uploadBase = "uploads/";
if (!is_dir($uploadBase)){
    if(@mkdir($uploadBase, 0777)) {
        if(is_dir($uploadBase)) {
            @chmod($uploadBase, 0777);
        }
    }
    else {
        
    }
}
for( $i=0 ; $i < count($_FILES['excel_upload']['name']); $i++ ) {
    $name = $_FILES['excel_upload']['name'][$i];
   // $name = iconv("utf-8","CP949",$name); //한글 파일명이 안되가지구.....
    $fileType = $_FILES['excel_upload']['type'][$i];
    
    if($fileType !== "")
    {
        if($fileType !== "application/vnd.ms-excel" && $fileType !== "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $fileType !== "application/haansoftxlsx" && $fileType !== "application/haansoftxls")
        {
            ?>
            {
            	"isSuc":"fail",
            	"msg":"xlsx 혹은 xls 파일만 가능합니다."
            }
            <?php
            exit;
        }
        
        if(move_uploaded_file($_FILES['excel_upload']['tmp_name'][$i], "$uploadBase/$name"))
        {
            $objPHPExcel = new PHPExcel();
            $filename = "uploads/{$name}";
            
            try {
                
                $objReader = PHPExcel_IOFactory::createReaderForFile($filename);
                $objReader->setReadDataOnly(true);
                $objExcel = $objReader->load($filename);
                $objExcel->setActiveSheetIndex(0);
                $objWorksheet = $objExcel->getActiveSheet();
                $rowIterator = $objWorksheet->getRowIterator();
                foreach ($rowIterator as $row) 
                {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(false);
                }
                $maxRow = $objWorksheet->getHighestRow();
                
                for ($j = 2 ; $j <= $maxRow ; $j++) 
                {
                    $date_start = $objWorksheet     ->  getCell('A' . $j)->getValue();
                    $date_end = $objWorksheet       ->  getCell('B' . $j)->getValue();
                    $over_date = $objWorksheet      ->  getCell('C' . $j)->getValue(); 
                    $send_email = $objWorksheet     ->  getCell('D' . $j)->getValue();
                    $today = $objWorksheet          ->  getCell('E' . $j)->getValue();
                    $client_name = $objWorksheet    ->  getCell('F' . $j)->getValue();
                    $connect_domain = $objWorksheet ->  getCell('G' . $j)->getValue();
                    $finish_date = $objWorksheet    ->  getCell('H' . $j)->getValue();
                    
                    $email_arr = explode(",", $send_email);
                    $client_name_str = str_replace(' ', ',', $client_name);
                    $connect_domain_str = str_replace(' ', ',', $connect_domain);
                    
                    $date_start = date('Y.m.d', strtotime($date_start));
                    $date_end = date('Y.m.d',strtotime($date_end));
                    
                    
                    
                    for($i = 0; $i < count($email_arr); $i++){
                        send_excel_mail($date_start, $date_end, $over_date, $email_arr[$i], $today, $client_name_str, $connect_domain_str, $finish_date);
                    }
                }
            }
            catch (exception $e) 
            {
                ?>
                {
                	"isSuc":"fail",
                	"msg":"엑셀파일을 읽는도중 오류가 발생하였습니다.(2)"
                }
                <?php
                exit;
            }
        }
        else
        {
            ?>
            {
            	"isSuc":"fail",
            	"msg":"파일 업로드에 실패하였습니다.(3)"
            }
            <?php
            exit;
        }
    }
}

?>
{
	"isSuc":"success",
	"msg":"저장 되었습니다"
}
