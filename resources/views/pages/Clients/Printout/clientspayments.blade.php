<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>
        {{ trans('page-client.clients.printpayment') }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href={{ URL::asset('adminassets/css/admin.rtl.css') }} rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href={{ URL::asset('adminassets/vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        /* Styles go here */

        .page-header, .page-header-space {
            height: 100px;
        }

        .page-footer, .page-footer-space {
            height: 50px;

        }

        .page-footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid black;
            background: #fefefe;
        }

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

        @page {
            margin: 20mm
        }

        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group;}

            /*button {display: none;}*/
            #printbtn {
                display :  none;
            }
            body {margin: 0;}
        }

        /* Style buttons */
        .btn {
            background-color: DodgerBlue; /* Blue background */
            border: none; /* Remove borders */
            color: white; /* White text */
            padding: 12px 16px; /* Some padding */
            font-size: 16px; /* Set a font size */
            cursor: pointer; /* Mouse pointer on hover */
        }

        /* Darker background on mouse-over */
        .btn:hover {
            background-color: RoyalBlue;
        }

    </style>
</head>

<body>

<div class="page-header" style="text-align: center">
    <input id="client_id" type="hidden" name="client_id" value="{{$client_id}}">
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
           <h4>{{ trans('global.paymentclient') }}<span style="color:black"> : </span><span style="color:red">{{$clientname}}</span ></h4>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <h3>{{$branchname}}</h3>
            <button  id="printbtn" type="button" onClick="window.print()" class="btn"><i class="fa fa-print" style="font-size:24px"></i>
                {{ trans('page-client.clients.printout') }}
            </button>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <img class="card-img-top "  src={{'/adminassets/img/logo.jpg'}} style="width:200px;height:90px;">
        </div>
    </div>
</div>

<div class="page-footer">

</div>
<div class="page-header-space"></div>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                           {{trans('page-contract.contract.paymenttitlecard')}}  <i class="fas fa-th-list"></i>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sizeTEXT" id="tablecontract" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tables.id') }}</th>
                                                <th class="text-center " style="vertical-align: middle" width="350px" >{{ trans('page-contract.contract.tables.date') }}</th>
                                                <th class="text-center " style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.deposit') }}</th>
                                                <th class="text-center " style="vertical-align: middle; display:none;" width="80px">{{ trans('page-contract.contract.tables.dcurr') }}</th>
                                                <th class="text-center " style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.carsnumbers') }}</th>
                                                <th class="text-center " style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.totalamount') }}</th>
                                                <th  class="text-center " style="vertical-align: middle; display:none;" width="80px">{{ trans('page-contract.contract.tables.curr') }}</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($contractlist as $colist)
                                                <tr class="corrows{{$colist -> id}}">
                                                    <td style="display:none;" >{{$colist -> id}}</td>
                                                    <td class="text-center" style="vertical-align: middle" width="350px">{{$colist -> codate}}</td>
                                                    <td class="text-center " style="vertical-align: middle" width="100px" >{{$colist -> deposit}}</td>
                                                    <td class="text-center " style="vertical-align: middle; display:none;" width="80px">{{$colist -> dcurr}}</td>
                                                    <td class="text-center" style="vertical-align: middle" width="100px">{{$colist -> cocars}}</td>
                                                    <td class="text-center " style="vertical-align: middle" width="100px">{{number_format($colist -> coamount)}}</td>
                                                    <td class="text-center " style="vertical-align: middle; display:none;" width="80px">{{$colist -> cocurr}}</td>
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

                <div class="col-lg-7 col-sm-12 col-xs-12">

                        <div class="card">
                            <div class="card-header">
                                {{trans('page-contract.contract.paymentlist')}}  <i class="fa fa-dollar-sign"></i>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sizeTEXT" id="tablepayments" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tables.payid') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="250px" >{{ trans('page-contract.contract.tables.paydate') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="120px">{{ trans('page-contract.contract.tables.payamount') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tables.payamountfor') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.paytype') }}</th>
                                                    <th class="text-center " style="display:none;" width="100px">{{ trans('page-contract.contract.tables.paytype') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <hr>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="totalamounts" class="control-label mb-1">{{trans('page-contract.contract.fields.totalamounts')}}</label>
                                    <input id="totalamounts" name="totalamounts" type="number"
                                           class="form-control totalamounts valid text-center" value="0" disabled>
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                          data-valmsg-replace="true"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="totaldeposits" class="control-label mb-1">{{trans('page-contract.contract.fields.totaldeposits')}}</label>
                                    <input id="totaldeposits" name="totaldeposits" type="number"
                                           class="form-control totaldeposits valid text-center" value="0" disabled>
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                          data-valmsg-replace="true"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="totalreceived" class="control-label mb-1">{{trans('page-contract.contract.fields.totalreceived')}}</label>
                                    <input id="totalreceived" name="totalreceived" type="number"
                                           class="form-control totalreceived valid text-center" value="0" disabled>
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                          data-valmsg-replace="true"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="totalremain" class="control-label mb-1">{{trans('page-contract.contract.fields.totalremain')}}</label>
                                    <input id="totalremain" name="totalremain" type="number"
                                           class="form-control totalremain valid text-center" value="0" disabled>
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                          data-valmsg-replace="true"></span>
                                </div>
                            </div>
                        </div>

                </div><!--/.col-->
            </div>
        </div>
    </div>

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
<script src={{ asset('adminassets/js/custom/printpayments.js') }}></script>
</body>

</html>

