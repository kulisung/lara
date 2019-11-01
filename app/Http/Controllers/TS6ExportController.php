<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TS6ExportController extends Controller
{
    //ts6member查詢匯出
    public function ts6members_export(Request $request)
    {
        //
        $join_strdate = $request->input('strdate');
        $member_finaldata = DB::table('ts6members')->orderby('register_date','desc')->limit(1)->value('register_date');
        if ($join_strdate < 1) {
            $sqlstr = '2017-01-01';
        }else{
            $sqlstr = substr($join_strdate,0,4).'-'.substr($join_strdate,4,2).'-'.substr($join_strdate,6,2);
        }
        $sqlend = substr($member_finaldata,0,10);
        //
        $member_exports = DB::select('SELECT name,email,cellphone,tel,register_date 
        FROM ts6members
        WHERE left(register_date,10) >= ? and left(register_date,10) <= ?
        ORDER BY register_date DESC',[$sqlstr,$sqlend]);

        if (count($member_exports)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('ts6members'); //指定工作表名稱
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '會員姓名');
        $worksheet->setCellValueByColumnAndRow(2, 1, 'Email');
        $worksheet->setCellValueByColumnAndRow(3, 1, '手機');
        $worksheet->setCellValueByColumnAndRow(4, 1, '電話');
        $worksheet->setCellValueByColumnAndRow(5, 1, '註冊時間');

        $j = 1;
        foreach ($member_exports as $member_export) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $member_export->name);
            $worksheet->setCellValueByColumnAndRow(2, $j, $member_export->email);
            $worksheet->setCellValueByColumnAndRow(3, $j, $member_export->cellphone);
            $worksheet->setCellValueByColumnAndRow(4, $j, $member_export->tel);
            $worksheet->setCellValueByColumnAndRow(5, $j, $member_export->register_date);
        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = $sqlstr.'_'.$sqlend.'_ts6members.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    
    }

    //TS6查詢匯出
    public function ts6orders_export(Request $request)
    {
        //
    }

}
