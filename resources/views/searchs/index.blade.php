@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h2>資料查詢</h2>
            <form method="post" action={{ route('searchs.store') }}>
            @csrf
            <div class="form-group">
                    <label>單號</label>
                    <input type="text" name="TH002" id="TH002">
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
                </div>
            </form>
        </div>
        <br>
    </div>
</div>  
@endsection
