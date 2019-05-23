@extends('layouts.master')
@section('title','檔案上傳處理')
@section('content')
<div class="container">
    <div class="row">
        <form method="post" role="form" action="file_handle.php" enctype="multipart/form-data">
            <div class="form-group">
            <label for="inputfile">檔案輸入</label>
            <input type="file" name="excel_path" accept=".csv">
            <p class="help-block">這裡是塊級幫助文字的例項。</p>
            </div>
            <button type="submit" class="btn btn-default bg-primary">提交</button>
        </form>
    </div>
</div>  
@endsection

