<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function upload()
    {
        //return view('auth.upload');
    }

    public function export()
    {
        //匯出頁面
        //return view('auth.export');
    }

    public function dbresult()
    {
        //檢視MS SQL連線結果
        return view('auth.dbresult');
    }
  
        public function search()
    {
        //匯出Excel
        return view('auth.search');
    }

    //以下資料查詢
    public function test(Request $request)
    //public function test()
    {
        $searchid1 = $request->input('TH001').'%';
        $searchid2 = $request->input('TH002').'%';
        //$searchid1 = $_GET['TH001'].'%';
        //$searchid2 = $_GET['TH002'].'%';
        $purths = DB::connection('sqlsrv_tensall')->select('select * from PURTH where TH001 like ? and TH002 like ?',[$searchid1, $searchid2]);
        //$purths = DB::connection('sqlsrv')->table('PURTH')->where('TH002', 'like', $searchid)->get();
        $data=[
            'purths'=>$purths
        ];
        return view('auth.test', $data);
    }
}
