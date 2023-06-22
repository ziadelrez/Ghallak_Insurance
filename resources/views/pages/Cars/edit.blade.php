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
        <div class="container">
            <form class="needs-validation" novalidate method="POST" action="{{ route('cars.update',$carsdetails[0]->id)}}" enctype="multipart/form-data">
                <input id="clientid" type="hidden" name="clientid" value="{{$carsdetails[0]->client}}">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-cars.cars.upcar')}} - {{$clientname[0]->cname}} </strong>
                            </div>

                            <div class="card-body">
                                {{--##Car name & Car Plat Number & Eng Type--}}
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="carname" class="control-label mb-1">{{ trans('page-cars.cars.fields.carname') }}</label>
                                            <input id="carname" name="carname" type="text"
                                                   class="form-control carname valid" value="{{$carsdetails[0]->carname}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.carname_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="platnumber" class="control-label mb-1">{{trans('page-cars.cars.fields.platnumber')}}</label>
                                            <input id="platnumber" name="platnumber" type="text"
                                                   class="form-control middle-name valid"
                                                   value="{{$carsdetails[0]->platnumber}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.platnumber_required')}}
                                            </div>
                                            <div class="alert alert-danger" id="err_carsexist" style="display:none">
                                                {{trans('validation.cars.carsexist_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="6">
                                            <label class="required" class="control-label col-sm-4" for="enginetype">{{trans('page-cars.cars.fields.carengine')}}</label>
                                            <select id="enginetype" name="enginetype" class="form-control p selectionenginetype"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($carsenginetypelist as $engtypelist)
                                                    @if($engtypelist -> id == $carsdetails[0]->enginetype)
                                                        <option selected
                                                                value="{{$engtypelist -> id}}">{{$engtypelist -> Description}}</option>
                                                    @else
                                                        <option
                                                            value="{{$engtypelist -> id}}">{{$engtypelist -> Description}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.carenginetype_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--##Car Type & Car Model & CarColor--}}
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="1">
                                            <label class="required" class="control-label col-sm-4" for="cartype">{{trans('page-cars.cars.fields.cartype')}}</label>
                                            <select id="cartype" name="cartype" class="form-control p selectioncartype"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($cartypelist as $typelist)
                                                    @if($typelist -> id == $carsdetails[0]->cartype)
                                                        <option selected
                                                                value="{{$typelist -> id}}">{{$typelist -> Description}}</option>
                                                    @else
                                                        <option
                                                            value="{{$typelist -> id}}">{{$typelist -> Description}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.cartype_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="2">
                                            <label class="required" class="control-label mb-1" for="carmodel">{{trans('page-cars.cars.fields.carmodel')}}</label>
                                            <select id="carmodel" name="carmodel" class="form-control p selectioncarmodel"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($carmodellist as $modellist)
                                                    @if($modellist -> id == $carsdetails[0]->carmodel)
                                                        <option selected
                                                                value="{{$modellist -> id}}">{{$modellist -> Description}}</option>
                                                    @else
                                                        <option
                                                            value="{{$modellist -> id}}">{{$modellist -> Description}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.carmodel_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="3">
                                            <label class="required" class="control-label mb-1" for="carcolor">{{trans('page-cars.cars.fields.carcolor')}}</label>
                                            <select id="carcolor" name="carcolor" class="form-control p selectioncarcolor"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($carcolorlist as $colorlist)
                                                    @if($colorlist -> id == $carsdetails[0]->carcolor)
                                                        <option selected
                                                                value="{{$colorlist -> id}}">{{$colorlist -> Description}}</option>
                                                    @else
                                                        <option
                                                            value="{{$colorlist -> id}}">{{$colorlist -> Description}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.carcolor_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--##Chanum & Engnum & Passengers--}}
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label  for="chanum" class="control-label mb-1">{{trans('page-cars.cars.fields.chanum')}}</label>
                                            <input id="chanum" name="chanum" type="text"
                                                   class="form-control chanum valid" value="{{$carsdetails[0]->chanum}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.chanum_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label  for="engnum" class="control-label mb-1">{{trans('page-cars.cars.fields.engnum')}}</label>
                                            <input id="engnum" name="engnum" type="text"
                                                   class="form-control engnum valid" value="{{$carsdetails[0]->engnum}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.engnum_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="passenger" class="control-label mb-1">{{trans('page-cars.cars.fields.passenger')}}</label>
                                            <input id="passenger" name="passenger" type="number"
                                                   class="form-control passenger valid" value="{{$carsdetails[0]->passenger}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.passenger_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--##Price & Currency & Car Use--}}
                                <div class="row">
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="carrate" class="control-label mb-1">{{trans('page-cars.cars.fields.carrate')}}</label>
                                            <input id="carrate" name="carrate" type="number"
                                                   class="form-control carrate valid" value="{{$carsdetails[0]->carrate}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.carrate_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="4">
                                            <label class="required" class="control-label col-sm-4" for="curr">{{trans('page-cars.cars.fields.curr')}}</label>
                                            <select id="curr" name="curr" class="form-control p "
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($currlist as $culist)
                                                    @if($culist -> id == $carsdetails[0]->curr)
                                                        <option selected
                                                                value="{{$culist -> id}}">{{$culist -> currname_eng}}</option>
                                                    @else
                                                        <option
                                                            value="{{$culist -> id}}">{{$culist -> currname_eng}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.curr_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group" data-label="5">
                                            <label class="required" class="control-label col-sm-4" for="carsuses">{{trans('page-cars.cars.fields.caruse')}}</label>
                                            <select id="carsuses" name="carsuses" class="form-control p selectioncarsuses"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($carsuselist as $carulist)
                                                    @if($carulist -> id == $carsdetails[0]->carused)
                                                        <option selected
                                                                value="{{$carulist -> id}}">{{$carulist -> Description}}</option>
                                                    @else
                                                        <option
                                                            value="{{$carulist -> id}}">{{$carulist -> Description}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.cars.carenginetype_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <button id="carssavebtn" class="btn btn-primary btn-block" type="submit">
                                                {{ trans('global.save') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <a class="btn btn-danger btn-block" href=" {{ route("clients.showcars",$carsdetails[0]->client) }}">
                                                {{ trans('global.cancel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- .card -->
                    </div><!--/.col-->
                </div>
            </form>
        </div>

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
    <script src={{ asset('adminassets/js/custom/newcar.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush


