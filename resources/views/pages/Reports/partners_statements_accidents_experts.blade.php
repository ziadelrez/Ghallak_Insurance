<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>
        {{ trans('page-contract.contract.titles.partnersstatmentss') }}
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
            <th colspan="12">
                <!--place holder for the fixed-position header-->
                <div class="row" >
                    <div class="col-md-4 text-center" style="text-align: center;background-color: #005490;color:white">
                        <div  style="text-align: center;padding: 40px 0;">
                            <h4>{{ trans('page-contract.contract.titles.partnerlabel') }}</h4>
                            <h2> {{ $partnername[0]->pname }} </h2>
                            <h5> ( {{ $partnertype[0]->ptype }} ) </h5>
                            <h4> {{ trans('page-contract.contract.titles.billscount') }} : {{$count}} </h4>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div  style="text-align: center;padding: 40px 0;">
                            <h2> {{ trans('page-contract.contract.titles.partnersstatments') }} </h2>
                            <h2> {{ trans('page-contract.contract.titles.partnersstatments2') }} </h2>
                            <h3> ( {{ $billoption }} ) </h3>
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
                        <h6>{{ trans('page-contract.contract.titles.billstatus') }}</h6>
                    </th>
                    <th style="width:8%">
                        <h6>{{ trans('page-accidents.tables.acccode') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.acctype') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.accdate') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.accperson') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.accinsname') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.acccar') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.accexpert') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.accgarage') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.accapersonprintout') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.accgcost') }}</h6>
                    </th>
                    <th >
                        <h6>{{ trans('page-accidents.tables.acccurr') }}</h6>
                    </th>
        </tr>
        </thead>
        <tbody>
        @foreach($contractlist as $colist)
{{--            @foreach($accidentdet->relatedRecords as $relatedRecord)--}}
                <tr>
                    @if($billstatus == 'billgarage')
                        @if($colist -> billgarage == "1")
                            <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.billsclosedrpt') }}</p></td>
                        @else
                            <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.billsnotclosedrpt') }}</p></td>
                        @endif
                    @elseif($billstatus == 'billexpert')
                        @if($colist -> billexpert == "1")
                            <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.billsclosedrpt') }}</p></td>
                        @else
                            <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.billsnotclosedrpt') }}</p></td>
                        @endif
                    @elseif($billstatus == 'billhospital')
                        @if($colist -> billhospital == "1")
                            <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.billsclosedrpt') }}</p></td>
                        @else
                            <td ><p class="font-weight-bold">{{ trans('page-contract.contract.tables.billsnotclosedrpt') }}</p></td>
                        @endif
                    @endif
                    <td ><p class="font-weight-bold">{{$colist -> codestr}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> accidenttypename}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> accdate}}</p></td>
                    @if($colist -> cname == 'NONE')
                            <td ><p class="font-weight-bold">{{$colist -> clientcarname}}</p></td>
                    @else
                        <td ><p class="font-weight-bold">{{$colist -> cname}}</p></td>
                    @endif
                    <td ><p class="font-weight-bold">{{$colist -> ccode}} , {{$colist -> insname}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> carname}} , {{$colist -> carnumber}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> expertname}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> garagename}}</p></td>
                    <td ><p class="font-weight-bold">
                            @foreach(DB::table('getaccidentsaperson')->where('accidentid', $colist->id)->get() as $relatedRecord)
                            {{ $relatedRecord->apersonname }}
                            @endforeach
                        </p></td>
                    <td ><p class="font-weight-bold">{{$colist -> ecost}}</p></td>
                    <td ><p class="font-weight-bold">{{$colist -> ecurrname}}</p></td>
                </tr>
{{--            @endforeach--}}
        @endforeach
        </tbody>
    </table>

        <table width="100%">
            <tr>
                <th  style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd') }} : {{$rec2}} {{$rec3}}</th>
            </tr>
            <tr>
                <th style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp') }} : {{$rec22}} {{$rec33}}</th>
            </tr>
        </table>
</body>

</html>

