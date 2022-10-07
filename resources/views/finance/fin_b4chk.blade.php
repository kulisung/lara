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
        <h6>查詢結果，請稍後...(資料量大)</h6>
        <a href={{ route('finance.fsearch2') }} class="btn btn-success btn-sm">返回</a>
        <a href="{{ route('fin_b4_export',$fin_chk) }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出明細" onclick="return confirm('確認是否要匯出Excel?匯出資料量大，請耐心等候!!');"></a>  
        <label style="font-size:16px">結算年月：{{ $fin_chk }}，累計為該年度1月起計算。淨額資料筆數：{{ $data_records }}筆。</label>
        <label style="font-size:16px">銷貨資料筆數：{{ $ship_records }}筆。</label>            
        </p>
        </div>
    <div id="js-tabs" style="width:100%">

        <div id="tabs-nav">
        <a href="#tab0" onclick="jsTabs(event,'tab0');return false" class="tabs-menu tabs-menu-active">淨額明細</a>
        <a href="#tab1" onclick="jsTabs(event,'tab1');return false" class="tabs-menu">銷貨明細</a>
        <a href="#tab2" onclick="jsTabs(event,'tab2');return false" class="tabs-menu">大分類\品牌單月未稅合計</a>
        <a href="#tab3" onclick="jsTabs(event,'tab3');return false" class="tabs-menu">大分類\品牌累計未稅合計</a>
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
                            <th>大分類</th>
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
                        @foreach ($b4_chks as $b4_chk)
                        <tr>
                            <td>{{ $b4_chk->TG004 }}</td>
                            <td>{{ $b4_chk->TG007 }}</td>
                            <td>{{ $b4_chk->TG003 }}</td>
                            <td>{{ $b4_chk->TG005 }}</td>
                            <td>{{ $b4_chk->MB008 }}</td>
                            <td>{{ $b4_chk->MB006 }}</td>
                            <td>{{ $b4_chk->MA038 }}</td>
                            <td>{{ $b4_chk->MA019 }}</td>
                            <td>{{ $b4_chk->TH005 }}</td>
                            <td>{{ (int)$b4_chk->QTY }}</td>
                            <td>{{ (int)$b4_chk->TG012 }}</td>
                            <td>{{ (int)$b4_chk->TH037 }}</td>
                            <td>{{ (int)$b4_chk->TH038 }}</td>
                            <td>{{ $b4_chk->TH001 }}</td>
                            <td>{{ $b4_chk->TH002 }}</td>
                            <td>{{ $b4_chk->TH003 }}</td>
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
                            <th>大分類</th>
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
                        @foreach ($b4_shipchks as $b4_shipchk)
                        <tr>
                            <td>{{ $b4_shipchk->TG004 }}</td>
                            <td>{{ $b4_shipchk->TG007 }}</td>
                            <td>{{ $b4_shipchk->TG003 }}</td>
                            <td>{{ $b4_shipchk->TG005 }}</td>
                            <td>{{ $b4_shipchk->MB008 }}</td>
                            <td>{{ $b4_shipchk->MB006 }}</td>
                            <td>{{ $b4_shipchk->MA038 }}</td>
                            <td>{{ $b4_shipchk->MA019 }}</td>
                            <td>{{ $b4_shipchk->TH005 }}</td>
                            <td>{{ (int)$b4_shipchk->QTY }}</td>
                            <td>{{ (int)$b4_shipchk->TG012 }}</td>
                            <td>{{ (int)$b4_shipchk->TH037 }}</td>
                            <td>{{ (int)$b4_shipchk->TH038 }}</td>
                            <td>{{ $b4_shipchk->TH001 }}</td>
                            <td>{{ $b4_shipchk->TH002 }}</td>
                            <td>{{ $b4_shipchk->TH003 }}</td>
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
                            <th>大分類</th>
                            <th>大分類單月未稅合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($b4_items as $b4_item)
                        <tr>
                            <td>{{ $b4_item->MB006 }}</td>
                            <td>{{ (int)$b4_item->COST }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>

                <div class="col-6 table-cont" style="float:left">
                    <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>大分類</th>
                            <th>大分類累計未稅合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($b4_sumitems as $b4_sumitem)
                        <tr>
                            <td>{{ $b4_sumitem->MB006 }}</td>
                            <td>{{ (int)$b4_sumitem->COST }}</td>
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
                            <td>{{ (int)$b4_brand->COST }}</td>
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
                            <td>{{ (int)$b4_sumbrand->COST }}</td>
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
                        <td>{{ (int)$b4_return->COST }}</td>
                        @endforeach
                        @foreach ($b4_allowances as $b4_allowance)
                        <td>{{ (int)$b4_allowance->ML008 }}</td>
                        @endforeach
                        @foreach ($b4_discounts as $b4_discount)
                        <td>{{ (int)$b4_discount->TD015 }}</td>
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
                        <td>{{ (int)$b4_sumreturn->COST }}</td>
                        @endforeach
                        @foreach ($b4_sumallowances as $b4_sumallowance)
                        <td>{{ (int)$b4_sumallowance->ML008 }}</td>
                        @endforeach
                        @foreach ($b4_sumdiscounts as $b4_sumdiscount)
                        <td>{{ (int)$b4_sumdiscount->TD015 }}</td>
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
                            <th>大分類</th>
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

                        @foreach ($b4_shipbacks as $b4_shipback)
                        <tr>
                            <td>{{ $b4_shipback->TI004 }}</td>
                            <td>{{ $b4_shipback->TI021 }}</td>
                            <td>{{ $b4_shipback->TI003 }}</td>
                            <td>{{ $b4_shipback->TG005 }}</td>
                            <td>{{ $b4_shipback->MB008 }}</td>
                            <td>{{ $b4_shipback->MB006 }}</td>
                            <td>{{ $b4_shipback->MA038 }}</td>
                            <td>{{ $b4_shipback->MA019 }}</td>
                            <td>{{ $b4_shipback->TJ005 }}</td>
                            <td>{{ (int)$b4_shipback->QTY }}</td>
                            <td>{{ (int)$b4_shipback->TI009 }}</td>
                            <td>{{ (int)$b4_shipback->TJ033 }}</td>
                            <td>{{ (int)$b4_shipback->TJ034 }}</td>
                            <td>{{ $b4_shipback->TJ001 }}</td>
                            <td>{{ $b4_shipback->TJ002 }}</td>
                            <td>{{ $b4_shipback->TJ003 }}</td>
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
                            <th>大分類</th>
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

                        @foreach ($b4_shipdiscs as $b4_shipdisc)
                        <tr>
                            <td>{{ $b4_shipdisc->TI004 }}</td>
                            <td>{{ $b4_shipdisc->TI021 }}</td>
                            <td>{{ $b4_shipdisc->TI003 }}</td>
                            <td>{{ $b4_shipdisc->TG005 }}</td>
                            <td>{{ $b4_shipdisc->MB008 }}</td>
                            <td>{{ $b4_shipdisc->MB006 }}</td>
                            <td>{{ $b4_shipdisc->MA038 }}</td>
                            <td>{{ $b4_shipdisc->MA019 }}</td>
                            <td>{{ $b4_shipdisc->TJ005 }}</td>
                            <td>{{ (int)$b4_shipdisc->QTY }}</td>
                            <td>{{ (int)$b4_shipdisc->TI009 }}</td>
                            <td>{{ (int)$b4_shipdisc->TJ033 }}</td>
                            <td>{{ (int)$b4_shipdisc->TJ034 }}</td>
                            <td>{{ $b4_shipdisc->TJ001 }}</td>
                            <td>{{ $b4_shipdisc->TJ002 }}</td>
                            <td>{{ $b4_shipdisc->TJ003 }}</td>
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
                        @foreach ($b4_customers as $b4_customer)
                        <tr>
                            <td>{{ $b4_customer->TG004 }}</td>
                            <td>{{ $b4_customer->TG007 }}</td>
                            <td>{{ (int)$b4_customer->SUMCUS }}</td>
                            <td>{{ (int)$b4_customer->SUMTAX }}</td>
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
                        @foreach ($b4_cusshipbacks as $b4_cusshipback)
                        <tr>
                            <td>{{ $b4_cusshipback->TI004 }}</td>
                            <td>{{ $b4_cusshipback->TI021 }}</td>
                            <td>{{ (int)$b4_cusshipback->TJ033 }}</td>
                            <td>{{ (int)$b4_cusshipback->TJ034 }}</td>
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
                        @foreach ($b4_cusbacks as $b4_cusback)
                        <tr>
                            <td>{{ $b4_cusback->TI004 }}</td>
                            <td>{{ $b4_cusback->TI021 }}</td>
                            <td>{{ (int)$b4_cusback->TJ033 }}</td>
                            <td>{{ (int)$b4_cusback->TJ034 }}</td>
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
                        @foreach ($b4_cusdiscs as $b4_cusdisc)
                        <tr>
                            <td>{{ $b4_cusdisc->TI004 }}</td>
                            <td>{{ $b4_cusdisc->TI021 }}</td>
                            <td>{{ (int)$b4_cusdisc->TJ033 }}</td>
                            <td>{{ (int)$b4_cusdisc->TJ034 }}</td>
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

