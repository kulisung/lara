<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('searchs.index');        
    }

    public function search1()
    {
        return view('searchs.search1');        
    }

    public function search2()
    {
        return view('searchs.search2');        
    }
    
    public function search3()
    {
        return view('searchs.search3');        
    }

    public function search4()
    {
        return view('searchs.search4');        
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

    public function result01(Request $request)
    {
        $searchid1 = $request->input('TH001').'%';
        $searchid2 = $request->input('TH002').'%';
        $purths = DB::connection('sqlsrv_tensall')->select('select * from PURTH where TH001 like ? and TH002 like ?',[$searchid1, $searchid2]);
        //$purths = DB::connection('sqlsrv')->table('PURTH')->where('TH002', 'like', $searchid)->get();
        $data=[
            'purths'=>$purths
        ];
        return view('searchs.result01', $data);
    }

    public function purth_result(Request $request)
    {
        $productid = $request->input('TH004').'%';
        $purths = DB::connection('sqlsrv_atv0002')->select('select TH001,TH002,TH003,TH004,TH007,SUM(TJ009) as SUMQTY from PURTH LEFT JOIN PURTJ ON PURTH.TH002=PURTJ.TJ014 and PURTH.TH003=PURTJ.TJ015 and PURTJ.TJ020=? WHERE TH030=? AND TH004 like ? GROUP BY TH001,TH002,TH003,TH004,TH007 ORDER BY TH002 DESC,TH003',['Y', 'Y', $productid]);
        $data=[
            'purths'=>$purths
        ];
        return view('searchs.purth_result', $data);
    }

    //展場代號更新
    public function pos_chk(Request $request)
    {
        //$date_str = $request->input('chkdate1');
        //$date_end = $request->input('chkdate2');
        $poschks = DB::connection('sqlsrv_tensall_temp')->select('SELECT TA004,TA009,TA014,TA016 FROM TempPOSTA where TA009 <> ?',['ATP0002']);
        //判斷是否有資料
        $pos_datas = count($poschks); //資料筆數
        if ($pos_datas < 1) {
            $result = '查無資料需要更新，請重新確認POS資料是否有轉入!!';
            return View('nodata')->with('result', $result);
        }else{
            DB::connection('sqlsrv_tensall_temp')->update('update TempPOSTA SET TA009 = ?',['ATP0002']);
            $result = '本次POS更新資料總數共'.$pos_datas.'筆，資料已更新!!';
            return View('nodata')->with('result', $result);
        }

    }

    //展場Invoice
    public function pos_inv(Request $request)
    {
        
        $date_str = $request->input('date1');
        $date_end = $request->input('date2');
        $invs = DB::connection('sqlsrv_tensall')->select('SELECT TH001,TH002,TH003,TH004,TH005,TG003,TG004,CASE TG005 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as TG005,TG007,TG012,TG014,TG098,CASE MB006 WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as MB006,CASE MB008 WHEN ? THEN ? WHEN ? THEN ? ELSE ? END as MB008,SUM(TH008+TH024) as QTY FROM COPTH LEFT JOIN COPTG ON (COPTH.TH001=COPTG.TG001 AND COPTH.TH002=COPTG.TG002 AND COPTH.TH007=? AND COPTG.TG004=? AND COPTG.TG023<>?) LEFT JOIN INVMB ON (COPTH.TH004=INVMB.MB001) WHERE COPTG.TG003>=? AND COPTG.TG003<=? GROUP BY TH001,TH002,TH003,TH004,TH005,TG003,TG004,TG005,TG007,TG012,TG014,TG098,MB006,MB008',['D200','管理部','D700','國際市場部','D620','大中華市場部','D610','ODM/OEM','其他','21','食品','22','化妝品','23','私密保養品','26','商品成品','Other','01','TS6','02','ODM','Other','B24','ATP0002','V',$date_str,$date_end]);

        $data=[
            'invs'=>$invs
        ];
        //return view('searchs.show', $data);
        return view('searchs.pos_inv', $data);
    }

    //展場Stocks
    public function pos_stocks(Request $request)
    {
        
        $date_str = $request->input('date1');
        $date_end = $request->input('date2');
        $stocks = DB::connection('sqlsrv_tensall')->select('SELECT P.AA,P.BB,P.CC,SUM(P.DD) AS QTY FROM (SELECT TH004 AS AA,TH005 AS BB,TH006 AS CC , SUM(TH008+TH024) AS DD FROM COPTG,COPTH WHERE TG001=TH001 AND TG002=TH002 AND (TG004=?) AND TG003>=? AND TG003<=? AND TH007=? AND TG023<>? GROUP BY  TH004,TH005,TH006 
        UNION
        SELECT TJ004 AS AA,TJ005 AS BB,TJ006 AS CC,SUM(TJ007)*-1 AS DD
        FROM COPTI,COPTJ WHERE TI001=TJ001 AND TI002=TJ002 AND (TI004=?) AND TI003>=? AND TI003<=? AND TJ013=? AND TI019<>? GROUP BY TJ004,TJ005,TJ006) P GROUP BY AA,BB,CC',['ATP0002',$date_str,$date_end,'B24','V','ATP0002',$date_str,$date_end,'B24','V']);

        $data=[
            'stocks'=>$stocks
        ];
        //return view('searchs.show', $data);
        return view('searchs.pos_stocks', $data);
    }


    public function export_file(Request $request)
    {
        //     
    }

    public function WorkingTime(Request $request)
    {
        
        $workdate = $request->input('workdate').'%';
        $works = DB::connection('sqlsrv_tensall')->select('Select CSTMB.MB007,INVMB.MB002,SUM(MOCTA.TA017) as QTY,SUM(CSTMB.MB005) as hum_time,SUM(CSTMB.MB006) as mac_time
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
        Order By CSTMB.MB007 asc',[$workdate,'A%','A-',$workdate,'B%','B-']);

        $data=[
            'works'=>$works
        ];
        return view('searchs.ShowWorkingTime', $data);
    }

    
    //Vicky用，銷貨單查詢暫出單客戶單號
    public function ATW0031_Query(Request $request)
    {
        $COP_TH001 = $request->input('TH001');
        $COP_TH002S = $request->input('TH002S');
        $COP_TH002E = $request->input('TH002E');
        $COP_STATUS = $request->input('STATUS');
        $COPTH_lists = DB::connection('sqlsrv_tensall')->select('Select TH001,TH002,TH014,TH015,TH032,TH033,SUM(TH037) AS COST,SUM(TH038) AS TAX,TC012 
        From COPTH A, COPTC B 
        WHERE A.TH014 = B.TC001 AND A.TH015 = B.TC002 
        AND TH001 = ?
        AND TH002 >= ? and TH002 <= ? 
        AND TH020 = ?
        AND TC012 like ?
        GROUP BY TH001,TH002,TH014,TH015,TH032,TH033,TC012
        ORDER BY TH001,TH002',
        [$COP_TH001,$COP_TH002S,$COP_TH002E,$COP_STATUS,'T%']);

        $COPTH_lists_count = count($COPTH_lists);
        if ($COPTH_lists_count < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('searchs.ShowATW0031', compact('COPTH_lists'));
        }

    }
    




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
}
