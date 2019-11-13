@extends('layouts.master')
@section('title','TS6會員查詢系統')
@section('content')
@if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
<div class="container">
    <div class="row">
        <div class="col-12">
        <span style="color:blue;"><h6>查詢結果</h6></span>
        <p><a href={{ route('sales.ts6index') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a>
        <a href="{{ route('ts6items_export',compact('sqlstr','sqlend','itemscount')) }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出Excel" onclick="return confirm('確認是否要匯出Excel?');"></a>
        <label style="font-size:16px"><span style="color:blue;">※計算日期區間：{{ $sqlstr }} 至 {{ $sqlend }}。商品累計次數大於等於：{{ $itemscount }}次。資料總筆數：{{ $itemstimes }} 筆。</span></label>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th style="background-color:#CCCCFF;">姓名</th>
                        <th style="background-color:#CCCCFF;">Email</th>
                        <th style="background-color:#CCCCFF;">電話</th>
                        <th style="background-color:#CCCCFF;">商品名稱</th>
                        <th style="background-color:#CCCCFF;">商品編號</th>
                        <th style="background-color:#CCCCFF;">商品累計次數</th>
                        <th style="background-color:#CCCCFF;">累計下單金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td style="background-color:#F2FFF2;">{{ $item->name }}</td>
                        <td><a href="{{ route('sales.ts6byemail',$item->email) }}">{{ $item->email }}</td>
                        <td style="background-color:#F2FFF2;">{{ $item->phone }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td style="background-color:#F2FFF2;">{{ $item->item_id }}</td>
                        <td>{{ $item->items_count }}</td>
                        <td style="background-color:#F2FFF2;">{{ $item->total_amount }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif  
@endsection

