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
                        <th><span style="font-size:14px;">部門</th>
                        <th><span style="font-size:14px;">品牌</th>
                        <th><span style="font-size:14px;">四大類</th>
                        <th><span style="font-size:14px;">品號</th>
                        <th><span style="font-size:14px;">品名</th>
                        <th><span style="font-size:14px;">數量</th>
                        <th><span style="font-size:14px;">匯率\單位</th>
                        <th><span style="font-size:14px;">發票起號</th>
                        <th><span style="font-size:14px;">發票迄號</th>
                        <th><span style="font-size:14px;">單別</th>
                        <th><span style="font-size:14px;">單號</th>
                        <th><span style="font-size:14px;">序號</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invs as $inv)
                    <tr>
                        <td><span style="font-size:16px;">{{ $inv->TG004 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TG007 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TG003 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TG005 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->MB008 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->MB006 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TH004 }}</td>
                        <td><span style="font-size:16px;">{{ $inv->TH005 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->QTY }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TG012 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TG098 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TG014 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TH001 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TH002 }}</td>
                        <td><span style="font-size:14px;">{{ $inv->TH003 }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection
