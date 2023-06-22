@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.menu.contractsdetsummary') }}
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
{{--            <input id="billedvalue" type="hidden" name="billed" value="">--}}
{{--            <input id="statusvalue" type="hidden" name="billed" value="">--}}

            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">{{ trans('global.clientcontractsdet') }}</span ><span style="color:black"> : </span><span style="color:red">{{ $codename }} , {{ $clientname }}</span >--}}
{{--                        <br><br><a href="{{ route('contract-client', $clientid) }}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtocontractdet') }}</a></h6>--}}

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><h3>{{ trans('page-contract.menu.contractsdetsummary') }}</h3></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12" style="border-style: dotted;">
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
                        <div class="col-md-6 col-sm-12 col-xs-12" style="border-style: dotted;">
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
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="border-style: dotted;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <input id="stopvalue" type="hidden" name="stopstatus" value="">
                                        <input type="radio" id="allstops" name="stopstatus" data-id="" checked/>
                                        <label for="allstops" >{{trans('page-contract.contract.tables.allstops')}} </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="radio" id="stopped" name="stopstatus" data-id="1" />
                                        <label for="stopped" >{{trans('page-contract.contract.tables.stopped')}} </label>
                                    </div>
                                    <div class="col-md-5 col-sm-4 col-xs-12">
                                        <input type="radio" id="notstopped" name="stopstatus" data-id="0"/>
                                        <label for="notstopped" >{{trans('page-contract.contract.tables.notstopped')}} </label><br>
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
                <input id="contdet_id" type="hidden" name="contid_id" value="">
                <input id="car_id" type="hidden" name="car_id" value="">
                <input id="user_role" type="hidden" value="{{ $user_role[0]->role_id }} ">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbcontractsummary" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;">{{ trans('page-contract.contract.tables.id') }}</th>
                                <th width="150px" style="display:none;">{{ trans('page-contract.contract.tables.billid') }}</th>
                                <th width="150px" style="display:none;">{{ trans('page-contract.contract.tables.statusid') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.billactions') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.statusactions') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.actions') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.inscode') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.clientname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.compname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.carnameins') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.maidname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.insname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.fromdate') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.todate') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.dayscount') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.cost') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.curr') }}</th>
                            </tr>
                            </thead>
                            @if($user_role[0]->role_id != "6")
                                <tfoot>
                                <tr>
                                    <th id="trusd" colspan="17" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd') }} :</th>
                                </tr>
                                <tr>
                                    <th id="trlbp" colspan="17" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp') }} :</th>
                                </tr>
                                </tfoot>
                            @endif

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
        <input id="total_bills_usd" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_usd') }}">
        <input id="total_bills_lbp" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_lbp') }}">
    </div>
@endsection

@push('js_content')
{{--    <script src={{ asset('adminassets/js/custom/contracts-index.js') }}></script>--}}
    <script src={{ asset('adminassets/js/custom/contract-summary.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





