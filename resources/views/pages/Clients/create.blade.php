@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.title') }}
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
            <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route("clients.store") }}">
{{--                {{ csrf_field() }}--}}
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-client.clients.newclient')}} - {{ trans('page-client.clients.titlecard') }}</strong>
                            </div>

                                <!-- Credit Card -->
                                <div id="pay-invoice">
                                    <div class="card-body">
                                        <div class="form-group has-success">
                                            <label class="required" for="cname" class="control-label mb-1">{{ trans('page-client.clients.fields.cname') }}</label>
                                            <input id="cname" name="cname" type="text"
                                                   class="form-control fname valid" value="{{old('cname')}}" required>
{{--                                            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
{{--                                            @error('cname')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.cname_required')}}</small>--}}
{{--                                            @enderror--}}
{{--                                            @error('cname')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.cname_unique')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.cname_required')}}
                                            </div>
                                        </div>

                                        <div class="form-group has-success">
                                            <label class="required" for="moname" class="control-label mb-1">{{trans('page-client.clients.fields.moname')}}</label>
                                            <input id="moname" name="moname" type="text"
                                                   class="form-control middle-name valid"
                                                   value="{{old('moname')}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
{{--                                            @error('moname')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.moname_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.moname_required')}}
                                            </div>
                                        </div>
                                        <div class="form-group has-success">
                                            <label class="required" for="cadr" class="control-label mb-1">{{trans('page-client.clients.fields.cadr')}}</label>
                                            <input id="cadr" name="cadr" type="text"
                                                   class="form-control cadr valid" value="{{old('cadr')}}" required>
                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
{{--                                            @error('cadr')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.cadr_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.cadr_required')}}
                                            </div>
                                        </div>
                                        {{--##Region--}}
                                        <div class="form-group" data-label="1">
                                            <label class="required" class="control-label col-sm-4" for="creg">{{trans('page-client.clients.fields.creg')}}</label>
                                            <select id="creg" name="creg" class="form-control p selectionreg"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($reglist as $regionlist)
                                                    <option value="{{$regionlist -> id}}">{{$regionlist -> Description}}</option>
                                                @endforeach
                                            </select>

{{--                                            @error('creg')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.creg_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.creg_required')}}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                {{--##Ctype--}}
                                                <div class="form-group" data-label="2">
                                                    <label class="required" class="control-label mb-1" for="cctype">{{trans('page-client.clients.fields.cctype')}}</label>
                                                    <select id="cctype" name="cctype" class="form-control p selectionctype"
                                                            aria-required="true" aria-invalid="false" required>
                                                        <option></option>
                                                    @foreach($ctypelist as $cctypelist)
                                                        <option value="{{$cctypelist -> id}}">{{$cctypelist -> Description}}</option>
                                                    @endforeach
                                                    </select>

{{--                                                    @error('cctype')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.clients.cctype_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.clients.cctype_required')}}
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                {{--##Natio--}}
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label mb-1" for="natio">{{trans('page-client.clients.fields.natio')}}</label>
                                                    <select id="natio" name="natio" class="form-control p selectionnatio"
                                                            aria-required="true" aria-invalid="false" required>
                                                        <option></option>
                                                        @foreach($nlist as $natiolist)
                                                            <option value="{{$natiolist -> id}}">{{$natiolist -> Description}}</option>
                                                        @endforeach
                                                    </select>

{{--                                                    @error('natio')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.clients.natio_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.clients.natio_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="cmob"
                                                           class="required"  class="control-label mb-1">{{trans('page-client.clients.fields.cmob')}}</label>
                                                    <input id="cmob" name="cmob" class="form-control"
                                                           aria-required="true" required aria-invalid="false" type="text"
                                                           value="{{old('cmob')}}"/>
{{--                                                    @error('cmob')--}}
{{--                                                    <small class="form-text text-danger">{{trans('validation.clients.cmob_required')}}</small>--}}
{{--                                                    @enderror--}}
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.clients.cmob_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="cmob1"
                                                           class="control-label mb-1">{{trans('page-client.clients.fields.cmob1')}}</label>
                                                    <input id="cmob1" name="cmob1" class="form-control"
                                                           aria-required="true" aria-invalid="false" type="text"
                                                           value="{{old('cmob1')}}"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cland"
                                                   class="control-label mb-1">{{trans('page-client.clients.fields.cland')}}</label>
                                            <input id="cland" name="cland" class="form-control"
                                                   aria-required="true" aria-invalid="false" type="text"
                                                   value="{{old('cland')}}"/>
                                        </div>

                                    </div>
                                </div>


                        </div> <!-- .card -->

                    </div><!--/.col-->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-client.clients.newclient')}} - {{ trans('page-client.clients.titlecard') }}</strong>
                            </div>
                            <div class="card-body">
                                <div class="form-group has-success">
                                    <label class="required" for="sigil" class="control-label mb-1">{{ trans('page-client.clients.fields.sid') }}</label>
                                    <input id="sigil" name="sigil" type="text"
                                           class="form-control fname valid" value="{{old('sigil')}}" required>
{{--                                    @error('sigil')--}}
{{--                                    <small class="form-text text-danger">{{trans('validation.clients.sigil_required')}}</small>--}}
{{--                                    @enderror--}}
                                    <div class="invalid-feedback">
                                        {{trans('validation.clients.sigil_required')}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        {{--##place--}}
                                        <div class="form-group" data-label="4">
                                            <label class="required" class="control-label mb-1" for="place">{{trans('page-client.clients.fields.place')}}</label>
                                            <select id="place" name="place" class="form-control p selectionplace"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($bplacelist as $bdplacelist)
                                                    <option value="{{$bdplacelist -> id}}">{{$bdplacelist -> Description}}</option>
                                                @endforeach
                                            </select>

{{--                                            @error('place')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.place_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.place_required')}}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="birthdate"
                                                   class="control-label mb-1">{{trans('page-client.clients.fields.birthdate')}}</label>
                                            <input id="birthdate" name="birthdate" type="date"
                                                   class="form-control birthdate valid"
                                                   value="{{old('birthdate')}}" required>
{{--                                            @error('birthdate')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.birthdate_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.birthdate_required')}}
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="form-group has-success">
                                    <label for="passnum" class="control-label mb-1">{{ trans('page-client.clients.fields.passnum') }}</label>
                                    <input id="passnum" name="passnum" type="text"
                                           class="form-control fname valid" value="{{old('passnum')}}">
{{--                                    @error('passnum')--}}
{{--                                    <small class="form-text text-danger">{{trans('validation.clients.passnum_unique')}}</small>--}}
{{--                                    @enderror--}}
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        {{--##place--}}
                                        <div class="form-group" data-label="5">
                                            <label class="required" class="control-label mb-1" for="passplace">{{trans('page-client.clients.fields.passplace')}}</label>
                                            <select id="passplace" name="passplace" class="form-control p selectionpassplace"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($passplacelist as $pplacelist)
                                                    <option value="{{$pplacelist -> id}}">{{$pplacelist -> Description}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.passplace_required')}}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" for="passdate"
                                                   class="control-label mb-1">{{trans('page-client.clients.fields.passdate')}}</label>
                                            <input id="passdate" name="passdate" type="date"
                                                   class="form-control passdate valid"
                                                   value="{{old('passdate')}}" required>
{{--                                            @error('passdate')--}}
{{--                                            <small class="form-text text-danger">{{trans('validation.clients.passdate_required')}}</small>--}}
{{--                                            @enderror--}}
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.passdate_required')}}
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                    <a class="btn btn-danger" href="{{ route("clients-list") }}">
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
{{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
{{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
{{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
{{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
        </div>
    </div><!-- .content -->

@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/newclient.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush



