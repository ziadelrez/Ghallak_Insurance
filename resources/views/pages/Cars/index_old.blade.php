@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-cars.cars.title') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
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
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary float-right">{{ trans('page-cars.cars.titletb') }}</h6>
                    @can('cars_create')
                    <div class="float-left">
                        <a class="btn btn-primary btn-lg" href=" {{ route('cars.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            {{ trans('page-cars.cars.buttons.btnadd') }}
                        </a>
                    </div>
                    @endcan
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >{{ trans('page-cars.cars.tables.id') }}</th>
                                <th width="200px">{{ trans('page-cars.cars.tables.carname') }}</th>
                                <th class="text-center" width="100px" >{{ trans('page-cars.cars.tables.platnumber') }}</th>
                                <th class="text-center" width="120px">{{ trans('page-cars.cars.tables.type') }}</th>
                                <th class="text-center" width="120px">{{ trans('page-cars.cars.tables.model') }}</th>
                                <th class="text-center" width="120px">{{ trans('page-cars.cars.tables.color') }}</th>
                                <th class="text-center" width="200px">{{ trans('page-cars.cars.tables.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($carslist as $car)
                                <tr class="carrows{{$car -> carid}}" >
                                    <td style="display:none;" >{{$car -> carid}}</td>
                                    <td>{{$car -> carname}}</td>
                                    <td class="text-center">{{$car -> carnumer}}</td>
                                    <td class="text-center">{{$car -> cartype}}</td>
                                    <td class="text-center">{{$car -> caryear}}</td>
                                    <td class="text-center">{{$car -> carcolor}}</td>
                                    <td class="text-center">
                                        @can('cars_view')
                                            <a class="btn btn-info btn-sm" href="">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan

                                        @can('cars_img')
                                                <button class="create-modal btn btn-primary btn-sm" data-id="{{$car -> carid}}" data-title="{{$car -> carname}}">
                                                    <i class="fas fa-images"></i>
                                                </button>
                                        @endcan

                                        @can('cars_transaction')
                                            <a class="btn btn-success btn-sm" href="">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endcan

                                        @can('cars_edit')
                                            <a class="btn btn-warning btn-sm" href="">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('cars_delete')
                                            <button class="delete-modal btn btn-danger btn-sm" data-id="{{$car->carid}}" data-title="{{$car->carname}}" >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
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
    <div id="myModal"class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">

                    {{--                     Form Delete Post --}}
                    <div class="deleteContent">
                        <span class="hidden id"></span><span> - </span>{{ trans('page-cars.clients.modals.lbl_license_deleteconfirmationclient') }}<span class="title"></span><span>{{ trans('page-cars
.clients.modals.lbl_license_questionmark') }}</span>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="fas fa-door-open"></span> {{ trans('page-cars.clients.modals.lbl_license_exit') }}
                    </button>
                </div>
            </div>
        </div>
{{--        <div class="hide" id="hidden-values">--}}
{{--         --}}
{{--            --}}{{--            <input id="branch_id" type="hidden" name="branch_id" value="{{$brID}}">--}}
{{--            --}}{{--            <input id="natio_quick_add" type="hidden" value="{{url('/addNewValueNATIO')}}">--}}
{{--            --}}{{--            <input id="place_quick_add" type="hidden" value="{{url('/addNewValuePLACE')}}">--}}
{{--            --}}{{--            <input id="passplace_quick_add" type="hidden" value="{{url('/addNewValuePASSPLACE')}}">--}}
{{--        </div>--}}
    </div>

@endsection

@push('js_content')
    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>
    <script src={{ asset('adminassets/js/custom/cars-index.js') }}></script>
    <script src={{ asset('adminassets/js/custom/cars-img.js') }}></script>
@endpush
