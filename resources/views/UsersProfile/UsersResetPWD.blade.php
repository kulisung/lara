@extends('layouts.master')
@section('title','UserEdit')
@section('content')
@auth
@if (auth()->user()->user_level==9)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 "><br>
            <form method="post" action="{{ route('UsersProfile.UsersResetPassword', $user->username) }}">
                @csrf
                {{ method_field('PATCH') }}
                <div class="card">
                    <div class="card-header">
                    使用者資訊
                </div>
                <div class="card-body">
                        <div class="form-group row">
                            <label for="loginid" class="col-md-4 col-form-label text-md-right">Login-ID</label>
                            <div class="col-md-6">
                            <label for="loginid" class="col-md-4 col-form-label text-md-right">{{ $user->username }}</label>
                            </div>

                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </div>
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
