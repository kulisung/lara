<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
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

    public function fsearch1()
    {
        //
        return view('finance.fsearch1');
    }

    public function fsearch2()
    {
        //
        return view('finance.fsearch2');
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

    //銷貨對帳單
    public function fin_ship(Request $request)
    {
        
        $date_str = $request->input('date3');
        $date_end = $request->input('date4');
        $ships = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,TG003,TH001,TH002,TH027,TH028,SUM(TH013) as NTD 
        FROM COPTH A,COPTG B 
        WHERE A.TH001=B.TG001 
        AND A.TH002=B.TG002 
        AND A.TH026=? 
        AND B.TG003>=? 
        AND B.TG003<=? 
        GROUP BY TG004,TG007,TG003,TH001,TH002,TH027,TH028 
        ORDER BY TG004,TH002',['Y',$date_str,$date_end]);

        $data=[
            'ships'=>$ships
        ];

        if (count($ships)<1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        //return view('searchs.show', $data);
        return view('finance.fin_ship', $data);
        }
    }

    
    //結帳前檢查Finance結帳前檢查 金額彙總
    public function fin_b4check(Request $request)
    {
        $fin_chk = $request->input('fin_b4date');
        $fin_date = substr($fin_chk,0,4).'01';  //累計由該年度一月開始計算
        //淨額合計
        $b4_checks = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TH037) AS SUMCOST,SUM(TH038) AS SUMTAX FROM (SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as TG005,MB008,MB006,MA038,MA019,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
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
        SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as TG005,MB008,MB006,MA038,MA019,TJ005,TJ007=(TJ007+TJ042)*-1,TI009,TJ033*-1,TJ034*-1,TJ001,TJ002,TJ003 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001 
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ?) P',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','Y',$fin_chk,'9090','D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','Y',$fin_chk,'9090']);

        //銷貨合計
        $b4_shipchecks = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TH037) AS SUMSHIP,SUM(TH038) AS SUMTAX 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?',
        ['Y',$fin_chk,'9090']);

        //客戶總額統計
        $b4_customers = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TH037) AS SUMCUS,SUM(TH038) AS SUMTAX
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001   
        AND E.TG002=H.TH002 
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?',
        ['Y',$fin_chk,'9090']);

        //單月銷退
        $b4_sumbacks = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TJ033) AS SUMBACK,SUM(TJ034) AS SUMTAX 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?',
        ['Y','1',$fin_chk,'9090']);

        //單月折讓
        $b4_sumdiscs = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TJ033) AS SUMDISC,SUM(TJ034) AS SUMTAX
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?',
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

        $data_records = count($b4_checks);
        if (count($b4_items) < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
            return view('finance.fin_b4check', compact('fin_chk','fin_date','b4_checks','b4_shipchecks','b4_sumbacks','b4_sumdiscs','b4_items','b4_sumitems','b4_brands','b4_sumbrands','b4_customers','b4_returns','b4_sumreturns','b4_allowances','b4_sumallowances','b4_discounts','b4_sumdiscounts'));
        }
    }
    

    /* #########結帳前檢查明細######### */
    //結帳前檢查Finance結帳前檢查 明細
    public function fin_b4chk(Request $request)
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
        AND left(TI003,6) BETWEEN ? AND ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','1',$fin_date,$fin_chk,'9090']);

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
        AND left(TI003,6) BETWEEN ? AND ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','2',$fin_date,$fin_chk,'9090']);

        //客戶總額統計
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

        //判斷是否有資料
        $data_records = count($b4_chks); //資料筆數
        $ship_records = count($b4_shipchks); //資料筆數

        if ($data_records < 1) {
            $result = '查無資料，請檢視查詢條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
            return view('finance.fin_b4chk', compact('fin_chk','b4_chks','b4_shipchks','b4_items','b4_sumitems','b4_brands','b4_sumbrands','b4_returns','b4_sumreturns','b4_allowances','b4_sumallowances','b4_discounts','b4_sumdiscounts','b4_shipbacks','b4_shipdiscs','b4_customers','b4_cusshipbacks','b4_cusbacks','b4_cusdiscs','data_records','ship_records'));
        }
    }

    /* #########結帳後檢查明細######### */
    //結帳後檢查Finance結帳後檢查 明細
    public function fin_afchk(Request $request)
    {
        $fin_chk = $request->input('fin_afdate');
        $fin_date = substr($fin_chk,0,4).'01';  //累計由該年度一月開始計算
        $fin_strnum = substr($fin_chk,2,4).'0001'; //查詢9090起始單號
        $fin_endnum = substr($fin_chk,2,4).'9999'; //查詢9090結束單號
        //9090檢查
        $af_9090chk = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND (TH004 = ?)
        AND TH028 >= ? AND TH028 <= ?',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','9090','$fin_strnum','$fin_endnum']);

        //結帳後淨額明細
        $af_chks = DB::connection('sqlsrv_tensall')->select('SELECT * FROM (SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
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
        SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,TJ005,TJ007=(TJ007+TJ042)*-1,TI009,TJ033*-1,TJ034*-1,TJ001,TJ002,TJ003 
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
        AND left(TI003,6) BETWEEN ? AND ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','1',$fin_date,$fin_chk,'9090']);

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
        AND left(TI003,6) BETWEEN ? AND ?  
        AND MB001 <> ?
        ORDER BY MB006 DESC,TI004,TI003',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','2',$fin_date,$fin_chk,'9090']);

        //客戶總額統計
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

        //判斷是否有資料
        $data_records = count($af_chks); //資料筆數
        $ship_records = count($af_shipchks); //資料筆數

        if ($data_records < 1) {
            $result = '查無資料，請檢視查詢條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
            return view('finance.fin_afchk', compact('fin_strnum','fin_chk','af_9090chk','af_chks','af_shipchks','af_items','af_sumitems','af_brands','af_sumbrands','af_returns','af_sumreturns','af_allowances','af_sumallowances','af_discounts','af_sumdiscounts','af_shipbacks','af_shipdiscs','af_customers','af_cusshipbacks','af_cusbacks','af_cusdiscs','data_records','ship_records'));
        }
    }

    //結帳後檢查Finance結帳後檢查 金額彙總
    public function fin_afcheck(Request $request)
    {
        $fin_chk = $request->input('fin_afdate');
        $fin_date = substr($fin_chk,0,4).'01';  //累計由該年度一月開始計算
        $fin_strnum = left(substr($fin_chk,2,4)).'0001'; //查詢9090起始單號
        $fin_endnum = left(substr($fin_chk,2,4)).'9999'; //查詢9090結束單號
        //9090檢查
        $af_9090chk = DB::connection('sqlsrv_tensall')->select('SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS TG005,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB008,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END AS MB006,CASE MA038 WHEN ? THEN ? ELSE ? END AS MA038,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND (TH004 = ?)
        AND TH028 >= ? AND TH028 <= ?',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','01','TS6','02','ODM','OTHER','21','食品','22','化妝品','23','私密保養品','26','商品成品','OTHER','3','外銷','內銷','Y','9090','$fin_strnum','$fin_endnum']);

        //淨額合計
        $af_checks = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TH037) AS SUMCOST,SUM(TH038) AS SUMTAX FROM (SELECT TG004,TG007,TG003,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as TG005,MB008,MB006,MA038,MA019,TH005,QTY=TH008+TH024,TG012,TH037,TH038,TH001,TH002,TH003 
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
        SELECT TI004,TI021,TI003,CASE TI005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as TG005,MB008,MB006,MA038,MA019,TJ005,TJ007=(TJ007+TJ042)*-1,TI009,TJ033*-1,TJ034*-1,TJ001,TJ002,TJ003 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001 
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND left(TI003,6) = ?
        AND MB001 <> ?) P',
        ['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','Y',$fin_chk,'9090','D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','Y',$fin_chk,'9090']);

        //銷貨合計
        $af_shipchecks = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TH037) AS SUMSHIP,SUM(TH038) AS SUMTAX 
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?',
        ['Y',$fin_chk,'9090']);

        //客戶總額統計
        $af_customers = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TH037) AS SUMCUS,SUM(TH038) AS SUMTAX
        FROM COPMA D,COPTG E,COPTH H,INVMB K
        WHERE E.TG001=H.TH001   
        AND E.TG002=H.TH002 
        AND H.TH004=K.MB001
        AND D.MA001=TG004
        AND D.MA001=E.TG004
        AND TH026 = ?
        AND left(TG003,6) = ?
        AND MB001 <> ?',
        ['Y',$fin_chk,'9090']);

        //單月銷退
        $af_sumbacks = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TJ033) AS SUMBACK,SUM(TJ034) AS SUMTAX 
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?',
        ['Y','1',$fin_chk,'9090']);

        //單月折讓
        $af_sumdiscs = DB::connection('sqlsrv_tensall')->select('SELECT SUM(TJ033) AS SUMDISC,SUM(TJ034) AS SUMTAX
        FROM COPMA D,COPTI E,COPTJ H,INVMB K
        WHERE E.TI001=H.TJ001   
        AND E.TI002=H.TJ002
        AND H.TJ004=K.MB001
        AND D.MA001=TI004
        AND D.MA001=E.TI004
        AND TJ024 = ?
        AND TJ030 = ?
        AND left(TI003,6) = ?  
        AND MB001 <> ?',
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

        $data_records = count($af_checks);
        if (count($af_items) < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
            return view('finance.fin_afcheck', compact('fin_chk','fin_date','af_9090chk','af_checks','af_shipchecks','af_sumbacks','af_sumdiscs','af_items','af_sumitems','af_brands','af_sumbrands','af_customers','af_returns','af_sumreturns','af_allowances','af_sumallowances','af_discounts','af_sumdiscounts'));
        }
    }
    

}
