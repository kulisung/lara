@extends('layouts.master')
@section('title','Home!')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>Welcome to TENSALL Data Center website!!</h3>
            <h3>Keep Going!!</h3><br>
        <h3><marquee behavior="scroll" direction="left" scrollamount="10"><a href="{{ route('posts.index')}}">最新公告</a></marquee></h3>
        </div>
    </div>
</div>  
@endsection