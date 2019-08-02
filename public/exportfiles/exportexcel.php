<?php

require '../../vendor/autoload.php';  //若使用Laravel 則已自動載入Auto項目，可需寫此行

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include('..\exportfiles\atv0002_dbconn.php'); //連接資料庫

//傳送資料並查詢
$id = $_POST['TH004'];
$sql = "select TH001,TH002,TH003,TH004,TH007,SUM(TJ009) as SUMQTY from PURTH LEFT JOIN PURTJ ON PURTH.TH002=PURTJ.TJ014 and PURTH.TH003=PURTJ.TJ015 and PURTJ.TJ020='Y' WHERE TH030='Y' AND TH004 like '".$id."' GROUP BY TH001,TH002,TH003,TH004,TH007 ORDER BY TH002 DESC,TH003";
$stmt = $db->query($sql);
//if (count($stmt)<1) {
//    echo "查無資料";
//}else{
$spreadsheet = new Spreadsheet();  // 開新excel檔案
$worksheet = $spreadsheet->getActiveSheet(); 
$worksheet->setTitle('進貨單資料明細');
//定義欄位
$worksheet->setCellValueByColumnAndRow(1, 1, '進貨單別');
$worksheet->setCellValueByColumnAndRow(2, 1, '進貨單號');
$worksheet->setCellValueByColumnAndRow(3, 1, '進貨序號');
$worksheet->setCellValueByColumnAndRow(4, 1, '進貨品號');
$worksheet->setCellValueByColumnAndRow(5, 1, '進貨數量');
$worksheet->setCellValueByColumnAndRow(6, 1, '合計已退貨數量');

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$len = count($rows);
$j = 0;
for ($i=0; $i < $len; $i++) { 
    $j = $i + 2;
    $worksheet->setCellValueByColumnAndRow(1, $j, $rows[$i]['TH001']);
    $worksheet->setCellValueByColumnAndRow(2, $j, $rows[$i]['TH002']);
    $worksheet->setCellValueByColumnAndRow(3, $j, $rows[$i]['TH003']);
    $worksheet->setCellValueByColumnAndRow(4, $j, $rows[$i]['TH004']);
    $worksheet->setCellValueByColumnAndRow(5, $j, $rows[$i]['TH007']);
    $worksheet->setCellValueByColumnAndRow(6, $j, $rows[$i]['SUMQTY']);
}

// 下载
$filename = '進退貨彙總.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
//}
?>