@extends('layouts.master')
@section('title','TS6會員詳細資訊')
@section('head')
<style>
#tabs-nav{
   margin: 0;
   padding: 0;
   position: relative;
   text-align: left
}
a.tabs-menu {
   display: inline-block;
   background-color: #1b91ab;
   font-size: 14px;
   font-family: Arial,Helvetica,sans-serif;
   color: #fff;
   padding: 5px 10px;
   text-shadow: 1px 1px 0px #1b91ab;
   font-weight: bold;
   text-decoration: none;
   border: solid 1px #1b91ab;
   border-bottom: 0;
   border-radius: 3px 3px 0 0;
}
a.tabs-menu.tabs-menu-active {
   background-color: #fff;
   text-shadow: 1px 1px 0px #ffffff;
   border: solid 1px #1b91ab;
   color: #6b6b6b;
   border-bottom: 0;
}
.tabs-container {
   border: solid 1px #1b91ab;
   margin-top: -1px;
   max-height: 480px;
   background-color: #fff;
   overflow-x: scroll;
   overflow-y: scroll;
   overflow: hidden;
}
.tabs-panel {
   display: none;
   max-height: 480px;
   min-height: 100px;
   overflow: auto;
   padding: 10px;
}
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
        <span style="color:blue;"><h6>TS6會員資訊查詢結果</h6></span>
        <p><a href={{ route('sales.ts6index') }} class="btn btn-success btn-sm">返回</a> 
        <label style="font-size:16px">下單累計次數共：##次。</label>        
        </p>
        </div>
    <div id="js-tabs" style="width:100%">

        <div id="tabs-nav">
        <a href="#tab0" onclick="jsTabs(event,'tab0');return false" class="tabs-menu tabs-menu-active">TS6會員詳細資料</a>
        <a href="#tab1" onclick="jsTabs(event,'tab1');return false" class="tabs-menu">下單紀錄</a>
        </div>

        <div class="tabs-container">
            <div id="tab0" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>會員編號</th>
                            <th>會員姓名</th>
                            <th>Email</th>
                            <th>手機</th>
                            <th>生日</th>
                            <th>性別</th>
                            <th>電話</th>
                            <th>地址</th>
                            <th>註冊時間</th>
                            <th>註冊來源</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ts6details as $ts6detail)
                        <tr>
                            <td>{{ $ts6detail->member_id }}</td>
                            <td>{{ $ts6detail->name }}</td>
                            <td>{{ $ts6detail->email }}</td>
                            <td>{{ $ts6detail->cellphone }}</td>
                            <td>{{ $ts6detail->birthday }}</td>
                            <td>{{ $ts6detail->sex }}</td>
                            <td>{{ $ts6detail->tel }}</td>
                            <td>{{ $ts6detail->address }}</td>
                            <td>{{ $ts6detail->register_date }}</td>
                            <td>{{ $ts6detail->register_source }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>

            <div id="tab1" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>訂單日期</th>
                            <th>訂單編號</th>
                            <th>訂購人</th>
                            <th>Email</th>
                            <th>商品名稱</th>
                            <th>商品編號</th>
                            <th>數量</th>
                            <th>總額</th>
                    </thead>
                    <tbody>
                        @foreach ($mem_orders as $mem_order)
                        <tr>
                            <td>{{ $mem_order->order_time }}</td>
                            <td>{{ $mem_order->order_id }}</td>
                            <td>{{ $mem_order->name }}</td>
                            <td>{{ $mem_order->email }}</td>
                            <td>{{ $mem_order->item_name }}</td>
                            <td>{{ $mem_order->item_id }}</td>
                            <td>{{ $mem_order->quantity }}</td>
                            <td>{{ $mem_order->total_amount }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    </div>
</div>

<script>
 function jsTabs(evt, tabId) {
    var tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabs-panel");
    for (var i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
     }
     tablinks = document.getElementsByClassName("tabs-menu");
     for (var i = 0; i < tablinks.length; i++) {
       tablinks[i].className = tablinks[i].className.replace(" tabs-menu-active", "");
     }
     var tab = document.getElementById(tabId);
         tab.style.display = "block";
     evt.currentTarget.className += " tabs-menu-active";
     return false;
 }
</script>

@endsection

