@extends('layouts.master')
@section('title','TS6會員查詢系統')
@section('content')
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container">
    <div class="row">
        <div class="col-12">
            <span style="color:blue;"><h6>查詢結果</h6></span>
            <a href={{ route('sales.ts6index') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
            <a href="{{ route('ts6members_export',$sqlstr) }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出Excel" onclick="return confirm('確認是否要匯出Excel?');"></a>
            <span style="color:blue;"><label style="font-size:14px">※資料截至：{{ $sqlstr }} - {{ $sqlend }}為止；會員總數共：{{ $memberscount }}名。點擊email可查詢下單之歷史紀錄。</label></span>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th style="background-color:#CCCCFF;">姓名</th>
                        <th style="background-color:#CCCCFF;">Email</th>
                        <th style="background-color:#CCCCFF;">手機</th>
                        <th style="background-color:#CCCCFF;">電話</th>
                        <th style="background-color:#CCCCFF;">註冊日期</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                    <tr>
                        <td style="background-color:#F2FFF2;">{{ $member->name }}</td>
                        <td><a href="{{ route('sales.ts6byemail',$member->email) }}">{{ $member->email }}</td>
                        <td style="background-color:#F2FFF2;">{{ $member->cellphone }}</td>
                        <td>{{ $member->tel }}</td>
                        <td style="background-color:#F2FFF2;">{{ $member->register_date }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif  
@endsection

