@extends('layouts.master')
@section('title','資料查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h3>天賜爾進貨單資料查詢</h3>
            <form method="post" action={{ route('searchs.result01') }}>
            @csrf
            <div class="form-group">
                    <label>進貨單別</label>
                    <input type="text" name="TH001" id="TH001">
                    <label>進貨單號</label>
                    <input type="text" name="TH002" id="TH002">                    
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
            </div>
            <hr color='gray'>
            <h3>賢齊進退貨資料查詢</h3>
            </form>
            <form method="post" action={{ route('searchs.purth_result') }}>
            @csrf
            <div class="form-group">
                    <label>By品號</label>
                    <input type="text" name="TH004" id="TH004">
                    <button type="submit" class="btn btn-primary btn-sm">查詢</button>
            </div>
            </form>
        </div>
        <br>
    </div>
</div>  
@endsection
