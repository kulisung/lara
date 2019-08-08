@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h5>查詢結果</h5>
        <p><a href={{ route('searchs.search2') }} class="btn btn-success btn-sm">返回</a></p>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>客戶代碼</th>
                        <th>客戶全名</th>
                        <th>銷貨日期</th>
                        <th>部門</th>
                        <th>品牌</th>
                        <th>四大類</th>
                        <th>品號</th>
                        <th>品名</th>
                        <th>數量</th>
                        <th>匯率\單位</th>
                        <th>發票起號</th>
                        <th>發票迄號</th>
                        <th>單別</th>
                        <th>單號</th>
                        <th>序號</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invs as $inv)
                    <tr>
                        <td>{{ $inv->TG004 }}</td>
                        <td>{{ $inv->TG007 }}</td>
                        <td>{{ $inv->TG003 }}</td>
                        <td>{{ $inv->TG005 }}</td>
                        <td>{{ $inv->MB008 }}</td>
                        <td>{{ $inv->MB006 }}</td>
                        <td>{{ $inv->TH004 }}</td>
                        <td>{{ $inv->TH005 }}</td>
                        <td>{{ $inv->QTY }}</td>
                        <td>{{ $inv->TG012 }}</td>
                        <td>{{ $inv->TG098 }}</td>
                        <td>{{ $inv->TG014 }}</td>
                        <td>{{ $inv->TH001 }}</td>
                        <td>{{ $inv->TH002 }}</td>
                        <td>{{ $inv->TH003 }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection

