@extends('layouts.master')
@section('title','查詢系統')
@section('content')
@auth
<div class="container">
    <div class="row">
        <div class="col-12">
            <br>
        <h6>查詢結果，請稍後...(資料量大)</h6>
        <p><a href={{ route('finance.fsearch2') }} class="btn btn-success btn-sm">返回</a> 
        <label style="font-size:14px">結算年月：{{ $fin_chk }}，累計起始年月：{{ $fin_date }}。</label></p>
        </div>
        <div class="col-12 table-cont">
            <div class="col-6 table-cont" style="float:left">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>淨額未稅金額合計</th>
                            <th>淨稅額合計</th>
                            <th>銷貨未稅金額合計</th>
                            <th>銷貨稅額合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($b4_checks as $b4_check)
                            <td>{{ (int)$b4_check->SUMCOST }}</td>
                            <td>{{ (int)$b4_check->SUMTAX }}</td>
                            @endforeach
                            @foreach($b4_shipchecks as $b4_shipcheck)
                            <td>{{ (int)$b4_shipcheck->SUMSHIP }}</td>
                            <td>{{ (int)$b4_shipcheck->SUMTAX }}</td>
                            @endforeach
                        </tr>  
                    </tbody>
                </table>
            </div>

            <div class="col-6 table-cont" style="float:left">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>銷退未稅金額合計</th>
                            <th>銷退稅額合計</th>
                            <th>折讓未稅金額合計</th>
                            <th>折讓稅額合計</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($b4_sumbacks as $b4_sumback)
                            <td>{{ (int)$b4_sumback->SUMBACK }}</td>
                            <td>{{ (int)$b4_sumback->SUMTAX }}</td>
                            @endforeach
                            @foreach ($b4_sumdiscs as $b4_sumdisc)
                            <td>{{ (int)$b4_sumdisc->SUMDISC }}</td>
                            <td>{{ (int)$b4_sumdisc->SUMTAX }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

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
                            <th>四大類</th>
                            <th>四大類累計未稅合計</th>
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
    </div>
</div>
@endauth
@endsection

