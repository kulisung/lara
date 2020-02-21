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
        <a href="{{ route('fin_af_export',$fin_chk) }}" style="text-decoration:none;"><input type="button" class="btn btn-info btn-sm" style="font-size:16px" value="匯出明細" onclick="return confirm('確認是否要匯出Excel?匯出資料量大，請耐心等候!!');"></a> 
        <label style="font-size:16px"><span style="color:blue;">結算年月：{{ $fin_chk }}，累計起始年月：{{ $fin_date }}。品號9090檢查共{{ $af90_records }}筆記錄。</span></label></p>
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
                            @foreach($af_checks as $af_check)
                            <td style="background-color:#EBEBFF;">{{ (int)$af_check->SUMCOST }}</td>
                            <td style="background-color:#EBEBFF;">{{ (int)$af_check->SUMTAX }}</td>
                            @endforeach
                            @foreach($af_shipchecks as $af_shipcheck)
                            <td>{{ (int)$af_shipcheck->SUMSHIP }}</td>
                            <td>{{ (int)$af_shipcheck->SUMTAX }}</td>
                            @endforeach
                            @foreach ($af_sumbacks as $af_sumback)
                            <td style="background-color:#EBEBFF;">{{ (int)$af_sumback->SUMBACK }}</td>
                            <td style="background-color:#EBEBFF;">{{ (int)$af_sumback->SUMTAX }}</td>
                            @endforeach
                            @foreach ($af_sumdiscs as $af_sumdisc)
                            <td>{{ (int)$af_sumdisc->SUMDISC }}</td>
                            <td>{{ (int)$af_sumdisc->SUMTAX }}</td>
                            @endforeach
                            @foreach ($af_customers as $af_customer)
                            <td style="background-color:#EBEBFF;">{{ (int)$af_customer->SUMCUS }}</td>
                            <td style="background-color:#EBEBFF;">{{ (int)$af_customer->SUMTAX }}</td>
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
                            <th><span style="color:blue;">四大類</span></th>
                            <th><span style="color:blue;">四大類累計未稅合計</span></th>
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

            <div class="col-6 table-cont" style="float:left">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th><span style="color:blue;">品牌</span></th>
                            <th><span style="color:blue;">品牌單月未稅合計</span></th>
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
                            <th><span style="color:blue;">品牌</span></th>
                            <th><span style="color:blue;">品牌累計未稅合計</span></th>
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

            <div class="col-12 table-cont">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <!-- <th><span style="color:blue;">單月銷退未稅合計</span></th> -->
                            <th><span style="color:blue;">單月折扣合計</span></th>
                            <th><span style="color:blue;">單月尾折合計</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- @foreach ($af_returns as $af_return)
                            <td>{{ (int)$af_return->COST }}</td> -->
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
                            <!-- <th><span style="color:blue;">累計銷退未稅合計</span></th> -->
                            <th><span style="color:blue;">累計折扣合計</span></th>
                            <th><span style="color:blue;">累計尾折合計</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- @foreach ($af_sumreturns as $af_sumreturn)
                            <td>{{ (int)$af_sumreturn->COST }}</td> -->
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
    </div>
</div>
@endauth
@endsection

