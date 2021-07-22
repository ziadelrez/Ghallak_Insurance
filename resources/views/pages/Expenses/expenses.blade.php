@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('expenses.Expenses.title') }}
@endsection

@push('css_content')
{{--    <link href="{{ asset("css/daterangepicker-bs3.css") }}" rel="stylesheet" type="text/css"/>--}}
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
{{--    <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>--}}
@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="content">

        <!-- Topbar -->
    @include('includes.adminpanel.header')
    <!-- Begin Page Content -->
        <div class="container-fluid">
{{--                <input id="client_id" type="hidden" name="client_id" value="">--}}
                <input id="exp_id" type="hidden" name="exp_id" value="">
                <input id="cflag" type="hidden" name="cflag" value="0">
{{--                    <form  method="POST" action="" enctype="multipart/form-data">--}}
                        {{--                {{ csrf_field() }}--}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('expenses.Expenses.exptitlecard')}}</strong>
                                    </div>
                                    <div class="card-body">
                                        {{--##Exp Date & Type --}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="expdate"
                                                           class="control-label mb-1">{{trans('expenses.Expenses.expdate')}}</label>
                                                    <input id="expdate" name="expdate" type="date"
                                                           class="form-control expdate valid"
                                                           value="{{old('expdate')}}">

                                                    <div class="alert alert-danger" id="err_details_expdate" style="display:none">
                                                        {{trans('validation.tabs.expdate_required')}}
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-6 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="exptype">{{trans('expenses.Expenses.exptype')}}</label>
                                                    <select id="exptype" name="exptype" class="form-control p selectexptype"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($exptypelist as $exptypelist)
                                                            <option value="{{$exptypelist -> id}}">{{$exptypelist -> Description}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_exptype" style="display:none">
                                                        {{trans('validation.tabs.exptype_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--##Amount &  Currency--}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="amount" class="control-label mb-1">{{trans('expenses.Expenses.amount')}}</label>
                                                    <input id="amount" name="amount" type="number"
                                                           class="form-control amount valid" value="0">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_amount" style="display:none">
                                                        {{trans('validation.tabs.expamount_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="curr">{{trans('expenses.Expenses.curr')}}</label>
                                                    <select id="curr" name="curr" class="form-control p selectcurr"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($currlist as $culist)
                                                            <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_curr" style="display:none">
                                                        {{trans('validation.tabs.expcurr_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="branch">{{trans('expenses.Expenses.branch')}}</label>
                                                    <select id="branch" name="branch" class="form-control p selectbranch"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($branchlist as $blist)
                                                            <option value="{{$blist -> id}}">{{$blist -> name}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_branch" style="display:none">
                                                        {{trans('validation.tabs.expbranch_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


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
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('expenses.Expenses.exptitlecard2')}}</strong>
                                    </div>
                                    <div class="card-body">
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
                                                    <button class="btn btn-primary btn-block btn-space-up" type="button" id="searchexp">
                                                        <i class="fa fa-search"></i> {{ trans('global.search') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="bootstrap-data-table" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th width="30px"  >{{ trans('expenses.Expenses.tables.id') }}</th>
                                                    <th class="text-center" width="120px">{{ trans('expenses.Expenses.tables.expdate') }}</th>
                                                    <th class="text-center" width="200px" >{{ trans('expenses.Expenses.tables.exptype') }}</th>
                                                    <th class="text-center" width="100px">{{ trans('expenses.Expenses.tables.expamount') }}</th>
                                                    <th class="text-center" width="80px" >{{ trans('expenses.Expenses.tables.expcurr') }}</th>
                                                    <th class="text-center" width="150px" >{{ trans('expenses.Expenses.tables.expbranch') }}</th>
                                                    <th class="text-center" width="100px">{{ trans('expenses.Expenses.tables.expactions') }}</th>
                                                </tr>
                                                </thead>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div><!--/.col-->
                        </div>
{{--                    </form>--}}
                         <br>
            <div class="hide" id="hidden-values">
                <input id="def_quick_add" type="hidden" value="{{url('/addNewValueexp')}}">
            </div>
        </div>
        <!-- /.container-fluid -->

@endsection

@push('js_content')
{{--    <script src={{ asset('adminassets/js/custom/contracts-index.js') }}></script>--}}
{{--    <script src={{ asset('adminassets/js/custom/contracts-license.js') }}></script>--}}
{{--    <script src="{{ asset('js/moment-locale.min.js') }}" type="text/javascript"></script>--}}
{{--    <script src="{{ asset('js/daterangepicker.js') }}" type="text/javascript"></script>--}}
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
    <script src={{ asset('adminassets/js/custom/expenses.js') }}></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endpush





