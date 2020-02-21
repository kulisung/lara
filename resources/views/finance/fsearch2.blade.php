@extends('layouts.master')
@section('title','財務專用')
@section('content')
@auth
@if (auth()->user()->user_level==9 or auth()->user()->user_level==5)
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <span style="color:blue;"><h6>#結帳前檢查</h6></span>
            <form method="post" action={{ route('finance.fin_b4check') }}>
            @csrf
            <div class="form-group">
                <label style="font-size:16px">結算的起始年月(格式為ex:201901)</label>
                <input type="text" id="Datepicker" class="Datepicker" name="fin_b4date">
                <button type="submit" style="font-size:16px" class="btn btn-primary btn-sm">結帳前檢查</button>
                <!-- 20191113註記，先不顯示明細節省效能 
                <button type="submit" style="font-size:16px" class="btn btn-warning btn-sm" formaction={{ route('finance.fin_b4chk') }}>結帳前檢查(明細)</button>
                -->
                
            </div>        
            </form>
            <span style="color:blue;"><h6>#結帳後檢查</h6></span>
            <form method="post" action={{ route('finance.fin_afcheck') }}>
            @csrf
            <div class="form-group">
                <label style="font-size:16px">結算的起始年月(格式為ex:201901)</label>
                <input type="text" id="Datepicker" class="Datepicker" name="fin_afdate">
                <button type="submit" style="font-size:16px" class="btn btn-primary btn-sm">結帳後檢查</button>
            </div>        
            </form>
        </div>
    </div>
</div> 
@endif
@endauth 
@endsection
