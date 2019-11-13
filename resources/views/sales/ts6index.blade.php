@extends('layouts.master')
@section('title','業務專用查詢系統')
@section('content')
@auth
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
        <span style="color:red;">※會員資料更新至：{{ $membertime }} 止；訂單資料更新至：{{ $ordertime }} 止。會員總筆數：{{ $membercounts }}筆。</span></p>
            <span style="color:blue;"><h6>TS6會員數量查詢（依註冊日期往後計算）</h6></span>
            <form method="post" action={{ route('sales.ts6members') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">計算起始日期(輸入格式為ex:20190101，空白則由第一筆計算至現有更新日期)</label>
                    <input type="text" style="font-size:16px" name="strdate"> 
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">會員數量查詢</button>

            </div>
            </form>
            <span style="color:blue;"><h6>TS6會員下單次數查詢(含金額)</h6></span>
            <form method="post" action={{ route('sales.orderscount') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">輸入下單次數大於等於<input type="text" name="orders">次。</label><br>
                    <label style="font-size:16px">計算起始日期(輸入格式為ex:20190101)</label>
                    <input type="text" style="font-size:16px" name="orderstr"><br>
                    <label style="font-size:16px">計算結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" style="font-size:16px" name="orderend">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">累計下單查詢</button>

            </div> 
            </form>
            <span style="color:blue;"><h6>TS6購買商品金額統計查詢</h6></span>
            <form method="post" action={{ route('sales.amountover') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">商品累計金額大於等於<input type="text" name="amount">元。</label><br>
                    <label style="font-size:16px">計算起始日期(輸入格式為ex:20190101)</label>
                    <input type="text" style="font-size:16px" name="amountstr"><br>
                    <label style="font-size:16px">計算結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" style="font-size:16px" name="amountend">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">累計金額查詢</button>

            </div> 
            </form>
            <span style="color:blue;"><h6>TS6購買商品次數統計查詢</h6></span>
            <form method="post" action={{ route('sales.itemscount') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">商品累計次數大於等於<input type="text" name="items">次。</label><br>
                    <label style="font-size:16px">計算起始日期(輸入格式為ex:20190101)</label>
                    <input type="text" style="font-size:16px" name="countstr"><br>
                    <label style="font-size:16px">計算結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" style="font-size:16px" name="countend">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">商品次數查詢</button>

            </div> 
            </form>
            <span style="color:blue;"><h6>TS6會員明細資料查詢</h6></span>
            <form method="post" action={{ route('sales.ts6detail') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">輸入TS6會員Email</label>
                    <input type="text" style="font-size:16px" name="ts6email">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">明細資料查詢</button>

            </div> 
            </form>
            <span style="color:blue;"><h6>TS6會員未下單查詢。(會員資料量大，查詢&匯出結果請稍等！)</h6></span>
            <form method="post" action={{ route('sales.ts6noorder') }}>
            @csrf
            <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">未下單資料查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction={{ route('ts6noorder_export') }} onclick="return confirm('等候時間較久，確認是否匯出Excel?');">匯出Excel</button>
            </div> 
            </form>        
        </div>
    </div>
</div>
@endif 
@endauth 
@endsection
