@extends('layouts.master')
@section('title','公告系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
        <br>
        </div>
        <div>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm" style="font-size:14px">返回</a>
        @auth
        <a href="{{ route('posts.edit',$post->id) }}" class="btn btn-primary btn-sm" style="font-size:14px">編輯</a>
        <a href="#" class="btn btn-danger btn-sm"  style="font-size:14px" onclick="document.getElementById('delete').submit()">刪除</a>
        @endauth
        <form method="post" action="{{ route('posts.destroy',$post->id) }}" id='delete'>
            @csrf
            {{ method_field('DELETE') }}
        </form>
        </div>
        <div class="col-12"><br>
            <div class="card">
                <div class="card-header">
                    <h3>{{ $post->title }}</h3>
                </div>
                <div class="card-body">
                    {{ $post->content }}
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection
