<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function AllUserExport() 
    {
        return view('ImportAndExport');
    }

    public function userexport() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function userimport() 
    {
        //$users = User::get()->toArray();
        //$data = (new UsersImport)->toArray(request()->file('import_file'));
        Excel::import(new UsersImport,request()->file('import_file'));
        return back()->with('success','Insert Records successfully.');
        //return redirect('/')->with('success', 'All good!');
    }
    
    public function export_xls(Request $request) 
    {
        $productid = $request->input('TH004').'%';
        $worktimes = DB::connection('sqlsrv_atv0002')->select('select TH001,TH002,TH003,TH004,TH007,SUM(TJ009) as SUMQTY from worktime LEFT JOIN PURTJ ON worktime.TH002=PURTJ.TJ014 and worktime.TH003=PURTJ.TJ015 and PURTJ.TJ020=? WHERE TH030=? AND TH004 like ? GROUP BY TH001,TH002,TH003,TH004,TH007 ORDER BY TH002 DESC,TH003',['Y', 'Y', $productid]);
 
        if (count($worktimes)<1) {
            $result = 'No data!';
            return View('nodata')->with('result', $result);
        }else{
            //$result = 'Good Job!';
            //return View('nodata')->with('result', $result);
        
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

        $j = 1;
        foreach ($worktimes as $worktime) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $worktime->TH001);
            $worksheet->setCellValueByColumnAndRow(2, $j, $worktime->TH002);
            $worksheet->setCellValueByColumnAndRow(3, $j, $worktime->TH003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $worktime->TH004);
            $worksheet->setCellValueByColumnAndRow(5, $j, $worktime->TH007);
            $worksheet->setCellValueByColumnAndRow(6, $j, $worktime->SUMQTY);
        }

        // 下载
        $filename = '進退貨彙總.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    }

    //展場銷貨匯出
    public function pos_inv_export(Request $request) 
    {
        $date_str = $request->input('date1');
        $date_end = $request->input('date2');
        //Page_Invoice_SQL
        $invs = DB::connection('sqlsrv_tensall')->select('SELECT TH001,TH002,TH003,TH004,TH005,TG003,TG004,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as TG005,TG007,TG012,TG014,TG098,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as MB006,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as MB008,SUM(TH008+TH024) as QTY FROM COPTH LEFT JOIN COPTG ON (COPTH.TH001=COPTG.TG001 AND COPTH.TH002=COPTG.TG002 AND COPTH.TH007=? AND COPTG.TG004=? AND COPTG.TG023<>?) LEFT JOIN INVMB ON (COPTH.TH004=INVMB.MB001) WHERE COPTG.TG003>=? AND COPTG.TG003<=? GROUP BY TH001,TH002,TH003,TH004,TH005,TG003,TG004,TG005,TG007,TG012,TG014,TG098,MB006,MB008',['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','21','食品','22','化妝品','23','私密保養品','26','商品成品','Other','01','TS6','02','ODM','Other','B24','ATP0002','V',$date_str,$date_end]);

        //Page_Stocks_SQL
        $stocks = DB::connection('sqlsrv_tensall')->select('SELECT P.AA,P.BB,P.CC,SUM(P.DD) AS QTY FROM (SELECT TH004 AS AA,TH005 AS BB,TH006 AS CC , SUM(TH008+TH024) AS DD FROM COPTG,COPTH WHERE TG001=TH001 AND TG002=TH002 AND (TG004=?) AND TG003>=? AND TG003<=? AND TH007=? AND TG023<>? GROUP BY  TH004,TH005,TH006 
        UNION
        SELECT TJ004 AS AA,TJ005 AS BB,TJ006 AS CC,SUM(TJ007)*-1 AS DD
        FROM COPTI,COPTJ WHERE TI001=TJ001 AND TI002=TJ002 AND (TI004=?) AND TI003>=? AND TI003<=? AND TJ013=? AND TI019<>? GROUP BY TJ004,TJ005,TJ006) P GROUP BY AA,BB,CC',['ATP0002',$date_str,$date_end,'B24','V','ATP0002',$date_str,$date_end,'B24','V']);

        if (count($invs)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }elseif(count($stocks)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('sales&invoice'); //指定工作表名稱
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '品號');
        $worksheet->setCellValueByColumnAndRow(8, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(9, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(10, 1, '匯率/單位');
        $worksheet->setCellValueByColumnAndRow(11, 1, '發票起號');
        $worksheet->setCellValueByColumnAndRow(12, 1, '發票迄號');
        $worksheet->setCellValueByColumnAndRow(13, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(15, 1, '序號');

        $j = 1;
        foreach ($invs as $inv) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $inv->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $inv->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $inv->TG003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $inv->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $inv->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $inv->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $inv->TH004);
            $worksheet->setCellValueByColumnAndRow(8, $j, $inv->TH005);
            $worksheet->setCellValueByColumnAndRow(9, $j, $inv->QTY);
            $worksheet->setCellValueByColumnAndRow(10, $j, $inv->TG012);
            $worksheet->setCellValueByColumnAndRow(11, $j, $inv->TG098);
            $worksheet->setCellValueByColumnAndRow(12, $j, $inv->TG014);
            $worksheet->setCellValueByColumnAndRow(13, $j, $inv->TH001);
            $worksheet->setCellValueByColumnAndRow(14, $j, $inv->TH002);
            $worksheet->setCellValueByColumnAndRow(15, $j, $inv->TH003);
        }

        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(1); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(1)->setTitle('Stocks'); //指定工作表名稱
        //定義第二頁籤欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '品號');
        $worksheet->setCellValueByColumnAndRow(2, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '規格');
        $worksheet->setCellValueByColumnAndRow(4, 1, '數量');

        $k = 1;
        foreach ($stocks as $stock) {
            $k = $k + 1;
            $worksheet->setCellValueByColumnAndRow(1, $k, $stock->AA);
            $worksheet->setCellValueByColumnAndRow(2, $k, $stock->BB);
            $worksheet->setCellValueByColumnAndRow(3, $k, $stock->CC);
            $worksheet->setCellValueByColumnAndRow(4, $k, $stock->QTY);
        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = '展場庫存&Invoice.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    }

    //銷貨對帳單匯出
    public function ship_data_export(Request $request) 
    {
        $date_str = $request->input('date3');
        $date_end = $request->input('date4');
        $ship_data = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,TG003,TH001,TH002,TH027,TH028,SUM(TH013) as NTD 
        FROM COPTH A,COPTG B 
        WHERE A.TH001=B.TG001 
        AND A.TH002=B.TG002 
        AND A.TH026=? 
        AND B.TG003>=? 
        AND B.TG003<=? 
        GROUP BY TG004,TG007,TG003,TH001,TH002,TH027,TH028 
        ORDER BY TG004,TH002',['Y',$date_str,$date_end]);

        if (count($ship_data)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
            //$result = 'Good Job!';
            //return View('nodata')->with('result', $result);
        
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('進貨單資料明細'); //指定工作表明稱
        //$worksheet = $spreadsheet->setTitle('進貨單資料明細'); 
        //$worksheet->setTitle('進貨單資料明細');
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '銷貨單別');
        $worksheet->setCellValueByColumnAndRow(5, 1, '銷貨單號');
        $worksheet->setCellValueByColumnAndRow(6, 1, '結帳單別');
        $worksheet->setCellValueByColumnAndRow(7, 1, '結帳單號');
        $worksheet->setCellValueByColumnAndRow(8, 1, '未稅金額');

        $j = 1;
        foreach ($ship_data as $ship) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $ship->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $ship->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $ship->TG003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $ship->TH001);
            $worksheet->setCellValueByColumnAndRow(5, $j, $ship->TH002);
            $worksheet->setCellValueByColumnAndRow(6, $j, $ship->TH027);
            $worksheet->setCellValueByColumnAndRow(7, $j, $ship->TH028);
            $worksheet->setCellValueByColumnAndRow(8, $j, $ship->NTD);

        }

        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(1); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(1)->setTitle('test'); //指定工作表名稱
        //$worksheet = $spreadsheet->setTitle('進貨單');

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = '銷貨對帳單明細.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    }

    //製令工時匯出
    public function WorkingTimeExport(Request $request) 
    {
        $sqlkey = $request->input('workdate').'%';
        $worktimes = DB::connection('sqlsrv_tensall')->select('Select CSTMB.MB007,INVMB.MB002,SUM(MOCTA.TA017) as QTY,SUM(CSTMB.MB005) as hum_time,SUM(CSTMB.MB006) as mac_time
        From CSTMB
        LEFT JOIN INVMB ON CSTMB.MB007=INVMB.MB001
        LEFT JOIN MOCTA ON CSTMB.MB003=MOCTA.TA001 And CSTMB.MB004=MOCTA.TA002 
        WHERE CSTMB.MB002 like ?
        And CSTMB.MB007 like ? 
        And Left(CSTMB.MB007,2) <> ?
        Or (CSTMB.MB002 like ?
        And CSTMB.MB007 like ? 
        And Left(CSTMB.MB007,2) <> ?)
        Group By CSTMB.MB007,INVMB.MB002 
        Order By CSTMB.MB007 asc',[$sqlkey,'A%','A-',$sqlkey,'B%','B-']);
 
        if (count($worktimes)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
            //$result = 'Good Job!';
            //return View('nodata')->with('result', $result);
        
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $worksheet = $spreadsheet->getActiveSheet(); 
        $worksheet->setTitle($workdate);
        //定義欄位
        $worksheet->setCellValueByColumnAndRow(1, 1, '品號');
        $worksheet->setCellValueByColumnAndRow(2, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(4, 1, '人時');
        $worksheet->setCellValueByColumnAndRow(5, 1, '機時');

        $j = 1;
        foreach ($worktimes as $worktime) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $worktime->MB007);
            $worksheet->setCellValueByColumnAndRow(2, $j, $worktime->MB002);
            $worksheet->setCellValueByColumnAndRow(3, $j, $worktime->QTY);
            $worksheet->setCellValueByColumnAndRow(4, $j, $worktime->hum_time);
            $worksheet->setCellValueByColumnAndRow(5, $j, $worktime->mac_time);
        }

        // 下载
        $filename = '製令工時.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    }


}
