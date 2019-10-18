@extends('layouts.master')
@section('title','財務專用')
@section('content')
@auth
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
        <h6>結帳後查詢結果，資料量大請稍後......</h6>
        <p><a href={{ route('finance.fsearch2') }} class="btn btn-success btn-sm" style="font-size:16px">返回</a> 
        <label style="font-size:16px"><span style="color:blue;">結算年月：{{ $fin_chk }}，累計起始年月：{{ $fin_date }}。</span></label></p>
        </div>
        <div class="col-12 table-cont">
            <div class="col-12 table-cont" style="float:left">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th style="background-color:#CCCCFF;">淨額未稅合計</th>
                            <th style="background-color:#CCCCFF;">淨額稅額合計</th>
                            <th><span style="color:blue;">銷貨未稅合計</span></th>
                            <th><span style="color:blue;">銷貨稅額合計</span></th>
                            <th style="background-color:#CCCCFF;">銷退未稅合計</th>
                            <th style="background-color:#CCCCFF;">銷退稅額合計</th>
                            <th><span style="color:blue;">折讓未稅合計</span></th>
                            <th><span style="color:blue;">折讓稅額合計</span></th>
                            <th style="background-color:#CCCCFF;">客戶未稅合計</th>
                            <th style="background-color:#CCCCFF;">客戶稅額合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($b4_checks as $b4_check)
                            <td style="background-color:#EBEBFF;">{{ (int)$b4_check->SUMCOST }}</td>
                            <td style="background-color:#EBEBFF;">{{ (int)$b4_check->SUMTAX }}</td>
                            @endforeach
                            @foreach($b4_shipchecks as $b4_shipcheck)
                            <td>{{ (int)$b4_shipcheck->SUMSHIP }}</td>
                            <td>{{ (int)$b4_shipcheck->SUMTAX }}</td>
                            @endforeach
                            @foreach ($b4_sumbacks as $b4_sumback)
                            <td style="background-color:#EBEBFF;">{{ (int)$b4_sumback->SUMBACK }}</td>
                            <td style="background-color:#EBEBFF;">{{ (int)$b4_sumback->SUMTAX }}</td>
                            @endforeach
                            @foreach ($b4_sumdiscs as $b4_sumdisc)
                            <td>{{ (int)$b4_sumdisc->SUMDISC }}</td>
                            <td>{{ (int)$b4_sumdisc->SUMTAX }}</td>
                            @endforeach
                            @foreach ($b4_customers as $b4_customer)
                            <td style="background-color:#EBEBFF;">{{ (int)$b4_customer->SUMCUS }}</td>
                            <td style="background-color:#EBEBFF;">{{ (int)$b4_customer->SUMTAX }}</td>
                            @endforeach
                        </tr>  
                    </tbody>
                </table>
            </div>


            <div class="col-6 table-cont" style="float:left">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><span style="color:blue;">四大類</span></th>
                            <th><span style="color:blue;">四大類單月未稅合計</span></th>
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
                            <th><span style="color:blue;">四大類</span></th>
                            <th><span style="color:blue;">四大類累計未稅合計</span></th>
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

            <div class="col-6 table-cont" style="float:left">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><span style="color:blue;">品牌</span></th>
                            <th><span style="color:blue;">品牌單月未稅合計</span></th>
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
                            <th><span style="color:blue;">品牌</span></th>
                            <th><span style="color:blue;">品牌累計未稅合計</span></th>
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

            <div class="col-12 table-cont">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><span style="color:blue;">單月銷退未稅合計</span></th>
                            <th><span style="color:blue;">單月折讓未稅合計</span></th>
                            <th><span style="color:blue;">單月尾折未稅合計</span></th>
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
                            <th><span style="color:blue;">累計銷退未稅合計</span></th>
                            <th><span style="color:blue;">累計折讓未稅合計</span></th>
                            <th><span style="color:blue;">累計尾折未稅合計</span></th>
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
    </div>
</div>
@endauth
@endsection

