@extends('layouts.master')
@section('title','銷貨單對應暫出單&客單查詢')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <span style="color:blue;"><h6>銷貨單查詢結果</h6></span>
        <a href={{ route('searchs.index') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>銷貨單別</th>
                        <th>銷貨單號</th>
                        <th>訂單單別</th>
                        <th>訂單單號</th>
                        <th>暫出單別</th>
                        <th>暫出單號</th>
                        <th>本幣未稅金額</th>
                        <th>本幣稅額</th>
                        <th>客戶單號</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($COPTH_lists as $COPTH_list)
                    <tr>
                        <td>{{ $COPTH_list->TH001 }}</td>
                        <td>{{ $COPTH_list->TH002 }}</td>
                        <td>{{ $COPTH_list->TH014 }}</td>
                        <td>{{ $COPTH_list->TH015 }}</td>
                        <td>{{ $COPTH_list->TH032 }}</td>
                        <td>{{ $COPTH_list->TH033 }}</td>
                        <td>{{ (int)$COPTH_list->COST }}</td>
                        <td>{{ (int)$COPTH_list->TAX }}</td>
                        <td>{{ $COPTH_list->TC012 }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection
