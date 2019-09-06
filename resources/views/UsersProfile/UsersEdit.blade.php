@extends('layouts.master')
@section('title','UserEdit')
@section('content')
@auth
@if (auth()->user()->user_level==9)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"><br>
            <form method="post" action="{{ route('UsersProfile.UsersUpdate', $user->username) }}">
                @csrf
                {{ method_field('PATCH') }}
                <div class="card">
                    <div class="card-header">
                    使用者資訊
                </div>
                <div class="card-body">
                    <div class="shadow p-1 bg-white rounded"><label class="col-md-4 col-form-label text-md-right">Login-ID：</label><input type="text" name="username" value="{{ $user->username }}" readonly><label style="font-size:10px">(ReadOnly無法修改)</label></div>
                    <div class="shadow p-1 bg-white rounded"><label class="col-md-4 col-form-label text-md-right">Name：</label>
                    <input type="text" name="name" value="{{ $user->name }}"></div>
                    <div class="shadow p-1 bg-white rounded"><label class="col-md-4 col-form-label text-md-right">User Level：</label>
                    <input type="text" name="user_level" value="{{ $user->user_level }}"></div>
                    <div class="shadow p-1 bg-white rounded"><label class="col-md-4 col-form-label text-md-right">E-mail：</label>
                    <input type="text" name="email" value="{{ $user->email }}"></div>
                </div>
                <label style="font-size:10px">## 註:User Level權限預設=0；1-行政；2-業務；3-生產；4-研發；5-財務；9系統管理員。 ##</label>
                <div><br>
                <a href="{{ route('UsersProfile.UsersIndex')}}" class="btn btn-secondary btn-sm">返回</a>
                <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('是否確認儲存?');">儲存</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endif
@endauth 
@endsection
