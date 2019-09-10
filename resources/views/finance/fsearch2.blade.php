@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
@if (auth()->user()->user_level==9 or auth()->user()->user_level==5)
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <h6>#結帳前檢查(測試)</h6>
            <form method="post" action={{ route('finance.fin_b4check') }}>
            @csrf
            <div class="form-group">
                    <label>結算的起始年月(格式為ex:201901)</label>
                    <input type="text" name="fin_date1">
                    <button type="submit" class="btn btn-primary btn-sm">結帳前檢查</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('finance.fin_b4chk') }}>結帳前檢查(明細)</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('finance.fin_b4chk') }} onclick="return confirm('確認是否匯出Excel?');">明細資料匯出Excel</button>
            </div>        
            </form>
            <h6>#結帳後檢查(測試)</h6>
            <form method="post" action={{ route('finance.fin_b4chk') }}>
            @csrf
            <div class="form-group">
                    <label>結算的起始年月(格式為ex:201901)</label>
                    <input type="text" name="fin_date3">
                    <button type="submit" class="btn btn-primary btn-sm">結帳後檢查</button>
                    <button type="submit" class="btn btn-secondary btn-sm" formaction={{ route('finance.fin_b4chk') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>        
            </form>
        </div>
    </div>
</div> 
@endif
@endauth 
@endsection
