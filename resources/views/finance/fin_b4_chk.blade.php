@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
        <h5>查詢結果</h5>
        <p><a href={{ route('finance.fsearch2') }} class="btn btn-success btn-sm">返回</a> <label>資料筆數：{{ $data_records }}筆。總額：@foreach($b4_checks as $b4_check){{ $b4_check->SUMCOST }}@endforeach</label></p>
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
                        <th>內外銷</th>
                        <th>國家別</th>
                        <th>品名</th>
                        <th>數量</th>
                        <th>匯率\單位</th>
                        <th>未稅金額</th>
                        <th>稅額</th>
                        <th>單別</th>
                        <th>單號</th>
                        <th>序號</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($b4_chks as $b4_chk)
                    <tr>
                        <td>{{ $b4_chk->TG004 }}</td>
                        <td>{{ $b4_chk->TG007 }}</td>
                        <td>{{ $b4_chk->TG003 }}</td>
                        <td>{{ $b4_chk->TG005 }}</td>
                        <td>{{ $b4_chk->MB008 }}</td>
                        <td>{{ $b4_chk->MB006 }}</td>
                        <td>{{ $b4_chk->MA038 }}</td>
                        <td>{{ $b4_chk->MA019 }}</td>
                        <td>{{ $b4_chk->TH005 }}</td>
                        <td>{{ $b4_chk->QTY }}</td>
                        <td>{{ $b4_chk->TG012 }}</td>
                        <td>{{ $b4_chk->TH037 }}</td>
                        <td>{{ $b4_chk->TH038 }}</td>
                        <td>{{ $b4_chk->TH001 }}</td>
                        <td>{{ $b4_chk->TH002 }}</td>
                        <td>{{ $b4_chk->TH003 }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

