<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>
        {{ trans('page-contract.contract.titles.partnerspaymentss') }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href={{ URL::asset('adminassets/css/admin.rtl.css') }} rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href={{ URL::asset('adminassets/vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <style>
        .body-main {
            background: #ffffff;
            border-bottom: 15px solid #005490;
            border-top: 15px solid #005490;
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 40px 30px !important;
            position: relative;
            box-shadow: 0 1px 21px #808080;
            font-size: 10px
        }


       .main thead {
            background: #005490;
            color: #fff
        }

        .img {
            height: 100px
        }

        h1 {
            text-align: center
        }

        #rcorners1 {
            float: left;
            border-radius: 25px;
            border: 2px solid #005490;
            padding: 10px;
            width: 300px;
            height: 50px;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            page-break-after:auto;
            page-break-inside: avoid;
        }

        thead {display:table-header-group;}

        th {
            text-align: center;
            padding: 20px;
        }
        tr {
            text-align: center;
            vertical-align: center;
        }
        tr:nth-child(even) {
            background-color: #dddddd;
        }

        tfoot { display: table-row-group }

        body {
            /* Set "my-sec-counter" to 0 */
            counter-reset: my-sec-counter;
        }

        /*.page-header, .page-header-space {*/
        /*    height: 220px;*/
        /*}*/

        /*.page-footer, .page-footer-space {*/
        /*    height: 10px;*/

        /*}*/

        /*.page-footer {*/
        /*    !*counter-increment: page;*!*/
        /*    !*content:"Page " counter(page) ' of ' counter(pages);*!*/
        /*    text-align: center;*/
        /*    position: fixed;*/
        /*    bottom: 0;*/
        /*    width: 100%;*/
        /*    border-top: 1px solid black;*/
        /*}*/

        .page-number:before {
            content: "Page: " counter(page);}

        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            border-bottom: 1px solid black;
            background: #fefefe;
        }

        .page {
            page-break-after: always;
        }

        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group;}

            button {display: none;}

            body {margin: 0;}
        }
    </style>

</head>

<body>
<div class="page-header" style="text-align: center">

</div>

<div class="page-footer">

</div>

<table  style="width:100%">
        <thead>
        <tr>
            <th colspan="8">
                <!--place holder for the fixed-position header-->
                <div class="row" >
                    <div class="col-md-4 text-center" style="text-align: center;background-color: #005490;color:white">
                        <div  style="text-align: center;padding: 40px 0;">
                            <h4>{{ trans('page-contract.contract.titles.partnerlabel') }}</h4>
                            <h2> {{ $partnername[0]->pname }} </h2>
                            <h5> ( {{ $partnertype[0]->ptype }} ) </h5>
                            <h4> {{ trans('page-contract.contract.titles.paymentscount') }} : {{$count}} </h4>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div  style="text-align: center;padding: 40px 0;">
                            <h2> {{ trans('page-contract.contract.titles.partnerspayments') }} </h2>
                            <h2> {{ trans('page-contract.contract.titles.partnerspayments2') }} </h2>
                            <h5> {{ trans('page-contract.contract.titles.fromdate') }} : {{$from}} {{ trans('page-contract.contract.titles.todate') }} : {{$to}}</h5>
                        </div>
                    </div>
                    <div class="col-md-4 text-center" style="background-color: #005490;color:white">
                        <div  style="text-align: center;padding: 20px 0;">
                            <img class="img" src={{'/adminassets/img/logo.png'}} style="width:200px;height:200px;"/> </div>
                    </div>
                    <a class="btn btn-sm btn-secondary float-left mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">
                        <i class="fa fa-print"></i> {{ trans('page-contract.contract.titles.statementprint') }}</a>
                </div>
            </th>
        </tr>
        <tr style="background-color: #005490;color:#ffffff">
                    <th style="width:8%">
                        <h6>{{ trans('page-contract.contract.tables.paynum') }}</h6>
                    </th>
                    <th style="width:8%">
                        <h6>{{ trans('page-contract.contract.tables.paydate') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-contract.contract.tables.paytype') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-contract.contract.tables.bankname') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-contract.contract.tables.checknum') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-contract.contract.tables.checkdate') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-contract.contract.tables.payamount') }}</h6>
                    </th>
                    <th style="width:30%">
                        <h6>{{ trans('page-contract.contract.tables.paydetails') }}</h6>
                    </th>
        </tr>
        </thead>
        <tbody>
        @foreach($paymentlist as $colist)
            <tr>
                <td ><p class="font-weight-bold">{{$colist -> codestr}}</p></td>
                <td ><p class="font-weight-bold">{{$colist -> paydate}}</p></td>
                <td ><p class="font-weight-bold">{{$colist -> paytype}}</p></td>
                @if($colist -> bankname == 'NONE')
                    <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.nocar') }}</p></td>
                    <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.nocar') }}</p></td>
                    <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.nocar') }}</p></td>
                @else
                    <td ><p class="font-weight-bold">{{$colist -> bankname}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> paychecknum}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> checkdate}}</p></td>
                @endif
                <td ><p class="font-weight-bold">{{number_format($colist -> payamount)}} {{$colist -> paycurr}}</p></td>
                <td ><p class="font-weight-bold">{{$colist -> details}}</p></td>
            </tr>
        @endforeach
        </tbody>
    </table>

        <table width="100%">
            @if($fromwhere == '0')
                <tr>
                    <th  style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_contracts') }} : {{$ausd}} {{$cusd}}</th>
                    <th  style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_payments') }} : {{$rec2}} {{$rec3}}</th>
                    <th  style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_remain') }} : {{number_format($remainusd)}} {{$rec3}}</th>
                </tr>
                <tr>
                    <th style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_contracts') }} : {{$albp}} {{$clbp}}</th>
                    <th style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_payments') }} : {{$rec22}} {{$rec33}}</th>
                    <th style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_remain') }} : {{number_format($remainlbp)}} {{$rec33}}</th>
                </tr>
            @else
                <tr>
                    <th  style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_contracts') }} : {{$totalbrokerusd}} {{$cusd}}</th>
                    <th  style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_payments') }} : {{$rec2}} {{$rec3}}</th>
                    <th  style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_remain') }} : {{number_format($remainusd)}} {{$rec3}}</th>
                </tr>
                <tr>
                    <th style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_contracts') }} : {{$totalbrokerlbp}} {{$clbp}}</th>
                    <th style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_payments') }} : {{$rec22}} {{$rec33}}</th>
                    <th style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_remain') }} : {{number_format($remainlbp)}} {{$rec33}}</th>
                </tr>
            @endif
        </table>

</body>

</html>

