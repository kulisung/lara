@extends('layouts.master')
@section('title','資料查詢')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>資料查詢</h2>
            <a class="btn btn-primary" href={{ route('searchs.index') }} role="button">賢齊進退貨查詢</a>
            <a class="btn btn-primary" href="#" role="button">測試</a>
        </div>
    </div>
</div>  
@endsection
