@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
<div class="container">
    <div class="row">
        <div class="col-12">
            <h5>#天賜爾進貨單資料查詢(測試)</h5>
            <form method="post" action={{ route('searchs.result01') }}>
            @csrf
            <div class="form-group">
                    <label>進貨單別</label>
                    <input type="text" name="TH001" id="TH001">
                    <label>進貨單號</label>
                    <input type="text" name="TH002" id="TH002">                    
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
            <button type="submit" class="btn btn-primary btn-sm" formaction="{{ route('auth.test')}}">查詢2</button>
            </div>
            </form>
            <h5>#賢齊進退貨資料查詢(測試)</h5>
            <form method="post" action={{ route('searchs.purth_result') }}>
            @csrf
            <div class="form-group">
                    <label>By品號</label>
                    <input type="text" name="TH004" id="TH004">
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction="exportfiles\exportexcel.php" onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('export_xls') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel-Test</button>
            </div>
            </form>
            <h5>#展場銷貨查詢(測試)</h5>
            <form method="post" action={{ route('searchs.pos_inv') }}>
            @csrf
            <div class="form-group">
                    <label>起始日期(輸入格式為ex:20190601)</label>
                    <input type="text" name="date1"><br>
                    <label>結束日期(輸入格式為ex:20190630)</label>
                    <input type="text" name="date2">                    
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction="exportfiles\export_posinv.php" onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>

            </div>        
            </form>
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
