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
    <div class="container-fluid">
        <form  method="POST" action="" >
            {{--                    @method('PUT')--}}
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{trans('page-client.clients.showclient')}} </strong>
                        </div>
                        <div class="card-body">

                            {{--##Normal Client & Broker Type--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <input name="nclient" id="nclient" type="checkbox"
                                               @if(isset($clientdetails[0]->nclient))
                                               {!!  $clientdetails[0]->nclient ? "checked" : ""!!}
                                               @endif;
                                               class="switchery" disabled>
                                        <label for="nclient" class="card-title ">{{trans('page-client.clients.fields.nclient')}} </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <input name="broker" id="broker" type="checkbox"
                                               @if(isset($clientdetails[0]->broker))
                                               {!!  $clientdetails[0]->broker ? "checked" : ""!!}
                                               @endif;
                                               class="switchery" disabled>
                                        <label for="broker" class="card-title ">{{trans('page-client.clients.fields.broker')}} </label>
                                    </div>
                                </div>
                            </div>

                            {{--##Employee & Expert Client Type--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <input name="employee" id="employee" type="checkbox"
                                               @if(isset($clientdetails[0]->employee))
                                               {!!  $clientdetails[0]->employee ? "checked" : ""!!}
                                               @endif;
                                               class="switchery" disabled>
                                        <label for="employee" class="card-title ">{{trans('page-client.clients.fields.employee')}} </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <input name="expert" id="expert" type="checkbox"
                                               @if(isset($clientdetails[0]->expert))
                                               {!!  $clientdetails[0]->expert ? "checked" : ""!!}
                                               @endif;
                                               class="switchery" disabled>
                                        <label for="expert" class="card-title ">{{trans('page-client.clients.fields.expert')}} </label>
                                    </div>
                                </div>
                            </div>
                            {{--##Other Client Type--}}
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <input name="oclient" id="oclient" type="checkbox"
                                               @if(isset($clientdetails[0]->oclient))
                                               {!!  $clientdetails[0]->oclient ? "checked" : ""!!}
                                               @endif;
                                               class="switchery" disabled>
                                        <label for="oclient" class="card-title ">{{trans('page-client.clients.fields.oclient')}} </label>
                                    </div>
                                </div>
                            </div>

                            {{--##FullName--}}
                            <div class="form-group has-success">
                                <label class="required" for="cname" class="control-label mb-1">{{ trans('page-client.clients.fields.cname') }}</label>
                                <input id="cname" name="cname" type="text"
                                       class="form-control fname valid" value="{{$clientdetails[0]->cname}}" disabled>

                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                      data-valmsg-replace="true"></span>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.cname_required')}}
                                </div>
                            </div>

                            {{--##Birth Day--}}
                            <div class="form-group has-success">
                                <label class="required" for="birthdate"
                                       class="control-label mb-1">{{trans('page-client.clients.fields.birthdate')}}</label>
                                <input id="birthdate" name="birthdate" type="date"
                                       class="form-control birthdate valid"
                                       value="{{$clientdetails[0]->birthdate}}" disabled>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.birthdate_required')}}
                                </div>
                            </div>
                            {{--##MotherName--}}
                            <div class="form-group has-success">
                                <label class="required" for="moname" class="control-label mb-1">{{trans('page-client.clients.fields.moname')}}</label>
                                <input id="moname" name="moname" type="text"
                                       class="form-control middle-name valid"
                                       value="{{$clientdetails[0]->moname}}" disabled>
                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                      data-valmsg-replace="true"></span>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.moname_required')}}
                                </div>
                            </div>
                            {{--##Address--}}
                            <div class="form-group has-success">
                                <label class="required" for="cadr" class="control-label mb-1">{{trans('page-client.clients.fields.cadr')}}</label>
                                <input id="cadr" name="cadr" type="text"
                                       class="form-control cadr valid" value="{{$clientdetails[0]->cadr}}" disabled>
                                <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                      data-valmsg-replace="true"></span>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.cadr_required')}}
                                </div>
                            </div>
                            {{--##Region--}}
                            <div class="form-group" data-label="1">
                                <label class="required" class="control-label col-sm-4" for="creg">{{trans('page-client.clients.fields.creg')}}</label>
                                <select id="creg" name="creg" class="form-control p selectionreg"
                                        aria-required="true" aria-invalid="false" disabled>
                                    <option></option>
                                    @foreach($reglist as $regionlist)
                                        @if($regionlist -> id == $clientdetails[0]->creg)
                                            <option selected
                                                    value="{{$regionlist -> id}}">{{$regionlist -> Description}}</option>
                                        @else
                                            <option
                                                value="{{$regionlist -> id}}">{{$regionlist -> Description}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.creg_required')}}
                                </div>
                            </div>
                        </div>
                    </div> <!-- .card -->
                </div><!--/.col-->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{trans('page-client.clients.showclient1')}}</strong>
                        </div>
                        <div class="card-body">
                            {{--## Mobile and Land Line--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="cmob"
                                               class="required"  class="control-label mb-1">{{trans('page-client.clients.fields.cmob')}}</label>
                                        <input id="cmob" name="cmob" class="form-control"
                                               aria-required="true"  aria-invalid="false" type="text"
                                               value="{{$clientdetails[0]->cmob}}" disabled>
                                        <div class="invalid-feedback">
                                            {{trans('validation.clients.cmob_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="cland"
                                               class="control-label mb-1">{{trans('page-client.clients.fields.cland')}}</label>
                                        <input id="cland" name="cland" class="form-control"
                                               aria-required="true" aria-invalid="false" type="text"
                                               value="{{$clientdetails[0]->cland}}" disabled>
                                    </div>
                                </div>
                            </div>
                            {{--## Email --}}
                            <div class="form-group has-success">
                                <label for="email" class="control-label mb-1">{{trans('page-client.clients.fields.email')}}</label>
                                <input id="email" name="email" class="form-control"
                                       aria-invalid="false" type="text"
                                       value="{{$clientdetails[0]->email}}"disabled>
                            </div>

                            {{--##Religion--}}
                            <div class="form-group" data-label="2">
                                <label class="required" class="control-label col-sm-4" for="relig">{{trans('page-client.clients.fields.relig')}}</label>
                                <select id="relig" name="relig" class="form-control p selectionrelig"
                                        aria-required="true" aria-invalid="false" disabled>
                                    <option></option>
                                    @foreach($religlist as $rlist)
                                        @if($rlist -> id == $clientdetails[0]->relig)
                                            <option selected
                                                    value="{{$rlist -> id}}">{{$rlist -> Description}}</option>
                                        @else
                                            <option
                                                value="{{$rlist -> id}}">{{$rlist -> Description}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.relig_required')}}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <a class="btn btn-danger" href="{{ route("clients-list") }}">
                                    {{ trans('global.close') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="hide" id="hidden-values">
        <input id="def_quick_add" type="hidden" value="{{url('/addNewValueDEF')}}">
        {{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
        {{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
        {{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
        {{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
    </div>

@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/newclient.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush



