@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h5>賢齊進退貨資料查詢結果</h5>
        <p><a href={{ route('searchs.search1') }} class="btn btn-success btn-sm">返回</a></p>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
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
