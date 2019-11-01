<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    //
    public function ts6index()
    {
        //
        //$memberfresh = DB::select('SELECT register_date FROM ts6members ORDER BY register_date DESC LIMIT 1');
        $member_refresh = DB::table('ts6members')->orderby('register_date','desc')->limit(1)->value('register_date');
        $order_refresh = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        $membertime = substr($member_refresh,0,10);
        $ordertime = substr($order_refresh,0,10);
        return view('sales.ts6index',compact('membertime', 'ordertime'));
    }

    public function ts6members(Request $request)
    {
        //依加入時間查詢會員資料，並記錄總數
        $join_strdate = $request->input('strdate');
        //$join_enddate = $request->input('enddate');
        $member_finaldata = DB::table('ts6members')->orderby('register_date','desc')->limit(1)->value('register_date');
        if ($join_strdate < 1) {
            $sqlstr = '2017-01-01';
        }else{
            $sqlstr = substr($join_strdate,0,4).'-'.substr($join_strdate,4,2).'-'.substr($join_strdate,6,2);
        }
        $sqlend = substr($member_finaldata,0,10);
        $members = DB::select('SELECT name,email,cellphone,tel,register_date 
        FROM ts6members
        WHERE left(register_date,10) >= ? and left(register_date,10) <= ?
        ORDER BY register_date DESC',
        [$sqlstr,$sqlend]);

        $memberscount = count($members);
        if ($memberscount < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.ts6members', compact('sqlstr','sqlend','memberscount','members'));
        }

    }

    public function orderscount(Request $request)
    {
        //查詢大於等於輸入次數，並顯示聯繫資料
        $orderscount = $request->input('orders');
        $order_enddate = $request->input('orderend');
        //判斷次數未輸入則視為大於等於1
        if ($orderscount < 1 or $order_enddate < 1) {
            $orderscount = 1;
        }
        $sqlend = substr($order_enddate,0,4).'/'.substr($order_enddate,4,2).'/'.substr($order_enddate,6,2);
        $orders = DB::select('SELECT name,email,count(order_id) AS orders_count,sum(total_amount) AS total_amount
        FROM ( SELECT DISTINCT order_id,name,email,total_amount FROM ts6orders WHERE order_time <= ? ) P
        GROUP BY name,email
        HAVING orders_count >= ?
        ORDER BY orders_count DESC',
        [$sqlend, $orderscount]);

        $ordertimes = count($orders);
        if ($ordertimes < 1) {
            $result = '查無資料，請檢查條件是否輸入正確(截止日期不可空白)!!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.ts6orders', compact('order_enddate','orderscount','ordertimes','orders'));
        }

    }

    public function ts6detail(Request $request)
    {
        //依會員Email查詢詳細記錄
        $mem_email = $request->input('ts6email');
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
        return view('sales.ts6detail', compact('ts6details','mem_orders','order_times'));
        }

    }

    public function ts6noorder(Request $request)
    {
        //By時間查詢未下單資料
        $noorder_strdate = $request->input('noorder');
        if ($noorder_strdate < 1) {
            $noorder_strdate = '20171101';
        }
        $no_str = substr($noorder_strdate,0,4).'-'.substr($noorder_strdate,4,2).'-'.substr($noorder_strdate,6,2);
        $noorders = DB::select('SELECT name,email,cellphone,tel,register_date 
        FROM ts6members
        WHERE NOT EXISTS (SELECT * FROM ts6orders WHERE ts6orders.email = ts6members.email) AND register_date >= ?
        ORDER BY register_date DESC',[$no_str]);

        $noorderscount = count($noorders);
        if ($noorderscount < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.ts6noorder', compact('noorder_strdate','noorderscount','noorders'));
        }

    }

}
