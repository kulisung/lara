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
    
    /*//20191031註記不使用
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
    */

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
        $filename = $date_str.'-'.$date_end.'展場庫存&Invoice.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    }

    //銷貨對帳單匯出
    public function fin_ship_export(Request $request) 
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
        $filename = $date_str.'-'.$date_end.'銷貨對帳單明細.xlsx';
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
        $filename = $sqlkey.'製令工時.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
        
        }
    }

    //結帳前明細資料匯出
    public function fin_b4_export(Request $request) 
    {
        $fin_chk = $request->input('fin_b4date');
        $fin_date = substr($fin_chk,0,4).'01';  //累計由該年度一月開始計算
        $b4_chks = DB::connection('sqlsrv_tensall')->select('SELECT * FROM (SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?
        UNION
        SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TJ005,TJ007=(TJ007+TJ042)*-1,TI009,TJ033*-1,TJ034*-1,TJ001,TJ002,TJ003 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001 
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ?) P  
        ORDER BY MB006,TG004,TG003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y',$fin_chk,'9090','D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y',$fin_chk,'9090']);

        //銷貨總額不含成本毛利額
        $b4_shipchks = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?
        ORDER BY MB006,TG004,TG003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y',$fin_chk,'9090']);

        //單月銷退
        $b4_shipbacks = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TJ005,QTY=TJ007+TJ042,TI009,TJ033,TJ034,TJ001,TJ002,TJ003
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','1',$fin_chk,'9090']);

        //單月折讓
        $b4_shipdiscs = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TJ005,QTY=TJ007+TJ042,TI009,TJ033, TJ034,TJ001,TJ002,TJ003
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','2',$fin_chk,'9090']);

        //客戶銷貨總額
        $b4_customers = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,SUM(TH037) AS SUMCUS,SUM(TH038) AS SUMTAX
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001   
        AND E.TG002=H.TH002 
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ? 
        GROUP BY TG004,TG007 ORDER BY TG004,TG007',
        ['Y',$fin_chk,'9090']);

        //銷退單銷退By客戶
        $b4_cusshipbacks = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,SUM(TJ033) AS TJ033,SUM(TJ034) AS TJ034
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ? 
        GROUP BY TI004,TI021 ORDER BY TI004,TI021',
        ['Y',$fin_chk,'9090']);

        //銷退單單身銷退By客戶
        $b4_cusbacks = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,SUM(TJ033) AS TJ033,SUM(TJ034) AS TJ034
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ? 
        GROUP BY TI004,TI021 ORDER BY TI004,TI021',
        ['Y','1',$fin_chk,'9090']);

        //銷退單單身折讓By客戶
        $b4_cusdiscs = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,SUM(TJ033) AS TJ033,SUM(TJ034) AS TJ034
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ? 
        GROUP BY TI004,TI021 ORDER BY TI004,TI021',
        ['Y','2',$fin_chk,'9090']);

        //單月四大類合計
        $b4_items = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,SUM(TH037) AS COST FROM (
        SELECT MB006,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?) P
        GROUP BY MB006 ORDER BY COST DESC',
        ['21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','Y',$fin_chk,'9090']);

        //累計四大類
        $b4_sumitems = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,SUM(TH037) AS COST FROM (
        SELECT MB006,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) BETWEEN ? AND ?
        AND MB001 <> ?) P
        GROUP BY MB006 ORDER BY COST DESC',
        ['21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','Y',$fin_date,$fin_chk,'9090']);

        //單月品牌統計
        $b4_brands = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,SUM(TH037) AS COST FROM (
        SELECT MB008,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?) P
        GROUP BY MB008 ORDER BY COST DESC',
        ['01','TS6','02','ODM','OTHER','Y',$fin_chk,'9090']);

        //品牌年度累計
        $b4_sumbrands = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,SUM(TH037) AS COST FROM (
        SELECT MB008,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) BETWEEN ? AND ?
        AND MB001 <> ?) P
        GROUP BY MB008 ORDER BY COST DESC',
        ['01','TS6','02','ODM','OTHER','Y',$fin_date,$fin_chk,'9090']);

        //單月銷退單彙總合計
        $b4_returns = DB::connection('sqlsrv_tensall')->select('SELECT CASE WHEN SUM(TJ033) < ? THEN SUM(TJ033) ELSE SUM(TJ033) END AS COST 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ?',
        ['0','Y',$fin_chk,'9090']);
        
        //累計銷退單彙總合計
        $b4_sumreturns = DB::connection('sqlsrv_tensall')->select('SELECT CASE WHEN SUM(TJ033) < ? THEN SUM(TJ033) ELSE SUM(TJ033) END AS COST 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) BETWEEN ? AND ?
        AND MB001 <> ?',
        ['0','Y',$fin_date,$fin_chk,'9090']); 

        //單月折讓合計allowance '4172'=現金折扣
        $b4_allowances = DB::connection('sqlsrv_tensall')->select('SELECT SUM(ML008) AS ML008 FROM ACTML 
        WHERE (ML006 = ?)  
        AND left(ML002,6) = ?',
        ['4172',$fin_chk]);

        //累計折讓合計allowance
        $b4_sumallowances = DB::connection('sqlsrv_tensall')->select('SELECT SUM(ML008) AS ML008 FROM ACTML 
        WHERE (ML006 = ?)  
        AND left(ML002,6) BETWEEN ? AND ?',
        ['4172',$fin_date,$fin_chk]);

        //單月尾折 last discount
        $b4_discounts = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TD015) AS TD015 FROM ACRTC,ACRTD
        WHERE TC001=TD001
        AND TC002=TD002
        AND (TD008 = ? OR TD008 = ?) 
        AND left(TC002,6) = ?',
        ['4191','4172',$fin_chk]);

        //累計尾折 last discount
        $b4_sumdiscounts = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TD015) AS TD015 FROM ACRTC,ACRTD
        WHERE TC001=TD001
        AND TC002=TD002
        AND (TD008 = ? OR TD008 = ?) 
        AND left(TC002,6) BETWEEN ? AND ?',
        ['4191','4172',$fin_date,$fin_chk]);

        //判斷是否有資料
        if (count($b4_chks)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return view('nodata')->with('result', $result);
        }else{
        //結帳前淨額
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('淨額明細'); //指定工作表明稱
        //$worksheet = $spreadsheet->setTitle('進貨單資料明細'); 
        //$worksheet->setTitle('進貨單資料明細');
        //定義欄位 Sheet1
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($b4_chks as $b4_chk) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_chk->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_chk->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $b4_chk->TG003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $b4_chk->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $b4_chk->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $b4_chk->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $b4_chk->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $b4_chk->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $b4_chk->TH005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $b4_chk->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $b4_chk->TG012);
            $worksheet->setCellValueByColumnAndRow(12, $j, $b4_chk->TH037);
            $worksheet->setCellValueByColumnAndRow(13, $j, $b4_chk->TH038);
            $worksheet->setCellValueByColumnAndRow(14, $j, $b4_chk->TH001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $b4_chk->TH002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $b4_chk->TH003);
        }

        //結帳前銷貨
        //定義欄位 Sheet2
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(1); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(1)->setTitle('銷貨明細'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($b4_shipchks as $b4_shipchk) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_shipchk->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_shipchk->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $b4_shipchk->TG003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $b4_shipchk->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $b4_shipchk->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $b4_shipchk->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $b4_shipchk->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $b4_shipchk->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $b4_shipchk->TH005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $b4_shipchk->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $b4_shipchk->TG012);
            $worksheet->setCellValueByColumnAndRow(12, $j, $b4_shipchk->TH037);
            $worksheet->setCellValueByColumnAndRow(13, $j, $b4_shipchk->TH038);
            $worksheet->setCellValueByColumnAndRow(14, $j, $b4_shipchk->TH001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $b4_shipchk->TH002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $b4_shipchk->TH003);
        }

        //結帳前銷退
        //定義欄位 Sheet3
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(2); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(2)->setTitle('銷退明細'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($b4_shipbacks as $b4_shipback) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_shipback->TI004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_shipback->TI021);
            $worksheet->setCellValueByColumnAndRow(3, $j, $b4_shipback->TI003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $b4_shipback->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $b4_shipback->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $b4_shipback->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $b4_shipback->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $b4_shipback->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $b4_shipback->TJ005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $b4_shipback->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $b4_shipback->TI009);
            $worksheet->setCellValueByColumnAndRow(12, $j, $b4_shipback->TJ033);
            $worksheet->setCellValueByColumnAndRow(13, $j, $b4_shipback->TJ034);
            $worksheet->setCellValueByColumnAndRow(14, $j, $b4_shipback->TJ001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $b4_shipback->TJ002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $b4_shipback->TJ003);
        }

        //結帳前折讓
        //定義欄位 Sheet4
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(3); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(3)->setTitle('折讓明細'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($b4_shipdiscs as $b4_shipdisc) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_shipdisc->TI004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_shipdisc->TI021);
            $worksheet->setCellValueByColumnAndRow(3, $j, $b4_shipdisc->TI003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $b4_shipdisc->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $b4_shipdisc->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $b4_shipdisc->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $b4_shipdisc->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $b4_shipdisc->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $b4_shipdisc->TJ005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $b4_shipdisc->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $b4_shipdisc->TI009);
            $worksheet->setCellValueByColumnAndRow(12, $j, $b4_shipdisc->TJ033);
            $worksheet->setCellValueByColumnAndRow(13, $j, $b4_shipdisc->TJ034);
            $worksheet->setCellValueByColumnAndRow(14, $j, $b4_shipdisc->TJ001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $b4_shipdisc->TJ002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $b4_shipdisc->TJ003);
        }

        //結帳前客戶總額
        //定義欄位 Sheet5
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(4); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(4)->setTitle('客戶總額'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '未稅總金額');
        $worksheet->setCellValueByColumnAndRow(4, 1, '稅額總額');

        $j = 1;
        foreach ($b4_customers as $b4_customer) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_customer->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_customer->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $b4_customer->SUMCUS);
            $worksheet->setCellValueByColumnAndRow(4, $j, $b4_customer->SUMTAX);
        }

        //結帳前客戶銷退折讓總額
        //定義欄位 Sheet6
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(5); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(5)->setTitle('客戶銷退折讓'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷退未稅總金額');
        $worksheet->setCellValueByColumnAndRow(4, 1, '銷退稅額總額');
        $worksheet->setCellValueByColumnAndRow(6, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(7, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(8, 1, '單身銷退未稅總金額');
        $worksheet->setCellValueByColumnAndRow(9, 1, '單身銷退稅額總額');
        $worksheet->setCellValueByColumnAndRow(11, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(12, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(13, 1, '單身折讓未稅總金額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單身折讓稅額總額');

        $j = 1;
        foreach ($b4_cusshipbacks as $b4_cusshipback) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_cusshipback->TI004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_cusshipback->TI021);
            $worksheet->setCellValueByColumnAndRow(3, $j, $b4_cusshipback->TJ033);
            $worksheet->setCellValueByColumnAndRow(4, $j, $b4_cusshipback->TJ034);
        }

        $j = 1;
        foreach ($b4_cusbacks as $b4_cusback) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(6, $j, $b4_cusback->TI004);
            $worksheet->setCellValueByColumnAndRow(7, $j, $b4_cusback->TI021);
            $worksheet->setCellValueByColumnAndRow(8, $j, $b4_cusback->TJ033);
            $worksheet->setCellValueByColumnAndRow(9, $j, $b4_cusback->TJ034);
        }

        $j = 1;
        foreach ($b4_cusdiscs as $b4_cusdisc) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(11, $j, $b4_cusdisc->TI004);
            $worksheet->setCellValueByColumnAndRow(12, $j, $b4_cusdisc->TI021);
            $worksheet->setCellValueByColumnAndRow(13, $j, $b4_cusdisc->TJ033);
            $worksheet->setCellValueByColumnAndRow(14, $j, $b4_cusdisc->TJ034);
        }

        //結帳前四大類、品牌合計
        //定義欄位 Sheet6
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(6); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(6)->setTitle('類別品牌合計'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(2, 1, '四大類單月未稅合計');
        $worksheet->setCellValueByColumnAndRow(3, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(4, 1, '四大類累計未稅合計');
        $worksheet->setCellValueByColumnAndRow(7, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(8, 1, '品牌單月未稅合計');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(10, 1, '品牌累計未稅合計');
        $worksheet->setCellValueByColumnAndRow(1, 11, '單月銷退未稅合計');
        $worksheet->setCellValueByColumnAndRow(2, 11, '累計銷退未稅合計');
        $worksheet->setCellValueByColumnAndRow(1, 15, '單月折讓未稅合計');
        $worksheet->setCellValueByColumnAndRow(2, 15, '累計折讓未稅合計');
        $worksheet->setCellValueByColumnAndRow(1, 19, '單月尾折未稅合計');
        $worksheet->setCellValueByColumnAndRow(2, 19, '累計尾折未稅合計');

        $j = 1;
        foreach ($b4_items as $b4_item) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_item->MB006);
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_item->COST);
        }

        $j = 1;
        foreach ($b4_sumitems as $b4_sumitem) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(3, $j, $b4_sumitem->MB006);
            $worksheet->setCellValueByColumnAndRow(4, $j, $b4_sumitem->COST);
        }

        $j = 1;
        foreach ($b4_brands as $b4_brand) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(7, $j, $b4_brand->MB008);
            $worksheet->setCellValueByColumnAndRow(8, $j, $b4_brand->COST);
        }

        $j = 1;
        foreach ($b4_sumbrands as $b4_sumbrand) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(9, $j, $b4_sumbrand->MB008);
            $worksheet->setCellValueByColumnAndRow(10, $j, $b4_sumbrand->COST);
        }

        $j = 11;
        foreach ($b4_returns as $b4_return) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_return->COST);
        }

        $j = 11;
        foreach ($b4_sumreturns as $b4_sumreturn) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_sumreturn->COST);
        }

        $j = 15;
        foreach ($b4_allowances as $b4_allowance) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_allowance->ML008);
        }

        $j = 15;
        foreach ($b4_sumallowances as $b4_sumallowance) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_sumallowance->ML008);
        }

        $j = 19;
        foreach ($b4_discounts as $b4_discount) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $b4_discount->TD015);
        }

        $j = 19;
        foreach ($b4_sumdiscounts as $b4_sumdiscount) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(2, $j, $b4_sumdiscount->TD015);
        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = $fin_chk.'_結前.xlsx';
        header('Content-Description: File Transfer');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
       
        }
    }

    //結帳後明細資料匯出
    public function fin_af_export(Request $request) 
    {
        $fin_chk = $request->input('fin_afdate');
        $fin_date = substr($fin_chk,0,4).'01';  //累計由該年度一月開始計算
        //結帳後銷貨淨額
        $af_chks = DB::connection('sqlsrv_tensall')->select('SELECT * FROM (SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?
        UNION
        SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TJ005,TJ007=(TJ007+TJ042)*-1,TI009,TJ033*-1,TJ034*-1,TJ001,TJ002,TJ003 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001 
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ?) P  
        ORDER BY MB006,TG004,TG003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y',$fin_chk,'9090','D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y',$fin_chk,'9090']);

        //結帳後銷貨總額不含成本毛利額
        $af_shipchks = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?
        ORDER BY MB006,TG004,TG003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y',$fin_chk,'9090']);

        //單月銷退
        $af_shipbacks = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TJ005,QTY=TJ007+TJ042,TI009,TJ033,TJ034,TJ001,TJ002,TJ003
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','1',$fin_chk,'9090']);

        //單月折讓
        $af_shipdiscs = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,MA019,TJ005,QTY=TJ007+TJ042,TI009,TJ033, TJ034,TJ001,TJ002,TJ003
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','2',$fin_chk,'9090']);

        //客戶銷貨總額
        $af_customers = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,SUM(TH037) AS SUMCUS,SUM(TH038) AS SUMTAX
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001   
        AND E.TG002=H.TH002 
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ? 
        GROUP BY TG004,TG007 ORDER BY TG004,TG007',
        ['Y',$fin_chk,'9090']);

        //銷退單銷退By客戶
        $af_cusshipbacks = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,SUM(TJ033) AS TJ033,SUM(TJ034) AS TJ034
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ? 
        GROUP BY TI004,TI021 ORDER BY TI004,TI021',
        ['Y',$fin_chk,'9090']);

        //銷退單單身銷退By客戶
        $af_cusbacks = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,SUM(TJ033) AS TJ033,SUM(TJ034) AS TJ034
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ? 
        GROUP BY TI004,TI021 ORDER BY TI004,TI021',
        ['Y','1',$fin_chk,'9090']);

        //銷退單單身折讓By客戶
        $af_cusdiscs = DB::connection('sqlsrv_tensall')->select('SELECT TI004,TI021,SUM(TJ033) AS TJ033,SUM(TJ034) AS TJ034
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ? 
        GROUP BY TI004,TI021 ORDER BY TI004,TI021',
        ['Y','2',$fin_chk,'9090']);

        //單月四大類合計
        $af_items = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,SUM(TH037) AS COST FROM (
        SELECT MB006,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?) P
        GROUP BY MB006 ORDER BY COST DESC',
        ['21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','Y',$fin_chk,'9090']);

        //累計四大類
        $af_sumitems = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,SUM(TH037) AS COST FROM (
        SELECT MB006,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) BETWEEN ? AND ?
        AND MB001 <> ?) P
        GROUP BY MB006 ORDER BY COST DESC',
        ['21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','Y',$fin_date,$fin_chk,'9090']);

        //單月品牌統計
        $af_brands = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,SUM(TH037) AS COST FROM (
        SELECT MB008,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?) P
        GROUP BY MB008 ORDER BY COST DESC',
        ['01','TS6','02','ODM','OTHER','Y',$fin_chk,'9090']);

        //品牌年度累計
        $af_sumbrands = DB::connection('sqlsrv_tensall')->select('SELECT CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,SUM(TH037) AS COST FROM (
        SELECT MB008,TH037 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) BETWEEN ? AND ?
        AND MB001 <> ?) P
        GROUP BY MB008 ORDER BY COST DESC',
        ['01','TS6','02','ODM','OTHER','Y',$fin_date,$fin_chk,'9090']);

        //單月銷退單彙總合計
        $af_returns = DB::connection('sqlsrv_tensall')->select('SELECT CASE WHEN SUM(TJ033) < ? THEN SUM(TJ033) ELSE SUM(TJ033) END AS COST 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ?',
        ['0','Y',$fin_chk,'9090']);
        
        //累計銷退單彙總合計
        $af_sumreturns = DB::connection('sqlsrv_tensall')->select('SELECT CASE WHEN SUM(TJ033) < ? THEN SUM(TJ033) ELSE SUM(TJ033) END AS COST 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002 
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) BETWEEN ? AND ?
        AND MB001 <> ?',
        ['0','Y',$fin_date,$fin_chk,'9090']); 

        //單月折讓合計allowance '4172'=現金折扣
        $af_allowances = DB::connection('sqlsrv_tensall')->select('SELECT SUM(ML008) AS ML008 FROM ACTML 
        WHERE (ML006 = ?)  
        AND left(ML002,6) = ?',
        ['4172',$fin_chk]);

        //累計折讓合計allowance
        $af_sumallowances = DB::connection('sqlsrv_tensall')->select('SELECT SUM(ML008) AS ML008 FROM ACTML 
        WHERE (ML006 = ?)  
        AND left(ML002,6) BETWEEN ? AND ?',
        ['4172',$fin_date,$fin_chk]);

        //單月尾折 last discount
        $af_discounts = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TD015) AS TD015 FROM ACRTC,ACRTD
        WHERE TC001=TD001
        AND TC002=TD002
        AND (TD008 = ? OR TD008 = ?) 
        AND left(TC002,6) = ?',
        ['4191','4172',$fin_chk]);

        //累計尾折 last discount
        $af_sumdiscounts = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TD015) AS TD015 FROM ACRTC,ACRTD
        WHERE TC001=TD001
        AND TC002=TD002
        AND (TD008 = ? OR TD008 = ?) 
        AND left(TC002,6) BETWEEN ? AND ?',
        ['4191','4172',$fin_date,$fin_chk]);

        //判斷是否有資料
        if (count($af_chks)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return view('nodata')->with('result', $result);
        }else{
        //結帳前淨額
        $spreadsheet = new Spreadsheet();  // 開新excel檔案
        $spreadsheet->setActiveSheetIndex(0);  //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(0)->setTitle('淨額明細'); //指定工作表明稱
        //$worksheet = $spreadsheet->setTitle('進貨單資料明細'); 
        //$worksheet->setTitle('進貨單資料明細');
        //定義欄位 Sheet1
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($af_chks as $af_chk) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_chk->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_chk->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $af_chk->TG003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $af_chk->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $af_chk->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $af_chk->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $af_chk->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $af_chk->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $af_chk->TH005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $af_chk->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $af_chk->TG012);
            $worksheet->setCellValueByColumnAndRow(12, $j, $af_chk->TH037);
            $worksheet->setCellValueByColumnAndRow(13, $j, $af_chk->TH038);
            $worksheet->setCellValueByColumnAndRow(14, $j, $af_chk->TH001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $af_chk->TH002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $af_chk->TH003);
        }

        //結帳前銷貨
        //定義欄位 Sheet2
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(1); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(1)->setTitle('銷貨明細'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($af_shipchks as $af_shipchk) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_shipchk->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_shipchk->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $af_shipchk->TG003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $af_shipchk->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $af_shipchk->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $af_shipchk->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $af_shipchk->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $af_shipchk->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $af_shipchk->TH005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $af_shipchk->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $af_shipchk->TG012);
            $worksheet->setCellValueByColumnAndRow(12, $j, $af_shipchk->TH037);
            $worksheet->setCellValueByColumnAndRow(13, $j, $af_shipchk->TH038);
            $worksheet->setCellValueByColumnAndRow(14, $j, $af_shipchk->TH001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $af_shipchk->TH002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $af_shipchk->TH003);
        }

        //結帳前銷退
        //定義欄位 Sheet3
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(2); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(2)->setTitle('銷退明細'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($af_shipbacks as $af_shipback) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_shipback->TI004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_shipback->TI021);
            $worksheet->setCellValueByColumnAndRow(3, $j, $af_shipback->TI003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $af_shipback->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $af_shipback->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $af_shipback->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $af_shipback->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $af_shipback->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $af_shipback->TJ005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $af_shipback->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $af_shipback->TI009);
            $worksheet->setCellValueByColumnAndRow(12, $j, $af_shipback->TJ033);
            $worksheet->setCellValueByColumnAndRow(13, $j, $af_shipback->TJ034);
            $worksheet->setCellValueByColumnAndRow(14, $j, $af_shipback->TJ001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $af_shipback->TJ002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $af_shipback->TJ003);
        }

        //結帳前折讓
        //定義欄位 Sheet4
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(3); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(3)->setTitle('折讓明細'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷貨日期');
        $worksheet->setCellValueByColumnAndRow(4, 1, '部門');
        $worksheet->setCellValueByColumnAndRow(5, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(6, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(7, 1, '內外銷');
        $worksheet->setCellValueByColumnAndRow(8, 1, '國家別');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品名');
        $worksheet->setCellValueByColumnAndRow(10, 1, '數量');
        $worksheet->setCellValueByColumnAndRow(11, 1, '匯率\單位');
        $worksheet->setCellValueByColumnAndRow(12, 1, '未稅金額');
        $worksheet->setCellValueByColumnAndRow(13, 1, '稅額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單別');
        $worksheet->setCellValueByColumnAndRow(15, 1, '單號');
        $worksheet->setCellValueByColumnAndRow(16, 1, '序號');

        $j = 1;
        foreach ($af_shipdiscs as $af_shipdisc) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_shipdisc->TI004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_shipdisc->TI021);
            $worksheet->setCellValueByColumnAndRow(3, $j, $af_shipdisc->TI003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $af_shipdisc->TG005);
            $worksheet->setCellValueByColumnAndRow(5, $j, $af_shipdisc->MB008);
            $worksheet->setCellValueByColumnAndRow(6, $j, $af_shipdisc->MB006);
            $worksheet->setCellValueByColumnAndRow(7, $j, $af_shipdisc->MA038);
            $worksheet->setCellValueByColumnAndRow(8, $j, $af_shipdisc->MA019);
            $worksheet->setCellValueByColumnAndRow(9, $j, $af_shipdisc->TJ005);
            $worksheet->setCellValueByColumnAndRow(10, $j, $af_shipdisc->QTY);
            $worksheet->setCellValueByColumnAndRow(11, $j, $af_shipdisc->TI009);
            $worksheet->setCellValueByColumnAndRow(12, $j, $af_shipdisc->TJ033);
            $worksheet->setCellValueByColumnAndRow(13, $j, $af_shipdisc->TJ034);
            $worksheet->setCellValueByColumnAndRow(14, $j, $af_shipdisc->TJ001);
            $worksheet->setCellValueByColumnAndRow(15, $j, $af_shipdisc->TJ002);
            $worksheet->setCellValueByColumnAndRow(16, $j, $af_shipdisc->TJ003);
        }

        //結帳前客戶總額
        //定義欄位 Sheet5
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(4); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(4)->setTitle('客戶總額'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '未稅總金額');
        $worksheet->setCellValueByColumnAndRow(4, 1, '稅額總額');

        $j = 1;
        foreach ($af_customers as $af_customer) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_customer->TG004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_customer->TG007);
            $worksheet->setCellValueByColumnAndRow(3, $j, $af_customer->SUMCUS);
            $worksheet->setCellValueByColumnAndRow(4, $j, $af_customer->SUMTAX);
        }

        //結帳前客戶銷退折讓總額
        //定義欄位 Sheet6
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(5); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(5)->setTitle('客戶銷退折讓'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(2, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(3, 1, '銷退未稅總金額');
        $worksheet->setCellValueByColumnAndRow(4, 1, '銷退稅額總額');
        $worksheet->setCellValueByColumnAndRow(6, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(7, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(8, 1, '單身銷退未稅總金額');
        $worksheet->setCellValueByColumnAndRow(9, 1, '單身銷退稅額總額');
        $worksheet->setCellValueByColumnAndRow(11, 1, '客戶代碼');
        $worksheet->setCellValueByColumnAndRow(12, 1, '客戶全名');
        $worksheet->setCellValueByColumnAndRow(13, 1, '單身折讓未稅總金額');
        $worksheet->setCellValueByColumnAndRow(14, 1, '單身折讓稅額總額');

        $j = 1;
        foreach ($af_cusshipbacks as $af_cusshipback) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_cusshipback->TI004);
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_cusshipback->TI021);
            $worksheet->setCellValueByColumnAndRow(3, $j, $af_cusshipback->TJ033);
            $worksheet->setCellValueByColumnAndRow(4, $j, $af_cusshipback->TJ034);
        }

        $j = 1;
        foreach ($af_cusbacks as $af_cusback) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(6, $j, $af_cusback->TI004);
            $worksheet->setCellValueByColumnAndRow(7, $j, $af_cusback->TI021);
            $worksheet->setCellValueByColumnAndRow(8, $j, $af_cusback->TJ033);
            $worksheet->setCellValueByColumnAndRow(9, $j, $af_cusback->TJ034);
        }

        $j = 1;
        foreach ($af_cusdiscs as $af_cusdisc) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(11, $j, $af_cusdisc->TI004);
            $worksheet->setCellValueByColumnAndRow(12, $j, $af_cusdisc->TI021);
            $worksheet->setCellValueByColumnAndRow(13, $j, $af_cusdisc->TJ033);
            $worksheet->setCellValueByColumnAndRow(14, $j, $af_cusdisc->TJ034);
        }

        //結帳前四大類、品牌合計
        //定義欄位 Sheet6
        $spreadsheet->createSheet(); //新增工作頁
        $spreadsheet->setActiveSheetIndex(6); //指定工作頁索引
        $worksheet = $spreadsheet->getActiveSheet(6)->setTitle('類別品牌合計'); //指定工作表名稱
        $worksheet->setCellValueByColumnAndRow(1, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(2, 1, '四大類單月未稅合計');
        $worksheet->setCellValueByColumnAndRow(3, 1, '四大類');
        $worksheet->setCellValueByColumnAndRow(4, 1, '四大類累計未稅合計');
        $worksheet->setCellValueByColumnAndRow(7, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(8, 1, '品牌單月未稅合計');
        $worksheet->setCellValueByColumnAndRow(9, 1, '品牌');
        $worksheet->setCellValueByColumnAndRow(10, 1, '品牌累計未稅合計');
        $worksheet->setCellValueByColumnAndRow(1, 11, '單月銷退未稅合計');
        $worksheet->setCellValueByColumnAndRow(2, 11, '累計銷退未稅合計');
        $worksheet->setCellValueByColumnAndRow(1, 15, '單月折讓未稅合計');
        $worksheet->setCellValueByColumnAndRow(2, 15, '累計折讓未稅合計');
        $worksheet->setCellValueByColumnAndRow(1, 19, '單月尾折未稅合計');
        $worksheet->setCellValueByColumnAndRow(2, 19, '累計尾折未稅合計');

        $j = 1;
        foreach ($af_items as $af_item) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_item->MB006);
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_item->COST);
        }

        $j = 1;
        foreach ($af_sumitems as $af_sumitem) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(3, $j, $af_sumitem->MB006);
            $worksheet->setCellValueByColumnAndRow(4, $j, $af_sumitem->COST);
        }

        $j = 1;
        foreach ($af_brands as $af_brand) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(7, $j, $af_brand->MB008);
            $worksheet->setCellValueByColumnAndRow(8, $j, $af_brand->COST);
        }

        $j = 1;
        foreach ($af_sumbrands as $af_sumbrand) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(9, $j, $af_sumbrand->MB008);
            $worksheet->setCellValueByColumnAndRow(10, $j, $af_sumbrand->COST);
        }

        $j = 11;
        foreach ($af_returns as $af_return) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_return->COST);
        }

        $j = 11;
        foreach ($af_sumreturns as $af_sumreturn) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_sumreturn->COST);
        }

        $j = 15;
        foreach ($af_allowances as $af_allowance) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_allowance->ML008);
        }

        $j = 15;
        foreach ($af_sumallowances as $af_sumallowance) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_sumallowance->ML008);
        }

        $j = 19;
        foreach ($af_discounts as $af_discount) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $af_discount->TD015);
        }

        $j = 19;
        foreach ($af_sumdiscounts as $af_sumdiscount) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(2, $j, $af_sumdiscount->TD015);
        }

        $spreadsheet->setActiveSheetIndex(0); //最後指定回第一頁MS Excel開啟顯示
        // 下载
        $filename = $fin_chk.'_結後.xlsx';
        header('Content-Description: File Transfer');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output'); 
       
        }
    }


}
