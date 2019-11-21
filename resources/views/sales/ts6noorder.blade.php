@extends('layouts.master')
@section('title','TS6會員查詢系統')
@section('content')
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container">
    <div class="row">
        <div class="col-12">
        <span style="color:blue;"><h6>查詢結果</h6></span>
        <p><a href={{ route('sales.ts6index') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
        <a href="{{ route('ts6noorder_export') }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出Excel" onclick="return confirm('確認是否要匯出Excel?');"></a>
        <label style="font-size:14px"><span style="color:blue;">※自註冊後未曾下單會員總數：{{ $noorderscount }}；會員最後註冊時間：{{ $member_finaldata }}；最後訂單時間：{{ $noorder_finaldata }}。</span></label>
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
                    @foreach ($noorders as $noorder)
                    <tr>
                        <td style="background-color:#F2FFF2;">{{ $noorder->name }}</td>
                        <td>{{ $noorder->email }}</td>
                        <td style="background-color:#F2FFF2;">{{ $noorder->cellphone }}</td>
                        <td>{{ $noorder->tel }}</td>
                        <td style="background-color:#F2FFF2;">{{ $noorder->register_date }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif  
@endsection

