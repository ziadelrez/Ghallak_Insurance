@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.menu.ppayments') }}
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
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group" data-label="1000">
                                <label class="control-label col-sm-6" for="partners">{{trans('page-contract.contract.fields.partners')}}</label>
                                <select id="partners" name="partners" class="form-control p selectpartners"
                                        aria-required="true" aria-invalid="false">
                                    <option></option>
                                    @foreach($partnerslist as $plist)
                                        <option value="{{$plist -> id}}">{{$plist -> partner}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group" data-label="120">
                                <label class="control-label col-sm-6" for="partnersname">{{trans('page-contract.contract.fields.partnersname')}}</label>
                                <select id="partnersname" name="partnersname" class="form-control p selectpartnersname"
                                        aria-required="true" aria-invalid="false">
                                    <option></option>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="fromdate">{{trans('expenses.Expenses.fromdate')}} :</label>
                            <input id="fromdate" name="fromdate" type="date"
                                   class="form-control fromdate valid"
                                   value="{{old('fromdate')}}">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label for="todate">{{trans('expenses.Expenses.todate')}} :</label>
                            <input id="todate" name="todate" type="date"
                                   class="form-control todate valid"
                                   value="{{old('todate')}}">
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block btn-space-up" type="button" id="searchpayments">
                                    <i class="fa fa-search"></i> {{ trans('global.searchpayments') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-secondary btn-block" onclick="openprintout()" type="button" id="printstatements">
                                    <i class="fa fa-print"></i> {{ trans('global.printstatements') }}
                                </button>
{{--                                <a href="#" target="_blank" class="btn btn-secondary btn-block" id="printstatements">--}}
{{--                                    {{ trans('global.printstatements') }}--}}
{{--                                </a>--}}
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-success btn-block" onclick="openpaymentsprintout()" type="button" id="printpayments">
                                    <i class="fa fa-print"></i> {{ trans('global.printpayments') }}</button>
                            </div>
                        </div>
                    </div>


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <input id="client_id" type="hidden" name="client_id" value="">
                <input id="tbname" type="hidden" name="tbname" value="">
{{--                <input id="cont_id" type="hidden" name="cont_id" value="{{$contid}}">--}}
{{--                <input id="flag_id" type="hidden" name="flag_id" value="{{$rflag}}">--}}
                <input id="payment_id" type="hidden" name="payment_id" value="">
                <input id="routeid" type="hidden" name="routeid" value="{{  url('/print-partners-statements') }}">
                <input id="routeidopt" type="hidden" name="routeidopt" value="{{  url('/print-partners-statements-options') }}">
                <input id="routeidpayments" type="hidden" name="routeidpayments" value="{{  url('/print-partners-payments') }}">
                <input id="cflag" type="hidden" name="cflag" value="0">
                <input id="flagselect" type="hidden" name="flagselect" value="0">
                <br>
                <div class="container">
                    <form  method="POST" action="" enctype="multipart/form-data">
                        {{--                {{ csrf_field() }}--}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-5 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.ppaymenttitlecard2')}}</strong>
                                    </div>
                                    <div class="card-body">
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
                                                            <option value="{{$culist -> id}}">{{$culist -> currname_eng}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_curr" style="display:none">
                                                        {{trans('validation.tabs.paycurr_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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

                                        {{--##Account Type--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="12">
                                                    <label class="required" class="control-label col-sm-4" for="fromaccount">{{trans('page-contract.contract.fields.fromaccount')}}</label>
                                                    <select id="fromaccount" name="fromaccount" class="form-control p selectfromaccount"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
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
                                                        <button class="btn btn-primary btn-block " type="button" id="savepayment" >
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
                                                <i class="fa fa-chevron-down pull-right"></i> {{trans('page-contract.contract.ppaymenttitlecard')}}  <i class="fas fa-th-list"></i>
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
                                                            <th class="text-center " style="vertical-align: middle" width="100px" >{{ trans('page-contract.contract.titles.ppcode') }}</th>
                                                            <th class="text-center " style="vertical-align: middle" width="350px" >{{ trans('page-contract.contract.tables.ppname') }}</th>
                                                            <th class="text-center bg-primary text-white" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.ptotalamount') }}</th>
                                                            <th  class="text-center bg-primary text-white" style="vertical-align: middle;" width="80px">{{ trans('page-contract.contract.tables.curr') }}</th>
                                                            <th class="text-center" style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.titles.pdisplaycontract') }}</th>
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
            <input id="change_status_billing" type="hidden" value="{{url('/partners-billing-status')}}">
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
    <script src={{ asset('adminassets/js/custom/ppayments.js') }}></script>
{{--    <script src="https://cdn.datatables.net/plug-ins/1.10.19/api/sum().js"></script>--}}
@endpush





