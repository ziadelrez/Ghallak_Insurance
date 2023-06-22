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
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group" data-label="300">
                                <label class="required" class="control-label col-sm-4" for="followby">{{trans('page-contract.contract.fields.followby')}}</label>
                                <select id="followby" name="followby" class="form-control p selectfollowby"
                                        aria-required="true" aria-invalid="false">
                                    <option></option>
                                    @foreach($followlist as $folist)
                                        <option value="{{$folist -> followby}}">{{$folist -> followname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group" data-label="301">
                                <label class="required" class="control-label col-sm-4" for="brokername">{{trans('page-contract.contract.fields.brokername')}}</label>
                                <select id="brokername" name="brokername" class="form-control p selectbrokername"
                                        aria-required="true" aria-invalid="false">
                                    <option></option>
                                    @foreach($brokerslist as $brlist)
                                        <option value="{{$brlist -> brokerid}}">{{$brlist -> brokername}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="button" id="clientssearchby">
                                    <i class="fa fa-search"></i> {{ trans('global.clientssearchby') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="fromdate">{{trans('expenses.Expenses.fromdate')}} :</label>
                            <input id="fromdate" name="fromdate" type="date"
                                   class="form-control fromdate valid"
                                   value="{{old('fromdate')}}">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <label for="todate">{{trans('expenses.Expenses.todate')}} :</label>
                            <input id="todate" name="todate" type="date"
                                   class="form-control todate valid"
                                   value="{{old('todate')}}">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <input id="filterbyvalue" type="hidden" name="filterbyvalue" value="0">
                            <input type="radio" id="allfilterby" name="filterby" data-id="" checked/>
                            <label for="allfilterby" >{{trans('page-contract.contract.tables.allfilterby')}} </label>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="radio" id="filterbyfollowby" name="filterby" data-id="1" />
                            <label for="filterbyfollowby" >{{trans('page-contract.contract.tables.filterbyfollowby')}} </label>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <input type="radio" id="filterbybroker" name="filterby" data-id="2"/>
                            <label for="filterbybroker" >{{trans('page-contract.contract.tables.filterbybroker')}} </label><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-secondary btn-block" onclick="openclientsprintout()" type="button" id="clientsprintstatements">
                                    <i class="fa fa-print"></i> {{ trans('global.printstatements') }}</button>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-success btn-block" onclick="openclientspaymentsprintout()" type="button" id="clientsprintpayments">
                                    <i class="fa fa-print"></i>  {{ trans('global.printpayments') }}</button>
                            </div>
                        </div>
                    </div>


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <input id="client_id" type="hidden" name="client_id" value="{{$client_id}}">
                <input id="person" type="hidden" name="person" value="{{$client_id}}">
{{--                <input id="cont_id" type="hidden" name="cont_id" value="{{$contid}}">--}}
{{--                <input id="flag_id" type="hidden" name="flag_id" value="{{$rflag}}">--}}
                <input id="clientsrouteid" type="hidden" name="clientsrouteid" value="{{  url('/print-clients-statements') }}">
                <input id="clientsrouteidopt" type="hidden" name="clientsrouteidopt" value="{{  url('/print-clients-statements-options') }}">
                <input id="clientsrouteidpayments" type="hidden" name="clientsrouteidpayments" value="{{  url('/print-clients-payments') }}">

                <input id="bclientsrouteid" type="hidden" name="bclientsrouteid" value="{{  url('/bprint-clients-statements') }}">
                <input id="bclientsrouteidopt" type="hidden" name="bclientsrouteidopt" value="{{  url('/bprint-clients-statements-options') }}">
                <input id="bclientsrouteidpayments" type="hidden" name="bclientsrouteidpayments" value="{{  url('/bprint-clients-payments') }}">

                                <input id="payment_id" type="hidden" name="payment_id" value="">
                <input id="brokerid" type="hidden" name="brokerid" value="">
                <input id="followbyid" type="hidden" name="followbyid" value="">
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

                                        {{--##Payment For--}}
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

                                        {{--##Contid & CCode--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="contid" class="control-label mb-1">{{trans('page-contract.contract.fields.contid')}}</label>
                                                    <input id="contid" name="contid" type="text"
                                                           class="form-control contid valid text-center" value="{{old('contid')}}" disabled>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_contid" style="display:none">
                                                        {{trans('validation.tabs.paycontid_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="ccode" class="control-label mb-1">{{trans('page-contract.contract.fields.ccodepayments')}}</label>
                                                    <input id="ccode" name="ccode" type="text"
                                                           class="form-control ccode valid text-center" value="{{old('ccode')}}" disabled>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_ccode" style="display:none">
                                                        {{trans('validation.tabs.payccode_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Date & Payment Type--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
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
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="300">
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

                                        {{--##Banks --}}
                                        <div class="row" id="banks-div">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="1">
                                                    <label id="banks-lbl" class="required" class="control-label col-sm-4" for="banks">{{trans('page-contract.contract.fields.banks')}}</label>
                                                    <select id="banks" name="banks" class="form-control p selectbanks"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($bankslist as $blist)
                                                            <option value="{{$blist -> id}}" {{$blist->id == 1 ? 'selected' : '' }}>{{$blist -> Description}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_bank" style="display:none">
                                                        {{trans('validation.tabs.banks_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Check Num & Check Date--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label id="checknum-lbl" for="checknum" class="control-label mb-1">{{trans('page-contract.contract.fields.checknum')}}</label>
                                                    <input id="checknum" name="checknum" type="text"
                                                           class="form-control checknum valid" value="-">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label id="checkdate-lbl" for="checkdate"
                                                           class="control-label mb-1">{{trans('page-contract.contract.fields.checkdate')}}</label>
                                                    <input id="checkdate" name="checkdate" type="date"
                                                           class="form-control checkdate valid"
                                                           value="{{old('checkdate')}}">

                                                    <div class="alert alert-danger" id="err_details_checkdate" style="display:none">
                                                        {{trans('validation.tabs.checkdate_required')}}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        {{--##CheckDiscount--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input type="checkbox"  name="checkdiscount" id="checkdiscount"
                                                           class="switchery" data-color="success" {{ old('checkdiscount') ? 'checked' : '' }} />
                                                    <label for="checkdiscount" class="card-title ">{{trans('page-contract.contract.fields.checkdiscount')}} </label>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Amount &  Discount--}}
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
                                                <div class="form-group has-success">
                                                    <label class="required" for="discount" class="control-label mb-1">{{trans('page-contract.contract.fields.discount')}}</label>
                                                    <input id="discount" name="discount" type="number"
                                                           class="form-control discount valid" value="0">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_discount" style="display:none">
                                                        {{trans('validation.tabs.paydiscount_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##DueAmount &  Currency--}}
                                        <div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="dueamount" class="control-label mb-1">{{trans('page-contract.contract.fields.dueamount')}}</label>
                                                    <input id="dueamount" name="dueamount" type="number"
                                                           class="form-control dueamount valid" value="0">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_dueamount" style="display:none">
                                                        {{trans('validation.tabs.paydueamount_required')}}
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
                                                            <option value="{{$culist -> id}}">{{$culist -> currname_eng}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_curr" style="display:none">
                                                        {{trans('validation.tabs.paycurr_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                       {{--##Account Type--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="12">
                                                    <label class="required" class="control-label col-sm-4" for="fromaccount">{{trans('page-contract.contract.fields.fromaccount')}}</label>
                                                    <select id="fromaccount" name="fromaccount" class="form-control p selectfromaccount"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($accountype as $alist)
                                                            <option value="{{$alist -> id}}">{{$alist -> transtype}} - {{$alist -> type}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_fromaccount" style="display:none">
                                                        {{trans('validation.tabs.fromaccount_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Payments Details--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="pdetails" class="control-label mb-1">{{trans('page-contract.contract.fields.pdetails')}}</label>
                                                    <textarea class="form-control rounded-0" name="pdetails" id="pdetails" rows="3" ></textarea>
                                                    <div class="alert alert-danger" id="err_details_pdetails" style="display:none">
                                                        {{trans('validation.tabs.pdetails_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Payment Type--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                                <div class="form-group" data-label="3">--}}
{{--                                                    <label class="required" class="control-label col-sm-4" for="paymentstatus">{{trans('page-contract.contract.fields.paymentstatus')}}</label>--}}
{{--                                                    <select id="paymentstatus" name="paymentstatus" class="form-control p selectpaymentstatus"--}}
{{--                                                            aria-required="true" aria-invalid="false">--}}
{{--                                                        <option></option>--}}
{{--                                                        @foreach($paymentstatus as $pstatuslist)--}}
{{--                                                            <option value="{{$pstatuslist -> id}}">{{$pstatuslist -> Description}}</option>--}}
{{--                                                        @endforeach--}}
{{--                                                    </select>--}}

{{--                                                    <div class="alert alert-danger" id="err_details_paymentstatus" style="display:none">--}}
{{--                                                        {{trans('validation.tabs.paymentstatus_required')}}--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <div class="card-footer">

                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-block " type="button" id="savepayment"  {{$rfalg}}>
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
                                                <div class="form-group">
                                                     <div class="row">
                                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                                                <input id="billedvalue" type="hidden" name="billed" value="">
                                                                <input type="radio" id="allbills" name="billed" data-id="" checked/>
                                                                <label for="allbills" >{{trans('page-contract.contract.tables.allbills')}} </label>
                                                        </div>
                                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                                                <input type="radio" id="billsclosed" name="billed" data-id="1" />
                                                                <label for="billsclosed" >{{trans('page-contract.contract.tables.billsclosed')}} </label>
                                                         </div>
                                                        <div class="col-md-5 col-sm-4 col-xs-12">
                                                                <input type="radio" id="billsnotclosed" name="billed" data-id="0"/>
                                                                <label for="billsnotclosed" >{{trans('page-contract.contract.tables.billsnotclosed')}} </label><br>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sizeTEXT" id="tablecontract" width="100%" cellspacing="0" cellpadding="0">
                                                        <thead>
                                                        <tr>
                                                            <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tables.id') }}</th>
                                                            <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tables.id') }}</th>
{{--                                                            <th class="text-center" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.titles.billselect') }}</th>--}}
                                                            <th class="text-center" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.titles.billstatus') }}</th>
                                                            <th class="text-center " style="vertical-align: middle" width="100px" >{{ trans('page-contract.contract.titles.inscode') }}</th>
                                                            <th class="text-center " style="vertical-align: middle" width="350px" >{{ trans('page-contract.contract.tables.insname') }}</th>
                                                            <th class="text-center bg-primary text-white" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.totalamount') }}</th>
                                                            <th  class="text-center bg-primary text-white" style="vertical-align: middle;" width="80px">{{ trans('page-contract.contract.tables.curr') }}</th>
                                                            <th class="text-center" style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.titles.displaycontract') }}</th>
                                                        </tr>
                                                        </thead>

                                                        <tfoot>
                                                        <tr>
                                                            <th id="trusd" colspan="8" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd') }} :</th>
                                                        </tr>
                                                        <tr>
                                                            <th id="trlbp" colspan="8" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp') }} :</th>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                             </div>

                                     </div> <!-- .card -->
{{--                                    End Table contract list--}}
{{--                                    <hr>--}}
{{--                                    Start Claculation Fields--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                            <div class="form-group has-success">--}}
{{--                                                <label  for="totalamounts" class="control-label mb-1">{{trans('page-contract.contract.fields.totalamounts')}}</label>--}}
{{--                                                <input id="totalamounts" name="totalamounts" type="number"--}}
{{--                                                       STYLE="color: #FFFFFF; background-color: #d20713;" class="form-control totalamounts valid text-center" value="0" disabled>--}}
{{--                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"--}}
{{--                                                      data-valmsg-replace="true"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-6 col-sm-6 col-xs-12">--}}
{{--                                            <div class="form-group has-success">--}}
{{--                                                <label  for="totalins" class="control-label mb-1">{{trans('page-contract.contract.fields.totalins')}}</label>--}}
{{--                                                <input id="totalins" name="totalins" type="number"--}}
{{--                                                        class="form-control totalins valid text-center" value="0" disabled>--}}
{{--                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"--}}
{{--                                                      data-valmsg-replace="true"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-md-6 col-sm-6 col-xs-12">--}}
{{--                                            <div class="form-group has-success">--}}
{{--                                                <label  for="totalreceived" class="control-label mb-1">{{trans('page-contract.contract.fields.totalreceived')}}</label>--}}
{{--                                                <input id="totalreceived" name="totalreceived" type="number"--}}
{{--                                                       class="form-control totalreceived valid text-center" value="0" disabled>--}}
{{--                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"--}}
{{--                                                      data-valmsg-replace="true"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="col-md-6 col-sm-6 col-xs-12">--}}
{{--                                            <div class="form-group has-success">--}}
{{--                                                <label  for="totalremain" class="control-label mb-1">{{trans('page-contract.contract.fields.totalremain')}}</label>--}}
{{--                                                <input id="totalremain" name="totalremain" type="number"--}}
{{--                                                        class="form-control totalremain valid text-center" value="0" disabled>--}}
{{--                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"--}}
{{--                                                      data-valmsg-replace="true"></span>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
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
                                                                    <th  class="text-center align-middle text-nowrap" style="vertical-align: middle" width="300px">{{ trans('page-contract.contract.tables.actionspayment') }}</th>
                                                                    <th class="text-center align-middle text-nowrap" style="vertical-align: middle" width="500px" >{{ trans('page-contract.contract.tables.receipt') }}</th>
                                                                    <th class="text-center align-middle text-nowrap" style="vertical-align: middle" width="500px" >{{ trans('page-contract.contract.tables.paydate') }}</th>
                                                                    <th class="text-center align-middle text-nowrap" style="vertical-align: middle" width="120px">{{ trans('page-contract.contract.tables.payamount') }}</th>
{{--                                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tables.payamountfor') }}</th>--}}
{{--                                                                    <th class="text-center " style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.paytype') }}</th>--}}
{{--                                                                    <th class="text-center " style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.fromaccount') }}</th>--}}
                                                                </tr>
                                                                </thead>

                                                                <tfoot>
                                                                <tr>
                                                                    <th id="trpusd" colspan="5" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd') }} :</th>
                                                                </tr>
                                                                <tr>
                                                                    <th id="trplbp" colspan="5" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp') }} :</th>
                                                                </tr>
                                                                </tfoot>
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
        <div class="hide" id="hidden-values">
            <input id="def_quick_add" type="hidden" value="{{url('/addNewValuepayments')}}">
            <input id="change_status_billing" type="hidden" value="{{url('/billing-status')}}">
            <input id="total_bills_usd" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_usd') }}">
            <input id="total_bills_lbp" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_lbp') }}">
            <input id="billfor" type="hidden" value="{{ trans('page-contract.contract.tables.billfor') }}">
        </div>
    </div>
@endsection

@push('js_content')
{{--    <script src={{ asset('adminassets/js/custom/contracts-index.js') }}></script>--}}
{{--    <script src={{ asset('adminassets/js/custom/contracts-license.js') }}></script>--}}
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
    <script src={{ asset('adminassets/js/custom/payments.js') }}></script>
@endpush





