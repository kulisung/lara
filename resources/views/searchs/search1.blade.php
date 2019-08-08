@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
<div class="container" style="background-color:#DEFFFF;">
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
            </div>
            </form>
            <h5>#賢齊進退貨資料查詢(測試)</h5>
            <form method="post" action={{ route('searchs.purth_result') }}>
            @csrf
            <div class="form-group">
                    <label>By品號</label>
                    <input type="text" name="TH004" id="TH004">
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('export_xls') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>
         </div>
    </div>
</div> 
@endauth 
@endsection
