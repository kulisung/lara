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
        /*
        $purths = DB::connection('sqlsrv_atv0002')
                    ->table('PURTH')
                    ->select('TH001', 'TH002', 'TH003', 'TH004', 'TH007', 'TJ009')
                    ->leftJoin('PURTJ', 'PURTH.TH002', '=', 'PURTJ.TJ014', 'PURTH.TH003', '=', 'PURTJ.TJ015', 'PURTJ.TJ020', '=', 'Y')
                    ->where('TH030', '=', 'Y')
                    ->where('TH004', '=', $productid)
                    ->get();
        */            
        $data=[
            'purths'=>$purths
        ];
        return view('searchs.purth_result', $data);
    }

    public function pos_inv(Request $request)
    {
        
        $date_str = $request->input('TG003');
        $date_end = $request->input('TG003');
        /* 原SQL 敘述
        SELECT TG004 as '客戶代碼',TG007 as '客戶全名',TG003 as '銷貨日期','部門'=CASE WHEN TG005='D200' THEN '管理部' WHEN TG005='D700' THEN '國際市場部' WHEN TG005='D620' THEN '大中華市場部' WHEN TG005='D610' THEN 'ODM/OEM' ELSE '其他' END,
        '品牌'=CASE WHEN MB008='01' THEN 'TS6' WHEN K.MB008='02' THEN 'ODM' ELSE 'OTHER' END,
        '四大類'=CASE WHEN MB006='21' THEN '食品' WHEN MB006='22' THEN '化妝品' WHEN MB006='23' THEN '私密保養品'
        WHEN MB006='26' THEN '商品成品' ELSE 'OTHER' END ,TH004 AS '品號',
        TH005 as '品名','數量'=TH008+TH024,TG012 as '匯率/單位',TG098 AS '發票起號' , TG014 AS '發票迄號',
        TH001 as '單別',TH002 as '單號' ,TH003 as '序號' 
        FROM  COPMA D ,COPTG E,COPTH H,INVMB K 
        WHERE E.TG001=H.TH001 
        AND E.TG002=H.TH002 
        AND H.TH004=K.MB001
        AND D.MA001=E.TG004
        AND TG004='ATP0002'
        AND TG003>='20190606'
        AND TG003<='20190610'
        AND TH007='B24'
        AND TG023<> 'V' 
        ORDER BY TG098,TG014,TH001,TH002,TH003
        */
        $invs = DB::connection('sqlsrv_tensall')
                    ->table('COPMA', 'COPTG', 'COPTH', 'INVMB')
                    ->select('TG003', 'TG004', 'TG005', 'TG00', '', '', '', '', '')
                    ->where('TG003', '>=', $date_str)
                    ->where('TG003', '<=', $date_end)
                    ->get();
        $data=[
            'invs'=>$invs
        ];
        return view('searchs.show', $data);
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
