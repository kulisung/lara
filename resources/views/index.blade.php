@extends('layouts.master')
@section('title','Home!')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h3>Welcome to TENSALL Data Center!!!</h3>
            <h3>Still designing & testing!!</h3><br>
        <h3><marquee behavior="scroll" direction="left" scrollamount="10"><a href="{{ route('posts.index')}}">登入帳號申請及操作方式請洽MIS，公告僅供參考!!</a></marquee></h3>
        </div>
    </div>
    <div class="col-12 table-cont" id="table-cont">
        <div class="card-body">
            <div>
                <label class="col-form-label" style="font-size:24px">
                    登入帳號申請及操作方式請洽MIS，系統測試中!!
                </label>
            </div>
        </div>
    </div>
</div>  
@endsection