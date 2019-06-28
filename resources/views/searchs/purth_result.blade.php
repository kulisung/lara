@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h3>賢齊進退貨資料查詢結果</h3>
        <a href={{ route('searchs.index') }} class="btn btn-success btn-sm">返回</a>
        <a href={{ route('searchs.index') }} class="btn btn-success btn-sm">匯出Excel</a>
        </div>
        <br>
        <div class="col-12">
            <br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>進貨單別</th>
                        <th>進貨單號</th>
                        <th>進貨序號</th>
                        <th>進貨品號</th>
                        <th>進貨數量</th>
                        <th>合計已退貨數量</th>
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
                        <td>{{ $purth->SUMQTY }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection
