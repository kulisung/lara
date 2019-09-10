@extends('layouts.master')
@section('title','查詢系統')
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
   max-height: 520px;
   background-color: #fff;
   overflow-x: scroll;
   overflow-y: scroll;
   overflow: hidden;
}
.tabs-panel {
   display: none;
   max-height: 520px;
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
        <h5>查詢結果，請稍後...(資料量大)</h5>
        <p><a href={{ route('finance.fsearch2') }} class="btn btn-success btn-sm">返回</a> 
        <label style='font-size:14px'>結算年月：{{ $fin_chk }}，累計為該年度1月起計算。</label>         
        </p>
        </div>
    <div id="js-tabs" style="width:100%">

        <div id="tabs-nav">
        <a href="#tab0" onclick="jsTabs(event,'tab0');return false" class="tabs-menu tabs-menu-active">淨額/銷貨未稅總額</a>
        <a href="#tab1" onclick="jsTabs(event,'tab1');return false" class="tabs-menu">銷退彙總</a>
        <a href="#tab2" onclick="jsTabs(event,'tab2');return false" class="tabs-menu">四大類\品牌單月未稅合計</a>
        <a href="#tab2" onclick="jsTabs(event,'tab3');return false" class="tabs-menu">四大類\品牌累計未稅合計</a>
        <a href="#tab2" onclick="jsTabs(event,'tab4');return false" class="tabs-menu">銷退\折讓\尾折未稅合計</a>
        <a href="#tab2" onclick="jsTabs(event,'tab5');return false" class="tabs-menu">Tab</a>
        </div>

        <div class="tabs-container">
            <div id="tab0" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>淨額未稅金額合計</th>
                            <th>銷貨未稅金額合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($b4_checks as $b4_check)
                            <td>{{ $b4_check->SUMCOST }}</td>
                            @endforeach
                            @foreach($b4_shipchecks as $b4_shipcheck)
                            <td>{{ $b4_shipcheck->SUMSHIP }}</td>
                            @endforeach
                        </tr>  
                    </tbody>
                    </table>
                </div>
            </div>

            <div id="tab1" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>銷退未稅金額合計</th>
                            <th>折讓未稅金額合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($b4_sumbacks as $b4_sumback)
                            <td>{{ $b4_sumback->SUMBACK }}</td>
                            @endforeach
                            @foreach ($b4_sumdiscs as $b4_sumdisc)
                            <td>{{ $b4_sumdisc->SUMDISC }}</td>
                            @endforeach
                        </tr>  
                    </tbody>
                    </table>
                </div>
            </div>            

            <div id="tab2" class="tabs-panel" style="display:block">
                <div class="col-6 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>四大類</th>
                            <th>四大類單月未稅合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($b4_items as $b4_item)
                        <tr>
                            <td>{{ $b4_item->MB006 }}</td>
                            <td>{{ $b4_item->COST }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="col-6 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>四大類</th>
                            <th>四大類累計未稅合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($b4_sumitems as $b4_sumitem)
                        <tr>
                            <td>{{ $b4_sumitem->MB006 }}</td>
                            <td>{{ $b4_sumitem->COST }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>

            </div>

            <div id="tab3" class="tabs-panel" style="display:block">
                <div class="col-6 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>品牌</th>
                            <th>品牌單月未稅合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($b4_brands as $b4_brand)
                        <tr>
                            <td>{{ $b4_brand->MB008 }}</td>
                            <td>{{ $b4_brand->COST }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="col-6 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>品牌</th>
                            <th>品牌累計未稅合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($b4_sumbrands as $b4_sumbrand)
                        <tr>
                            <td>{{ $b4_sumbrand->MB008 }}</td>
                            <td>{{ $b4_sumbrand->COST }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>

            </div>

            <div id="tab4" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont">
                <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>單月銷退未稅合計</th>
                        <th>單月折讓未稅合計</th>
                        <th>單月尾折未稅合計</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        @foreach ($b4_returns as $b4_return)
                        <td>{{ $b4_return->COST }}</td>
                        @endforeach
                        @foreach ($b4_allowances as $b4_allowance)
                        <td>{{ $b4_allowance->ML008 }}</td>
                        @endforeach
                        @foreach ($b4_discounts as $b4_discount)
                        <td>{{ $b4_discount->TD015 }}</td>
                        @endforeach
                    </tr>  

                </tbody>
                <thead>
                    <tr>
                        <th>累計銷退未稅合計</th>
                        <th>累計折讓未稅合計</th>
                        <th>累計尾折未稅合計</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        @foreach ($b4_sumreturns as $b4_sumreturn)
                        <td>{{ $b4_sumreturn->COST }}</td>
                        @endforeach
                        @foreach ($b4_sumallowances as $b4_sumallowance)
                        <td>{{ $b4_sumallowance->ML008 }}</td>
                        @endforeach
                        @foreach ($b4_sumdiscounts as $b4_sumdiscount)
                        <td>{{ $b4_sumdiscount->TD015 }}</td>
                        @endforeach
                    </tr>  

                </tbody>
                </table>
                </div>
            </div>

            <div id="tab5" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>客戶代碼</th>
                            <th>客戶全名</th>
                            <th>銷貨日期</th>
                            <th>部門</th>
                            <th>品牌</th>
                            <th>四大類</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td></td>

                        </tr>  

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

