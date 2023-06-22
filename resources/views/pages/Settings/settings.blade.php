@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('settings.Settings.title') }}
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
    <div class="content mt-1">
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
                                {{--                               route("cars.store") </ul>--}}
                            </div>
                        </div> <!-- .card -->

                    </div><!--/.col-->
                </div>
            @endif
            <div class="container">

                <form class="needs-validation" novalidate method="POST" action="{{ route($status) }}" enctype="multipart/form-data">
                    <input id="statusid" type="hidden" name="statusid" value="{{$setid}}">
                    {{--                {{ csrf_field() }}--}}
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title">{{trans('settings.Settings.title')}}</strong>
                                </div>
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            {{--##Currency--}}
                                            <div class="form-group" data-label="4">
                                                <label class="required" class="control-label col-sm-4" for="curr">{{trans('settings.Settings.curr')}}</label>
                                                <select id="curr" name="curr" class="form-control p "
                                                        aria-required="true" aria-invalid="false" required>
                                                    <option></option>
                                                    @if($chkexist == "1")
                                                        @foreach($currlist as $culist)
                                                            @if($culist -> id == $settingsDB[0]->curr)
                                                                <option selected
                                                                        value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                            @else
                                                                <option
                                                                    value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @foreach($currlist as $culist)
                                                            <option value="{{$culist -> id}}">{{$culist -> currname_ara}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.Settings.curr_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="form-group">
                                                    <label for="photo" class="required" >{{trans('settings.Settings.photo')}}</label>
                                                    <input type="file" class="form-control" name="photo"  id="photo" >
                                                    <div class="invalid-feedback">
                                                        {{trans('validation.Settings.photo_required')}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="form-group">
                                                    @if($chkexist == "1")
                                                    <img id="blah" src="/files/images/company/{{$settingsDB[0]->img_filename}}" style="width: 100px; height: 100px;" required>
                                                    @else
                                                     <img id="blah" src="/files/images/no-photo.jpg" style="width: 100px; height: 100px;" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="billnum" class="control-label mb-1">{{trans('settings.Settings.billnum')}}</label>
                                                <input id="billnum" name="billnum" type="number"
                                                       class="form-control billnum valid" value="{{$settingsDB[0]->billnum}}" required>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.Settings.billnum_required')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="recunum" class="control-label mb-1">{{trans('settings.Settings.recunum')}}</label>
                                                <input id="recunum" name="recunum" type="number"
                                                       class="form-control recunum valid" value="{{$settingsDB[0]->recunum}}" required>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.Settings.recunum_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="accnum" class="control-label mb-1">{{trans('settings.Settings.accnum')}}</label>
                                                <input id="accnum" name="accnum" type="number"
                                                       class="form-control accnum valid" value="{{$settingsDB[0]->accnum}}" required>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.Settings.accnum_required')}}
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
                                    <strong class="card-title">{{trans('settings.Settings.title2')}}</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="reminder" class="control-label mb-1">{{trans('settings.Settings.reminder')}}</label>
                                                <input id="reminder" name="reminder" type="number"
                                                       class="form-control reminder valid" value="{{$settingsDB[0]->reminder}}" required>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.Settings.reminder_required')}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12">
                                            <br><br>
                                            {{trans('settings.Settings.days')}}
                                        </div>
                                    </div>

                                    {{--##sms renew Details--}}
                                    <div class="row" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group has-success">
                                                <label  class="required" for="smsrenewdetails" class="control-label mb-1">{{trans('reminders.reminders.smsrenewdetails')}}</label>
                                                <label  id="smsrenewlbl"  class="control-label mb-1"></label>
                                                <textarea class="form-control rounded-0" name="smsrenewdetails" id="smsrenewdetails" rows="3" required>{{$settingsDB[0]->smsrenew}}</textarea>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.Settings.smsrenewdetails_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--##sms payment Details--}}
                                    <div class="row" >
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="form-group has-success">
                                                <label class="required" for="smspaymentdetails" class="control-label mb-1">{{trans('reminders.reminders.smspaymentdetails')}}</label>
                                                <label  id="smspaymentlbl"  class="control-label mb-1"></label>
                                                <textarea class="form-control rounded-0" name="smspaymentdetails" id="smspaymentdetails" rows="3" required>{{$settingsDB[0]->smspayment}}</textarea>
                                                <div class="invalid-feedback">
                                                    {{trans('validation.Settings.smspaymentdetails_required')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-block" type="submit">
                                                        {{ trans('global.save') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- .card -->

                        </div><!--/.col-->
                    </div>
                </form>
            </div>
                <br>
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
    <script src={{ asset('adminassets/js/custom/settings.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush


