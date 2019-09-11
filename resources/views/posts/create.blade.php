@extends('layouts.master')
@section('title','公告系統')
@section('content')
@auth
<div class="container">
    <div class="row">
        <div class="col-12">
            <span style="color:blue;"><h6>新增公告</h6></span>
        <a href="{{ route('posts.index')}}" class="btn btn-secondary btn-sm" style="font-size:14px">返回</a>
        </div>
        <div class="col-12">
            <form method="post" action="{{ route('posts.store')}}">
                @csrf
                <div class="form-group">
                    <label for="title" style="font-size:14px">標題</label>
                    <input type="text" class="form-control" name="title" id="title" value="">
                </div>
                <div class="form-group">
                    <label for="content" style="font-size:14px">內容</label>
                    <textarea name="content" id="content" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="files" style="font-size:14px">附件</label>
                    <input type="file" class="form-group" style="font-size:14px" name="files[]" id="files" multiple>
                </div>
                <button type="submit" class="btn btn-primary btn-sm" style="font-size:14px">儲存</button>
            </form>
        </div>
    </div>
</div>
@endauth  
@endsection
