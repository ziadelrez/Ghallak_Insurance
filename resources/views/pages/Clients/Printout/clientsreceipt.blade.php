<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>
        {{ trans('page-contract.contract.receipt.clientreceipttitle') }}
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
    </style>
</head>

<body>

<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-md-offset-3 body-main">
                <div class="col-md-12" style="border-style: solid;">
                    {{--Logo & Receipt Number & Title--}}
                    <div class="row">
                        <div class="col-md-4 text-right">
                            {!! DNS2D::getBarcodeHTML("$InvCode", 'QRCODE',5,5,'#005490',true) !!}
                            <h2>{{ trans('page-contract.contract.receipt.receiptnum') }}</h2>
                            <h5>{{$paymentlist[0]->codestr}}</h5>

                        </div>
                        <div class="col-md-4 text-center ">
                            <div class="row h-100 justify-content-center align-items-center">
                            <h2 style="color: #F81D2D;"><strong>{{ trans('page-contract.contract.receipt.clientreceipttitle') }}</strong></h2>
                            </div>
                        </div>
                        <div class="col-md-4 text-left"> <img class="img" src={{'/adminassets/img/logo.jpg'}} style="width:150px;height:150px;"/> </div>
                        <a class="btn btn-sm btn-secondary float-left mr-1 d-print-none" href="#" onclick="javascript:window.print();" data-abc="true">
                            <i class="fa fa-print"></i> {{ trans('page-contract.contract.receipt.printreceipt') }}</a>
                    </div>
                 </div>
                <br>
                <div class="col-md-12" style="border-style: solid;">
                    <br>
                    {{--Date & Amount--}}
                    <div class="row">
                        <div class="col-md-4 text-right">

                        </div>
                        <div class="col-md-4 text-center">
                            <h5 id="rcorners1" style="color: #161616;"><b>{{ trans('page-contract.contract.receipt.ramount') }} : </b> <span class="d-inline-block" style="border-bottom: 1px dotted">  <h4 style="color: #F81D2D;"><strong>{{number_format($paymentlist[0]->dueamount)}} {{$paymentlist[0]->paycurr}}</strong></h4></span></h5>
                        </div>
                        <div class="col-md-4 text-center">
                            <h5 id="rcorners1" style="color: #161616;"><b>{{ trans('page-contract.contract.receipt.indate') }} : </b> <span class="d-inline-block" style="border-bottom: 1px dotted"> <h4 style="color: #F81D2D;"><strong>{{$paymentlist[0]->paydate}}</strong></h4></span></h5>
                        </div>
                    </div>
                    <hr>
                    {{--Person Name--}}
                    <div class="row">
                        <div class="col-md-12 text-right d-inline-block" style="border-bottom: 1px dotted">
                            <div class="row h-100 justify-content-center align-items-center">
                            <h6><b>{{ trans('page-contract.contract.receipt.person') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$paymentlist[0]->cname}}</strong></h4></span></h6>
                            </div>
                        </div>
                    </div>
                    {{--Tafkit--}}
                    <div class="row">
                        <div class="col-md-12 text-right" style="border-bottom: 1px dotted">
                            <div class="row h-100 justify-content-center align-items-center">
                            <h6><b>{{ trans('page-contract.contract.receipt.taf') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$tafqeetInArabic}}</strong></h4></span></h6>
                            </div>
                        </div>
                    </div>

                    {{--Discount--}}
                    <div class="row">
                        <div class="col-md-12 text-right" style="border-bottom: 1px dotted">
                            <div class="row h-100 justify-content-center align-items-center">
                                <h6><b>{{ trans('page-contract.contract.receipt.discount') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$paymentlist[0]->discount}} {{$paymentlist[0]->paycurr}}</strong></h4></span></h6>
                            </div>
                        </div>
                    </div>

                    {{--Payment Type--}}
                    <div class="row">
                        <div class="col-md-12 text-right d-inline-block" style="border-bottom: 1px dotted">
                            <div class="row h-100 justify-content-center align-items-center">
                            <h6><b>{{ trans('page-contract.contract.receipt.paymenttype') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$paymentlist[0]->paytype}}</strong></h4></span></h6>
                            </div>
                        </div>
                    </div>

                    @if($paymentlist[0]->bankname != "NONE")
                        {{--Bank Name & Checknum--}}
                        <div class="row">
                            <div class="col-md-4 text-right d-inline-block" style="border-bottom: 1px dotted">
                                <div class="row h-100 justify-content-center align-items-center">
                                <h6><b>{{ trans('page-contract.contract.receipt.bankname') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$paymentlist[0]->bankname}}</strong></h4></span></h6>
                                </div>
                            </div>
                            <div class="col-md-4 text-right d-inline-block" style="border-bottom: 1px dotted">
                                <div class="row h-100 justify-content-center align-items-center">
                                <h6><b>{{ trans('page-contract.contract.receipt.checknum') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$paymentlist[0]->paychecknum}}</strong></h4></span></h6>
                                </div>
                            </div>
                            <div class="col-md-4 text-right d-inline-block" style="border-bottom: 1px dotted">
                                <div class="row h-100 justify-content-center align-items-center">
                                    <h6><b>{{ trans('page-contract.contract.receipt.checkdate') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$paymentlist[0]->checkdate}}</strong></h4></span></h6>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{--Payment For--}}
                    <div class="row">
                        <div class="col-md-12 text-right d-inline-block" style="border-bottom: 1px dotted">
                            <div class="row h-100 justify-content-center align-items-center">
                            <h6><b>{{ trans('page-contract.contract.receipt.paymentfor') }} : </b> <span class="d-inline-block" >  <h4 style="color: #161616;"><strong>{{$paymentlist[0]->details}}</strong></h4></span></h6>
                            </div>
                        </div>
                    </div>
                </div>
                    <hr>

                <div class="col-md-12 text-right">
                    <div class="row">
                        <h6><b>{{ trans('page-contract.contract.tables.datebellow') }} : </b> <span class="d-inline-block" style="border-bottom: 1px dotted"> {{$currdate}}</span></h6> <br />
                    </div>
                    <div class="row">
                        <h6><b>{{ trans('page-contract.contract.tables.signature') }}:</b></h6>
                    </div>
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

