@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.titlemaid') }}
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
        <form class="needs-validation" novalidate method="POST" action="{{ route("clients.store.maids") }}">
            {{--                {{ csrf_field() }}--}}
            <input id="clientid" type="hidden" name="clientid" value="{{$clid}}">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">{{ trans('page-client.clients.titlecardmaid') }} - {{$clname}}</strong>
                        </div>
                        <div class="card-body">
                            {{--##Maid Full Name--}}
                            <div class="form-group has-success">
                                <label class="required" for="maidname" class="control-label mb-1">{{ trans('page-client.clients.fields.maidname') }}</label>
                                <input id="maidname" name="maidname" type="text"
                                       class="form-control maidname valid" value="{{old('maidname')}}" required>
                                {{--                                            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.maidname_required')}}
                                </div>
                            </div>
                            <div class="list-group list-group-item-action" id="content"></div>
                            {{--##Birth Day --}}
                            <div class="form-group has-success">
                                <label class="required" for="dob"
                                       class="control-label mb-1">{{trans('page-client.clients.fields.dob')}}</label>
                                <input id="dob" name="dob" type="date"
                                       class="form-control dob valid"
                                       value="{{old('dob')}}" required>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.dob_required')}}
                                </div>
                            </div>

                            {{--##Natio--}}
                            <div class="form-group" data-label="1">
                                <label class="required" class="control-label col-sm-4" for="natio">{{trans('page-client.clients.fields.natio_maid')}}</label>
                                <select id="natio" name="natio" class="form-control p selectionnatio"
                                        aria-required="true" aria-invalid="false" required>
                                    <option></option>
                                    @foreach($natio as $natiolist)
                                        <option value="{{$natiolist -> id}}" {{ $loop->first ? 'selected="selected"' : '' }}>{{$natiolist -> Description}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.natio_maid_required')}}
                                </div>
                            </div>
                            {{--## Passport--}}
                            <div class="form-group has-success">
                                <label for="passport" class="required"  class="control-label mb-1">{{trans('page-client.clients.fields.passport')}}</label>
                                <input id="passport" name="passport" class="form-control passport valid" type="text"
                                      value="{{old('passport')}}" required>
                                <div class="invalid-feedback">
                                    {{trans('validation.clients.passport_required')}}
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
                    </div> <!-- .card -->

                </div><!--/.col-->
            </div>

        </form>
    </div>

    <div class="hide" id="hidden-values">
        <input id="def_quick_add" type="hidden" value="{{url('/addNewValueDEFmaids')}}">
        {{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
        {{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
        {{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
        {{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
    </div>

@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/newmaid.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
    {{--    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>--}}
{{--    <script src={{ asset("adminassets/vendor/featherlight/featherlight.js") }}></script>--}}
{{--    @include('includes.adminpanel.userscript')--}}
@endpush





