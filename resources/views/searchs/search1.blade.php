@extends('layouts.master')
@section('title','銷退貨資料查詢')
@section('content')
@auth
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <span style="color:blue;"><h6>#銷貨單彙總查詢</h6></span>
            <form method="post" action={{ route('COPTG_SUM_Export') }}>
            @csrf
            <div class="form-group">
                <label style="font-size:16px">輸入銷貨日期(EX:20200701)：</label>
                <input type="text" name="TG003" id="TG003"><br>
                <label style="font-size:16px">輸入ERP客戶代號：</label>
                <input type="text" name="TG004" id="TG004"><br>
                <label style="font-size:16px">銷貨單確認狀態：</label>
                    <select name="TG023" style="font-size:16px">
                        <option value='Y' style="font-size:14px">已確認</option>
                        <option value='N' style="font-size:14px">未確認</option>
                    </select>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>

            <span style="color:blue;"><h6>#銷退單彙總查詢</h6></span>
            <form method="post" action={{ route('COPTI_SUM_Export') }}>
            @csrf
            <div class="form-group">
                <label style="font-size:16px">輸入銷退日期(EX:20200701)：</label>
                <input type="text" name="TI003" id="TI003"><br>
                <label style="font-size:16px">輸入ERP客戶代號：</label>
                <input type="text" name="TI004" id="TI004"><br>
                <label style="font-size:16px">銷退單確認狀態：</label>
                    <select name="TI019" style="font-size:16px">
                        <option value='Y' style="font-size:14px">已確認</option>
                        <option value='N' style="font-size:14px">未確認</option>
                    </select>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>
         </div>
    </div>
</div> 
@endauth 
@endsection
