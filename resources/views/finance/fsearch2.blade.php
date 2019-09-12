@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
@if (auth()->user()->user_level==9 or auth()->user()->user_level==5)
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <span style="color:blue;"><h6>#結帳前檢查(測試)</h6></span>
            <form method="post" action={{ route('finance.fin_b4check') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:14px">結算的起始年月(格式為ex:201901)</label>
                    <input type="text" name="fin_date1">
                    <button type="submit" style="font-size:14px" class="btn btn-primary btn-sm">結帳前檢查</button>
                    <button type="submit" style="font-size:14px" class="btn btn-warning btn-sm" formaction={{ route('finance.fin_b4chk') }}>結帳前檢查(明細)</button>
                    <button type="submit" style="font-size:14px" class="btn btn-info btn-sm" formaction={{ route('fin_b4_export') }} onclick="return confirm('確認是否匯出Excel?');">明細匯出Excel</button>
            </div>        
            </form>
            <span style="color:blue;"><h6>#結帳後檢查(測試)</h6></span>
            <form method="post" action={{ route('finance.fin_b4chk') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:14px">結算的起始年月(格式為ex:201901)</label>
                    <input type="text" name="fin_date3">
                    <button type="submit" style="font-size:14px" class="btn btn-primary btn-sm">結帳後檢查</button>
                    <button type="submit" style="font-size:14px" class="btn btn-info btn-sm" formaction={{ route('finance.fin_b4chk') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>        
            </form>
        </div>
    </div>
</div> 
@endif
@endauth 
@endsection
