@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h2>查詢結果</h2>
        <a href={{ route('searchs.index') }} class="btn btn-success btn-sm">返回</a>
        </div>
        <br>
        <div class="col-12" style="width:500px;height:500px;overflow:auto;">
            <br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><span style="font-size:14px;">客戶代碼</th>
                        <th><span style="font-size:14px;">客戶全名</th>
                        <th><span style="font-size:14px;">銷貨日期</th>
                        <th><span style="font-size:14px;">銷貨單別</th>
                        <th><span style="font-size:14px;">銷貨單號</th>
                        <th><span style="font-size:14px;">結帳單別</th>
                        <th><span style="font-size:14px;">結帳單號</th>
                        <th><span style="font-size:14px;">未稅金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ships as $ship)
                    <tr>
                        <td><span style="font-size:16px;">{{ $ship->TG004 }}</td>
                        <td><span style="font-size:14px;">{{ $ship->TG007 }}</td>
                        <td><span style="font-size:14px;">{{ $ship->TG003 }}</td>
                        <td><span style="font-size:14px;">{{ $ship->TH001 }}</td>
                        <td><span style="font-size:14px;">{{ $ship->TH002 }}</td>
                        <td><span style="font-size:14px;">{{ $ship->TH027 }}</td>
                        <td><span style="font-size:14px;">{{ $ship->TH028 }}</td>
                        <td><span style="font-size:16px;">{{ $ship->NTD }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection

