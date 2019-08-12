@extends('layouts.master')
@section('title','簡易公告系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h3>公告內容列表</h3>
        @auth
        <a href="{{ route('posts.create')}}" class="btn btn-success btn-sm">新增內容</a>
        @endauth
        </div>
        <br>
        <div class="col-12">
            <br>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>發表時間</th>
                        <th>標題</th>
                        <th>發表人</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->created_at }}</td>
                        <td><a href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a></td>
                        <td>{{ $post->user_id }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection
