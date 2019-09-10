@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <h6>#01#天賜爾進貨單資料查詢(測試)</h6>
            <form method="post" action={{ route('searchs.result01') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:14px">進貨單別</label>
                    <input type="text" name="TH001" id="TH001">
                    <label style="font-size:14px">進貨單號</label>
                    <input type="text" name="TH002" id="TH002">                    
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:14px">查詢</button>
            </div>
            </form>
            <h6>#02#賢齊進退貨資料查詢</h6>
            <form method="post" action={{ route('searchs.purth_result') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:14px">By品號</label>
                    <input type="text" name="TH004" id="TH004">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:14px">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size:14px" formaction={{ route('export_xls') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>
            <h6>#03#展場庫存查詢</h6>
            <form method="post" action={{ route('searchs.pos_inv') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:14px">起始日期(輸入格式為ex:20190601)</label>
                    <input type="text" name="date1"><br>
                    <label style="font-size:14px">結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="date2">                    
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:14px">Invoice查詢</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:14px" formaction={{ route('searchs.pos_stocks') }}>Stocks查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size:14px" formaction={{ route('pos_inv_export') }} onclick="return confirm('確認是否匯出Excel?');">合併匯出Excel</button>
            </div>        
            </form>
            <h6>#04#銷貨對帳單查詢</h6>
            <form method="post" action={{ route('finance.fin_ship') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:14px">起始日期(輸入格式為ex:20190601)</label>
                    <input type="text" name="date3"><br>
                    <label style="font-size:14px">結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="date4">                    
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size:14px" formaction={{ route('fin_ship_export') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>        
            </form>
            <h6>#05#起始品號A or B製令工時查詢(不包含'A-'與'B-'起始品號)</h6>
            <form method="post" action={{ route('searchs.WorkingTime') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:14px">輸入製令工時年月(輸入格式為ex:201908)</label>
                    <input type="text" name="workdate">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:14px">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" style="font-size:14px" formaction={{ route('WorkingTimeExport') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>
        </div>
    </div>
</div> 
@endauth 
@endsection
