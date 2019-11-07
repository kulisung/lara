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
    public function ts6members_export(Request $request, $sqlstr)
    {
        //
        //$join_strdate = $request->input('strdate');
        /*
        if ($join_strdate < 1) {
            $sqlstr = '2017-01-01';
        }else{
            $sqlstr = substr($join_strdate,0,4).'-'.substr($join_strdate,4,2).'-'.substr($join_strdate,6,2);
        }
        */
        $member_finaldata = DB::table('ts6members')->orderby('register_date','desc')->limit(1)->value('register_date');
        $sqlend = substr($member_finaldata,0,10);
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
        $filename = $sqlstr.'_'.$sqlend.'_會員資料.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    
    }

    //Orders Count
    public function ts6counts_export(Request $request)
    {
        //查詢大於等於輸入次數，並顯示聯繫資料
        //$orderscount = $request->input('orders');
        //$order_enddate = $request->input('orderend');
        //判斷次數未輸入則視為大於等於1
        /*if ($orderscount < 1) {
            $orderscount = 1;
        }
        if ($order_enddate < 1) {
            $sqlend = substr($member_finaldata,0,10); //未輸入日期取最後一筆訂單時間
        }else{ 
            $sqlend = substr($order_enddate,0,4).'/'.substr($order_enddate,4,2).'/'.substr($order_enddate,6,2);
        }*/ 
        //修改為查詢後頁面轉匯出，故上述無須判定
        //$member_finaldata = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        //$sqlend = substr($member_finaldata,0,10);
        $sqlstr = $request->input('sqlstr');
        $sqlend = $request->input('sqlend');
        $orderscount = $request->input('orderscount');
        //$sqlstr = '2018/01/01';
        //$sqlend = '2019/09/30';
        $orders = DB::select('SELECT name,email,phone,count(order_id) AS orders_count,sum(total_amount) AS total_amount
        FROM ( SELECT DISTINCT order_id,name,email,phone,total_amount FROM ts6orders WHERE left(order_time,10) >= ? AND left(order_time,10) <= ? ) P
        GROUP BY name,email,phone
        HAVING orders_count >= ?
        ORDER BY orders_count DESC',
        [$sqlstr, $sqlend, $orderscount]);

        $ordertimes = count($orders);
        if ($ordertimes < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
    
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('下單次數統計'); //指定工作表名稱
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '會員姓名');
        $worksheet->setCellValueByColumnAndRow(2, 1, 'Email');
        $worksheet->setCellValueByColumnAndRow(3, 1, '電話');
        $worksheet->setCellValueByColumnAndRow(4, 1, '累計下單次數');
        $worksheet->setCellValueByColumnAndRow(5, 1, '累計下單金額');

        $j = 1;
        foreach ($orders as $order) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $order->name);
            $worksheet->setCellValueByColumnAndRow(2, $j, $order->email);
            $worksheet->setCellValueByColumnAndRow(3, $j, $order->phone);
            $worksheet->setCellValueByColumnAndRow(4, $j, $order->orders_count);
            $worksheet->setCellValueByColumnAndRow(5, $j, $order->total_amount);
        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = $sqlstr.'至'.$sqlend.'訂單大於'.$orderscount.'次會員清單.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    
    }

    //Items Count
    public function ts6items_export(Request $request)
    {
        //商品購買次數統計匯出
        $sqlstr = $request->input('sqlstr');
        $sqlend = $request->input('sqlend');
        $itemscount = $request->input('itemscount');
        $items = DB::select('SELECT name,email,phone,item_name,item_id,count(item_name) AS items_count,sum(total_amount) AS total_amount
        FROM ts6orders
        WHERE left(order_time,10) >= ? and left(order_time,10) <= ?
        GROUP BY name,email,phone,item_name,item_id
        HAVING items_count >= ?
        ORDER BY items_count DESC',
        [$sqlstr, $sqlend, $itemscount]);

        $itemtimes = count($items);
        if ($itemtimes < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
    
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('商品次數統計'); //指定工作表名稱
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '會員姓名');
        $worksheet->setCellValueByColumnAndRow(2, 1, 'Email');
        $worksheet->setCellValueByColumnAndRow(3, 1, '電話');
        $worksheet->setCellValueByColumnAndRow(4, 1, '商品名稱');
        $worksheet->setCellValueByColumnAndRow(5, 1, '商品編號');
        $worksheet->setCellValueByColumnAndRow(6, 1, '商品累計次數');
        $worksheet->setCellValueByColumnAndRow(7, 1, '累計下單金額');

        $j = 1;
        foreach ($items as $item) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $item->name);
            $worksheet->setCellValueByColumnAndRow(2, $j, $item->email);
            $worksheet->setCellValueByColumnAndRow(3, $j, $item->phone);
            $worksheet->setCellValueByColumnAndRow(4, $j, $item->item_name);
            $worksheet->setCellValueByColumnAndRow(5, $j, $item->item_id);
            $worksheet->setCellValueByColumnAndRow(6, $j, $item->items_count);
            $worksheet->setCellValueByColumnAndRow(7, $j, $item->total_amount);
        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = $sqlstr.'至'.$sqlend.'商品次數大於'.$itemscount.'次會員清單.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    }

    //會員明細資料匯出
    public function ts6detail_export(Request $request ,$mem_email)
    {
        //依會員Email查詢詳細記錄
        //$mem_email = $request->input('ts6email');
        //會員資料明細
        $ts6details = DB::select('SELECT member_id,name,email,cellphone,birthday,sex,tel,address,register_date,register_source 
        FROM ts6members
        WHERE email = ?',
        [$mem_email]);
        //訂單資料明細
        $mem_orders = DB::select('SELECT order_time,order_id,name,email,item_name,item_id,quantity,price,bonus_discount,discount,discount_amount,total_amount 
        FROM ts6orders 
        WHERE email = ?',
        [$mem_email]);
        //計算下單次數
        $order_times = DB::select('SELECT count(order_id) AS orders_count,sum(total_amount) AS orders_amount
        FROM ( SELECT DISTINCT order_id,name,email,total_amount FROM ts6orders WHERE email = ? ) P',[$mem_email]);

        $ts6count = count($ts6details);
        if ($ts6count < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('會員資料'); //指定工作表名稱
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '會員編號');
        $worksheet->setCellValueByColumnAndRow(2, 1, '姓名');
        $worksheet->setCellValueByColumnAndRow(3, 1, 'Email');
        $worksheet->setCellValueByColumnAndRow(4, 1, '手機');
        $worksheet->setCellValueByColumnAndRow(5, 1, '生日');
        $worksheet->setCellValueByColumnAndRow(6, 1, '性別');
        $worksheet->setCellValueByColumnAndRow(7, 1, '電話');
        $worksheet->setCellValueByColumnAndRow(8, 1, '地址');
        $worksheet->setCellValueByColumnAndRow(9, 1, '註冊時間');
        $worksheet->setCellValueByColumnAndRow(10, 1, '註冊來源');

        $j = 1;
        foreach ($ts6details as $ts6detail) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $ts6detail->member_id);
            $worksheet->setCellValueByColumnAndRow(2, $j, $ts6detail->name);
            $worksheet->setCellValueByColumnAndRow(3, $j, $ts6detail->email);
            $worksheet->setCellValueByColumnAndRow(4, $j, $ts6detail->cellphone);
            $worksheet->setCellValueByColumnAndRow(5, $j, $ts6detail->birthday);
            $worksheet->setCellValueByColumnAndRow(6, $j, $ts6detail->sex);
            $worksheet->setCellValueByColumnAndRow(7, $j, $ts6detail->tel);
            $worksheet->setCellValueByColumnAndRow(8, $j, $ts6detail->address);
            $worksheet->setCellValueByColumnAndRow(9, $j, $ts6detail->register_date);
            $worksheet->setCellValueByColumnAndRow(10, $j, $ts6detail->register_source);
        }

        //定義欄位 Sheet2
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(1); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(1)->setTitle('訂單明細'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '訂單日期');
        $worksheet->setCellValueByColumnAndRow(2, 1, '訂單編號');
        $worksheet->setCellValueByColumnAndRow(3, 1, '訂購人');
        $worksheet->setCellValueByColumnAndRow(4, 1, 'Email');
        $worksheet->setCellValueByColumnAndRow(5, 1, '商品名稱');
        $worksheet->setCellValueByColumnAndRow(6, 1, '商品編號');
        $worksheet->setCellValueByColumnAndRow(7, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(8, 1, '單價');
        $worksheet->setCellValueByColumnAndRow(9, 1, '紅利折扣');
        $worksheet->setCellValueByColumnAndRow(10, 1, '任選折扣');
        $worksheet->setCellValueByColumnAndRow(11, 1, '任選折扣總額');
        $worksheet->setCellValueByColumnAndRow(12, 1, '訂單總額');

        $k = 1;
        foreach ($mem_orders as $mem_order) {
            $k = $k + 1;
            $worksheet->setCellValueByColumnAndRow(1, $k, $mem_order->order_time);
            $worksheet->setCellValueByColumnAndRow(2, $k, $mem_order->order_id);
            $worksheet->setCellValueByColumnAndRow(3, $k, $mem_order->name);
            $worksheet->setCellValueByColumnAndRow(4, $k, $mem_order->email);
            $worksheet->setCellValueByColumnAndRow(5, $k, $mem_order->item_name);
            $worksheet->setCellValueByColumnAndRow(6, $k, $mem_order->item_id);
            $worksheet->setCellValueByColumnAndRow(7, $k, $mem_order->quantity);
            $worksheet->setCellValueByColumnAndRow(8, $k, $mem_order->price);
            $worksheet->setCellValueByColumnAndRow(9, $k, $mem_order->bonus_discount);
            $worksheet->setCellValueByColumnAndRow(10, $k, $mem_order->discount);
            $worksheet->setCellValueByColumnAndRow(11, $k, $mem_order->discount_amount);
            $worksheet->setCellValueByColumnAndRow(12, $k, $mem_order->total_amount);

        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = $mem_email.'_會員下單明細.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }

    }

    //TS6未下單明細匯出
    public function ts6noorder_export()
    {
        //未下單會員查詢
        $member_finaldata = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        $exportdate = substr($member_finaldata,0,10);
        //$noorder_finaldata = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        //$member_finaldata = DB::table('ts6members')->orderby('register_date','desc')->limit(1)->value('register_date');
        $noorders = DB::select('SELECT name,email,cellphone,tel,register_date 
        FROM ts6members
        WHERE NOT EXISTS (SELECT * FROM ts6orders WHERE ts6orders.email = ts6members.email)
        ORDER BY register_date DESC');

        $noorderscount = count($noorders);
        if ($noorderscount < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{

        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('未下單明細'); //指定工作表名稱
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '會員姓名');
        $worksheet->setCellValueByColumnAndRow(2, 1, 'Email');
        $worksheet->setCellValueByColumnAndRow(3, 1, '手機');
        $worksheet->setCellValueByColumnAndRow(4, 1, '電話');
        $worksheet->setCellValueByColumnAndRow(5, 1, '註冊日期');

        $j = 1;
        foreach ($noorders as $noorder) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $noorder->name);
            $worksheet->setCellValueByColumnAndRow(2, $j, $noorder->email);
            $worksheet->setCellValueByColumnAndRow(3, $j, $noorder->cellphone);
            $worksheet->setCellValueByColumnAndRow(4, $j, $noorder->tel);
            $worksheet->setCellValueByColumnAndRow(5, $j, $noorder->register_date);
        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = $exportdate.'_未下單清單.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 

        }
    }

}
