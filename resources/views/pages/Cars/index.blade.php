@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-cars.cars.title') }}
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

                    <div class="row" style="padding-bottom: 0px;">
                        <div class="col-4" >
                            <h4 class="m-0 font-weight-bold text-primary ">{{ trans('page-cars.cars.titletb') }}</h4>
                            <hr style="border:1px solid black">
                            <div><h5 class="m-0 font-weight-bold text-danger ">{{ trans('page-cars.cars.carscount') }} : <span id="total_records">{{$carscount}}</span></h5></div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <input id="taken" type="hidden" name="taken" value="">
                                <input type="radio" id="allcars" name="taken" data-id="" checked/>
                                <label for="allcars" >{{trans('page-cars.cars.carsall')}} </label><br>
                                <input type="radio" id="takenyes" name="taken" data-id="1" />
                                <label for="takenyes" >{{trans('page-cars.cars.carsout')}} </label><br>
                                <input type="radio" id="takenno" name="taken" data-id="0"/>
                                <label for="takenno" >{{trans('page-cars.cars.carsin')}} </label><br>
{{--                                <hr>--}}
{{--                                <input type="text" name="search" id="search" class="form-control" placeholder={{ trans('page-cars.cars.searchbar') }} />--}}
                            </div>
                        </div>
                        <div class="col-4">
                            @can('cars_create')
                                <div class="float-left">
                                    <a class="btn btn-primary btn-lg" href=" {{ route('cars.create') }}">
                                        <i class="fas fa-plus-circle"></i>
                                        {{ trans('page-cars.cars.buttons.btnadd') }}
                                    </a>
                                </div>
                            @endcan
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="bootstrap-data-table" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th width="30px"  >{{ trans('page-cars.cars.tables.id') }}</th>
                                                <th class="text-center" width="200px">{{ trans('page-cars.cars.tables.carname') }}</th>
                                                <th class="text-center" width="100px" >{{ trans('page-cars.cars.tables.platnumber') }}</th>
                                                <th class="text-center" width="120px">{{ trans('page-cars.cars.tables.type') }}</th>
                                                <th class="text-center" width="120px" >{{ trans('page-cars.cars.tables.color') }}</th>
                                                <th class="text-center" width="100px" >{{ trans('page-cars.cars.tables.model') }}</th>
                                                <th class="text-center" width="100px" >{{ trans('page-cars.cars.tables.rates') }}</th>
                                                <th class="text-center" width="100px" >{{ trans('page-cars.cars.tables.photo') }}</th>
                                                <th class="text-center" width="180px">{{ trans('page-cars.cars.tables.actions') }}</th>
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
        <div class="hide" id="hidden-values">
            <input id="ajax_url" type="hidden" value="{{url('/deletecars')}}">
        </div>
    </div>

@endsection

@push('js_content')
{{--    <script src="{{ asset('adminassets/lib/data-table/datatables.min.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/dataTables.bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/jszip.min.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/pdfmake.min.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/vfs_fonts.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/buttons.html5.min.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/buttons.print.min.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/buttons.colVis.min.js') }}"></script>--}}
{{--    <script src="{{ asset('adminassets/lib/data-table/datatables-init.js') }}"></script>--}}
    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>
    <script src={{ asset('adminassets/js/custom/cars-index.js') }}></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
{{--    <script src={{ asset('adminassets/js/custom/cars-img.js') }}></script>--}}
@endpush
