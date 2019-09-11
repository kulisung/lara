@extends('layouts.master')
<meta http-equiv="refresh" content="3;url={{ route('index')}}">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ auth()->user()->name }} 你好!!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    已登入系統！！ 3秒後轉至首頁！！
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
