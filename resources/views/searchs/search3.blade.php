@extends('layouts.master')
@section('title','產線資料查詢')
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
        </div>
    </div>
</div> 
@endauth 
@endsection
