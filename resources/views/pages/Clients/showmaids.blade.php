@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.menu.titlemaids') }}
@endsection

@push('css_content')
{{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--}}
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

@endpush

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div id="content">

        <!-- Topbar -->
    @include('includes.adminpanel.header')
    <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3" >
                    <input id="clientid" type="hidden" name="clientid" value="{{$client_id}}">
                    <div class="row" style="padding-bottom: 0px;">
                        <div class="col-8" >
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="{{ route("clients-list") }}">{{ trans('global.backtoclient') }}</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">{{ trans('page-client.clients.clients_maids_list_title') }}<span style="color:black"> : </span><span style="color:red">{{$client_name}}</span ></li>
                                            <li class="breadcrumb-item active" aria-current="page">{{ trans('page-client.clients.clientsmaidscount') }} : <span id="total_records">{{$maidscount}}</span></li>
                                        </ol>
                                    </nav>
                        </div>

                        <div class="col-4">
                            @can('cars_create')
                                <div class="float-left">
                                    <a class="btn btn-primary btn-lg" href=" {{ route('maids.create',$client_id)}}">
                                        <i class="fas fa-plus-circle"></i>
                                        {{ trans('page-client.clients.buttons.btnaddmaids') }}
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>

                </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="bootstrap-data-table" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th width="30px"  >{{ trans('page-client.clients.tables.id') }}</th>
                                                <th class="text-center" width="200px">{{ trans('page-client.clients.tables.maidname') }}</th>
                                                <th class="text-center" width="100px" >{{ trans('page-client.clients.tables.dob') }}</th>
                                                <th class="text-center" width="120px">{{ trans('page-client.clients.tables.natio') }}</th>
                                                <th class="text-center" width="120px" >{{ trans('page-client.clients.tables.passportnum') }}</th>
                                                <th class="text-center" width="180px">{{ trans('page-client.clients.tables.actions') }}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>

                </div>
                </div>
            </div>


        <!-- /.container-fluid -->

    <div id="create" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">
                                <i class="fas fa-paperclip"></i> {{trans('global.attachcarimg')}}
                                <span id="counter"></span>
                            </strong>
                        </div>
                        <div class="card-body">
                            {{--                                <div class="form-group">--}}
                            <input id="car__id" name="car__id" type="hidden" value="">


                            <form action="{{route('carsimg.attach')}}" class="dropzone margin-top-10"
                                  id="my-dropzone">
                                @csrf
                                <div class="dz-message text-center" data-dz-message ><span><div>{{trans('global.drop')}}
                                    <span class="text-danger">{{trans('global.files')}}</span> {{trans('global.here')}} <br>{{trans('global.click')}} <br>{{trans('global.direct')}}</div></span>
                                </div>
                            </form>
                        </div>
                    </div> <!-- .card -->



                </div>
                <div class="modal-footer">
{{--                    <button class="btn btn-success" type="submit" id="add">--}}
{{--                        <span class="fas fa-plus"></span>{{ trans('page-client.clients.modals.lbl_license_save') }}--}}
{{--                    </button>--}}
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>{{ trans('page-client.clients.modals.lbl_license_exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="hide" id="hidden-values">
        <input id="ajax_url" type="hidden" value="{{url('/deletecars')}}">
    </div>

@endsection

@push('js_content')
    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>
    <script src={{ asset('adminassets/js/custom/clients-maids-index.js') }}></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
{{--    <script src={{ asset('adminassets/js/custom/cars-img.js') }}></script>--}}
@endpush
