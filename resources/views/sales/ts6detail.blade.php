@extends('layouts.master')
@section('title','TS6會員查詢系統')
@section('content')
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container">
    <div class="row">
        <div class="col-12">
        <span style="color:blue;"><h6>TS6會員資訊查詢結果</h6></span>
        <p><a href={{ route('sales.ts6index') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
        <a href="{{ route('ts6detail_export',$mem_email) }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出Excel" onclick="return confirm('確認是否要匯出Excel?');"></a>
        <label style="font-size:14px"><span style="color:blue;">※累計下單次數共：@foreach($order_times as $order_time){{ (int)$order_time->orders_count }}@endforeach 次。累計金額共：@foreach($order_times as $order_time){{ (int)$order_time->orders_amount }}@endforeach 元。</span></label>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>會員編號</th>
                        <th>姓名</th>
                        <th>Email</th>
                        <th>手機</th>
                        <th>生日</th>
                        <th>性別</th>
                        <th>電話</th>
                        <th>地址</th>
                        <th>註冊時間</th>
                        <th>註冊來源</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ts6details as $ts6detail)
                    <tr>
                        <td>{{ $ts6detail->member_id }}</td>
                        <td>{{ $ts6detail->name }}</td>
                        <td>{{ $ts6detail->email }}</td>
                        <td>{{ $ts6detail->cellphone }}</td>
                        <td>{{ $ts6detail->birthday }}</td>
                        <td>{{ $ts6detail->sex }}</td>
                        <td>{{ $ts6detail->tel }}</td>
                        <td>{{ $ts6detail->address }}</td>
                        <td>{{ $ts6detail->register_date }}</td>
                        <td>{{ $ts6detail->register_source }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-12 table-cont">
            <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>訂單日期</th>
                    <th>訂單編號</th>
                    <th>訂購人</th>
                    <th>Email</th>
                    <th>商品名稱</th>
                    <th>商品編號</th>
                    <th>數量</th>
                    <th>單價</th>
                    <th>紅利折抵</th>
                    <th>任選折扣</th>
                    <th>任選折扣總額</th>
                    <th>訂單總額</th>
            </thead>
            <tbody>
                @foreach ($mem_orders as $mem_order)
                <tr>
                    <td>{{ $mem_order->order_time }}</td>
                    <td>{{ $mem_order->order_id }}</td>
                    <td>{{ $mem_order->name }}</td>
                    <td>{{ $mem_order->email }}</td>
                    <td>{{ $mem_order->item_name }}</td>
                    <td>{{ $mem_order->item_id }}</td>
                    <td>{{ $mem_order->quantity }}</td>
                    <td>{{ $mem_order->price }}</td>
                    <td>{{ $mem_order->bonus_discount}}</td>
                    <td>{{ $mem_order->discount}}</td>
                    <td>{{ $mem_order->discount_amount }}</td>
                    <td>{{ $mem_order->total_amount }}</td>
                </tr>  
                @endforeach
            </tbody>
            </table>
        </div>

    </div>
</div>
@endif  
@endsection

