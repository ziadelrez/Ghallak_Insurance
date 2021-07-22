@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.contract.title') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
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
{{--            @if($errors->any())--}}
{{--                <div class="row">--}}
{{--                    <div class="col-lg-12">--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header card-error">--}}
{{--                                <strong class="card-title">{{trans('global.VALIDATION')}}</strong>--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <!-- Credit Card -->--}}
{{--                                <ul class="alert alert-danger">--}}
{{--                                    @foreach($errors->all() as $error)--}}
{{--                                        <li>--}}
{{--                                            {{ $error }}--}}
{{--                                        </li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div> <!-- .card -->--}}

{{--                    </div><!--/.col-->--}}
{{--                </div>--}}
{{--            @endif--}}
        <div class="container">
            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route("contract-car-details.store") }}">
{{--                {{ csrf_field() }}--}}
                <input id="contid" type="hidden" name="contid" value="{{$contract_id}}">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-contract.contract.newcontract')}} - {{ trans('page-contract.contract.titlecard') }}</strong>
                            </div>

                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        {{--##Select Car--}}
                                        <div class="form-group" data-label="1">
                                            <label class="required" class="control-label col-sm-4" for="carname">{{trans('page-contract.contract.fields.carname')}}</label>
                                            <select id="carname" name="carname" class="form-control p selectioncarname"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($carslist as $carlist)
                                                    <option value="{{$carlist -> carid}}">{{$carlist -> carname}} - {{$carlist -> carnumber}} , {{$carlist -> carcolor}} , {{$carlist -> caryear}} </option>
                                                @endforeach
                                            </select>
{{--                                            @error('carname')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.carname_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.carname_required')}}
                                            </div>
                                        </div>

                                        {{--##Date & TIME Out--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="dateout"
                                                           class="control-label mb-1">{{trans('page-contract.contract.fields.dateout')}}</label>
                                                    <input id="dateout" name="dateout" type="date"
                                                           class="form-control dateout valid"
                                                           value="{{old('dateout')}}" required>
{{--                                                    @error('dateout')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.dateout_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.dateout_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="timeout"
                                                           class="control-label mb-1">{{trans('page-contract.contract.fields.timeout')}}</label>
                                                    <input id="timeout" name="timeout" type="time"
                                                           class="form-control timeout valid"
                                                           value="{{old('timeout')}}" required>
{{--                                                    @error('timeout')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.timeout_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.timeout_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Date & TIME IN--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="datein"
                                                           class="control-label mb-1">{{trans('page-contract.contract.fields.datein')}}</label>
                                                    <input id="datein" name="datein" type="date"
                                                           class="form-control datein valid"
                                                           value="{{old('datein')}}" required>
{{--                                                    @error('datein')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.datein_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.datein_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="timein"
                                                           class="control-label mb-1">{{trans('page-contract.contract.fields.timein')}}</label>
                                                    <input id="timein" name="timein" type="time"
                                                           class="form-control timeout valid"
                                                           value="{{old('timein')}}" required>
{{--                                                    @error('timein')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.timein_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.timein_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Days & Rates--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="days" class="control-label mb-1">{{trans('page-contract.contract.fields.days')}}</label>
                                                    <input id="days" name="days" type="number"
                                                           class="form-control days valid" value="0" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>
{{--                                                    @error('days')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.days_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.days_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="dayrate" class="control-label mb-1">{{trans('page-contract.contract.fields.dayrate')}}</label>
                                                    <input id="dayrate" name="dayrate" type="number"
                                                           class="form-control dayrate valid" value="0" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>
{{--                                                    @error('dayrate')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.dayrate_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.dayrate_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Deposit & DEPOSIT Currency--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="deposit" class="control-label mb-1">{{trans('page-contract.contract.fields.deposit')}}</label>
                                                    <input id="deposit" name="deposit" type="number"
                                                           class="form-control deposit valid" value="0" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>
{{--                                                    @error('deposit')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.deposit_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.deposit_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="depcurr">{{trans('page-contract.contract.fields.curr')}}</label>
                                                    <select id="depcurr" name="depcurr" class="form-control p "
                                                            aria-required="true" aria-invalid="false" required>
                                                        <option></option>
                                                        @foreach($currlist as $culist)
                                                            <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                        @endforeach
                                                    </select>

{{--                                                    @error('depcurr')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.curr_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.curr_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##KMS Out & IN--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="kmsout" class="control-label mb-1">{{trans('page-contract.contract.fields.kmsout')}}</label>
                                                    <input id="kmsout" name="kmsout" type="number"
                                                           class="form-control kmsout valid" value="0" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>
{{--                                                    @error('kmsout')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.kmsout_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.kmsout_required')}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="kmsin" class="control-label mb-1">{{trans('page-contract.contract.fields.kmsin')}}</label>
                                                    <input id="kmsin" name="kmsin" type="number"
                                                           class="form-control kmsin valid" value="0" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>
{{--                                                    @error('kmsin')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.contractsdet.kmsin_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.contractsdet.kmsin_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                        </div> <!-- .card -->

                    </div><!--/.col-->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-contract.contract.newcontract')}} - {{ trans('page-contract.contract.titlecard') }}</strong>
                            </div>
                            <div class="card-body">
                                {{--##GAS & GAScost--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="gas" class="control-label mb-1">{{trans('page-contract.contract.fields.gas')}}</label>
                                            <input id="gas" name="gas" type="number"
                                                   class="form-control gas valid" value="0" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
{{--                                            @error('gas')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.gas_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.gas_required')}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="gascost" class="control-label mb-1">{{trans('page-contract.contract.fields.gascost')}}</label>
                                            <input id="gascost" name="gascost" type="number"
                                                   class="form-control gascost valid" value="0" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
{{--                                            @error('gascost')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.gascost_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.gascost_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                {{--##Driver & Drivercost--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group ">
                                            <br>
                                            <input type="checkbox"  name="driver" id="driver"
                                                   class="switchery" data-color="success" {{ old('driver') ? 'checked' : '' }} />
                                            <label for="driver" class="card-title ">{{trans('page-contract.contract.fields.driver')}} </label>
{{--                                            @error('driver')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.driver_required')}}</small>--}}
{{--                                            @enderror--}}
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="drivercost" class="control-label mb-1">{{trans('page-contract.contract.fields.drivercost')}}</label>
                                            <input id="drivercost" name="drivercost" type="number"
                                                   class="form-control drivercost valid" value="0" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
{{--                                            @error('drivercost')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.drivercost_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.drivercost_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                {{--##Total & Currency--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="stotal" class="control-label mb-1">{{trans('page-contract.contract.fields.stotal')}}</label>
                                            <input id="stotal" name="stotal" type="number"
                                                   class="form-control stotal valid" value="0" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
{{--                                            @error('stotal')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.stotal_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.stotal_required')}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" data-label="2">
                                            <label class="required" class="control-label col-sm-4" for="curr">{{trans('page-contract.contract.fields.curr')}}</label>
                                            <select id="curr" name="curr" class="form-control p "
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($currlist as $culist)
                                                    <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                @endforeach
                                            </select>

{{--                                            @error('curr')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.curr_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.contractsdet.curr_required')}}
                                            </div>
                                        </div>
                                    </div>

                                </div>

                              <div class="myDivCarDetails" id="deposit_id"  style="display:none" ></div>

                            </div>
                            <div class="card-footer">
                                <div class="form-group">
                                    <a class="btn btn-success" id="calculate_btn" href="javascript:;">
                                        <i class="fas fa-calculator"></i>  {{ trans('global.calculate') }}
                                    </a> ||
                                    <button class="btn btn-primary" type="submit" disabled id="btn_save">
                                        {{ trans('global.save') }}
                                    </button>
                                    <a class="btn btn-danger" href="{{ route('contract-details',$contract_id)}}">
                                        {{ trans('global.cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </form>

            </div><!-- .animated -->
        </div>

        <div class="hide" id="hidden-values">
            <input id="def_quick_add" type="hidden" value="{{url('/addNewValueDEF')}}">
            <input id="deposit_id_lbl" type="hidden" value="{{ trans('page-contract.contract.fields.deposit')}}">
{{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
{{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
{{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
{{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
        </div>
    </div><!-- .content -->

@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/newcontractdet.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush



