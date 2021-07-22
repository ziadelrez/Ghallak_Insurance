@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.contract.titleactions') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">--}}
@endpush

@section('content')

    @include('includes.adminpanel.header')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="breadcrumbs">

        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">

                </div>
            </div>
        </div>
    </div>
    <div class="content mt-1">
        <div class="animated fadeIn">

        <div class="container">
            <input id="contdetid" type="hidden" name="contdetid" value="{{$carsname[0]->codetid}}">
            <input id="cflag" type="hidden" name="cflag" value="0">
            <input id="cflagspeed" type="hidden" name="cflagspeed" value="0">
            <input id="cflagfailure" type="hidden" name="cflagfailure" value="0">
            <input id="cflagdocument" type="hidden" name="cflagdocument" value="0">
            <input id="accid" type="hidden" name="accid" value="">
            <input id="speedid" type="hidden" name="speedid" value="">
            <input id="failureid" type="hidden" name="failureid" value="">
{{--            <div><h4><span style="color:black">{{ trans('page-contract.contract.tabs.titlehead') }} : </span><span style="color:red">{{$carsname[0]->carname}} ( {{$carsname[0]->carnumber}} ) , {{$carsname[0]->carcolor}} - {{$carsname[0]->carmodel}}</span></h4></div>--}}
{{--            <h6><a href="{{ route('contract-details',$carsname[0]->contid)}}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtocontractdetails') }}</a></h6>--}}

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('contract-details',$carsname[0]->contid)}}">{{ trans('global.backtocontractdetails') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('page-contract.contract.tabs.titlehead') }}<span style="color:black"> : </span><span style="color:red">{{$carsname[0]->carname}} ( {{$carsname[0]->carnumber}} ) , {{$carsname[0]->carcolor}} - {{$carsname[0]->carmodel}}</span ></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <hr>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-accident-tab" data-toggle="tab" href="#nav-accident" role="tab" aria-controls="nav-accident" aria-selected="true"><i class="fa fa-car-crash"></i> {{ trans('page-contract.contract.tabs.accident') }}</a>
                    <a class="nav-item nav-link" id="nav-speed-tab" data-toggle="tab" href="#nav-speed" role="tab" aria-controls="nav-speed" aria-selected="false"><i class="fa fa-tachometer-alt"></i> {{ trans('page-contract.contract.tabs.speed') }}</a>
                    <a class="nav-item nav-link" id="nav-failure-tab" data-toggle="tab" href="#nav-failure" role="tab" aria-controls="nav-failure" aria-selected="false"><i class="fa fa-car-battery"></i> {{ trans('page-contract.contract.tabs.failure') }}</a>
                    <a class="nav-item nav-link" id="nav-document-tab" data-toggle="tab" href="#nav-document" role="tab" aria-controls="nav-document" aria-selected="false"><i class="fa fa-file-upload"></i> {{ trans('page-contract.contract.tabs.document') }}</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-accident" role="tabpanel" aria-labelledby="nav-accident-tab">
                    <br>
                    <form method="POST" action="">
                        {{--                {{ csrf_field() }}--}}

{{--                        <input id="contract_id" type="hidden" name="contract_id" value="">--}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.tabaccident')}}</strong>
                                    </div>

                                    <!-- Credit Card -->
                                    <div id="pay-invoice">
                                        <div class="card-body">
                                            {{--## Accident Location--}}
                                            <div class="form-group" data-label="1">
                                                <label class="required" class="control-label col-sm-4" for="location1">{{trans('page-contract.contract.tabs.accidentlocation')}}</label>
                                                <select id="location1" name="location1" class="form-control p selectionlocation1"
                                                        aria-required="true" aria-invalid="false">
                                                    <option></option>
                                                    @foreach($locationlist as $loclist)
                                                        <option value="{{$loclist -> id}}">{{$loclist -> Description}} </option>
                                                    @endforeach
                                                </select>

                                                <div class="alert alert-danger" id="err_details_location1" style="display:none">
                                                    {{trans('validation.tabs.accident_location_required')}}
                                                </div>
                                            </div>

                                            {{--##Accident Date--}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actiondate1"
                                                               class="control-label mb-1">{{trans('page-contract.contract.tabs.accidentdate')}}</label>
                                                        <input id="actiondate1" name="actiondate1" type="date"
                                                               class="form-control actiondate1 valid"
                                                               value="{{old('actiondate1')}}">

                                                        <div class="alert alert-danger" id="err_details_actiondate1" style="display:none">
                                                            {{trans('validation.tabs.accident_date_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--##Accident Details--}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actiondetails1" class="control-label mb-1">{{trans('page-contract.contract.tabs.accidentdetails')}}</label>
                                                        <textarea  id="actiondetails1" name="actiondetails1"
                                                                   class="form-control actiondetails1 valid" >-</textarea>
                                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-actiondetails1"
                                                              data-valmsg-replace="true"></span>

                                                        <div class="alert alert-danger" id="err_details_actiondetails1" style="display:none">
                                                            {{trans('validation.tabs.accident_details_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--##Accident Cost & Currency--}}
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actioncost1" class="control-label mb-1">{{trans('page-contract.contract.tabs.accidentcost')}}</label>
                                                        <input id="actioncost1" name="actioncost1" type="number"
                                                               class="form-control actioncost1 valid" value="0">
                                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-actioncost1"
                                                              data-valmsg-replace="true"></span>

                                                        <div class="alert alert-danger" id="err_details_actioncost1" style="display:none">
                                                            {{trans('validation.tabs.accident_cost_required')}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group" data-label="0">
                                                        <label class="required" class="control-label col-sm-4" for="actioncurr1">{{trans('page-contract.contract.tabs.accidentcurr')}}</label>
                                                        <select id="actioncurr1" name="actioncurr1" class="form-control p selectionacccurr1"
                                                                aria-required="true" aria-invalid="false">
                                                            <option></option>
                                                            @foreach($currlist as $culist)
                                                                <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                            @endforeach
                                                        </select>

                                                        <div class="alert alert-danger" id="err_details_actioncurr1" style="display:none">
                                                            {{trans('validation.tabs.accident_curr_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-group">
                                            <button class="btn btn-info" type="button" id="clearaccident">
                                                 {{ trans('global.clearaccident') }}
                                            </button>

                                            <button class="btn btn-primary" type="button" id="saveaccident">
                                                {{ trans('global.save') }}
                                            </button>
                                        </div>
                                    </div>

                                </div> <!-- .card -->

                            </div><!--/.col-->

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.tabaccident-det')}}</strong>
                                    </div>
                                    <div class="card-body">
                                        {{--##Accident list--}}
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tableaccident" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tabs.id') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tabs.accidentlocation') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tabs.accidentdate') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="120px">{{ trans('page-contract.contract.tabs.accidentcost') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="50px">{{ trans('page-contract.contract.tabs.accidentcurr') }}</th>
                                                    <th class="text-center" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.actions') }}</th>
                                                </tr>
                                                </thead>

                                                <tbody>
{{--                                                <tr class="accidentrows">--}}
{{--                                                    <td style="display:none;" ></td>--}}
{{--                                                    <td class="text-center" style="vertical-align: middle" width="150px"></td>--}}
{{--                                                    <td class="text-center" style="vertical-align: middle" width="150px"></td>--}}
{{--                                                    <td class="text-center" style="vertical-align: middle" width="120px"></td>--}}
{{--                                                    <td class="text-center" style="vertical-align: middle" width="50px"></td>--}}
{{--                                                    <td class="text-center" width="100px">--}}
{{--                                                        <button type="button"   class="edit-btn btn btn-warning btn-sm" data-id="" title="{{ trans('page-contract.contract.tabs.editaccident') }}">--}}
{{--                                                            <i class="fa fa-edit"></i>--}}
{{--                                                        </button>--}}

{{--                                                        <button type="button" class="delete-btn btn btn-danger btn-sm" data-id="" title="{{ trans('page-contract.contract.tabs.deleteaccident') }}">--}}
{{--                                                            <i class="fas fa-trash"></i>--}}
{{--                                                        </button>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}

                                                </tbody>
                                            </table>
                                            <input type="hidden" id="cdetails" value="{{url('/contract-details')}}">
                                            <input type="hidden" id="t1" value="{{ trans('page-contract.contract.titles.cdetails') }}">
                                            <input type="hidden" id="t2" value="{{ trans('page-contract.contract.titles.adddriver') }}">
                                            <input type="hidden" id="t3" value="{{ trans('page-contract.contract.titles.cpayments') }}">
                                            <input type="hidden" id="t4" value="{{ trans('page-contract.contract.titles.editcontract') }}">
                                            <input type="hidden" id="t5" value="{{ trans('page-contract.contract.titles.deletecontract') }}">
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>

                    </form>
                </div>
                <div class="tab-pane fade" id="nav-speed" role="tabpanel" aria-labelledby="nav-speed-tab">
                    <br>
                    <form method="POST" action="">
                        {{--                {{ csrf_field() }}--}}

                        {{--                        <input id="contract_id" type="hidden" name="contract_id" value="">--}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.tabspeed')}}</strong>
                                    </div>

                                    <!-- Credit Card -->
                                    <div id="pay-invoice">
                                        <div class="card-body">
                                            {{--## Speed Location--}}
                                            <div class="form-group" data-label="2">
                                                <label class="required" class="control-label col-sm-4" for="location2">{{trans('page-contract.contract.tabs.speedlocation')}}</label>
                                                <select id="location2" name="location2" class="form-control p selectionlocation2"
                                                        aria-required="true" aria-invalid="false">
                                                    <option></option>
                                                    @foreach($locationlist as $loclist)
                                                        <option value="{{$loclist -> id}}">{{$loclist -> Description}} </option>
                                                    @endforeach
                                                </select>

                                                <div class="alert alert-danger" id="err_details_location2" style="display:none">
                                                    {{trans('validation.tabs.speed_location_required')}}
                                                </div>
                                            </div>

                                            {{--##Speed Date--}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actiondate2"
                                                               class="control-label mb-1">{{trans('page-contract.contract.tabs.speeddate')}}</label>
                                                        <input id="actiondate2" name="actiondate2" type="date"
                                                               class="form-control actiondate2 valid"
                                                               value="{{old('actiondate2')}}">

                                                        <div class="alert alert-danger" id="err_details_actiondate2" style="display:none">
                                                            {{trans('validation.tabs.speed_date_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--##Speed Details--}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actiondetails2" class="control-label mb-1">{{trans('page-contract.contract.tabs.speeddetails')}}</label>
                                                        <textarea  id="actiondetails2" name="actiondetails2"
                                                                   class="form-control actiondetails2 valid" >-</textarea>
                                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-actiondetails2"
                                                              data-valmsg-replace="true"></span>

                                                        <div class="alert alert-danger" id="err_details_actiondetails2" style="display:none">
                                                            {{trans('validation.tabs.speed_details_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--##Speed Cost & Currency--}}
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actioncost2" class="control-label mb-1">{{trans('page-contract.contract.tabs.speedcost')}}</label>
                                                        <input id="actioncost2" name="actioncost2" type="number"
                                                               class="form-control actioncost2 valid" value="0">
                                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-actioncost2"
                                                              data-valmsg-replace="true"></span>

                                                        <div class="alert alert-danger" id="err_details_actioncost2" style="display:none">
                                                            {{trans('validation.tabs.speed_cost_required')}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group" data-label="0">
                                                        <label class="required" class="control-label col-sm-4" for="actioncurr2">{{trans('page-contract.contract.tabs.speedcurr')}}</label>
                                                        <select id="actioncurr2" name="actioncurr2" class="form-control p selectionacccurr2"
                                                                aria-required="true" aria-invalid="false">
                                                            <option></option>
                                                            @foreach($currlist as $culist)
                                                                <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                            @endforeach
                                                        </select>

                                                        <div class="alert alert-danger" id="err_details_actioncurr2" style="display:none">
                                                            {{trans('validation.tabs.speed_curr_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-group">
                                            <button class="btn btn-info" type="button" id="clearspeed">
                                                {{ trans('global.clearspeed') }}
                                            </button>

                                            <button class="btn btn-primary" type="button" id="savespeed">
                                                {{ trans('global.save') }}
                                            </button>
                                        </div>
                                    </div>

                                </div> <!-- .card -->

                            </div><!--/.col-->

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.tabspeed-det')}}</strong>
                                    </div>
                                    <div class="card-body">
                                        {{--##Accident list--}}
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tablespeed" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tabs.id') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tabs.speedlocation') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tabs.speeddate') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="120px">{{ trans('page-contract.contract.tabs.speedcost') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="50px">{{ trans('page-contract.contract.tabs.speedcurr') }}</th>
                                                    <th class="text-center" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.actions') }}</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                {{--                                                <tr class="accidentrows">--}}
                                                {{--                                                    <td style="display:none;" ></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="150px"></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="150px"></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="120px"></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="50px"></td>--}}
                                                {{--                                                    <td class="text-center" width="100px">--}}
                                                {{--                                                        <button type="button"   class="edit-btn btn btn-warning btn-sm" data-id="" title="{{ trans('page-contract.contract.tabs.editaccident') }}">--}}
                                                {{--                                                            <i class="fa fa-edit"></i>--}}
                                                {{--                                                        </button>--}}

                                                {{--                                                        <button type="button" class="delete-btn btn btn-danger btn-sm" data-id="" title="{{ trans('page-contract.contract.tabs.deleteaccident') }}">--}}
                                                {{--                                                            <i class="fas fa-trash"></i>--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                    </td>--}}
                                                {{--                                                </tr>--}}

                                                </tbody>
                                            </table>
                                            {{--                                        <input type="hidden" id="cdetails" value="{{url('/contract-details')}}">--}}
                                            {{--                                        <input type="hidden" id="t1" value="{{ trans('page-contract.contract.titles.cdetails') }}">--}}
                                            {{--                                        <input type="hidden" id="t2" value="{{ trans('page-contract.contract.titles.adddriver') }}">--}}
                                            {{--                                        <input type="hidden" id="t3" value="{{ trans('page-contract.contract.titles.cpayments') }}">--}}
                                            {{--                                        <input type="hidden" id="t4" value="{{ trans('page-contract.contract.titles.editcontract') }}">--}}
                                            {{--                                        <input type="hidden" id="t5" value="{{ trans('page-contract.contract.titles.deletecontract') }}">--}}
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>

                    </form>
                </div>

                <div class="tab-pane fade" id="nav-failure" role="tabpanel" aria-labelledby="nav-failure-tab">
                    <br>
                    <form method="POST" action="">
                        {{--                {{ csrf_field() }}--}}

                        {{--                        <input id="contract_id" type="hidden" name="contract_id" value="">--}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.tabfailure')}}</strong>
                                    </div>

                                    <!-- Credit Card -->
                                    <div id="pay-invoice">
                                        <div class="card-body">
                                            {{--## Speed Location--}}
                                            <div class="form-group" data-label="3">
                                                <label class="required" class="control-label col-sm-4" for="location3">{{trans('page-contract.contract.tabs.failurelocation')}}</label>
                                                <select id="location3" name="location3" class="form-control p selectionlocation3"
                                                        aria-required="true" aria-invalid="false">
                                                    <option></option>
                                                    @foreach($locationlist as $loclist)
                                                        <option value="{{$loclist -> id}}">{{$loclist -> Description}} </option>
                                                    @endforeach
                                                </select>

                                                <div class="alert alert-danger" id="err_details_location3" style="display:none">
                                                    {{trans('validation.tabs.failure_location_required')}}
                                                </div>
                                            </div>

                                            {{--##Speed Date--}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actiondate3"
                                                               class="control-label mb-1">{{trans('page-contract.contract.tabs.failuredate')}}</label>
                                                        <input id="actiondate3" name="actiondate3" type="date"
                                                               class="form-control actiondate3 valid"
                                                               value="{{old('actiondate3')}}">

                                                        <div class="alert alert-danger" id="err_details_actiondate3" style="display:none">
                                                            {{trans('validation.tabs.failure_date_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--##Speed Details--}}
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actiondetails3" class="control-label mb-1">{{trans('page-contract.contract.tabs.failuredetails')}}</label>
                                                        <textarea  id="actiondetails3" name="actiondetails3"
                                                                   class="form-control actiondetails3 valid" >-</textarea>
                                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-actiondetails3"
                                                              data-valmsg-replace="true"></span>

                                                        <div class="alert alert-danger" id="err_details_actiondetails3" style="display:none">
                                                            {{trans('validation.tabs.failure_details_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--##Speed Cost & Currency--}}
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group has-success">
                                                        <label class="required" for="actioncost3" class="control-label mb-1">{{trans('page-contract.contract.tabs.failurecost')}}</label>
                                                        <input id="actioncost3" name="actioncost3" type="number"
                                                               class="form-control actioncost3 valid" value="0">
                                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-actioncost3"
                                                              data-valmsg-replace="true"></span>

                                                        <div class="alert alert-danger" id="err_details_actioncost3" style="display:none">
                                                            {{trans('validation.tabs.failure_cost_required')}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="form-group" data-label="0">
                                                        <label class="required" class="control-label col-sm-4" for="actioncurr3">{{trans('page-contract.contract.tabs.failurecurr')}}</label>
                                                        <select id="actioncurr3" name="actioncurr3" class="form-control p selectionacccurr3"
                                                                aria-required="true" aria-invalid="false">
                                                            <option></option>
                                                            @foreach($currlist as $culist)
                                                                <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                            @endforeach
                                                        </select>

                                                        <div class="alert alert-danger" id="err_details_actioncurr3" style="display:none">
                                                            {{trans('validation.tabs.failure_curr_required')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="form-group">
                                            <button class="btn btn-info" type="button" id="clearfailure">
                                                {{ trans('global.clearfailure') }}
                                            </button>

                                            <button class="btn btn-primary" type="button" id="savefailure">
                                                {{ trans('global.save') }}
                                            </button>
                                        </div>
                                    </div>

                                </div> <!-- .card -->

                            </div><!--/.col-->

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">{{trans('page-contract.contract.tabfailure-det')}}</strong>
                                    </div>
                                    <div class="card-body">
                                        {{--##Accident list--}}
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="tablefailure" width="100%" cellspacing="0">
                                                <thead>
                                                <tr>
                                                    <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tabs.id') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tabs.failurelocation') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="150px">{{ trans('page-contract.contract.tabs.failuredate') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="120px">{{ trans('page-contract.contract.tabs.failurecost') }}</th>
                                                    <th class="text-center " style="vertical-align: middle" width="50px">{{ trans('page-contract.contract.tabs.failurecurr') }}</th>
                                                    <th class="text-center" style="vertical-align: middle" width="100px">{{ trans('page-contract.contract.tables.actions') }}</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                {{--                                                <tr class="accidentrows">--}}
                                                {{--                                                    <td style="display:none;" ></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="150px"></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="150px"></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="120px"></td>--}}
                                                {{--                                                    <td class="text-center" style="vertical-align: middle" width="50px"></td>--}}
                                                {{--                                                    <td class="text-center" width="100px">--}}
                                                {{--                                                        <button type="button"   class="edit-btn btn btn-warning btn-sm" data-id="" title="{{ trans('page-contract.contract.tabs.editaccident') }}">--}}
                                                {{--                                                            <i class="fa fa-edit"></i>--}}
                                                {{--                                                        </button>--}}

                                                {{--                                                        <button type="button" class="delete-btn btn btn-danger btn-sm" data-id="" title="{{ trans('page-contract.contract.tabs.deleteaccident') }}">--}}
                                                {{--                                                            <i class="fas fa-trash"></i>--}}
                                                {{--                                                        </button>--}}
                                                {{--                                                    </td>--}}
                                                {{--                                                </tr>--}}

                                                </tbody>
                                            </table>
                                            {{--                                        <input type="hidden" id="cdetails" value="{{url('/contract-details')}}">--}}
                                            {{--                                        <input type="hidden" id="t1" value="{{ trans('page-contract.contract.titles.cdetails') }}">--}}
                                            {{--                                        <input type="hidden" id="t2" value="{{ trans('page-contract.contract.titles.adddriver') }}">--}}
                                            {{--                                        <input type="hidden" id="t3" value="{{ trans('page-contract.contract.titles.cpayments') }}">--}}
                                            {{--                                        <input type="hidden" id="t4" value="{{ trans('page-contract.contract.titles.editcontract') }}">--}}
                                            {{--                                        <input type="hidden" id="t5" value="{{ trans('page-contract.contract.titles.deletecontract') }}">--}}
                                        </div>

                                    </div>

                                </div>
                            </div>


                        </div>

                    </form>
                </div>
                <div class="tab-pane fade" id="nav-document" role="tabpanel" aria-labelledby="nav-document-tab">
                    ...</div>
            </div>

        </div>
        </div><!-- .animated -->
        <div class="hide" id="hidden-values">
            <input id="def_quick_add" type="hidden" value="{{url('/addNewValueProcLocation')}}">
{{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
{{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
{{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
{{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
        </div>
    </div><!-- .content -->

@endsection

@push('js_content')
{{--    <script src={{ asset('adminassets/js/custom/newcontractdet.js') }}></script>--}}
    <script src={{ asset('adminassets/js/custom/cprocedures.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>--}}
@endpush



