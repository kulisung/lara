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
        $membercounts = DB::table('ts6members')->count();
        $membertime = substr($member_refresh,0,10);
        $ordertime = substr($order_refresh,0,10);
        return view('sales.ts6index',compact('membertime', 'ordertime','membercounts'));
    }

    //會員數量查詢依日期
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

    //會員下單次數查詢依日期和次數
    public function orderscount(Request $request)
    {
        //查詢大於等於輸入次數，並顯示聯繫資料
        $orderscount = $request->input('orders');
        $order_strdate = $request->input('orderstr');
        $order_enddate = $request->input('orderend');
        $order_finaldata = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        //判斷次數未輸入則視為大於等於1
        if ($orderscount < 1) {
            $orderscount = 1;
        }
        //判斷起始日期是否為空
        if ($order_strdate < 1) {
            $sqlstr = '2017/01/01'; //未輸入日期取最後一筆訂單時間
        }else{ 
            $sqlstr = substr($order_strdate,0,4).'/'.substr($order_strdate,4,2).'/'.substr($order_strdate,6,2);
        }
        //判斷結束日期是否為空
        if ($order_enddate < 1) {
            $sqlend = substr($order_finaldata,0,10); //未輸入日期取最後一筆訂單時間
        }else{ 
            $sqlend = substr($order_enddate,0,4).'/'.substr($order_enddate,4,2).'/'.substr($order_enddate,6,2);
        }
                    
        $orders = DB::select('SELECT name,email,phone,count(order_id) AS orders_count,sum(total_amount) AS total_amount
        FROM ( SELECT DISTINCT order_id,name,email,phone,total_amount FROM ts6orders WHERE left(order_time,10) >= ? and left(order_time,10) <= ? ) P
        GROUP BY name,email,phone
        HAVING orders_count >= ?
        ORDER BY orders_count DESC',
        [$sqlstr, $sqlend, $orderscount]);

        $ordertimes = count($orders);
        if ($ordertimes < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.orderscount', compact('sqlstr','sqlend','orderscount','ordertimes','orders','order_finaldata'));
        }

    }

    //會員商品次數查詢依日期和商品計算
    public function itemscount(Request $request)
    {
        //查詢大於等於輸入次數，並顯示聯繫資料
        $itemscount = $request->input('items');
        $count_strdate = $request->input('countstr');
        $count_enddate = $request->input('countend');
        $order_finaldata = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        //判斷次數未輸入則視為大於等於1
        if ($itemscount < 1) {
            $itemscount = 1;
        }
        //判斷起始日期是否為空
        if ($count_strdate < 1) {
            $sqlstr = '2017/01/01'; //未輸入日期取最後一筆訂單時間
        }else{ 
            $sqlstr = substr($count_strdate,0,4).'/'.substr($count_strdate,4,2).'/'.substr($count_strdate,6,2);
        }
        //判斷結束日期是否為空
        if ($count_enddate < 1) {
            $sqlend = substr($order_finaldata,0,10); //未輸入日期取最後一筆訂單時間
        }else{ 
            $sqlend = substr($count_enddate,0,4).'/'.substr($count_enddate,4,2).'/'.substr($count_enddate,6,2);
        }
                    
        $items = DB::select('SELECT name,email,phone,item_name,item_id,count(item_name) AS items_count,sum(total_amount) AS total_amount
        FROM ts6orders
        WHERE left(order_time,10) >= ? and left(order_time,10) <= ?
        GROUP BY name,email,phone,item_name,item_id
        HAVING items_count >= ?
        ORDER BY items_count DESC',
        [$sqlstr, $sqlend, $itemscount]);

        $itemstimes = count($items);
        if ($itemstimes < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.itemscount', compact('sqlstr','sqlend','itemscount','itemstimes','items','order_finaldata'));
        }
    }

    //累計下單金額查詢
    public function amountover(Request $request)
    {
        //查詢大於等於輸入次數，並顯示聯繫資料
        $amountover = $request->input('amount');
        $amount_strdate = $request->input('amountstr');
        $amount_enddate = $request->input('amountend');
        $order_finaldata = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        //判斷次數未輸入則視為大於等於1
        if ($amountover < 1) {
            $amountover = 1;
        }
        //判斷起始日期是否為空
        if ($amount_strdate < 1) {
            $sqlstr = '2017/01/01'; //未輸入日期取最後一筆訂單時間
        }else{ 
            $sqlstr = substr($amount_strdate,0,4).'/'.substr($amount_strdate,4,2).'/'.substr($amount_strdate,6,2);
        }
        //判斷結束日期是否為空
        if ($amount_enddate < 1) {
            $sqlend = substr($order_finaldata,0,10); //未輸入日期取最後一筆訂單時間
        }else{ 
            $sqlend = substr($amount_enddate,0,4).'/'.substr($amount_enddate,4,2).'/'.substr($amount_enddate,6,2);
        }
                    
        $amounts = DB::select('SELECT name,email,phone,count(order_id) AS orders_count,sum(total_amount) AS total_amount
        FROM ( SELECT DISTINCT order_id,name,email,phone,total_amount FROM ts6orders WHERE left(order_time,10) >= ? and left(order_time,10) <= ? ) P
        GROUP BY name,email,phone
        HAVING total_amount >= ?
        ORDER BY total_amount DESC',
        [$sqlstr, $sqlend, $amountover]);

        $sumamounts = count($amounts);
        if ($sumamounts < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.amountover', compact('sqlstr','sqlend','amountover','sumamounts','amounts','order_finaldata'));
        }
    }

    //依Email查詢會員下單明細
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
        WHERE email = ?
        ORDER BY item_id ASC',
        [$mem_email]);
        //計算下單次數
        $order_times = DB::select('SELECT count(order_id) AS orders_count,sum(total_amount) AS orders_amount
        FROM ( SELECT DISTINCT order_id,name,email,total_amount FROM ts6orders WHERE email = ? ) P',[$mem_email]);

        $ts6count = count($ts6details);
        if ($ts6count < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.ts6detail', compact('ts6details','mem_orders','order_times','mem_email'));
        }

    }

    public function ts6byemail($email) //查詢ByEmail
    {
        //依會員Email查詢詳細記錄
        //會員資料明細
        $ts6details = DB::select('SELECT member_id,name,email,cellphone,birthday,sex,tel,address,register_date,register_source 
        FROM ts6members
        WHERE email = ?',
        [$email]);
        //訂單資料明細
        $mem_orders = DB::select('SELECT order_time,order_id,name,email,item_name,item_id,quantity,price,bonus_discount,discount,discount_amount,total_amount 
        FROM ts6orders 
        WHERE email = ?
        ORDER BY order_time DESC',
        [$email]);
        //計算下單次數
        $order_times = DB::select('SELECT count(order_id) AS orders_count,sum(total_amount) AS orders_amount
        FROM ( SELECT DISTINCT order_id,name,email,total_amount FROM ts6orders WHERE email = ? ) P',[$email]);

        $ts6count = count($ts6details);
        if ($ts6count < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!!';
            return View('nodata')->with('result', $result);
        }else{
            $mem_email = $email;
            return view('sales.ts6detail', compact('ts6details','mem_orders','order_times','mem_email'));
        }

    }

    public function ts6noorder(Request $request)
    {
        //By時間查詢未下單資料
        //$noorder_strdate = '2017/01/01';
        $noorder_finaldata = DB::table('ts6orders')->orderby('order_time','desc')->limit(1)->value('order_time');
        $member_finaldata = DB::table('ts6members')->orderby('register_date','desc')->limit(1)->value('register_date');
        $noorders = DB::select('SELECT name,email,cellphone,tel,register_date 
        FROM ts6members
        WHERE NOT EXISTS (SELECT * FROM ts6orders WHERE ts6orders.email = ts6members.email)
        ORDER BY register_date DESC');

        $noorderscount = count($noorders);
        if ($noorderscount < 1) {
            $result = '查無資料，請檢查條件是否輸入正確!!';
            return View('nodata')->with('result', $result);
        }else{
        return view('sales.ts6noorder', compact('noorder_finaldata','member_finaldata','noorderscount','noorders'));
        }

    }

}
