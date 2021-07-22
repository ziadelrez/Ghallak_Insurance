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
                <input id="booking_id" type="hidden" name="booking_id" value="">
                <input id="cflag" type="hidden" name="cflag" value="0">
{{--                    <form  method="POST" action="" enctype="multipart/form-data">--}}
                        {{--                {{ csrf_field() }}--}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-xs-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('booking.Bookings.exptitlecard')}}</strong>
                                    </div>
                                    <div class="card-body">
                                        {{--## From Date -> To Date & CarCollection  --}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="fromdate"
                                                           class="control-label mb-1">{{trans('booking.Bookings.fromdate')}}</label>
                                                    <input id="fromdate" name="fromdate" type="date"
                                                           class="form-control fromdate valid"
                                                           value="{{old('fromdate')}}">

                                                    <div class="alert alert-danger" id="err_details_fromdate" style="display:none">
                                                        {{trans('validation.tabs.fromdate_required')}}
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-4 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="todate"
                                                           class="control-label mb-1">{{trans('booking.Bookings.todate')}}</label>
                                                    <input id="todate" name="todate" type="date"
                                                           class="form-control todate valid"
                                                           value="{{old('todate')}}">

                                                    <div class="alert alert-danger" id="err_details_todate" style="display:none">
                                                        {{trans('validation.tabs.todate_required')}}
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-5 col-sm-4 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="car">{{trans('booking.Bookings.car')}}</label>
                                                    <select id="car" name="car" class="form-control p selectcar"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($carslist as $carlist)
                                                            <option value="{{$carlist -> carid}}">{{$carlist -> carname}} - {{$carlist -> carnumber}} , {{$carlist -> carcolor}} , {{$carlist -> caryear}} </option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_car" style="display:none">
                                                        {{trans('validation.tabs.car_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{--##ClientName , Mobile , Branch & Number Of Days--}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="pname" class="control-label mb-1">{{trans('booking.Bookings.pname')}}</label>
                                                    <input id="pname" name="pname" type="text"
                                                           class="form-control pname valid" value="">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_pname" style="display:none">
                                                        {{trans('validation.tabs.pname_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-2 col-sm-2 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="mobile" class="control-label mb-1">{{trans('booking.Bookings.mobile')}}</label>
                                                    <input id="mobile" name="mobile" type="text"
                                                           class="form-control mobile valid" value="">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_mobile" style="display:none">
                                                        {{trans('validation.tabs.mobile_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-1 col-sm-2 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="ndays" class="control-label mb-1">{{trans('booking.Bookings.ndays')}}</label>
                                                    <input id="ndays" name="ndays" type="number"
                                                           class="form-control ndays valid" value="0">
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>

                                                    <div class="alert alert-danger" id="err_details_ndays" style="display:none">
                                                        {{trans('validation.tabs.ndays_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-5 col-sm-4 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="branch">{{trans('booking.Bookings.branch')}}</label>
                                                    <select id="branch" name="branch" class="form-control p selectbranch"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        @foreach($branchlist as $blist)
                                                            <option value="{{$blist -> id}}">{{$blist -> name}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_branch" style="display:none">
                                                        {{trans('validation.tabs.branch_required')}}
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
                                        <strong class="card-title">{{trans('booking.Bookings.exptitlecard2')}}</strong>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label for="fromdateS">{{trans('booking.Bookings.fromdatesearch')}} :</label>
                                                <input id="fromdateS" name="fromdateS" type="date"
                                                       class="form-control fromdateS valid"
                                                       value="{{old('fromdateS')}}">
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label for="todateS">{{trans('booking.Bookings.todate')}} :</label>
                                                <input id="todateS" name="todateS" type="date"
                                                       class="form-control todateS valid"
                                                       value="{{old('todateS')}}">
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
                                                    <th width="30px"  >{{ trans('booking.Bookings.tables.id') }}</th>
                                                    <th class="text-center" width="150px">{{ trans('booking.Bookings.tables.pname') }}</th>
                                                    <th class="text-center" width="100px" >{{ trans('booking.Bookings.tables.fromdate') }}</th>
                                                    <th class="text-center" width="100px">{{ trans('booking.Bookings.tables.todate') }}</th>
                                                    <th class="text-center" width="120px" >{{ trans('booking.Bookings.tables.car') }}</th>
                                                    <th class="text-center" width="50px" >{{ trans('booking.Bookings.tables.status') }}</th>
                                                    <th class="text-center" width="80px">{{ trans('booking.Bookings.tables.bookingactions') }}</th>
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
                <input id="change_status_booking" type="hidden" value="{{url('/booking-status')}}">
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
    <script src={{ asset('adminassets/js/custom/booking.js') }}></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endpush





