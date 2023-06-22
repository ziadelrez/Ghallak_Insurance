@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.uptitle') }}
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
            <form class="needs-validation" novalidate method="POST" action="{{ route('clients.update',$clientdetails[0]->id)}}" >
{{--                    @method('PUT')--}}
                    @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-client.clients.upclient')}} </strong>
                            </div>
                                    <div class="card-body">

                                        {{--##Normal Client & Office--}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input name="nclient" id="nclient" type="checkbox"
                                                           @if(isset($clientdetails[0]->nclient))
                                                           {!!  $clientdetails[0]->nclient ? "checked" : ""!!}
                                                           @endif;
                                                           class="switchery">
                                                    <label for="nclient" class="card-title ">{{trans('page-client.clients.fields.nclient')}} </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input name="office" id="office" type="checkbox"
                                                           @if(isset($clientdetails[0]->office))
                                                           {!!  $clientdetails[0]->office ? "checked" : ""!!}
                                                           @endif;
                                                           onchange="onCheckboxChangedOffice(this.checked)" class="switchery">
                                                    <label for="office" class="card-title ">{{trans('page-client.clients.fields.office')}} </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group ">
                                                    <input id="officeshare" name="officeshare" type="text"
                                                           class="form-control officeshare valid" value="{{$clientdetails[0]->officeshare}}" style="display:none;">
                                                </div>
                                            </div>
                                        </div>
                                        {{--##Garage & Broker--}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input name="garage" id="garage" type="checkbox"
                                                           @if(isset($clientdetails[0]->garage))
                                                           {!!  $clientdetails[0]->garage ? "checked" : ""!!}
                                                           @endif;
                                                           class="switchery">
                                                    <label for="garage" class="card-title ">{{trans('page-client.clients.fields.garage')}} </label>
                                                </div>
                                             </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input name="broker" id="broker" type="checkbox"
                                                           @if(isset($clientdetails[0]->broker))
                                                           {!!  $clientdetails[0]->broker ? "checked" : ""!!}
                                                           @endif;
                                                           onchange="onCheckboxChangedBroker(this.checked)" class="switchery">
                                                    <label for="broker" class="card-title ">{{trans('page-client.clients.fields.broker')}} </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group ">
                                                    <input id="brokershare" name="brokershare" type="text"
                                                           class="form-control brokershare valid" value="{{$clientdetails[0]->brokershare}}" style="display:none;">
                                                </div>
                                            </div>
                                        </div>
                                        {{--##Expert & Employee--}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input name="expert" id="expert" type="checkbox"
                                                           @if(isset($clientdetails[0]->expert))
                                                           {!!  $clientdetails[0]->expert ? "checked" : ""!!}
                                                           @endif;
                                                           class="switchery">
                                                    <label for="expert" class="card-title ">{{trans('page-client.clients.fields.expert')}} </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input name="employee" id="employee" type="checkbox"
                                                           @if(isset($clientdetails[0]->employee))
                                                           {!!  $clientdetails[0]->employee ? "checked" : ""!!}
                                                           @endif;
                                                           class="switchery">
                                                    <label for="employee" class="card-title ">{{trans('page-client.clients.fields.employee')}} </label>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Aperson & Follow By Name--}}
                                        <div class="row">
                                            <div class="col-md-4 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <input name="aperson" id="aperson" type="checkbox"
                                                           @if(isset($clientdetails[0]->aperson))
                                                           {!!  $clientdetails[0]->aperson ? "checked" : ""!!}
                                                           @endif;
                                                           class="switchery">
                                                    <label for="aperson" class="card-title ">{{trans('page-client.clients.fields.aperson')}} </label>
                                                </div>

                                            </div>
                                            <div class="col-md-8 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="3">
                                                    <label class="required" class="control-label col-sm-4" for="followby">{{trans('page-client.clients.fields.followby')}}</label>
                                                    <select id="followby" name="followby" class="form-control p selectionfollowby"
                                                            aria-required="true" aria-invalid="false" required>
                                                        <option></option>
                                                        @foreach($followlist as $flist)
                                                            @if($flist -> id == $clientdetails[0]->followby)
                                                                <option selected
                                                                        value="{{$flist -> id}}">{{$flist -> Description}}</option>
                                                            @else
                                                                <option
                                                                    value="{{$flist -> id}}">{{$flist -> Description}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.clients.followby_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{--##FullName--}}
                                        <div class="form-group has-success">
                                            <label class="required" for="cname" class="control-label mb-1">{{ trans('page-client.clients.fields.cname') }}</label>
                                            <input id="cname" name="cname" type="text"
                                                   class="form-control fname valid" value="{{$clientdetails[0]->cname}}" required>

                                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                  data-valmsg-replace="true"></span>
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.cname_required')}}
                                            </div>
                                        </div>
                                        {{--##MotherName & Birthday--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="moname" class="control-label mb-1">{{trans('page-client.clients.fields.moname')}}</label>
                                                    <input id="moname" name="moname" type="text"
                                                           class="form-control middle-name valid"
                                                           value="{{$clientdetails[0]->moname}}" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.clients.moname_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="birthdate"
                                                           class="control-label mb-1">{{trans('page-client.clients.fields.birthdate')}}</label>
                                                    <input id="birthdate" name="birthdate" type="date"
                                                           class="form-control birthdate valid"
                                                           value="{{$clientdetails[0]->birthdate}}" required>
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.clients.birthdate_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--## Region and Address--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group" data-label="1">
                                                    <label class="required" class="control-label col-sm-4" for="creg">{{trans('page-client.clients.fields.creg')}}</label>
                                                    <select id="creg" name="creg" class="form-control p selectionreg"
                                                            aria-required="true" aria-invalid="false" required>
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
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="cadr" class="control-label mb-1">{{trans('page-client.clients.fields.cadr')}}</label>
                                                    <input id="cadr" name="cadr" type="text"
                                                           class="form-control cadr valid" value="{{$clientdetails[0]->cadr}}" required>
                                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                                          data-valmsg-replace="true"></span>
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.clients.cadr_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{--## Mobile and Land Line--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="cmob"
                                                           class="required"  class="control-label mb-1">{{trans('page-client.clients.fields.cmob')}}</label>
                                                    <input id="cmob" name="cmob" class="form-control"
                                                           aria-required="true" required aria-invalid="false" type="tel"
                                                           pattern="[0-9]{8}" value="{{$clientdetails[0]->cmob}}"/>
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
                                                           value="{{$clientdetails[0]->cland}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </div> <!-- .card -->
                    </div><!--/.col-->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">{{trans('page-client.clients.upclient1')}}</strong>
                            </div>
                            <div class="card-body">

                                {{--## Passport & Natio--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label for="passport" class="control-label mb-1">{{trans('page-client.clients.fields.passport')}}</label>
                                            <input id="passport" name="passport" class="form-control"
                                                   aria-invalid="false" type="text"
                                                   value="{{$clientdetails[0]->passport}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" data-label="8">
                                            <label class="required" class="control-label col-sm-4" for="natio">{{trans('page-client.clients.fields.natio')}}</label>
                                            <select id="natio" name="natio" class="form-control p selectionnatio"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($natiolist as $rlist)
                                                    @if($rlist -> id == $clientdetails[0]->natio)
                                                        <option selected
                                                                value="{{$rlist -> id}}">{{$rlist -> Description}}</option>
                                                    @else
                                                        <option
                                                            value="{{$rlist -> id}}">{{$rlist -> Description}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.natio_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--## Email & Religion--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label for="email" class="control-label mb-1">{{trans('page-client.clients.fields.email')}}</label>
                                            <input id="email" name="email" class="form-control"
                                                   aria-invalid="false" type="text"
                                                   value="{{$clientdetails[0]->email}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" data-label="2">
                                            <label class="required" class="control-label col-sm-4" for="relig">{{trans('page-client.clients.fields.relig')}}</label>
                                            <select id="relig" name="relig" class="form-control p selectionrelig"
                                                    aria-required="true" aria-invalid="false" required>
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
                                </div>

                                {{--## Branch--}}
                                <div class="form-group has-success">
                                    <label class="required" class="control-label col-sm-4" for="branch">{{trans('page-client.clients.fields.branch')}}</label>
                                    <select id="branch" name="branch" class="form-control p"
                                            aria-required="true" aria-invalid="false" required>
                                        <option></option>
                                        @foreach($branchlist as $brlist)
                                            @if($brlist -> id == $clientdetails[0]->branch)
                                                <option selected
                                                        value="{{$brlist -> id}}">{{$brlist -> name}}</option>
                                            @else
                                                <option
                                                    value="{{$brlist -> id}}">{{$brlist -> name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{trans('validation.clients.branch_required')}}
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                    <input class="form-control " type="text" name="name" id="name" value="{{ $getusersinfo[0]->name }}" required>
                                    <div class="invalid-feedback">
                                        {{trans('validation.clients.name_required')}}
                                    </div>
                                </div>

                                {{--## Username & Password--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="required" for="username">{{ trans('page-client.clients.fields.username') }}</label>
                                            <input class="form-control " type="text" name="username" id="username" value="{{ $getusersinfo[0]->email }}" required>
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.username_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="required" for="password">{{ trans('page-client.clients.fields.password') }}</label>
                                            <input class="form-control " type="text" name="password" id="password" value="{{ $clientdetails[0]->pid }}" required>
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.password_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--##Clients Roles & Evaluation--}}
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group has-success">
                                            <label class="required" class="control-label col-sm-4" for="userroles">{{trans('page-client.clients.fields.userroles')}}</label>
                                            <select id="userroles" name="userroles" class="form-control p"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($roleslist as $rolelist)
                                                    @if($rolelist -> id == $getusersrolesinfo[0]->role_id)
                                                        <option selected
                                                                value="{{$rolelist -> id}}">{{$rolelist -> title}}</option>
                                                    @else
                                                        <option
                                                            value="{{$rolelist -> id}}">{{$rolelist -> title}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.roles_required')}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group" data-label="1002">
                                            <label class="required" class="control-label col-sm-4" for="evalclient">{{trans('page-client.clients.fields.evalclient')}}</label>
                                            <select id="evalclient" name="evalclient" class="form-control p selectionevalclient"
                                                    aria-required="true" aria-invalid="false" required>
                                                <option></option>
                                                @foreach($evallist as $evalist)
                                                    @if($evalist -> id == $clientdetails[0]->eval)
                                                        <option selected
                                                                value="{{$evalist -> id}}">{{$evalist -> Description}}</option>
                                                    @else
                                                        <option
                                                            value="{{$evalist -> id}}">{{$evalist -> Description}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{trans('validation.clients.evalclient_required')}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        {{ trans('global.editclient') }}
                                    </button>
                                    <a class="btn btn-danger" href="{{ route("clients-list") }}">
                                        {{ trans('global.canceledit') }}
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
    <script src={{ asset('adminassets/js/custom/updateclient.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush



