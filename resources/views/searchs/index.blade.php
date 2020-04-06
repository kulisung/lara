@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
@auth
<div class="container" style="background-color:#DEFFFF;">
    <div class="row">
        <div class="col-12">
            <span style="color:blue;"><h6>##起始品號A or B製令工時查詢(不包含'A-'與'B-'起始品號)</h6></span>
            <form method="post" action={{ route('searchs.WorkingTime') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">輸入製令工時年月(輸入格式為ex:201908)</label>
                    <input type="text" name="workdate">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px">查詢</button>
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" formaction={{ route('WorkingTimeExport') }} onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>
            </form>
            <span style="color:blue;"><h6>#暫出單查詢客戶單號匯出(ForVicky用)</h6></span>
            <form method="post" action={{ route('INVTG_1300_Export') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">輸入暫出單別(EX:1300)：</label>
                    <input type="text" name="TG001"><br>
                    <label style="font-size:16px">輸入暫出單號前四碼(EX:2003)：</label>
                    <input type="text" name="TG002">                    
                    <button type="submit" class="btn btn-info btn-sm" style="font-size:16px" onclick="return confirm('確認是否匯出Excel?');">匯出Excel</button>
            </div>        
            </form>
            </form>
            <span style="color:blue;"><h6>#銷貨單暫出單查詢匯出(ForVicky用)</h6></span>
            <form method="post" action={{ route('COPTH_Export') }}>
            @csrf
            <div class="form-group">
                    <label style="font-size:16px">輸入銷貨單別(EX:2301)：</label>
                    <input type="text" name="TH001"><br>
                    <label style="font-size:16px">輸入起始銷貨單號(EX:20030001)：</label>
                    <input type="text" name="TH002S"><br>
                    <label style="font-size:16px">輸入結束銷貨單號(EX:20030050)：</label>
                    <input type="text" name="TH002E"><br>
                    <label style="font-size:16px">銷貨單確認狀態：</label>
                    <select name="STATUS" style="font-size:16px">
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
