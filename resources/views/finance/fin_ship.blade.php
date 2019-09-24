@extends('layouts.master')
@section('title','財務專用')
@section('content')
@auth
<div class="container">
    <div class="row">
        <div class="col-12">
        <span style="color:blue;"><h6>結帳單查詢結果</h6></span>
        <p><a href={{ route('finance.fsearch1') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a></p>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>客戶代碼</th>
                        <th>客戶全名</th>
                        <th>銷貨日期</th>
                        <th>銷貨單別</th>
                        <th>銷貨單號</th>
                        <th>結帳單別</th>
                        <th>結帳單號</th>
                        <th>未稅金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ships as $ship)
                    <tr>
                        <td>{{ $ship->TG004 }}</td>
                        <td>{{ $ship->TG007 }}</td>
                        <td>{{ $ship->TG003 }}</td>
                        <td>{{ $ship->TH001 }}</td>
                        <td>{{ $ship->TH002 }}</td>
                        <td>{{ $ship->TH027 }}</td>
                        <td>{{ $ship->TH028 }}</td>
                        <td>{{ $ship->NTD }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endauth  
@endsection

