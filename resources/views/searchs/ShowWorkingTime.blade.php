@extends('layouts.master')
@section('title','製令工時查詢')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h6>查詢結果</h6>
        <p><a href={{ route('searchs.search3') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a></p>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>品號</th>
                        <th>品名</th>
                        <th>數量</th>
                        <th>人時</th>
                        <th>機時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($works as $work)
                    <tr>
                        <td>{{ $work->MB007 }}</td>
                        <td>{{ $work->MB002 }}</td>
                        <td>{{ $work->QTY }}</td>
                        <td>{{ $work->hum_time }}</td>
                        <td>{{ $work->mac_time }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection

