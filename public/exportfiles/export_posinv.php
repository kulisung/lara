<?php
ini_set("memory_limit", "256M");
require '../../vendor/autoload.php';  //若使用Laravel 則已自動載入Auto項目，可需寫此行

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include('..\exportfiles\tensall_dbconn.php'); //連接資料庫

//傳送資料並查詢
$Str_id = $_POST['date1'];
$End_id = $_POST['date2'];
$sql = "SELECT TH001,TH002,TH003,TH004,TH005,TG003,TG004,TG005,TG007,TG012,TG014,TG098,MB006,MB008,SUM(TH008+TH024) as QTY FROM COPTH LEFT JOIN COPTG ON (COPTH.TH001=COPTG.TG001 AND COPTH.TH002=COPTG.TG002 AND COPTH.TH007='B24' AND COPTG.TG004='ATP0002' AND COPTG.TG023<>'V') LEFT JOIN INVMB ON (COPTH.TH004=INVMB.MB001) WHERE COPTG.TG003>='".$Str_id."' AND COPTG.TG003<='".$End_id."' GROUP BY TH001,TH002,TH003,TH004,TH005,TG003,TG004,TG005,TG007,TG012,TG014,TG098,MB006,MB008";
$stmt = $db->query($sql);
//if (count($stmt)<1) {
//    echo "查無資料";
//}else{
$spreadsheet = new Spreadsheet();  // 開新excel檔案
$sheet = $spreadsheet->getActiveSheet(); 
$sheet->setTitle('展場銷貨資料明細');
//定義欄位
$sheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
$sheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
$sheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
$sheet->setCellValueByColumnAndRow(4, 1, '部門');
$sheet->setCellValueByColumnAndRow(5, 1, '品牌');
$sheet->setCellValueByColumnAndRow(6, 1, '四大類');
$sheet->setCellValueByColumnAndRow(7, 1, '品號');
$sheet->setCellValueByColumnAndRow(8, 1, '品名');
$sheet->setCellValueByColumnAndRow(9, 1, '數量');
$sheet->setCellValueByColumnAndRow(10, 1, '匯率/單位');
$sheet->setCellValueByColumnAndRow(11, 1, '發票起號');
$sheet->setCellValueByColumnAndRow(12, 1, '發票迄號');
$sheet->setCellValueByColumnAndRow(13, 1, '單別');
$sheet->setCellValueByColumnAndRow(14, 1, '單號');
$sheet->setCellValueByColumnAndRow(15, 1, '序號');

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$len = count($rows);
$j = 0;
for ($i=0; $i < $len; $i++) { 
    $j = $i + 2;
    $sheet->setCellValueByColumnAndRow(1, $j, $rows[$i]['TG004']);
    $sheet->setCellValueByColumnAndRow(2, $j, $rows[$i]['TG007']);
    $sheet->setCellValueByColumnAndRow(3, $j, $rows[$i]['TG003']);
    $sheet->setCellValueByColumnAndRow(4, $j, $rows[$i]['TG005']);
    $sheet->setCellValueByColumnAndRow(5, $j, $rows[$i]['MB008']);
    $sheet->setCellValueByColumnAndRow(6, $j, $rows[$i]['MB006']);
    $sheet->setCellValueByColumnAndRow(7, $j, $rows[$i]['TH004']);
    $sheet->setCellValueByColumnAndRow(8, $j, $rows[$i]['TH005']);
    $sheet->setCellValueByColumnAndRow(9, $j, $rows[$i]['QTY']);
    $sheet->setCellValueByColumnAndRow(10, $j, $rows[$i]['TG012']);
    $sheet->setCellValueByColumnAndRow(11, $j, $rows[$i]['TG098']);
    $sheet->setCellValueByColumnAndRow(12, $j, $rows[$i]['TG014']);
    $sheet->setCellValueByColumnAndRow(13, $j, $rows[$i]['TH001']);
    $sheet->setCellValueByColumnAndRow(14, $j, $rows[$i]['TH002']);
    $sheet->setCellValueByColumnAndRow(15, $j, $rows[$i]['TH003']);
}

// 下载
$filename = '展場銷貨明細.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
//}
?>