@extends('layouts.master')
@section('title','TS6會員查詢系統')
@section('content')
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container">
    <div class="row">
        <div class="col-12">
        <span style="color:blue;"><h6>查詢結果</h6></span>
        <p><a href={{ route('sales.ts6index') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
        <a href="{{ route('ts6counts_export',compact('sqlstr','sqlend','orderscount')) }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出Excel" onclick="return confirm('確認是否要匯出Excel?');"></a>
        <label style="font-size:16px"><span style="color:blue;">※計算區間日期：{{ $sqlstr }} 至 {{ $sqlend }}。下單次數大於等於：{{ $orderscount }}。資料總筆數：{{ $ordertimes }} 筆。</span></label>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th style="background-color:#CCCCFF;">姓名</th>
                        <th style="background-color:#CCCCFF;">Email</th>
                        <th style="background-color:#CCCCFF;">電話</th>
                        <th style="background-color:#CCCCFF;">累計下單次數</th>
                        <th style="background-color:#CCCCFF;">累計下單金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td style="background-color:#F2FFF2;">{{ $order->name }}</td>
                        <td><a href="{{ route('sales.ts6byemail',$order->email) }}">{{ $order->email }}</td>
                        <td style="background-color:#F2FFF2;">{{ $order->phone }}</td>
                        <td>{{ $order->orders_count }}</td>
                        <td style="background-color:#F2FFF2;">{{ $order->total_amount }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif  
@endsection

