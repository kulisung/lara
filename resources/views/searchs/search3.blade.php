@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <h5>#銷貨對帳單查詢(測試)</h5>
            <form method="post" action={{ route('searchs.ship_data') }}>
            @csrf
            <div class="form-group">
                    <label>起始日期(輸入格式為ex:20190601)</label>
                    <input type="text" name="date3"><br>
                    <label>結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="date4">                    
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('ship_data_export') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>        
            </form>
        </div>
    </div>
</div> 
@endauth 
@endsection
