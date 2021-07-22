@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.license_title') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
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
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">{{ trans('page-client.clients.license_title') }} :</span> <span style="color:red">{{$client_name}}</span>--}}
{{--                    <br><br><a href="{{ route("clients-list") }}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtoclient') }}</a></h6>--}}
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route("clients-list") }}">{{ trans('global.backtoclient') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('page-client.clients.license_title') }}<span style="color:black"> : </span><span style="color:red">{{$client_name}}</span ></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <button class="create-modal btn btn-primary btn-lg" >
                                <i class="fas fa-plus-circle"></i>
                                {{ trans('page-client.clients.clients_license_add') }}
                            </button>
                        </div>
                    </div>
{{--                    <div class="float-left">--}}
{{--                        --}}
{{--                    </div>--}}
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
                                <th width="150px" style="display:none;" >{{ trans('page-client.clients.tables.license_id') }}</th>
                                <th>{{ trans('page-client.clients.tables.license_driver') }}</th>
                                <th>{{ trans('page-client.clients.tables.license_num') }}</th>
                                <th>{{ trans('page-client.clients.tables.license_place') }}</th>
                                <th>{{ trans('page-client.clients.tables.license_date') }}</th>
                                <th class="text-center" width="150px">{{ trans('page-client.clients.tables.license_actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($licensedetails as $lilist)
                                <tr class="lirows{{$lilist -> liid}}">
                                    <td style="display:none;" >{{$lilist -> liid}}</td>
                                    <td>{{$lilist -> drivername}}</td>
                                    <td>{{$lilist -> lnum}}</td>
                                    <td>{{$lilist -> placename}}</td>
                                    <td>{{$lilist -> dateend}}</td>
                                    <td class="text-center">
                                        <button class="edit-modal btn btn-warning btn-sm" title="{{ trans('page-client.clients.titles.liedit') }}" data-id="{{$lilist->liid}}" data-title="{{$lilist->drivername}}" >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="delete-modal btn btn-danger btn-sm" title="{{ trans('page-client.clients.titles.lidelete') }}" data-id="{{$lilist->liid}}" data-title="{{$lilist->drivername}}" >
                                            <i class="fas fa-trash"></i>
                                        </button>
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


    {{-- Modal Form Create Post --}}
    <div id="create" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">

                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="driver">{{ trans('page-client.clients.modals.lbl_license_driver') }}</label>
                            <input type="text" class="form-control" id="driver" name="driver">
                            <input id="clid" type="hidden" name="clid" class="form-control" value="{{$client_id}}">

                            <div class="alert alert-danger" id="err_details_driver" style="display:none"></div>


                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="linum">{{ trans('page-client.clients.modals.lbl_license_linum') }}</label>
                            <input type="text" class="form-control" id="linum" name="linum" required>

                            <div class="alert alert-danger" id="err_details_linum" style="display:none">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="place">{{ trans('page-client.clients.modals.lbl_license_place') }}</label>
                            <select id="place" name="place" class="form-control p selection"
                                    aria-required="true" aria-invalid="false">
                                <option></option>
                                {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
                                @foreach($passplacelist as $palcelist)
                                    <option value="{{$palcelist -> id}}">{{$palcelist -> Description}}</option>
                                @endforeach
                            </select>

                            <div class="alert alert-danger" id="err_details_place" style="display:none">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="lidate">{{ trans('page-client.clients.modals.lbl_license_date') }}</label>
                            <input id="lidate" name="lidate" type="date"
                                   class="form-control lidate valid" >

                            <div class="alert alert-danger" id="err_details_lidate" style="display:none">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="add">
                        <span class="fas fa-plus"></span>{{ trans('page-client.clients.modals.lbl_license_save') }}
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>{{ trans('page-client.clients.modals.lbl_license_exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Show POST --}}
    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">ID :</label>
                        <b id="i"/>
                    </div>
                    <div class="form-group">
                        <label for="">Title :</label>
                        <b id="ti"/>
                    </div>
                    <div class="form-group">
                        <label for="">Body :</label>
                        <b id="by"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Edit and Delete Post --}}
    <div id="myModal"class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="modal">

                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="editdriver">{{ trans('page-client.clients.modals.lbl_license_driver') }}</label>
                            <input type="text" class="form-control" id="editdriver" name="editdriver">
                            <input id="editliid" type="hidden" name="editliid" class="form-control" >

                            <div class="alert alert-danger" id="err_details_editdriver" style="display:none"></div>


                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="editlinum">{{ trans('page-client.clients.modals.lbl_license_linum') }}</label>
                            <input type="text" class="form-control" id="editlinum" name="editlinum" required>

                            <div class="alert alert-danger" id="err_details_editlinum" style="display:none">

                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="control-label col-sm-4 required" for="editplace">{{ trans('page-client.clients.modals.lbl_license_place') }}</label>
                            <select id="editplace" name="editplace" class="form-control p selection"
                                    aria-required="true" aria-invalid="false">
                                <option></option>
                                {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
                                @foreach($passplacelist as $palcelist)
                                    <option value="{{$palcelist -> id}}">{{$palcelist -> Description}}</option>
                                @endforeach
                            </select>

                            <div class="alert alert-danger" id="err_details_editplace" style="display:none">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="editlidate">{{ trans('page-client.clients.modals.lbl_license_date') }}</label>
                            <input id="editlidate" name="editlidate" type="date"
                                   class="form-control editlidate valid" >

                            <div class="alert alert-danger" id="err_details_editlidate" style="display:none">

                            </div>
                        </div>

                    </form>

{{--                     Form Delete Post --}}
                    <div class="deleteContent">
                        <span class="hidden id"></span><span> - </span>{{ trans('page-client.clients.modals.lbl_license_deleteconfirmation') }}<span class="title"></span><span>{{ trans('page-client.clients.modals.lbl_license_questionmark') }}</span>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="fas fa-door-open"></span> {{ trans('page-client.clients.modals.lbl_license_exit') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="hide" id="hidden-values">
            <input id="def_quick_add_place" type="hidden" value="{{url('/addNewValuePlace')}}">
        </div>
    </div>
@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/clients-license.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





