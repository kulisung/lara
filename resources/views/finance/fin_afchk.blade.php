@extends('layouts.master')
@section('title','財務專用')
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
   max-height: 500px;
   background-color: #fff;
   overflow-x: scroll;
   overflow-y: scroll;
   overflow: hidden;
}
.tabs-panel {
   display: none;
   max-height: 500px;
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
        <h6>結帳後查詢結果，資料量大請稍後......</h6>
        <p><a href={{ route('finance.fsearch2') }} class="btn btn-success btn-sm">返回</a> 
        <label style="font-size:16px">結算年月：{{ $fin_chk }}，累計為該年度1月起計算。淨額資料筆數：{{ $data_records }}筆。</label><label style="font-size:16px">銷貨資料筆數：{{ $ship_records }}筆。</label>            
        </p>
        </div>
    <div id="js-tabs" style="width:100%">

        <div id="tabs-nav">
        <a href="#tab0" onclick="jsTabs(event,'tab0');return false" class="tabs-menu tabs-menu-active">淨額明細</a>
        <a href="#tab1" onclick="jsTabs(event,'tab1');return false" class="tabs-menu">銷貨明細</a>
        <a href="#tab2" onclick="jsTabs(event,'tab2');return false" class="tabs-menu">四大類\品牌單月未稅合計</a>
        <a href="#tab3" onclick="jsTabs(event,'tab3');return false" class="tabs-menu">四大類\品牌累計未稅合計</a>
        <a href="#tab4" onclick="jsTabs(event,'tab4');return false" class="tabs-menu">銷退\折讓\尾折未稅合計</a>
        <a href="#tab5" onclick="jsTabs(event,'tab5');return false" class="tabs-menu">銷退明細</a>
        <a href="#tab6" onclick="jsTabs(event,'tab6');return false" class="tabs-menu">折讓明細</a>
        <a href="#tab7" onclick="jsTabs(event,'tab7');return false" class="tabs-menu">客戶明細彙總</a>
        <a href="#tab8" onclick="jsTabs(event,'tab8');return false" class="tabs-menu">銷退折讓彙總</a>
        </div>

        <div class="tabs-container">
            <div id="tab0" class="tabs-panel" style="display:block">
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
                            <th>內外銷</th>
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
                        @foreach ($af_chks as $af_chk)
                        <tr>
                            <td>{{ $af_chk->TG004 }}</td>
                            <td>{{ $af_chk->TG007 }}</td>
                            <td>{{ $af_chk->TG003 }}</td>
                            <td>{{ $af_chk->TG005 }}</td>
                            <td>{{ $af_chk->MB008 }}</td>
                            <td>{{ $af_chk->MB006 }}</td>
                            <td>{{ $af_chk->MA038 }}</td>
                            <td>{{ $af_chk->TH005 }}</td>
                            <td>{{ (int)$af_chk->QTY }}</td>
                            <td>{{ (int)$af_chk->TG012 }}</td>
                            <td>{{ (int)$af_chk->TH037 }}</td>
                            <td>{{ (int)$af_chk->TH038 }}</td>
                            <td>{{ $af_chk->TH001 }}</td>
                            <td>{{ $af_chk->TH002 }}</td>
                            <td>{{ $af_chk->TH003 }}</td>
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
                        @foreach ($af_shipchks as $af_shipchk)
                        <tr>
                            <td>{{ $af_shipchk->TG004 }}</td>
                            <td>{{ $af_shipchk->TG007 }}</td>
                            <td>{{ $af_shipchk->TG003 }}</td>
                            <td>{{ $af_shipchk->TG005 }}</td>
                            <td>{{ $af_shipchk->MB008 }}</td>
                            <td>{{ $af_shipchk->MB006 }}</td>
                            <td>{{ $af_shipchk->MA038 }}</td>
                            <td>{{ $af_shipchk->MA019 }}</td>
                            <td>{{ $af_shipchk->TH005 }}</td>
                            <td>{{ (int)$af_shipchk->QTY }}</td>
                            <td>{{ (int)$af_shipchk->TG012 }}</td>
                            <td>{{ (int)$af_shipchk->TH037 }}</td>
                            <td>{{ (int)$af_shipchk->TH038 }}</td>
                            <td>{{ $af_shipchk->TH001 }}</td>
                            <td>{{ $af_shipchk->TH002 }}</td>
                            <td>{{ $af_shipchk->TH003 }}</td>
                        </tr>  
                        @endforeach
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
                        @foreach ($af_items as $af_item)
                        <tr>
                            <td>{{ $af_item->MB006 }}</td>
                            <td>{{ (int)$af_item->COST }}</td>
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
                        @foreach ($af_sumitems as $af_sumitem)
                        <tr>
                            <td>{{ $af_sumitem->MB006 }}</td>
                            <td>{{ (int)$af_sumitem->COST }}</td>
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
                        @foreach ($af_brands as $af_brand)
                        <tr>
                            <td>{{ $af_brand->MB008 }}</td>
                            <td>{{ (int)$af_brand->COST }}</td>
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
                        @foreach ($af_sumbrands as $af_sumbrand)
                        <tr>
                            <td>{{ $af_sumbrand->MB008 }}</td>
                            <td>{{ (int)$af_sumbrand->COST }}</td>
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
                        @foreach ($af_returns as $af_return)
                        <td>{{ (int)$af_return->COST }}</td>
                        @endforeach
                        @foreach ($af_allowances as $af_allowance)
                        <td>{{ (int)$af_allowance->ML008 }}</td>
                        @endforeach
                        @foreach ($af_discounts as $af_discount)
                        <td>{{ (int)$af_discount->TD015 }}</td>
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
                        @foreach ($af_sumreturns as $af_sumreturn)
                        <td>{{ (int)$af_sumreturn->COST }}</td>
                        @endforeach
                        @foreach ($af_sumallowances as $af_sumallowance)
                        <td>{{ (int)$af_sumallowance->ML008 }}</td>
                        @endforeach
                        @foreach ($af_sumdiscounts as $af_sumdiscount)
                        <td>{{ (int)$af_sumdiscount->TD015 }}</td>
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

                        @foreach ($af_shipbacks as $af_shipback)
                        <tr>
                            <td>{{ $af_shipback->TI004 }}</td>
                            <td>{{ $af_shipback->TI021 }}</td>
                            <td>{{ $af_shipback->TI003 }}</td>
                            <td>{{ $af_shipback->TG005 }}</td>
                            <td>{{ $af_shipback->MB008 }}</td>
                            <td>{{ $af_shipback->MB006 }}</td>
                            <td>{{ $af_shipback->MA038 }}</td>
                            <td>{{ $af_shipback->MA019 }}</td>
                            <td>{{ $af_shipback->TJ005 }}</td>
                            <td>{{ (int)$af_shipback->QTY }}</td>
                            <td>{{ (int)$af_shipback->TI009 }}</td>
                            <td>{{ (int)$af_shipback->TJ033 }}</td>
                            <td>{{ (int)$af_shipback->TJ034 }}</td>
                            <td>{{ $af_shipback->TJ001 }}</td>
                            <td>{{ $af_shipback->TJ002 }}</td>
                            <td>{{ $af_shipback->TJ003 }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>            

            <div id="tab6" class="tabs-panel" style="display:block">
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

                        @foreach ($af_shipdiscs as $af_shipdisc)
                        <tr>
                            <td>{{ $af_shipdisc->TI004 }}</td>
                            <td>{{ $af_shipdisc->TI021 }}</td>
                            <td>{{ $af_shipdisc->TI003 }}</td>
                            <td>{{ $af_shipdisc->TG005 }}</td>
                            <td>{{ $af_shipdisc->MB008 }}</td>
                            <td>{{ $af_shipdisc->MB006 }}</td>
                            <td>{{ $af_shipdisc->MA038 }}</td>
                            <td>{{ $af_shipdisc->MA019 }}</td>
                            <td>{{ $af_shipdisc->TJ005 }}</td>
                            <td>{{ (int)$af_shipdisc->QTY }}</td>
                            <td>{{ (int)$af_shipdisc->TI009 }}</td>
                            <td>{{ (int)$af_shipdisc->TJ033 }}</td>
                            <td>{{ (int)$af_shipdisc->TJ034 }}</td>
                            <td>{{ $af_shipdisc->TJ001 }}</td>
                            <td>{{ $af_shipdisc->TJ002 }}</td>
                            <td>{{ $af_shipdisc->TJ003 }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>

            <div id="tab7" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>客戶代碼</th>
                            <th>客戶全名</th>
                            <th>未稅總金額</th>
                            <th>稅額總額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($af_customers as $af_customer)
                        <tr>
                            <td>{{ $af_customer->TG004 }}</td>
                            <td>{{ $af_customer->TG007 }}</td>
                            <td>{{ (int)$af_customer->SUMCUS }}</td>
                            <td>{{ (int)$af_customer->SUMTAX }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>

            <div id="tab8" class="tabs-panel" style="display:block">
                <div class="col-12 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>客戶代碼</th>
                            <th>客戶全名</th>
                            <th>銷退未稅總金額</th>
                            <th>銷退稅額總額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($af_cusshipbacks as $af_cusshipback)
                        <tr>
                            <td>{{ $af_cusshipback->TI004 }}</td>
                            <td>{{ $af_cusshipback->TI021 }}</td>
                            <td>{{ (int)$af_cusshipback->TJ033 }}</td>
                            <td>{{ (int)$af_cusshipback->TJ034 }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="col-12 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>客戶代碼</th>
                            <th>客戶全名</th>
                            <th>單身銷退未稅總金額</th>
                            <th>單身銷退稅額總額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($af_cusbacks as $af_cusback)
                        <tr>
                            <td>{{ $af_cusback->TI004 }}</td>
                            <td>{{ $af_cusback->TI021 }}</td>
                            <td>{{ (int)$af_cusback->TJ033 }}</td>
                            <td>{{ (int)$af_cusback->TJ034 }}</td>
                        </tr>  
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="col-12 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>客戶代碼</th>
                            <th>客戶全名</th>
                            <th>單身折讓未稅總金額</th>
                            <th>單身折讓稅額總額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($af_cusdiscs as $af_cusdisc)
                        <tr>
                            <td>{{ $af_cusdisc->TI004 }}</td>
                            <td>{{ $af_cusdisc->TI021 }}</td>
                            <td>{{ (int)$af_cusdisc->TJ033 }}</td>
                            <td>{{ (int)$af_cusdisc->TJ034 }}</td>
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

