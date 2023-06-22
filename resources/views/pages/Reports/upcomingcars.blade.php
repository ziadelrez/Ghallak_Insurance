@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('reports.Reports.titlecomingcars') }}
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
                                        <strong class="card-title">{{trans('reports.Reports.exptitlecard2')}}</strong>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label for="carname" class="control-label mb-1">{{ trans('reports.Reports.fields.carname') }}</label>
                                                <input id="carname" name="carname" type="text"
                                                       class="form-control carname valid" value="{{old('carname')}}" >
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label for="clientname" class="control-label mb-1">{{ trans('reports.Reports.fields.clientname') }}</label>
                                                <input id="clientname" name="clientname" type="text"
                                                       class="form-control clientname valid" value="{{old('clientname')}}" >
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <label for="brname" class="control-label mb-1">{{ trans('reports.Reports.fields.branchname') }}</label>
                                                <input id="brname" name="brname" type="text"
                                                       class="form-control brname valid" value="{{old('brname')}}" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <button class="btn btn-success btn-block btn-space-up" type="button" id="searchupcomingtoday">
                                                        <i class="fa fa-search"></i> {{ trans('global.upcomingcarstoday') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-block btn-space-up" type="button" id="searchexp">
                                                        <i class="fa fa-search"></i> {{ trans('global.search') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="bootstrap-data-table"  cellspacing="0" >
                                                <thead>
                                                <tr>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.contid') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.brname') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.contractdate') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.clientname') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.carname') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.cardays') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.takendate') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.takentime') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.returndate') }}</th>
                                                    <th class="text-center align-middle text-nowrap">{{ trans('reports.Reports.tables.returntime') }}</th>
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
                <input id="fromdateS" name="fromdateS" type="date"
                       class="form-control fromdateS valid"
                       value="{{old('fromdateS')}}">
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
    <script src={{ asset('adminassets/js/custom/upcomingcars.js') }}></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
@endpush





