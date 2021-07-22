@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-cars.cars.titleattach') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
{{--    <meta charset="utf-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">--}}
@endpush

@section('content')

    @include('includes.adminpanel.header')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="modal fade" id="doc_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ trans('page-cars.cars.filepreview') }}</h4>
                </div>
                <div class="modal-body">
                    <div id="divDocEmbed" style="height: 480px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-circle default"><i
                            class="fa fa-times-circle"></i> {{ trans('page-cars.cars.closemodal') }}
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
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

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route("cars-list") }}">{{ trans('global.backtocars') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ trans('page-cars.cars.titleattach') }}<span style="color:black"> : </span><span style="color:red">{{$carname[0]->carname}}</span ></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <hr>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-attach-tab" data-toggle="tab" href="#nav-attach" role="tab" aria-controls="nav-attach" aria-selected="true"><i class="fa fa-paperclip"></i>  {{ trans('page-cars.cars.titletbimages') }}</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
{{--                                    <strong class="card-title"><i--}}
{{--                                            class="fa fa-paperclip"> </i>  {{ trans('page-cars.cars.titleattach') }}--}}
{{--                                    </strong>--}}
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th style="display:none;" width="20%">{{ trans('page-cars.cars.tables.id') }}</th>
                                            <th width="20%">{{ trans('page-cars.cars.tables.filetype') }}</th>
                                            <th width="60%">{{ trans('page-cars.cars.tables.filename') }}</th>
                                            <th width="20%">{{ trans('page-cars.cars.tables.attchactions') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
{{--                                        @foreach($getattachfiles as $alist)--}}
{{--                                            <tr class="attachrows{{$alist -> id}}">--}}
{{--                                                <td style="display:none;" >{{$alist -> id}}</td>--}}
{{--                                                <td width="20%">{{$alist -> file_type}}</td>--}}
{{--                                                <td width="60%" class="text-center">{{$alist -> file_name}}</td>--}}
{{--                                                <td width="20%">{{$alist -> region}}</td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title"><span
                                            ><i class="fa fa-images"></i> | </span> {{ trans('page-cars.cars.tables.attachimages') }}
                                    </strong>
                                </div>
{{--                                {{url('/upload-x-files')}}--}}
                                <div class="card-body">
                                    <form action="{{url('/upload-images-files')}}" class="dropzone margin-top-10"
                                          id="my-dropzone">
                                        @csrf
                                        <div class="dz-message text-center" data-dz-message ><span><div>{{trans('global.drop')}}
                                    <span class="text-danger">{{trans('global.files')}}</span> {{trans('global.here')}} <br>{{trans('global.click')}} <br>{{trans('global.direct')}}</div></span>
                                        </div>
                                    </form>

                                </div>
                            </div> <!-- .card -->

                        </div><!--/.col-->

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <strong class="card-title"><span
                                        ><i class="fa fa-file-upload"></i> | </span> {{ trans('page-cars.cars.tables.attachdocs') }}
                                    </strong>
                                </div>
                                {{--                                {{url('/upload-x-files')}}--}}
                                <div class="card-body">
                                    <form action="{{url('/upload-docs-files')}}" class="dropzone margin-top-10"
                                          id="my-dropzone">
                                        @csrf
                                        <div class="dz-message text-center" data-dz-message ><span><div>{{trans('global.drop')}}
                                    <span class="text-danger">{{trans('global.files')}}</span> {{trans('global.here')}} <br>{{trans('global.click')}} <br>{{trans('global.direct')}}</div></span>
                                        </div>
                                    </form>

                                </div>
                            </div> <!-- .card -->

                        </div><!--/.col-->

                    </div>
                </div>
            </div>

        </div>
        </div><!-- .animated -->
        <div class="hide" id="hidden-values">
{{--            <input id="p_route" type="hidden" value="{{ route('cars.files') }}">--}}
            <input id="car-id" type="hidden" name="car-id" value="{{$cars_ids}}">
{{--            <input id="pv_route" type="hidden" value="{!! route('') !!}">--}}
{{--            <input id="deleteFile" type="hidden" value="{{url('')}}">--}}
{{--            <input id="general_def_quick" type="hidden" value="{{url('')}}">--}}
{{--            <input id="loading" type="hidden" value="{{trans('system.LOADING')}}">--}}
        </div>
    </div><!-- .content -->

@endsection

@push('js_content')
    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>
    <script src="{{ asset('adminassets/js/lib/data-table/jszip.min.js') }}"></script>
{{--    <script src="{{ asset('adminassets/js/lib/data-table/pdfmake.min.js') }}"></script>--}}
    <script src="{{ asset('adminassets/js/lib/data-table/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminassets/vendor/pdfObject/pdfobject.min.js') }}"></script>
    <script src="{{ asset('adminassets/vendor/featherlight/featherlight.js') }}"></script>
{{--    <script src={{ asset('adminassets/js/custom/cars-index.js') }}></script>--}}
    <script src={{ asset('adminassets/js/custom/cars-img.js') }}></script>
@endpush



