@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-cars.cars.title') }}
@endsection

@push('css_content')
    <link href="{{ URL::asset('css/customstyles.css') }}" rel="stylesheet" />
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
    <div class="content mt-3">
        <div class="animated fadeIn">
            @if($errors->any())
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            {{--                            <div class="card-header card-error">--}}
                            {{--                                <strong class="card-title">{{trans('global.VALIDATION')}}</strong>--}}
                            {{--                            </div>--}}
                            <div class="card-body">
                                <!-- Credit Card -->
                                {{--                                <ul class="alert alert-danger">--}}
                                {{--                                    @foreach($errors->all() as $error)--}}
                                {{--                                        <li>--}}
                                {{--                                            {{ $error }}--}}
                                {{--                                        </li>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </ul>--}}
                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->
                </div>
            @endif
            <div class="container">
                <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route("cars.store") }}" enctype="multipart/form-data">
                    {{--                {{ csrf_field() }}--}}
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">{{trans('page-cars.cars.newcar')}} - {{ trans('page-cars.cars.titlecard') }}</strong>
                                </div>

                                <!-- Credit Card -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Car name--}}
                                            <div class="form-group has-success">
                                                <label class="required" for="carname" class="control-label mb-1">{{ trans('page-cars.cars.fields.carname') }}</label>
                                                <input id="carname" name="carname" type="text"
                                                       class="form-control carname valid" value="{{old('carname')}}" required>
                                                <input id="branch_id" type="hidden" name="branch_id" value="{{$branchsid}}">
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('carname')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.carname_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.carname_required')}}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Car Plat Number--}}
                                            <div class="form-group has-success">
                                                <label class="required" for="platnumber" class="control-label mb-1">{{trans('page-cars.cars.fields.platnumber')}}</label>
                                                <input id="platnumber" name="platnumber" type="text"
                                                       class="form-control middle-name valid"
                                                       value="{{old('platnumber')}}" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('platnumber')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.platnumber_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.platnumber_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Car Type--}}
                                            <div class="form-group" data-label="1">
                                                <label class="required" class="control-label col-sm-4" for="cartype">{{trans('page-cars.cars.fields.cartype')}}</label>
                                                <select id="cartype" name="cartype" class="form-control p selectioncartype"
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($cartypelist as $typelist)
                                                        <option value="{{$typelist -> id}}">{{$typelist -> Description}}</option>
                                                    @endforeach
                                                </select>

{{--                                                @error('cartype')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.cartype_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.cartype_required')}}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Engine Type--}}
                                            <div class="form-group" data-label="5">
                                                <label class="required" class="control-label col-sm-4" for="carenginetype">{{trans('page-cars.cars.fields.carengine')}}</label>
                                                <select id="carenginetype" name="carenginetype" class="form-control p selectioncarenginetype"
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($carenginelist as $enginelist)
                                                        <option value="{{$enginelist -> id}}">{{$enginelist -> Description}}</option>
                                                    @endforeach
                                                </select>

{{--                                                @error('carenginetype')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.carenginetype_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.carenginetype_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Car Model--}}
                                            <div class="form-group" data-label="2">
                                                <label class="required" class="control-label mb-1" for="carmodel">{{trans('page-cars.cars.fields.carmodel')}}</label>
                                                <select id="carmodel" name="carmodel" class="form-control p selectioncarmodel"
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($carmodellist as $modellist)
                                                        <option value="{{$modellist -> id}}">{{$modellist -> Description}}</option>
                                                    @endforeach
                                                </select>

{{--                                                @error('carmodel')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.carmodel_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.carmodel_required')}}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##CarColor--}}
                                            <div class="form-group" data-label="3">
                                                <label class="required" class="control-label mb-1" for="carcolor">{{trans('page-cars.cars.fields.carcolor')}}</label>
                                                <select id="carcolor" name="carcolor" class="form-control p selectioncarcolor"
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($carcolorlist as $natiolist)
                                                        <option value="{{$natiolist -> id}}">{{$natiolist -> Description}}</option>
                                                    @endforeach
                                                </select>

{{--                                                @error('carcolor')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.carcolor_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.carcolor_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##chanum--}}
                                            <div class="form-group has-success">
                                                <label  for="chanum" class="control-label mb-1">{{trans('page-cars.cars.fields.chanum')}}</label>
                                                <input id="chanum" name="chanum" type="text"
                                                       class="form-control chanum valid" value="-" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('chanum')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.chanum_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.chanum_required')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##engnum--}}
                                            <div class="form-group has-success">
                                                <label  for="engnum" class="control-label mb-1">{{trans('page-cars.cars.fields.engnum')}}</label>
                                                <input id="engnum" name="engnum" type="text"
                                                       class="form-control engnum valid" value="-" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('engnum')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.engnum_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.engnum_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--##carspecs--}}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group" data-label="6">
                                                <label class="required" for="carsspecs">{{trans('page-cars.cars.fields.specs')}}</label>
                                                <div style="padding-bottom: 4px">
                                                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all_specs') }}</span>
                                                    <span class="btn btn-danger btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all_specs') }}</span>
                                                </div>
                                                <select class="form-control-select p select2 {{ $errors->has('carsspecs') ? 'is-invalid' : '' }}" name="carsspecs[]" id="carsspecs" multiple  aria-required="true" aria-invalid="false" required>
                                                    @foreach($carspecslist as $carspecs)
                                                        <option value="{{ $carspecs -> id }}" {{ in_array($carspecs -> id, old('carsspecs', [])) ? 'selected' : '' }}>{{ $carspecs -> Description }}</option>
                                                    @endforeach
                                                </select>
{{--                                                @error('carsspecs')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.carsspecs_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.carspecs_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--##Rates And Currency--}}
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##CarRate--}}
                                            <div class="form-group has-success">
                                                <label class="required" for="carrate" class="control-label mb-1">{{trans('page-cars.cars.fields.carrate')}}</label>
                                                <input id="carrate" name="carrate" type="number"
                                                       class="form-control carrate valid" value="0" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('carrate')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.carrate_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.carrate_required')}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Currency--}}
                                            <div class="form-group" data-label="4">
                                                <label class="required" class="control-label col-sm-4" for="curr">{{trans('page-cars.cars.fields.curr')}}</label>
                                                <select id="curr" name="curr" class="form-control p "
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($currlist as $culist)
                                                        <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                    @endforeach
                                                </select>

{{--                                                @error('curr')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.curr_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.curr_required')}}
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
                                    <strong class="card-title"></strong>
                                </div>
                                <div class="card-body">

                                    {{--##carused--}}
                                    <div class="form-group has-success">
                                        <label class="required" for="carused"
                                               class="control-label mb-1">{{trans('page-cars.cars.fields.carused')}}</label>
                                        <input id="carused" name="carused" type="date"
                                               class="form-control carused valid"
                                               value="{{old('carused')}}" required>
{{--                                        @error('carused')--}}
{{--                                        <small class="form-text text-danger">{{trans('validation.cars.carused_required')}}</small>--}}
{{--                                        @enderror--}}
                                        <div class="invalid-feedback">
                                            {{trans('validation.cars.carused_required')}}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##CarStop--}}
                                            <br>
                                            <div class="form-group has-success">
                                                <input type="checkbox"  name="carstop" id="carstop"
                                                       class="switchery" data-color="success" {{ old('carstop') ? 'checked' : '' }} />
                                                <label for="carstop" class="card-title ">{{trans('page-cars.cars.fields.carstop')}} </label>
{{--                                                @error('carstop')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.carstop_required')}}</small>--}}
{{--                                                @enderror--}}
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##CarStop Date--}}
                                            <div class="form-group has-success">
                                                <label  for="stopdate"
                                                        class="control-label mb-1">{{trans('page-cars.cars.fields.stopdate')}}</label>
                                                <input id="stopdate" name="stopdate" type="date"
                                                       class="form-control stopdate valid"
                                                       value="{{old('stopdate')}}" required>
{{--                                                @error('stopdate')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.stopdate_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.stopdate_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--##attach image--}}
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Passengers--}}
                                            <div class="form-group has-success">
                                                <label class="required" for="passenger" class="control-label mb-1">{{trans('page-cars.cars.fields.passenger')}}</label>
                                                <input id="passenger" name="passenger" type="number"
                                                       class="form-control passenger valid" value="0" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('passenger')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.passenger_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.passenger_required')}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Bags--}}
                                            <div class="form-group has-success">
                                                <label class="required" for="bags" class="control-label mb-1">{{trans('page-cars.cars.fields.bags')}}</label>
                                                <input id="bags" name="bags" type="number"
                                                       class="form-control bags valid" value="0" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('bags')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.bags_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.bags_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##CarRate--}}
                                            <div class="form-group has-success">
                                                <label class="required" for="doors" class="control-label mb-1">{{trans('page-cars.cars.fields.doors')}}</label>
                                                <input id="doors" name="doors" type="number"
                                                       class="form-control doors valid" value="0" required>
                                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                      data-valmsg-replace="true"></span>
{{--                                                @error('doors')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.doors_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.doors_required')}}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{--##Currency--}}
                                            <div class="form-group" data-label="7">
                                                <label class="required" class="control-label col-sm-4" for="transmission">{{trans('page-cars.cars.fields.transmission')}}</label>
                                                <select id="transmission" name="transmission" class="form-control p "
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($cartransmissionlist as $transmission)
                                                        <option value="{{$transmission -> id}}">{{$transmission -> Description}}</option>
                                                    @endforeach
                                                </select>

{{--                                                @error('transmission')--}}
{{--                                                <small class="form-text text-danger">{{trans('validation.cars.transmission_required')}}</small>--}}
{{--                                                @enderror--}}
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.transmission_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <hr>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="form-group">
                                                    <label for="photo" class="required" >{{trans('page-cars.cars.fields.photo')}}</label>
                                                    <input type="file" class="form-control" name="photo"  id="photo" required>
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.cars.photo_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="form-group">
                                                    <img id="blah" src="/files/images/no-photo.jpg" style="width: 100px; height: 100px;">
                                                </div>
                                            </div>
                                        </div>
{{--                                        @error('photo')--}}
{{--                                        <small class="form-text text-danger">{{trans('validation.cars.photo_required')}}</small>--}}
{{--                                        @enderror--}}

                                    </div>

                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <label class="required" class="control-label col-sm-4" for="branch">{{trans('page-cars.cars.fields.branch')}}</label>
                                            </div>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <select id="branch" name="branch" class="form-control p"
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @foreach($branchlist as $brlist)
                                                        <option value="{{$brlist -> id}}">{{$brlist -> name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.cars.branch_required')}}
                                                </div>
                                            </div>
{{--                                            @error('branch')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.cars.branch_required')}}</small>--}}
{{--                                            @enderror--}}

                                        </div>
                                    </div>

                                    <div class="card-footer">

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-block" type="submit">
                                                        {{ trans('global.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <a class="btn btn-danger btn-block" href=" {{ route("cars-list") }}">
                                                        {{ trans('global.cancel') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- .animated -->
        <div class="hide" id="hidden-values">
            <input id="def_quick_add" type="hidden" value="{{url('/addNewValueDEF_CAR')}}">
            {{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
            {{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
            {{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
            {{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
        </div>
    </div><!-- .content -->

@endsection

@push('js_content')
    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>
    <script src={{ asset("adminassets/vendor/featherlight/featherlight.js") }}></script>
    <script src={{ asset('adminassets/js/custom/newcar.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
    @include('includes.adminpanel.userscript')
@endpush


