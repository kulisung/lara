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
        return view('sales.ts6index');
    }

    public function ts6members(Request $request)
    {
        //依加入時間查詢會員資料，並記錄總數
        $join_enddate = $request->input('enddate');
        $sqlend = substr($join_enddate,0,4).'-'.substr($join_enddate,4,2).'-'.substr($join_enddate,6,2);
        $members = DB::select('SELECT name,email,cellphone,tel,register_date 
        FROM ts6members
        WHERE register_date <= ?
        ORDER BY register_date DESC',
        [$sqlend]);

        $memberscount = count($members);
        if ($memberscount < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.ts6members', compact('join_enddate','memberscount','members'));
        }

    }

    public function orderscount(Request $request)
    {
        //查詢大於等於輸入次數，並顯示聯繫資料
        $orderscount = $request->input('orders');
        if ($orderscount < 1) {
            $orderscount = 1;
        }
        $order_enddate = $request->input('orderend');
        $sqlend = substr($order_enddate,0,4).'/'.substr($order_enddate,4,2).'/'.substr($order_enddate,6,2);
        $orders = DB::select('SELECT name,email,count(order_id) AS orders_count,sum(total_amount) AS total_amount
        FROM ( SELECT DISTINCT order_id,name,email,total_amount FROM ts6orders WHERE order_time <= ? ) P
        GROUP BY name,email
        HAVING orders_count >= ?
        ORDER BY orders_count DESC',
        [$sqlend, $orderscount]);

        $ordertimes = count($orders);
        if ($ordertimes < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
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


}
