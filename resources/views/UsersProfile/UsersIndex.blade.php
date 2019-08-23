@extends('layouts.master')
@section('title','UsersList')
@section('content')
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
                            <a href="{{ route('UsersProfile.UsersEdit',$user->username) }}" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                        <td>
                            <button type="button" style="font-size:12px" class="btn btn-primary" data-toggle="modal" data-target="#resetpwd">ResetPassword</button>
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
<script>
$('#resetpwd').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('username') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('What' + recipient)
  modal.find('.modal-body input').val(recipient)
})
</script>
<div class="modal fade" id="resetpwd" tabindex="-1" role="dialog" aria-labelledby="resetpwdLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetpwdLabel">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="form-group row">
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

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>        
      <div class="modal-footer">
            <form method="post" action="{{ route('UsersProfile.UsersEdit',$user->username) }}">
            @csrf
            {{ method_field('PATCH') }}
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('是否確認修改?');">確認</button>
            </form>
      </div>
    </div>
  </div>
</div>  
@endsection
