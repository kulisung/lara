@extends('layouts.master')
@section('title','業務資訊查詢系統')
@section('content')
@auth
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12"></p>
            <span style="color:blue;"><h6>TS6會員數量查詢</h6></span>
            <form method="post" action={{ route('sales.ts6members') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">計算截止日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="enddate">                    
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">會員資料查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction=# onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>
            <span style="color:blue;"><h6>TS6會員下單次數查詢(含金額)</h6></span>
            <form method="post" action={{ route('sales.orderscount') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">下單次數大於等於(預設次數1)</label>
                    <input type="text" name="orders"><br>
                    <label style="font-size:16px">計算截止結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="orderend">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">次數查詢</button>
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
        </div>
    </div>
</div>
@endif 
@endauth 
@endsection
