@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <h5>#結帳前檢查(測試)</h5>
            <form method="post" action={{ route('searchs.SA_Begin_Check') }}>
            @csrf
            <div class="form-group">
                    <label>起始年月(輸入格式為ex:201908)</label>
                    <input type="text" name="fin_date1"><br>
                    <label>結束日期(輸入格式為ex:201908)</label>
                    <input type="text" name="fin_date2">                    
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('searchs.SA_Begin_Check') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>        
            </form>
            <h5>#結帳後檢查(測試)</h5>
            <form method="post" action={{ route('searchs.SA_Begin_Check') }}>
            @csrf
            <div class="form-group">
                    <label>起始年月(輸入格式為ex:201908)</label>
                    <input type="text" name="fin_date1"><br>
                    <label>結束日期(輸入格式為ex:201908)</label>
                    <input type="text" name="fin_date2">                    
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('searchs.SA_Begin_Check') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>        
            </form>
        </div>
    </div>
</div> 
@endauth 
@endsection
