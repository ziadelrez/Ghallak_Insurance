@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-companies.menu.companiesins-list') }}
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
                <div class="card-header py-3" >
                    <input id="companyid" type="hidden" name="companyid" value="{{$id}}">
                    <input id="company_ins_id" type="hidden" name="company_ins_id" value="">
                    <input id="cflag" type="hidden" name="cflag" value="0">
                    <div class="row" style="padding-bottom: 0px;">
                        <div class="col-12" >
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route("companies-list") }}">{{ trans('global.backtocompany') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('page-companies.pages.companiesins-list') }}<span style="color:black"> : </span><span style="color:red">{{$coname}}</span ></li>
{{--                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('page-companies.pages.companiesinscount') }} : <span id="total_records"></span></li>--}}
                                </ol>
                            </nav>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="card" >
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group" data-label="0">
                                            <label class="required" class="control-label col-sm-4" for="insname">{{trans('page-companies.pages.fields.insname')}}</label>
                                            <select id="insname" name="insname" class="form-control p selectioninsname"
                                                    aria-required="true" aria-invalid="false" >
                                                <option></option>
                                                @foreach($inslist as $ilist)
                                                    <option value="{{$ilist -> id}}">{{$ilist -> insname}}</option>
                                                @endforeach
                                            </select>

                                            <div class="alert alert-danger" id="err_details_insname" style="display:none">
                                                {{trans('validation.tabs.insname_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="cost"  class="required"  class="control-label mb-1">{{trans('page-companies.pages.fields.cost')}}</label>
                                            <input type="text" class="form-control"  id="cost" name="cost" >
                                            <div class="alert alert-danger" id="err_details_cost" style="display:none">
                                                {{trans('validation.tabs.cost_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="form-group" data-label="1">
                                            <label for="currcost"  class="required"  class="control-label mb-1">{{trans('page-companies.pages.fields.currcost')}}</label>
                                            <select id="currcost" name="currcost" class="form-control p selectioncurrcost"
                                                    aria-required="true" aria-invalid="false" >
                                                <option></option>
                                                @foreach($currlist as $culist)
                                                    <option value="{{$culist -> id}}">{{$culist -> currname_eng}}</option>
                                                @endforeach
                                            </select>
                                            <div class="alert alert-danger" id="err_details_currcost" style="display:none">
                                                {{trans('validation.tabs.currcost_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block" type="button" id="saveins">
                                                {{ trans('global.save') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <button class="btn btn-success btn-block" type="button" id="clearins">
                                                {{ trans('global.clear') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="bootstrap-data-table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="50px" >{{ trans('page-companies.pages.tables.id') }}</th>
                                <th>{{ trans('page-companies.pages.fields.insname') }}</th>
                                <th>{{ trans('page-companies.pages.fields.cost') }}</th>
                                <th>{{ trans('page-companies.pages.fields.currcost') }}</th>
                                @can('company_ins_actions')
                                    <th class="text-center" width="150px">{{ trans('page-companies.pages.tables.actions') }}</th>
                                @endcan
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
        <input id="def_quick_add" type="hidden" value="{{url('/addNewValueDEFINS')}}">
    </div>

@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/companies-ins.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





