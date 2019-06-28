@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h2>查詢結果</h2>
        <a href={{ route('searchs.index') }} class="btn btn-success btn-sm">返回</a>
        <a href={{ route('searchs.index') }} class="btn btn-success btn-sm">匯出Excel</a>
        </div>
        <br>
        <div class="col-12">
            <br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>客戶代碼</th>
                        <th>客戶全名</th>
                        <th>銷貨日期</th>
                        <th>部門</th>
                        <th>品牌</th>
                        <th>四大類</th>
                        <th>品名</th>
                        <th>數量</th>
                        <th>匯率/單位</th>
                        <th>發票起號</th>
                        <th>發票迄號</th>
                        <th>單別</th>
                        <th>單號</th>
                        <th>序號</th>                                                          
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purths as $purth)
                    <tr>
                        <td>{{ $purth->TH001 }}</td>
                        <td>{{ $purth->TH002 }}</td>
                        <td>{{ $purth->TH003 }}</td>
                        <td>{{ $purth->TH004 }}</td>
                        <td>{{ $purth->TH007 }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection
