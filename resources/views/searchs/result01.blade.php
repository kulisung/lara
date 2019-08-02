@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h2>查詢結果</h2>
        <p><a href={{ route('searchs.index') }} class="btn btn-success btn-sm">返回</a></p>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>單別</th>
                        <th>單號</th>
                        <th>序號</th>
                        <th>品號</th>
                        <th>品名</th>
                        <th>數量</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purths as $purth)
                    <tr>
                        <td>{{ $purth->TH001 }}</td>
                        <td>{{ $purth->TH002 }}</td>
                        <td>{{ $purth->TH003 }}</td>
                        <td>{{ $purth->TH004 }}</td>
                        <td>{{ $purth->TH005 }}</td>
                        <td>{{ $purth->TH007 }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection
