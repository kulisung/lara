<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet       = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '這是第一格');

$writer = new Xlsx($spreadsheet);
$writer->save('存放於主機檔名.xlsx');