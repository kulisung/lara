@extends('layouts.master')
@section('title','業務專用查詢系統')
@section('content')
@auth
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <span style="color:red;">會員資料更新至：{{ $membertime }} 止；訂單資料更新至：{{ $ordertime }} 止。</span></p>
            <span style="color:blue;"><h6>TS6會員數量查詢</h6></span>
            <form method="post" action={{ route('sales.ts6members') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">計算起始日期(輸入格式為ex:20190601，空白則由2017起計算至現有更新日期)</label>
                    <input type="text" name="strdate"> 
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">會員數量查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction={{ route('ts6members_export') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>
            <span style="color:blue;"><h6>TS6會員下單次數查詢(含金額)</h6></span>
            <form method="post" action={{ route('sales.orderscount') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">下單次數大於等於(預設次數1)</label>
                    <input type="text" name="orders"><p>
                    <label style="font-size:16px">計算截止結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="orderend">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">下單次數查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction=# onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div> 
            </form>
            <span style="color:blue;"><h6>TS6會員明細資料查詢</h6></span>
            <form method="post" action={{ route('sales.ts6detail') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">輸入TS6會員Email</label>
                    <input type="text" name="ts6email">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">明細資料查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction=# onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div> 
            </form>
            <span style="color:blue;"><h6>TS6會員未下單查詢。(會員資料量大，建議輸入日期判斷，未輸入則由第一筆開始判斷)</h6></span>
            <form method="post" action={{ route('sales.ts6noorder') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">註冊起始日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="noorder"">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">未下單資料查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction=# onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div> 
            </form>        
        </div>
    </div>
</div>
@endif 
@endauth 
@endsection
