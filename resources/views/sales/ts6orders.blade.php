@extends('layouts.master')
@section('title','TS6會員查詢系統')
@section('content')
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container">
    <div class="row">
        <div class="col-12">
        <span style="color:blue;"><h6>查詢結果</h6></span>
        <p><a href={{ route('sales.ts6index') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
        <label style="font-size:16px"><span style="color:blue;">下單次數計算截止日期：{{ $order_enddate }}。下單次數大於等於：{{ $orderscount }}。資料總筆數：{{ $ordertimes }}</span></label>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th style="background-color:#CCCCFF;">姓名</th>
                        <th style="background-color:#CCCCFF;">Email</th>
                        <th style="background-color:#CCCCFF;">累計下單次數</th>
                        <th style="background-color:#CCCCFF;">累計下單金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td style="background-color:#F2FFF2;">{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td style="background-color:#F2FFF2;">{{ $order->orders_count }}</td>
                        <td>{{ $order->total_amount }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif  
@endsection

