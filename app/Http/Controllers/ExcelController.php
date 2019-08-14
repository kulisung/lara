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
        $purths = DB::connection('sqlsrv_atv0002')->select('select TH001,TH002,TH003,TH004,TH007,SUM(TJ009) as SUMQTY from PURTH LEFT JOIN PURTJ ON PURTH.TH002=PURTJ.TJ014 and PURTH.TH003=PURTJ.TJ015 and PURTJ.TJ020=? WHERE TH030=? AND TH004 like ? GROUP BY TH001,TH002,TH003,TH004,TH007 ORDER BY TH002 DESC,TH003',['Y', 'Y', $productid]);
 
        if (count($purths)<1) {
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
        foreach ($purths as $purth) {
            $j = $j + 1;
            $worksheet->setCellValueByColumnAndRow(1, $j, $purth->TH001);
            $worksheet->setCellValueByColumnAndRow(2, $j, $purth->TH002);
            $worksheet->setCellValueByColumnAndRow(3, $j, $purth->TH003);
            $worksheet->setCellValueByColumnAndRow(4, $j, $purth->TH004);
            $worksheet->setCellValueByColumnAndRow(5, $j, $purth->TH007);
            $worksheet->setCellValueByColumnAndRow(6, $j, $purth->SUMQTY);
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
            $result = 'No data!';
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

}
