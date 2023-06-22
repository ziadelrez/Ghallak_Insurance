@extends('layouts.masteradminpanel')


@section('title')
    {{trans('dashboard.dashboard.exptitlecard2')}}
@endsection

@push('css_content')
    {{--    <meta name="viewport" content="width=device-width, initial-scale=1">--}}
    {{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--}}
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
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{trans('dashboard.dashboard.exptitlecard2')}}</h1>
{{--                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>--}}
            </div>

                @can('all_access')
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Total Companies -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-right-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-shield-alt fa-2x " style="color:#2462dd;"></i> {{trans('dashboard.dashboard.totalcompanies')}}</div>
                                            <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.comp_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$totalcomp[0] -> id}}</span>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Contract -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-right-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-file-signature fa-2x " style="color:#dd151b;"></i> {{trans('dashboard.dashboard.totalcontract')}}</div>
                                            <ul class="list-group">
                                                @foreach($totalcontracts as $tcontract)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{$tcontract -> insname}}
                                                        <span class="badge badge-primary badge-pill">  {{$tcontract -> contdetid}}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Persons -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-right-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-user-alt fa-2x " style="color:#4edd34;"></i> {{trans('dashboard.dashboard.clients')}}</div>
                                            <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.office_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$offices[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.nclients_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$nclients[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.brokers_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$brokers[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.experts_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$experts[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.garages_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$garages[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.employees_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$employees[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.apersons_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$apersons[0]->id}}</span>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total ِAccident -->
                    <div class="row">
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card border-right-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-car-crash fa-2x " style="color:#d6d46d;"></i> {{trans('dashboard.dashboard.totalaccident')}}</div>
                                            <ul class="list-group">
                                                @foreach($totalacc as $tacc)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{$tacc -> accidenttypename}}
                                                        <span class="badge badge-primary badge-pill">  {{$tacc -> accid}}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @elsecan('garages_access')
                        <div class="effect-box vintage">
                            <h1>{{$branches[0]->name}}</h1>
                        </div>
                @elsecan('brokers_access')
                    <!-- Content Row -->
                        <div class="row">
                            <!-- Total Companies -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-shield-alt fa-2x " style="color:#2462dd;"></i> {{trans('dashboard.dashboard.totalcompanies')}}</div>
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.comp_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$totalcomp[0] -> id}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Contract -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-file-signature fa-2x " style="color:#dd151b;"></i> {{trans('dashboard.dashboard.totalcontract')}}</div>
                                                <ul class="list-group">
                                                    @foreach($totalcontracts as $tcontract)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{$tcontract -> insname}}
                                                            <span class="badge badge-primary badge-pill">  {{$tcontract -> contdetid}}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Persons -->
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-user-alt fa-2x " style="color:#4edd34;"></i> {{trans('dashboard.dashboard.clients')}}</div>
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.office_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$offices[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.nclients_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$nclients[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.brokers_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$brokers[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.experts_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$experts[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.garages_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$garages[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.employees_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$employees[0]->id}}</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        {{trans('dashboard.dashboard.apersons_lbl')}}
                                                        <span class="badge badge-primary badge-pill">  {{$apersons[0]->id}}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total ِAccident -->
                        <div class="row">
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xl-right font-weight-bold text-primary text-uppercase mb-1"><i class="fas fa-car-crash fa-2x " style="color:#d6d46d;"></i> {{trans('dashboard.dashboard.totalaccident')}}</div>
                                                <ul class="list-group">
                                                    @foreach($totalacc as $tacc)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{$tacc -> accidenttypename}}
                                                            <span class="badge badge-primary badge-pill">  {{$tacc -> accid}}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endcan


{{--            <div class="card">--}}
{{--                <div class="card-header"><i class="fas fa-list-ol fa-2x " style="color:#d6d336;"></i> {{trans('dashboard.dashboard.topclients')}}</div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                            @foreach($topclients as $tclients)--}}
{{--                                <div class="col-md-4 col-sm-4 col-xs-12">--}}
{{--                                    <div class="card text-white bg-secondary">--}}
{{--                                        <div class="card-header text-black-50">{{$tclients->cname}}</div>--}}
{{--                                        <img class="card-img-top img-fluid" src="{{asset("files/images/avatar/user-male.png")}}" style="width: auto; height: auto;" class="img-circle" />--}}
{{--                                        <div class="card-body">--}}
{{--                                            <h4 class="card-title">{{$tclients->carname}}</h4>--}}
{{--                                            <p class="card-text">{{$tclients->carnumber}} - {{$tclients->carcolor}} , {{$tclients->carmodel}}</p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
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
