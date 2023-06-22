@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('reports.Reports.cashier') }}
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
                                        <strong class="card-title">{{trans('reports.Reports.cashier')}}</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-6 col-xs-12">
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
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <label for="fromdate">{{trans('expenses.Expenses.fromdate')}} :</label>
                                                <input id="fromdate" name="fromdate" type="date"
                                                       class="form-control fromdate valid"
                                                       value="{{old('fromdate')}}">
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                                <label for="todate">{{trans('expenses.Expenses.todate')}} :</label>
                                                <input id="todate" name="todate" type="date"
                                                       class="form-control todate valid"
                                                       value="{{old('todate')}}">
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
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
                                                    <th width="30px"  style="display:none;">{{ trans('reports.Reports.tables.id') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trbranch') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trdate') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trname') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trclient') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.tramountin') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.tramountout') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.curr') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trtype') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trcheck') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trbank') }}</th>
                                                    <th class="text-center align-middle text-nowrap" >{{ trans('reports.Reports.tables.trdetails') }}</th>
                                                </tr>
                                                </thead>

                                                <tfoot>
                                                <tr>
                                                    <th id="trusdin" colspan="4" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_in') }} :</th>
                                                    <th id="trusdout" colspan="8" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_usd_out') }} :</th>
                                                </tr>
                                                <tr>
                                                    <th id="trlbpin" colspan="4" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_in') }} :</th>
                                                    <th id="trlbpout" colspan="8" style="text-align:right">{{ trans('page-contract.contract.tables.totalbills_lbp_out') }} :</th>
                                                </tr>
                                                </tfoot>

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
                <input id="total_bills_usd_in" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_usd_in') }}">
                <input id="total_bills_usd_out" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_usd_out') }}">
                <input id="total_bills_lbp_in" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_lbp_in') }}">
                <input id="total_bills_lbp_out" type="hidden" value="{{ trans('page-contract.contract.tables.totalbills_lbp_out') }}">
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
    <script src={{ asset('adminassets/js/custom/cashier.js') }}></script>
@endpush





