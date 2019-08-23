@extends('layouts.master')
@section('title','UserEdit')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12"><br>
            <form method="post" action="{{ route('UsersProfile.UsersUpdate', $user->username) }}">
                @csrf
                {{ method_field('PATCH') }}
                <div class="card">
                    <div class="card-header">
                    使用者資訊
                </div>
                <div class="card-body">
                    <div class="shadow p-1 bg-white rounded">Login-ID：<input type="text" name="username" value="{{ $user->username }}" readonly> ReadOnly
                    <div class="shadow p-1 bg-white rounded">Name：
                    <input type="text" name="name" value="{{ $user->name }}"></div>
                    <div class="shadow p-1 bg-white rounded">User Level：
                    <input type="text" name="user_level" value="{{ $user->user_level }}"></div>
                    <div class="shadow p-1 bg-white rounded">E-mail：
                    <input type="text" name="email" value="{{ $user->email }}"></div>
                </div>
                <div><br>
                <a href="{{ route('UsersProfile.UsersIndex')}}" class="btn btn-secondary btn-sm">返回</a>
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('是否確認儲存?');">儲存</button>
                </div>
            </form>
        </div>
    </div>
</div>  
@endsection
