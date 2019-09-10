@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h6>查詢結果</h6>
        <p><a href={{ route('searchs.search2') }} class="btn btn-success btn-sm" style="font-size:14px">返回</a></p>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>品號</th>
                        <th>品名</th>
                        <th>規格</th>
                        <th>數量</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stocks as $stock)
                    <tr>
                        <td>{{ $stock->AA }}</td>
                        <td>{{ $stock->BB }}</td>
                        <td>{{ $stock->CC }}</td>
                        <td>{{ $stock->QTY }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection

