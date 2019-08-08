@extends('layouts.master')
@section('title','Import and Export !')
@section('content')
@auth
     <div class="container">
         <div class="card-text-center">
             <div class="card-header">
                <h8>使用者帳號匯出</h8>
             </div>
             <div class="card-body">
                 <ul class="nav nav-tabs card-header-tabs">
                     <li class="nav-item">
                         <a href="{{ route('userexport') }}" class="nav-link">Download Users file</a>
                     </li>

                 </ul>
             </div>
         </div>
         <div class="card">
             <div class="card-header">
                <h8>使用者帳號匯入</h8>
             </div>
             <div class="card-body">
                <form style="border: 1pt solid #a1cbef;margin: 10px;padding: 10px;" action="{{ route('userimport') }}" class="form" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ( Session::has('success'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif

                    @if ( Session::has('fail'))
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                            <p>{{ Session::get('fail') }}</p>
                        </div>
                    @endif

                    <input type="file" name="import_file" />
                    <button class="btn btn-primary">Import CSV</button>
                </form>
             </div>
         </div>
     </div>
@endauth
@endsection