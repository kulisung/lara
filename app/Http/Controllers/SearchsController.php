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
        $data=[
            'purths'=>$purths
        ];
        return view('searchs.purth_result', $data);
    }

    public function pos_inv(Request $request)
    {
        
        $date_str = $request->input('date1');
        $date_end = $request->input('date2');
        $invs = DB::connection('sqlsrv_tensall')->select('SELECT TH001,TH002,TH003,TH004,TH005,TG003,TG004,TG005,TG007,TG012,TG014,TG098,MB006,MB008,SUM(TH008+TH024) as QTY FROM COPTH LEFT JOIN COPTG ON (COPTH.TH001=COPTG.TG001 AND COPTH.TH002=COPTG.TG002 AND COPTH.TH007=? AND COPTG.TG004=? AND COPTG.TG023<>?) LEFT JOIN INVMB ON (COPTH.TH004=INVMB.MB001) WHERE COPTG.TG003>=? AND COPTG.TG003<=? GROUP BY TH001,TH002,TH003,TH004,TH005,TG003,TG004,TG005,TG007,TG012,TG014,TG098,MB006,MB008',['B24','ATP0002','V',$date_str,$date_end]);

        /*
        $invs = DB::connection('sqlsrv_tensall')
                    ->table('COPTG', 'COPTH', 'INVMB')
                    ->select('TH001', 'TH002', 'TH003', 'TH004', 'TG003', 'TG004', 'TG005', 'TG014', 'TG098', 'MB006', 'MB008')
                    ->where('TG003', '>=', $date_str)
                    ->where('TG003', '<=', $date_end)
                    ->get();
        */

        $data=[
            'invs'=>$invs
        ];
        //return view('searchs.show', $data);
        return view('searchs.pos_inv', $data);
    }

public function ship_data(Request $request)
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
        //return view('searchs.show', $data);
        return view('searchs.ship_data', $data);
    }

    public function export_file(Request $request)
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
