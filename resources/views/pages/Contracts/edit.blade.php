@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.contract.titleupdate') }}
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
            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('contract-car-details.update',$contractdetails[0]->id)}}" >
                {{--                {{ csrf_field() }}--}}
                <input id="contid" type="hidden" name="contid" value="{{$contractdetails[0]->cont}}">
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
                                                @if($carlist -> carid == $contractdetails[0]->car)
                                                    <option selected
                                                            value="{{$carlist -> carid}}">{{$carlist -> carname}} - {{$carlist -> carnumber}} , {{$carlist -> carcolor}} , {{$carlist -> caryear}} </option>
                                                @else
                                                    <option
                                                        value="{{$carlist -> carid}}">{{$carlist -> carname}} - {{$carlist -> carnumber}} , {{$carlist -> carcolor}} , {{$carlist -> caryear}} </option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                                       value="{{$contractdetails[0]->dateout}}" required>
{{--                                                @error('dateout')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.dateout_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                       value="{{$contractdetails[0]->timeout}}" required>
{{--                                                @error('timeout')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.timeout_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                       value="{{$contractdetails[0]->datein}}" required>
{{--                                                @error('datein')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.datein_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                       value="{{$contractdetails[0]->timein}}" required>
{{--                                                @error('timein')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.timein_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                       class="form-control days valid" value="{{$contractdetails[0]->days}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('days')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.days_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.days_required')}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="dayrate" class="control-label mb-1">{{trans('page-contract.contract.fields.dayrate')}}</label>
                                                <input id="dayrate" name="dayrate" type="number"
                                                       class="form-control dayrate valid" value="{{$contractdetails[0]->dayrate}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('dayrate')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.dayrate_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                       class="form-control deposit valid" value="{{$contractdetails[0]->deposit}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('deposit')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.deposit_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                        @if($culist -> id == $contractdetails[0]->depcurr)
                                                            <option selected
                                                                    value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                        @else
                                                            <option
                                                                value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>

{{--                                                @error('depcurr')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.curr_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                       class="form-control kmsout valid" value="{{$contractdetails[0]->kmsout}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('kmsout')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.kmsout_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.contractsdet.kmsout_required')}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="kmsin" class="control-label mb-1">{{trans('page-contract.contract.fields.kmsin')}}</label>
                                                <input id="kmsin" name="kmsin" type="number"
                                                       class="form-control kmsin valid" value="{{$contractdetails[0]->kmsin}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('kmsin')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.contractsdet.kmsin_required')}}</small>--}}
{{--                                                @enderror--}}
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
                                                   class="form-control gas valid" value="{{$contractdetails[0]->gas}}" required>
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
                                                   class="form-control gascost valid" value="{{$contractdetails[0]->gascost}}" required>
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
                                        <br>
                                        <div class="form-group ">
                                            <input name="driver" id="driver" type="checkbox"
                                                   @if(isset($contractdetails[0]->driver))
                                                   {!!  $contractdetails[0]->driver ? "checked" : ""!!}
                                                   @endif;
                                                   class="switchery">
                                            <label for="driver" class="card-title ">{{trans('page-contract.contract.fields.driver')}} </label>

                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="drivercost" class="control-label mb-1">{{trans('page-contract.contract.fields.drivercost')}}</label>
                                            <input id="drivercost" name="drivercost" type="number"
                                                   class="form-control drivercost valid" value="{{$contractdetails[0]->drivercost}}" required>
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
                                                   class="form-control stotal valid" value="{{$contractdetails[0]->stotal}}" required>
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
                                                    @if($culist -> id == $contractdetails[0]->curr)
                                                        <option selected
                                                                value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                    @else
                                                        <option
                                                            value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                    @endif
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
                                    <button class="btn btn-primary" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                    <a class="btn btn-danger" href="{{ route('contract-details',$contractdetails[0]->cont)}}">
                                        {{ trans('global.cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </form>
        </div>
        </div><!-- .animated -->
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



