@extends('layouts.master')
@section('title','結帳前查詢')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>結帳前查詢</h2>
            <a class="btn btn-primary" href={{ route('excel') }} role="button">產出Excel</a>
        </div>
    </div>
</div>  
@endsection
