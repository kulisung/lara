@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <span style="color:blue;"><h6>#展場庫存查詢</h6></span>
            <form method="post" action={{ route('searchs.pos_inv') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">起始日期(輸入格式為ex:20190601)</label>
                    <input type="text" name="date1"><br>
                    <label style="font-size:16px">結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="date2">                    
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">Invoice查詢</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px" formaction={{ route('searchs.pos_stocks') }}>數量查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction={{ route('pos_inv_export') }} onclick="return confirm('確認是否匯出Excel?');">合併匯出Excel</button>
            </div>       
            </form>
        </div>
    </div>
</div> 
@endauth 
@endsection
