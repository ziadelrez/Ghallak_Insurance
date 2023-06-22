@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.title') }}
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
        <form class="needs-validation" novalidate method="POST" action="{{ route("clients.store") }}">
            {{--                {{ csrf_field() }}--}}
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ trans('page-client.clients.titlecardpart1') }}</strong>
                        </div>
                        <div class="card-body">
                            {{--##Normal Client & Office--}}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <input type="checkbox"  name="nclient" id="nclient"
                                               class="switchery" data-color="success" {{ old('nclient') ? 'checked' : '' }} />
                                        <label for="nclient" class="card-title ">{{trans('page-client.clients.fields.nclient')}} </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group ">
                                            <input type="checkbox"  name="office" id="office"
                                                   onchange="onCheckboxChangedOffice(this.checked)" class="switchery" data-color="success" {{ old('office') ? 'checked' : '' }} />
                                            <label for="office" class="card-title ">{{trans('page-client.clients.fields.office')}} </label>
                                        </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                        <div class="form-group ">
                                            <input id="officeshare" name="officeshare" type="text"
                                                         class="form-control officeshare valid" value="0" style="display:none;">
                                        </div>
                                    </div>
                            </div>

                            {{--##Garage & Broker--}}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <input type="checkbox"  name="garage" id="garage"
                                               class="switchery" data-color="success" {{ old('garage') ? 'checked' : '' }} />
                                        <label for="garage" class="card-title ">{{trans('page-client.clients.fields.garage')}} </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <input type="checkbox"  name="broker" id="broker"
                                               onchange="onCheckboxChangedBroker(this.checked)" class="switchery" data-color="success" {{ old('broker') ? 'checked' : '' }} />
                                        <label for="broker" class="card-title ">{{trans('page-client.clients.fields.broker')}} </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group ">
                                        <input id="brokershare" name="brokershare" type="text"
                                               class="form-control brokershare valid" value="0" style="display:none;">
                                    </div>
                                </div>
                            </div>

                            {{--##Expert & Employee--}}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <input type="checkbox"  name="expert" id="expert"
                                               class="switchery" data-color="success" {{ old('expert') ? 'checked' : '' }} />
                                        <label for="expert" class="card-title ">{{trans('page-client.clients.fields.expert')}} </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <input type="checkbox"  name="employee" id="employee"
                                               class="switchery" data-color="success" {{ old('employee') ? 'checked' : '' }} />
                                        <label for="employee" class="card-title ">{{trans('page-client.clients.fields.employee')}} </label>
                                    </div>
                                </div>
                            </div>

                            {{--##Aperson & Follow By Name--}}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 col-xs-12">
                                    <div class="form-group has-success">
                                        <input type="checkbox"  name="aperson" id="aperson"
                                               class="switchery" data-color="success" {{ old('aperson') ? 'checked' : '' }} />
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
                                                <option value="{{$flist -> id}}">{{$flist -> Description}}</option>
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
                                       class="form-control cname valid" value="{{old('cname')}}" required>
                                {{--                                            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.cname_required')}}
                                </div>
                            </div>
                            <div class="list-group list-group-item-action" id="content"></div>
                            {{--##Birth Day  & MotherName--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="required" for="moname" class="control-label mb-1">{{trans('page-client.clients.fields.moname')}}</label>
                                        <input id="moname" name="moname" type="text"
                                               class="form-control middle-name valid"
                                               value="-" required>
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
                                               value="{{old('birthdate')}}" required>
                                        <div class="invalid-feedback">
                                            {{trans('validation.clients.birthdate_required')}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--##Region & Address--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="1">
                                        <label class="required" class="control-label col-sm-4" for="creg">{{trans('page-client.clients.fields.creg')}}</label>
                                        <select id="creg" name="creg" class="form-control p selectionreg"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($reglist as $regionlist)
                                                <option value="{{$regionlist -> id}}" {{ $loop->first ? 'selected="selected"' : '' }}>{{$regionlist -> Description}}</option>
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
                                               class="form-control cadr valid" value="-" required>
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
                                               pattern="[0-9]{8}" value="{{old('cmob')}}"/>
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
                                               value="{{old('cland')}}"/>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- .card -->

                </div><!--/.col-->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ trans('page-client.clients.titlecardpart2') }}</strong>
                        </div>
                        <div class="card-body">

                            {{--## Passport & Natio--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label for="passport" class="control-label mb-1">{{ trans('page-client.clients.fields.passport') }}</label>
                                        <input id="passport" name="passport" type="text"
                                               class="form-control passport valid" value="-" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="8">
                                        <label class="required" class="control-label col-sm-4" for="natio">{{trans('page-client.clients.fields.natio')}}</label>
                                        <select id="natio" name="natio" class="form-control p selectionnatio"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($natiolist as $rlist)
                                                <option value="{{$rlist -> id}}" {{ $loop->first ? 'selected="selected"' : '' }}>{{$rlist -> Description}}</option>
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
                                        <label for="email" class="control-label mb-1">{{ trans('page-client.clients.fields.email') }}</label>
                                        <input id="email" name="email" type="text"
                                               class="form-control email valid" value="{{old('email')}}" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group" data-label="2">
                                        <label class="required" class="control-label col-sm-4" for="relig">{{trans('page-client.clients.fields.relig')}}</label>
                                        <select id="relig" name="relig" class="form-control p selectionrelig"
                                                aria-required="true" aria-invalid="false" required>
                                            <option></option>
                                            @foreach($religlist as $rlist)
                                                <option value="{{$rlist -> id}}" {{ $loop->first ? 'selected="selected"' : '' }}>{{$rlist -> Description}}</option>
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
                                        <option value="{{$brlist -> id}}">{{$brlist -> name}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.branch_required')}}
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                                <input class="form-control " type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.name_required')}}
                                </div>
                            </div>

                            {{--## Username & Password--}}
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="required" for="username">{{ trans('page-client.clients.fields.username') }}</label>
                                        <input class="form-control " type="text" name="username" id="username" value="{{ $strusername }}" required>
                                        <div class="invalid-feedback">
                                            {{trans('validation.clients.username_required')}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="required" for="password">{{ trans('page-client.clients.fields.password') }}</label>
                                        <input class="form-control " type="text" name="password" id="password" value="{{ $password }}" required>
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
                                            @foreach($roleslist as $rlist)
                                                <option value="{{$rlist -> id}}" {{$rlist->id == $rlist->id ? 'selected' : '' }}>{{$rlist -> title}}</option>
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
                                                <option value="{{$evalist -> id}}" >{{$evalist -> Description}}</option>
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
    {{--    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>--}}
{{--    <script src={{ asset("adminassets/vendor/featherlight/featherlight.js") }}></script>--}}
{{--    @include('includes.adminpanel.userscript')--}}
@endpush





