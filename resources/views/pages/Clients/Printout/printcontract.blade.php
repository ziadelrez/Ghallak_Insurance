<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <title>
        {{ trans('page-contract.contract.printcontract') }}
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
            height: 300px;
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



        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group;}

            @page {
                /*size: A4 portrait;*/
                margin: 10mm
            }

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

        /*table {*/
        /*    margin-bottom : 0rem;*/
        /*}*/

        /*tr {*/
        /*    height: 10px;*/
        /*}*/


    </style>
</head>

<body>

<div class="page-header" style="text-align: center">
{{--    <input id="client_id" type="hidden" name="client_id" value="{{$client_id}}" style="width:200px;height:90px;">--}}
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <img class="card-img-top "  src={{'/adminassets/img/header_contract.jpg'}} >
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p style="color:red; font-size:20px;">{{ trans('page-contract.contract.printcontract1') }}          <span style="color:black;font-size:30px;">{{$contractdetlist[0]->billnum}}</span></p>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <button  id="printbtn" type="button" onClick="window.print()" class="btn"><i class="fa fa-print" style="font-size:24px"></i>
                {{ trans('page-contract.contract.printout') }}
            </button>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <p style="color:red; font-size:20px;">{{ trans('page-contract.contract.printcontract2') }}</p>
        </div>
    </div>
</div>

<div class="page-footer">

</div>
<div class="page-header-space"></div>
<br>
<div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                            <table class="table_print table-bordered" id="myTable" cellspacing="0">
                                <thead>
                                <tr >
                                    <th class="text-right " style="background-color:#ff3023" width="50px">{{ trans('page-contract.contract.agentname') }}</th>
                                    <th class="text-right " style="background-color:#ffaa9b" width="150px">{{$contractdetlist[0]->cname}}</th>
                                </tr>
                                </thead>
                            </table>
                    </div>
                    <div class="row">
                        <table class="table_print">
                            <thead>
                            <tr>
                                <th class="text-right " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.carinfo_ar') }}</th>
                                <th class="text-left " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.carinfo_en') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered">
                            <thead>
                            <tr >
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.color') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.model') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.type') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.platnumber') }}</th>
                            </tr>
                            <tr >
                                <td>{{$contractdetlist[0]->carcolor}}</td>
                                <td>{{$contractdetlist[0]->carmodel}}</td>
                                <td>{{$contractdetlist[0]->carname}}</td>
                                <td>{{$contractdetlist[0]->carnumber}}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.rates') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.engnum') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.chnum') }}</th>
                            </tr>
                            <tr>
                                <td>{{$contractdetlist[0]->carrate}}</td>
                                <td>{{$contractdetlist[0]->engnum}}</td>
                                <td>{{$contractdetlist[0]->chanum}}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.days') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.in') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.out') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.item') }}</th>
                            </tr>
                            <tr>
                                <td>{{$contractdetlist[0]->cardays}}</td>
                                <td>{{$contractdetlist[0]->datein}}</td>
                                <td>{{$contractdetlist[0]->dateout}}</td>
                                <td style="background-color:#ff3023">{{ trans('page-contract.contract.datecar') }}</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td>{{$contractdetlist[0]->timein}}</td>
                                <td>{{$contractdetlist[0]->timeout}}</td>
                                <td style="background-color:#ff3023">{{ trans('page-contract.contract.timecar') }}</td>
                            </tr>
                            <tr>
                                <td>-</td>
                                <td>{{$contractdetlist[0]->kmsin}}</td>
                                <td>{{$contractdetlist[0]->kmsout}}</td>
                                <td style="background-color:#ff3023">{{ trans('page-contract.contract.kms') }}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print ">
                            <thead>
                            <tr>
                                <th class="text-center " style="display:none;" width="150px">{{ trans('page-contract.contract.rates') }}</th>
                                <th class="text-right " style="display:none;" width="150px">{{ trans('page-contract.contract.engnum') }}</th>
                                <th class="text-left " style="display:none;" width="150px">{{ trans('page-contract.contract.engnum') }}</th>
                            </tr>
                            <tr>
                                <td class="text-center " style="border-top-style:solid;border-right-style:solid;border-width:1px; border-bottom-style:solid;">{{$contractdetlist[0]->cartotal}}</td>
                                <td class="text-right " style="background-color:#ff3023; border-right-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.amount_ar') }}</td>
                                <td class="text-left " style="background-color:#ff3023; border-left-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.amount_en') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center " style="border-top-style:solid;border-right-style:solid;border-width:1px; border-bottom-style:solid;">{{$contractdetlist[0]->gascost}}</td>
                                <td class="text-right " style="background-color:#ff3023; border-right-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.gaz_ar') }}</td>
                                <td class="text-left " style="background-color:#ff3023; border-left-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.gaz_en') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center " style="border-top-style:solid;border-right-style:solid;border-width:1px; border-bottom-style:solid;">0</td>
                                <td class="text-right " style="background-color:#ff3023; border-right-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.accident_ar') }}</td>
                                <td class="text-left " style="background-color:#ff3023; border-left-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.accident_en') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center " style="border-top-style:solid;border-right-style:solid;border-width:1px; border-bottom-style:solid;">{{$contractdetlist[0]->drivercost}}</td>
                                <td class="text-right " style="background-color:#ff3023; border-right-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.driver_ar') }}</td>
                                <td class="text-left " style="background-color:#ff3023; border-left-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.driver_en') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center " style="border-top-style:solid;border-right-style:solid;border-width:1px; border-bottom-style:solid;">0</td>
                                <td class="text-right " style="background-color:#ff3023; border-right-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;"></td>
                                <td class="text-left " style="background-color:#ff3023; border-left-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.vat') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center " style="border-top-style:solid;border-right-style:solid;border-width:1px; border-bottom-style:solid;">{{$contractdetlist[0]->cartotal}}</td>
                                <td class="text-right " style="background-color:#ff3023; border-right-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.balance_ar') }}</td>
                                <td class="text-left " style="background-color:#ff3023; border-left-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.balance_en') }}</td>
                            </tr>
                            <tr>
                                <td class="text-center " style="border-top-style:solid;border-right-style:solid;border-width:1px; border-bottom-style:solid;">{{$contractdetlist[0]->deposit}}</td>
                                <td class="text-right " style="background-color:#ff3023; border-right-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.deposit_ar') }}</td>
                                <td class="text-left " style="background-color:#ff3023; border-left-style:solid;border-width:1px; border-bottom-style:solid;border-top-style:solid;">{{ trans('page-contract.contract.deposit_en') }}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
{{--                    <div class="row">--}}
{{--                        <table class="table_print">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th class="text-right " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.apayment_ar') }}</th>--}}
{{--                                <th class="text-left " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.apayment_en') }}</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <table class="table_print table-bordered">--}}
{{--                            <thead>--}}
{{--                            <tr>--}}
{{--                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.preamount') }}</th>--}}
{{--                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.predate') }}</th>--}}
{{--                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.pretype') }}</th>--}}
{{--                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.ptype') }}</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                                @foreach($getpayment as $plist)--}}
{{--                                    <tr>--}}
{{--                                        <td>{{$plist->payamount}} {{$plist->paycurr}}</td>--}}
{{--                                        <td>{{$plist->paydate}}</td>--}}
{{--                                        <td>{{$plist->payamountfor}}</td>--}}
{{--                                        <td>{{$plist->paytype}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <img class="card-img-top "  src={{'/adminassets/img/right_side_contract.jpg'}} >
                            <br>
                        </div>
                    </div>
                </div>

{{--                <div class="col-sm-1" ></div>--}}
                <div class="col-sm-6">
                    <div class="row">
                        <table class="table_print table-bordered" id="myTable" cellspacing="0">
                            <thead>
                            <tr >
                                <th class="text-right " style="background-color:#ff3023" width="50px">{{ trans('page-contract.contract.agentname') }}</th>
                                <th class="text-right " style="background-color:#ffaa9b" width="150px">{{$contractdetlist[0]->cname}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered" id="" cellspacing="0">
                            <thead>
                            <tr>
                                <th class="text-right " style="background-color:#ff3023" width="50px">{{ trans('page-contract.contract.adr') }}</th>
                                <th class="text-right " style="background-color:#ffaa9b" width="150px">{{$contractdetlist[0]->cadr}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered" id="" cellspacing="0">
                            <thead>
                            <tr >
                                <th class="text-right " style="background-color:#ff3023" width="50px">{{ trans('page-contract.contract.phone') }}</th>
                                <th class="text-right " style="background-color:#ffaa9b" width="150px">{{$contractdetlist[0]->cmob}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.natio') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.placenatio') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.sigil') }}</th>
                            </tr>
                            <tr>
                                <td>{{$contractdetlist[0]->natio}}</td>
                                <td>{{$contractdetlist[0]->place}} , {{$contractdetlist[0]->birthdate}}</td>
                                <td>{{$contractdetlist[0]->sigil}}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.passdate') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.passplace') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.passnum') }}</th>
                            </tr>
                            <tr>
                                <td>{{$contractdetlist[0]->passdate}}</td>
                                <td>{{$contractdetlist[0]->passplace}}</td>
                                <td>{{$contractdetlist[0]->passnum}}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.lidate') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.liplace') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.linum') }}</th>
                            </tr>
                            <tr>
                                <td>{{$getlicense[0]->lidate}}</td>
                                <td>{{$getlicense[0]->liplacename}}</td>
                                <td>{{$getlicense[0]->linum}}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="row">
                        <table class="table_print table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.driveradd') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.driverliplace') }}</th>
                                <th class="text-center " style="background-color:#ff3023" width="150px">{{ trans('page-contract.contract.driverlinum') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($getlicensecontract as $plist)
                                    <tr>
                                        <td>{{$plist->person}}</td>
                                        <td>{{$plist->liplacename}}</td>
                                        <td>{{$plist->linum}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <img class="card-img-top "  src={{'/adminassets/img/left_side_contract.jpg'}} >
                            <br>
                        </div>
                    </div>

                </div><!--/.col-->
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
{{--<script src={{ asset('adminassets/js/custom/printpayments.js') }}></script>--}}
</body>

</html>

