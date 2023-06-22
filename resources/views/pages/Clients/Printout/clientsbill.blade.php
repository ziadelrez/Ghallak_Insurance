<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>
        {{ trans('page-contract.contract.titles.clientinvoice') }}
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
            width: 450px;
            height: 50px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="page-header" style="text-align: center">
        <h2> {{ trans('page-contract.contract.titles.clientinvoicetitle') }} </h2>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-3 body-main">
                <div class="col-md-12" >
                    <div class="row" style="border-style: solid;">
                        <div class="col-md-4 text-right">
                            {!! DNS2D::getBarcodeHTML("$InvCode", 'QRCODE',5,5,'#005490',true) !!}
                            <h2>{{ trans('page-contract.contract.titles.clientinvoicenum') }}</h2>
                            <h5>{{$contratinfo[0]->codestr}}</h5>

                        </div>
                        <div class="col-md-4 text-center">
                            <h4 style="color: #F81D2D;"><strong>{{ trans('page-contract.contract.titles.mr') }} {{$clientslist[0]->cname}}</strong></h4>
                            <h6>{{$clientslist[0]->cadr}}</h6>
                            <h6>{{$clientslist[0]->cmob}}</h6>
                            <h6>{{$clientslist[0]->email}}</h6>
                        </div>
                        <div class="col-md-4 text-left"> <img class="img" src={{'/adminassets/img/logo.jpg'}} style="width:150px;height:150px;"/> </div>
                        <a class="btn btn-sm btn-secondary float-left mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">
                            <i class="fa fa-print"></i> {{ trans('page-contract.contract.titles.invoiceprint') }}</a>
                    </div>
{{--                    <div class="row">--}}
{{--                        <div class="col-md-12 text-center">--}}
{{--                            <h2>{{ trans('page-contract.contract.titles.clientinvoicenum') }}</h2>--}}
{{--                            <h5>{{$contratinfo[0]->codestr}}</h5>--}}
{{--                        </div>--}}
{{--                    </div> <br />  table-striped--}}
{{--                    <hr>--}}
                    <br>
                    <div class="row" style="border-style: solid;">
                        <div class="col-md-12 text-center">
                            <table class="table  table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        <h6>{{ trans('page-contract.contract.tables.itemcode') }}</h6>
                                    </th>
                                    <th>
                                        <h6>{{ trans('page-contract.contract.tables.itemdesc') }}</h6>
                                    </th>
                                    <th>
                                        <h6>{{ trans('page-contract.contract.tables.carnameins') }}</h6>
                                    </th>
                                    <th>
                                        <h6>{{ trans('page-contract.contract.tables.itemcost') }}</h6>
                                    </th>
                                    <th>
                                        <h6>{{ trans('page-contract.contract.tables.itemcurr') }}</h6>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($contractlist as $colist)
                                    <tr>
                                        <td class="col-md-4"><p class="lead font-weight-bold">{{$colist -> ccode}}</p></td>
                                        <td class="col-md-4"><p class="lead font-weight-bold">{{$colist -> insname}}</p></td>
                                        @if($colist -> carname == 'NONE')
                                            <td class="col-md-4"><p class="lead font-weight-bold">{{ trans('page-contract.contract.tables.nocar') }}</p></td>
                                            @else
                                            <td class="col-md-4"><p class="lead font-weight-bold">{{$colist -> carname}} , {{$colist -> platnumber}}</p></td>
                                        @endif
                                        <td class="col-md-2"><p class="lead font-weight-bold">{{number_format($colist -> totalcost)}}</p></td>
                                        <td class="col-md-2"><p class="lead font-weight-bold">{{$colist -> currname}}</p></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 text-center" >
                            <h5 id="rcorners1" style="color: #161616;"><strong>{{ trans('page-contract.contract.tables.itemtotalusd') }} : {{number_format($contratinfo[0]->coamount)}}  {{$contratinfo[0]->cocurr}}</strong></h5>
                        </div>
                        <div class="col-md-6 text-left d-inline-block" style="border-bottom: 1px dotted">
                            <h5> {{$tafqeetInArabic}}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <h5 id="rcorners1" style="color: #161616;"><strong>{{ trans('page-contract.contract.tables.itemtotallbp') }} : {{number_format($contratinfo[0]->coamountlbp)}}  {{$contratinfo[0]->cocurrlbp}}</strong></h5>
                        </div>
                        <div class="col-md-6 text-left d-inline-block" style="border-bottom: 1px dotted">
                            <h5> {{$tafqeetInArabicLB}}</h5>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12 text-right">
                            <div class="row">
                                <h6><b>{{ trans('page-contract.contract.tables.datebellow') }} : </b> <span class="d-inline-block" style="border-bottom: 1px dotted"> {{$currdate}}</span></h6> <br />
                            </div>
                            <div class="row">
                                <h6><b>{{ trans('page-contract.contract.tables.signature') }}:</b></h6>
                            </div>
                    </div>
                    <br>
            </div>
        </div>
    </div>
</div>

<div class="page-footer">

</div>


<script src={{ URL::asset('adminassets/vendor/jquery/jquery.min.js') }}></script>
<script src={{ URL::asset('adminassets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}></script>
<script src={{ URL::asset('adminassets/vendor/chart.js/Chart.min.js') }}></script>
<script src={{ URL::asset('adminassets/vendor/jquery-easing/jquery.easing.min.js') }}></script>
<script src={{ URL::asset('adminassets/js/sb-admin-2.min.js') }}></script>
<script src={{ URL::asset('adminassets/js/custom/checkbox-toggle.js') }}></script>
<script src={{ URL::asset('adminassets/js/custom/lbl-tables.js') }}></script>
<script src={{ URL::asset('adminassets/js/custom/validation_elements.js') }}></script>
<script src={{ URL::asset('adminassets/js/demo/chart-area-demo.js') }}></script>
<script src={{ URL::asset('adminassets/js/demo/chart-pie-demo.js') }}></script>
<script src="{{ URL::asset('adminassets/vendor/bootbox/bootbox.min.js') }}" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
{{--<script src={{ asset('adminassets/js/custom/printpayments.js') }}></script>--}}
</body>

</html>

