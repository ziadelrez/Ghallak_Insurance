@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('reminders.reminders.title') }}
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
            <input id="msgcontent1" type="hidden" name="msgcontent1" value="{{ trans('reminders.reminders.msgcontent1') }}">
{{--            <input id="statusvalue" type="hidden" name="billed" value="">--}}

            <input id="clientsrouteid" type="hidden" name="clientsrouteid" value="{{  url('/print-reminders-statements') }}">

            <input id="bclientsrouteid" type="hidden" name="bclientsrouteid" value="{{  url('/bprint-reminders-statements') }}">

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">{{ trans('global.clientcontractsdet') }}</span ><span style="color:black"> : </span><span style="color:red">{{ $codename }} , {{ $clientname }}</span >--}}
{{--                        <br><br><a href="{{ route('contract-client', $clientid) }}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtocontractdet') }}</a></h6>--}}

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><h4>{{ trans('reminders.reminders.pageheader') }}</h4></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('global.msgbalance') }}<span style="color:black"> : </span><span style="color:red" id="gbalance"></span > {{ trans('global.msgbalancelbl') }}</li>
{{--                                    <input id="gbalance" type="text" name="gbalance" value="">--}}
                                </ol>
                            </nav>
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
                                <button class="btn btn-primary btn-block" type="button" id="clientssearchby">
                                    <i class="fa fa-search"></i> {{ trans('global.reminderssearchby') }}</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group" data-label="300">
                                <label class="required" class="control-label col-sm-4" for="followby">{{trans('page-contract.contract.fields.followby')}}</label>
                                <select id="followby" name="followby" class="form-control p selectfollowby"
                                        aria-required="true" aria-invalid="false">
                                    <option></option>
                                    @foreach($followlist as $folist)
                                        <option value="{{$folist -> id}}">{{$folist -> Description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group" data-label="301">
                                <label class="required" class="control-label col-sm-4" for="brokername">{{trans('page-contract.contract.fields.brokername')}}</label>
                                <select id="brokername" name="brokername" class="form-control p selectbrokername"
                                        aria-required="true" aria-invalid="false">
                                    <option></option>
                                    @foreach($brokerslist as $brlist)
                                        <option value="{{$brlist -> id}}">{{$brlist -> cname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <button class="btn btn-secondary btn-block" onclick="openremindersclientsprintout()" type="button" id="clientsprintstatements">
                                    <i class="fa fa-print"></i> {{ trans('global.remindersprintstatements') }}</button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="border-style: solid;background-color:#919191;">
                            <div class="form-group">
                                <div class="row">
                                    <input id="msgtype" type="hidden" name="msgtype" value="">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        {{--                                        <input id="billedvalue" type="hidden" name="billed" value="">--}}
                                        <input type="radio" id="welcomemsg" name="sms" data-id="0" checked/>
                                        <label for="welcomemsg" >{{trans('reminders.reminders.welcomemsg')}} </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
{{--                                        <input id="billedvalue" type="hidden" name="billed" value="">--}}
                                        <input type="radio" id="smsrenew" name="sms" data-id="1" />
                                        <label for="smsrenew" >{{trans('reminders.reminders.smsrenew')}} </label>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <input type="radio" id="smspayment" name="sms" data-id="2" />
                                        <label for="smspayment" >{{trans('reminders.reminders.smspayment')}} </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12" style="border-style: dotted;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                            <label class="required" for="msgwelcomearea" class="control-label mb-1">{{trans('reminders.reminders.msgwelcomearea')}}</label>
                                            <textarea class="form-control rounded-0" name="msgwelcomearea" id="msgwelcomearea" rows="3" >{{trans('reminders.reminders.msgcontent')}}</textarea>
                                            <div class="alert alert-danger" id="err_details_msgwelcomearea" style="display:none">
                                                {{trans('validation.reminders.msgwelcomearea_required')}}
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12" style="border-style: dotted;">
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
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12" style="border-style: dotted;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <input id="statusvalue" type="hidden" name="statusins" value="">
                                        <input type="radio" id="allstatus" name="statusins" data-id="" checked/>
                                        <label for="allstatus" >{{trans('page-contract.contract.tables.allstatus')}} </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="radio" id="statusclosed" name="statusins" data-id="1" />
                                        <label for="statusclosed" >{{trans('page-contract.contract.tables.statusclosed')}} </label>
                                    </div>
                                    <div class="col-md-5 col-sm-4 col-xs-12">
                                        <input type="radio" id="statusnotclosed" name="statusins" data-id="0"/>
                                        <label for="statusnotclosed" >{{trans('page-contract.contract.tables.statusnotclosed')}} </label><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
{{--                <input id="contid_id" type="hidden" name="contid_id" value="{{$contract_id}}">--}}
                <input id="smsrenew_id" type="hidden" name="smsrenew_id" value="{{$settsmsrenew}}">
                <input id="smspayment_id" type="hidden" name="smsrenew_id" value="{{$settsmspayment}}">
                <input id="msg_id" type="hidden" name="msg_id" value="">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbcontractsummary" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;">{{ trans('reminders.tables.id') }}</th>
                                <th width="150px" style="display:none;">{{ trans('reminders.tables.status') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.reminders.sendsms') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.inscode') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.clientname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.clientphone') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.compname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.carname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.maidname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.insname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.fromdate') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.todate') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.dayscount') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.cost') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('reminders.tables.curr') }}</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>

    <div class="hide" id="hidden-values">
        <input id="change_status_billing" type="hidden" value="{{url('/billing-status')}}">
        <input id="change_status_ins" type="hidden" value="{{url('/insurance-status')}}">
    </div>
@endsection

@push('js_content')
{{--    <script src={{ asset('adminassets/js/custom/contracts-index.js') }}></script>--}}
    <script src={{ asset('adminassets/js/custom/reminders.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





