@extends('layouts.master')
@section('title','!!!!!')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
        <h4><span style="color:red;">{{ $result }}</span></h4>
        </div>
        <form method="post" action={{ route('searchs.pos_update') }}>
            @csrf
            <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm" style="font-size:16px" onclick="return confirm('確認是否更新?');">資料更新</button>
            </div>       
        </form>
    </div>
</div>  
@endsection