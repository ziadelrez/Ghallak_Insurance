@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-accidents.menu.title') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
{{--    <link href="{{ URL::asset('css/customstyles.css') }}" rel="stylesheet" />--}}
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

    <div class="container-fluid">
        <form class="needs-validation" novalidate method="POST" action="{{ route("accidents.store") }}">
            {{--                {{ csrf_field() }}--}}
            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ trans('page-accidents.menu.titlecardpart1') }}</strong>
                        </div>
                        <div class="card-body">
                            {{--##AccDate & AccType--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="accdate"
                                               class="control-label mb-1">{{trans('page-accidents.fields.accdate')}}</label>
                                        <input id="accdate" name="accdate" type="date"
                                               class="form-control accdate valid"
                                               value="{{old('accdate')}}" required>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.accdate_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" data-label="2">
                                        <label class="required" class="control-label col-sm-4" for="accidenttype">{{trans('page-accidents.fields.accidenttype')}}</label>
                                        <select id="accidenttype" name="accidenttype" class="form-control p selectionaccidenttype"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($accidenttype as $acctypelist)
                                                <option value="{{$acctypelist -> id}}">{{$acctypelist -> Description}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.accidenttype_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--##Client Name--}}
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" data-label="100">
                                        <label class="required" class="control-label col-sm-4" for="client">{{trans('page-accidents.fields.cname')}}</label>
                                        <select id="client" name="client" class="form-control p selectionclient"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($clientslist as $nclist)
                                                <option value="{{$nclist -> id}}">{{$nclist -> cname}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.cname_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--##AccCar & InsName--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" data-label="100">
                                        <label class="required" class="control-label col-sm-4" for="car">{{trans('page-accidents.fields.car')}}</label>
                                        <select id="car" name="car" class="form-control p selectioncar"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($carslist as $acccar)
                                                <option value="{{$acccar -> id}}">{{$acccar -> carname}} - {{$acccar -> platnumber}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.car_required')}}
                                        </div>
                                        <div class="alert alert-danger" id="err_carvalidation" style="display:none">
                                            {{trans('validation.accidents.carvalidation_required')}}
                                        </div>
                                        <div class="alert alert-danger" id="err_insnotexist" style="display:none">
                                            {{trans('validation.accidents.insnotexist_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" data-label="200">
                                        <label class="required" class="control-label col-sm-4" for="insname">{{trans('page-accidents.fields.insname')}}</label>
                                        <select id="insname" name="insname" class="form-control p selectioninsname"
                                                aria-required="true" aria-invalid="false" required>


                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.insname_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--##Garage Name & AccReg--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" data-label="200">
                                        <label class="required" class="control-label col-sm-4" for="garage">{{trans('page-accidents.fields.garage')}}</label>
                                        <select id="garage" name="garage" class="form-control p selectiongarage"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($garagelist as $glist)
                                                <option value="{{$glist -> id}}">{{$glist -> cname}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.garage_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group" data-label="1">
                                        <label class="required" class="control-label col-sm-4" for="reg">{{trans('page-accidents.fields.reg')}}</label>
                                        <select id="reg" name="reg" class="form-control p selectionreg"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($reglist as $rlist)
                                                <option value="{{$rlist -> id}}">{{$rlist -> Description}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.reg_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--##Gcost & Gcurr--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="gcost" class="control-label mb-1">{{trans('page-accidents.fields.gcost')}}</label>
                                        <input id="gcost" name="gcost" type="number"
                                               class="form-control gcost valid" value="0" required>
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.gcost_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="4">
                                        <label class="required" class="control-label col-sm-4" for="gcurr">{{trans('page-accidents.fields.gcurr')}}</label>
                                        <select id="gcurr" name="gcurr" class="form-control p selectiongcurr"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($currlist as $gcurrlist)
                                                <option value="{{$gcurrlist -> id}}">{{$gcurrlist -> currname_eng}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.gcurr_required')}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{--##Gcost2 & Gcurr2--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="gcost2" class="control-label mb-1">{{trans('page-accidents.fields.gcost2')}}</label>
                                        <input id="gcost2" name="gcost2" type="number"
                                               class="form-control gcost2 valid" value="0" required>
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.gcost_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="4">
                                        <label class="required" class="control-label col-sm-4" for="gcurr2">{{trans('page-accidents.fields.gcurr')}}</label>
                                        <select id="gcurr2" name="gcurr2" class="form-control p selectiongcurr"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($currlist as $gcurrlist)
                                                <option value="{{$gcurrlist -> id}}" {{ $loop->first ? 'selected="selected"' : '' }}>{{$gcurrlist -> currname_eng}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.gcurr_required')}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{--##Accident Details--}}
                            <div class="row" id="rowdetails">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="details" class="control-label mb-1">{{trans('page-accidents.fields.details')}}</label>
                                        <textarea class="form-control rounded-0" name="details" id="details" rows="3" required>-</textarea>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.details_required')}}
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
                            <strong class="card-title">{{ trans('page-accidents.menu.titlecardpart2') }}</strong>
                        </div>
                        <div class="card-body">
                            {{--##Expert Name--}}
                            <div class="form-group" data-label="200" id="rowexpert">
                                <label class="required" class="control-label col-sm-4" for="expert">{{trans('page-accidents.fields.expert')}}</label>
                                <select id="expert" name="expert" class="form-control p selectionexpert"
                                        aria-required="true" aria-invalid="false" required>
                                    <option></option>
                                    @foreach($expertlist as $elist)
                                        <option value="{{$elist -> id}}" {{$elist->id == 1 ? 'selected' : '' }}>{{$elist -> cname}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{trans('validation.accidents.expert_required')}}
                                </div>
                            </div>

                            {{--##Ecost & Ecurr--}}
                            <div class="row" id="rowexpertdet">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="ecost" class="control-label mb-1">{{trans('page-accidents.fields.ecost')}}</label>
                                        <input id="ecost" name="ecost" type="number"
                                               class="form-control ecost valid" value="0" required>
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.ecost_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="4">
                                        <label class="required" class="control-label col-sm-4" for="ecurr">{{trans('page-accidents.fields.ecurr')}}</label>
                                        <select id="ecurr" name="ecurr" class="form-control p selectionecurr"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($currlist as $ecurrlist)
                                                <option value="{{$ecurrlist -> id}}" {{$ecurrlist->id == 1 ? 'selected' : '' }}>{{$ecurrlist -> currname_eng}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.ecurr_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--##Hospital Name--}}
                            <div class="form-group" data-label="3" id="rowhosp">
                                <label class="required" class="control-label col-sm-4" for="hospital">{{trans('page-accidents.fields.hospital')}}</label>
                                <select id="hospital" name="hospital" class="form-control p selectionhospital"
                                        aria-required="true" aria-invalid="false" required>
                                    <option></option>
                                    @foreach($hosplist as $hlist)
                                        <option value="{{$hlist -> id}}" {{$hlist->id == 1 ? 'selected' : '' }}>{{$hlist -> Description}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{trans('validation.accidents.hospital_required')}}
                                </div>
                            </div >

                            {{--##Hcost & Hcurr--}}
                            <div class="row" id="rowhospdet">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="hcost" class="control-label mb-1">{{trans('page-accidents.fields.hcost')}}</label>
                                        <input id="hcost" name="hcost" type="number"
                                               class="form-control hcost valid" value="0" required>
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.hcost_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="4">
                                        <label class="required" class="control-label col-sm-4" for="hcurr">{{trans('page-accidents.fields.hcurr')}}</label>
                                        <select id="hcurr" name="hcurr" class="form-control p selectionhcurr"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($currlist as $hcurrlist)
                                                <option value="{{$hcurrlist -> id}}" {{$hcurrlist->id == 1 ? 'selected' : '' }}>{{$hcurrlist -> currname_eng}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.hcurr_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--##Accident Company Code--}}
                            <div class="row" id="rowcompcode">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <label for="compacccode" class="control-label mb-1">{{ trans('page-accidents.fields.compacccode') }}</label>
                                        <input id="compacccode" name="compacccode" type="text"
                                               class="form-control compacccode valid" value="{{old('compacccode')}}" >
                                    </div>
                                </div>
                            </div>
                            <hr id="rowhr">
                            {{--##Total & Currency--}}
                            <div class="row" id="rowtotal">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="totalcost" class="control-label mb-1">{{trans('page-accidents.fields.totalcost')}}</label>
                                        <input id="totalcost" name="totalcost" type="number"
                                               class="form-control totalcost valid" value="0" required>
                                        <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                              data-valmsg-replace="true"></span>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.totalcost_required')}}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="4">
                                        <label class="required" class="control-label col-sm-4" for="tcurr">{{trans('page-accidents.fields.tcurr')}}</label>
                                        <select id="tcurr" name="tcurr" class="form-control p selectiontcurr"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($currlist as $tcurrlist)
                                                <option value="{{$tcurrlist -> id}}" {{$tcurrlist->id == 1 ? 'selected' : '' }}>{{$tcurrlist -> currname_eng}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.tcurr_required')}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{--##Accident Details--}}
                            <div class="row" id="rowgdetails">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="garagedetails" class="control-label mb-1">{{trans('page-accidents.fields.garagedetails')}}</label>
                                        <textarea class="form-control rounded-0" name="garagedetails" id="garagedetails" rows="18" required>إسم الخصم :&#13;&#10;رقم هاتف الخصم :&#13;&#10;نوع سيارة الخصم :&#13;&#10;رقم سيارة الخصم :&#13;&#10;تكلفة إصلاح سيارة الخصم :&#13;&#10;-----------&#13;&#10;إسم الخبير :&#13;&#10;رقم هاتف الخبير :&#13;&#10;كلفة الخبير :&#13;&#10;-----------&#13;&#10;تفاصيل الحادث :
                                        </textarea>
                                        <div class="invalid-feedback">
                                            {{trans('validation.accidents.garagedetails_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <button id="accsavebtn" class="btn btn-primary btn-block" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <a class="btn btn-danger btn-block" href="{{ route("accidents-list") }}">
                                            {{ trans('global.cancel') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </form>
    </div>

    <div class="hide" id="hidden-values">
        <input id="def_quick_add" type="hidden" value="{{url('/addNewValueDEFacc')}}">
        <input id="user_role_create" type="hidden" value="{{ $user_role[0]->role_id }} ">
        {{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
        {{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
        {{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
    </div>


@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/accidents.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
{{--    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>--}}
{{--    <script src={{ asset("adminassets/vendor/featherlight/featherlight.js") }}></script>--}}
{{--    @include('includes.adminpanel.userscript')--}}
@endpush



