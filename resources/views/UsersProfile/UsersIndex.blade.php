@extends('layouts.master')
@section('title','UsersList')
@section('content')
@auth
@if (auth()->user()->user_level==9)
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h5>使用者列表</h5>
        </div>
        <br>
        <div class="col-12 table-cont" id="table-cont">
            <br>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Login-ID</th>
                        <th>Name</th>
                        <th>User-Level</th>
                        <th>E-mail</th>
                        <th>Edit</th>
                        <th>Reset Password</th>
                        <th>Delete User</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->user_level }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('UsersProfile.UsersEdit',$user->username) }}" style="font-size:12px" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                        <td>
                            <a href="{{ route('UsersProfile.UsersResetPWD',$user->username) }}" class="btn btn-primary btn-sm" style="font-size:12px">ResetPassword</a>
                        </td>
                        <td>
                            <form method="post" action="{{ route('UsersProfile.destroy',$user->username) }}" id='delete'>
                                @csrf
                                {{ method_field('DELETE') }}
                                <button type="submit" style="font-size:12px" class="btn btn-danger btn-sm" onclick="return confirm('是否確認刪除?');">Delete</button>
                            </form>
                        </td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endauth
@endsection
