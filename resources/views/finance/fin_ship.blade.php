@extends('layouts.master')
@section('title','財務專用')
@section('content')
@auth
<div class="container">
    <div class="row">
        <div class="col-12">
        <span style="color:blue;"><h6>結帳單查詢結果</h6></span>
        <a href={{ route('finance.fsearch1') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
        <a href="{{ route('fin_ship_export',compact('date_str','date_end')) }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出明細" onclick="return confirm('確認是否要匯出Excel?匯出資料量大，請耐心等候!!');"></a>
        <span style="color:blue;"><label style="font-size:16px">查詢日期：{{ $date_str }} 至 {{ $date_end }} 止。資料筆數：{{ $data_records }}筆。</label></span>
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
                        <td>{{ (int)$ship->NTD }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endauth  
@endsection

