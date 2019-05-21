@extends('layouts.master')
@section('title','Home!')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Welcome! {{ env('APP_NAME') }}</h2>
        </div>
    </div>
</div>  
@endsection