@extends('layouts.master')
@section('title','查詢系統')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
            <h5>查詢結果</h5>
        <p><a href={{ route('searchs.search4') }} class="btn btn-success btn-sm">返回</a></p>
        </div>
        <div class="col-12 table-cont" id="table-cont">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>客戶代碼</th>
                        <th>客戶全名</th>
                        <th>銷貨日期</th>
                        <th>部門</th>
                        <th>品牌</th>
                        <th>四大類</th>
                        <th>內外銷</th>
                        <th>國家別</th>
                        <th>品名</th>
                        <th>數量</th>
                        <th>匯率\單位</th>
                        <th>未稅金額</th>
                        <th>稅額</th>
                        <th>單別</th>
                        <th>單號</th>
                        <th>序號</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sa_arrays as $sa_array)
                    <tr>
                        <td>{{ $sa_array->TG004 }}</td>
                        <td>{{ $sa_array->TG007 }}</td>
                        <td>{{ $sa_array->TG003 }}</td>
                        <td>{{ $sa_array->TG005 }}</td>
                        <td>{{ $sa_array->MB008 }}</td>
                        <td>{{ $sa_array->MB006 }}</td>
                        <td>{{ $sa_array->MA038 }}</td>
                        <td>{{ $sa_array->MA019 }}</td>
                        <td>{{ $sa_array->TH005 }}</td>
                        <td>{{ $sa_array->QTY }}</td>
                        <td>{{ $sa_array->TG012 }}</td>
                        <td>{{ $sa_array->TH037 }}</td>
                        <td>{{ $sa_array->TH038 }}</td>
                        <td>{{ $sa_array->TH001 }}</td>
                        <td>{{ $sa_array->TH002 }}</td>
                        <td>{{ $sa_array->TH003 }}</td>
                    </tr>  
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>  
@endsection

