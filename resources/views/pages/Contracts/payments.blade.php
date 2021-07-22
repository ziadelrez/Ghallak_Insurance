@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.menu.payments') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="content">

        <!-- Topbar -->
    @include('includes.adminpanel.header')
    <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><a href="{{url('/clients-list')}}"> {{ trans('global.backtoclient') }}  </a></h6>--}}
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">  /  {{ trans('global.clientcontracts') }}</span ><span style="color:black"> : </span><span style="color:red">{{$clientname}}</span ></h6>--}}

                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/clients-list')}}">{{ trans('global.backtoclient') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('global.paymentclient') }}<span style="color:black"> : </span><span style="color:red">{{$clientname}}</span ></li>
                                </ol>
                            </nav>
                        </div>
                    </div>


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <input id="client_id" type="hidden" name="client_id" value="{{$client_id}}">
                <input id="payment_id" type="hidden" name="payment_id" value="">
                <input id="cflag" type="hidden" name="cflag" value="0">
                <br>
                <div class="container">
                    <form  method="POST" action="" enctype="multipart/form-data">
                        {{--                {{ csrf_field() }}--}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-5 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.paymenttitlecard2')}}</strong>
                                    </div>
                                    <div class="card-body">
                                        {{--##Date & Payment For--}}
                                        <div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="paymentdate"
                                                           class="control-label mb-1">{{trans('page-contract.contract.fields.paymentdate')}}</label>
                                                    <input id="paymentdate" name="paymentdate" type="date"
                                                           class="form-control paymentdate valid"
                                                           value="{{old('paymentdate')}}">

                                                    <div class="alert alert-danger" id="err_details_paymentdate" style="display:none">
                                                        {{trans('validation.tabs.paydate_required')}}
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="paymenttype">{{trans('page-contract.contract.fields.paymenttype')}}</label>
                                                    <select id="paymenttype" name="paymenttype" class="form-control p selectpaymenttype"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($paymenttype as $ptypelist)
                                                            <option value="{{$ptypelist -> id}}">{{$ptypelist -> Description}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_paymenttype" style="display:none">
                                                        {{trans('validation.tabs.paytype_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Check Num--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label for="checknum" class="control-label mb-1">{{trans('page-contract.contract.fields.checknum')}}</label>
                                                    <input id="checknum" name="checknum" type="text"
                                                           class="form-control checknum valid" value="-">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                </div>
                                            </div>

                                        </div>

                                        {{--##Amount &  Currency--}}
                                        <div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="amount" class="control-label mb-1">{{trans('page-contract.contract.fields.amount')}}</label>
                                                    <input id="amount" name="amount" type="number"
                                                           class="form-control amount valid" value="0">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_amount" style="display:none">
                                                        {{trans('validation.tabs.payamount_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="curr">{{trans('page-contract.contract.fields.curr')}}</label>
                                                    <select id="curr" name="curr" class="form-control p selectcurr"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($currlist as $culist)
                                                            <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_curr" style="display:none">
                                                        {{trans('validation.tabs.paycurr_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Payment Type--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="amountfor">{{trans('page-contract.contract.fields.amountfor')}}</label>
                                                    <select id="amountfor" name="amountfor" class="form-control p selectamountfor"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($paymentforlist as $pforlist)
                                                            <option value="{{$pforlist -> id}}">{{$pforlist -> Description}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_amountfor" style="display:none">
                                                        {{trans('validation.tabs.payamountfor_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Payment Type--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="paymentstatus">{{trans('page-contract.contract.fields.paymentstatus')}}</label>
                                                    <select id="paymentstatus" name="paymentstatus" class="form-control p selectpaymentstatus"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($paymentstatus as $pstatuslist)
                                                            <option value="{{$pstatuslist -> id}}">{{$pstatuslist -> Description}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_paymentstatus" style="display:none">
                                                        {{trans('validation.tabs.paymentstatus_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="card-footer">

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-block" type="button" id="savepayment">
                                                            {{ trans('global.save') }}
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-info btn-block" type="button" id="clearpayment">
                                                            {{ trans('global.cancelpayment') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-7 col-sm-12 col-xs-12">
                                <div id="accordionTB" role="tablist" aria-multiselectable="true">
{{--                                    Start Table Contract List--}}
                                    <div class="card">
                                        <h5 class="card-header" role="tab" id="headingOne">
                                            <a data-toggle="collapse" data-parent="#accordionTB" href="#collapseOneContract" aria-expanded="false" aria-controls="collapseOne" class="collapsed d-block">
                                                <i class="fa fa-chevron-down pull-right"></i> {{trans('page-contract.contract.paymenttitlecard')}}  <i class="fas fa-th-list"></i>
                                            </a>
                                        </h5>
                                        <div id="collapseOneContract" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sizeTEXT" id="tablecontract" width="100%" cellspacing="0">
                                                        <thead>
                                                        <tr>
                                                            <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tables.id') }}</th>
                                                            <th class="text-center " style="vertical-align: middle" width="250px" >{{ trans('page-contract.contract.tables.date') }}</th>
                                                            <th class="text-center bg-danger text-white" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.deposit') }}</th>
                                                            <th class="text-center bg-danger text-white" style="vertical-align: middle" width="80px">{{ trans('page-contract.contract.tables.dcurr') }}</th>
                                                            <th class="text-center " style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.carsnumbers') }}</th>
                                                            <th class="text-center bg-primary text-white" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.totalamount') }}</th>
                                                            <th  class="text-center bg-primary text-white" style="vertical-align: middle" width="80px">{{ trans('page-contract.contract.tables.curr') }}</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        @foreach($contractlist as $colist)
                                                            <tr class="corrows{{$colist -> id}}">
                                                                <td style="display:none;" >{{$colist -> id}}</td>
                                                                <td class="text-center" style="vertical-align: middle" width="250px">{{$colist -> codate}}</td>
                                                                <td class="text-center bg-danger text-white" style="vertical-align: middle" width="100px" >{{$colist -> deposit}}</td>
                                                                <td class="text-center bg-danger text-white" style="vertical-align: middle" width="80px">{{$colist -> dcurr}}</td>
                                                                <td class="text-center" style="vertical-align: middle" width="100px">{{$colist -> cocars}}</td>
                                                                <td class="text-center bg-primary text-white" style="vertical-align: middle" width="100px">{{$colist -> coamount}}</td>
                                                                <td class="text-center bg-primary text-white" style="vertical-align: middle" width="80px">{{$colist -> cocurr}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        </div>

                                     </div> <!-- .card -->
{{--                                    End Table contract list--}}
                                    <hr>
{{--                                    Start Claculation Fields--}}
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
                                                       STYLE="color: #FFFFFF; background-color: #d20713;" class="form-control totaldeposits valid text-center" value="0" disabled>
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
{{--                                    End Field Calculation--}}
                                    <hr>
                            {{--Start Payment list from here--}}
                                    <div class="card">
                                        <h5 class="card-header" role="tab" id="headingTow">
                                            <a data-toggle="collapse" data-parent="#accordionTB" href="#collapseOnePay" aria-expanded="true" aria-controls="collapseTwo" class="d-block">
                                                <i class="fa fa-chevron-down pull-right"></i> {{trans('page-contract.contract.paymentlist')}}  <i class="fa fa-dollar-sign"></i>
                                            </a>
                                        </h5>
                                        <div id="collapseOnePay" class="collapse show" role="tabpanel" aria-labelledby="headingTow">
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
                                                                    <th  class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tables.actions') }}</th>
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

                                    </div>

                                </div>
                            </div><!--/.col-->
                        </div>
                    </form>
                </div>
                <br>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
@endsection

@push('js_content')
{{--    <script src={{ asset('adminassets/js/custom/contracts-index.js') }}></script>--}}
{{--    <script src={{ asset('adminassets/js/custom/contracts-license.js') }}></script>--}}
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
    <script src={{ asset('adminassets/js/custom/payments.js') }}></script>
@endpush





