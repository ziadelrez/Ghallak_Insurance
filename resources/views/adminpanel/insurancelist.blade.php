@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-insurance-names.menu.insurance-list') }}
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
                    <h5 class="m-0 font-weight-bold text-primary float-right">{{ trans('page-insurance-names.pages.insurance-list') }}</h5>
                    <div class="float-left">
                        <button class="create-modal btn btn-primary btn-lg" >
                            <i class="fas fa-plus-circle"></i>
                            {{ trans('page-insurance-names.pages.buttons.btnadd') }}
                        </button>
                    </div>
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
                                <th width="150px" style="display:none;" >{{ trans('page-insurance-names.pages.tables.id') }}</th>
                                <th>{{ trans('page-insurance-names.pages.tables.catname') }}</th>
                                <th>{{ trans('page-insurance-names.pages.tables.name') }}</th>
                                <th class="text-center" width="150px">{{ trans('page-insurance-names.pages.tables.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($inslist as $ilist)
                                <tr class="brrows{{$ilist -> insid}}">
                                    <td style="display:none;" >{{$ilist -> insid}}</td>
                                    <td>{{$ilist -> instype}}</td>
                                    <td>{{$ilist -> insname}}</td>
                                    <td class="text-center">
                                        <button class="edit-modal btn btn-warning btn-sm" data-id="{{$ilist->insid}}" data-title="{{$ilist->insname}}" >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="delete-modal btn btn-danger btn-sm" data-id="{{$ilist->insid}}" data-title="{{$ilist->insname}}" >
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
        <input type="hidden" id="userlist" value="{{url('/adminpanel/busers')}}">
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
                    <form class="form-horizontal" role="form" id="formcreate">


                        <div class="form-group">
                            <label class="control-label col-sm-4" for="instype">{{ trans('page-insurance-names.pages.fields.instype') }} :</label>
                            <select id="instype" name="instype" class="form-control p selection"
                                    aria-required="true" aria-invalid="false">
                                <option></option>
                                {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
                                @foreach($ptype as $instypelist)
                                    <option value="{{$instypelist -> id}}">{{$instypelist -> Description}}</option>
                                @endforeach
                            </select>

                            <div class="alert alert-danger" id="err_details_instype" style="display:none">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="insname">{{ trans('page-insurance-names.pages.fields.insname') }} : </label>
                            <input type="text" class="form-control" id="insname" name="insname"
                                   placeholder="أدخل إسم التأمين" required>

                            <div class="alert alert-danger" id="err_details_insname" style="display:none">

                            </div>
                        </div>
                        <div class="form-group has-success">
                            <label class="control-label mb-1" for="details">{{ trans('page-insurance-names.pages.fields.details') }} :</label>
                            <input type="text" class="form-control" id="details" name="details"
                                   placeholder="أدخل تفاصيل التأمين" required>

                            <div class="alert alert-danger" id="err_details_details" style="display:none">

                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="add">
                        <span class="fas fa-plus"></span>{{ trans('page-insurance-names.pages.fields.save') }}
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>   {{ trans('page-insurance-names.pages.fields.exit') }}
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
                            <label class="control-label col-sm-4"for="id">{{ trans('page-insurance-names.pages.fields.id') }} :</label>
                            <input type="text" class="form-control" id="fid" disabled>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="editinstype">{{ trans('page-insurance-names.pages.fields.instype') }} :</label>
                            <select id="editinstype" name="editinstype" class="form-control p selection"
                                    aria-required="true" aria-invalid="false">
                                <option></option>
                                @foreach($ptype as $instypelist)
                                    <option value="{{$instypelist -> id}}">{{$instypelist -> Description}}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger" id="err_details_editinstype" style="display:none"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="editinsname">{{ trans('page-insurance-names.pages.fields.insname') }} :</label>
                            <input type="text" class="form-control" id="editinsname" name="editinsname" >
                            <div class="alert alert-danger" id="err_details_editinsname" style="display:none"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label mb-1" for="editdetails">{{ trans('page-insurance-names.pages.fields.details') }} :</label>
                            <input type="text" class="form-control" id="editdetails" name="editdetails">
                            <div class="alert alert-danger" id="err_details_editdetails" style="display:none"></div>
                        </div>
                    </form>
                    {{-- Form Delete Post --}}
                    <div class="deleteContent">
                        هل تريد فعلا حذف هذا التأمين ؟ -  <span class="title"></span>
                        <span class="hidden id"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="fas fa-door-open"></span> {{ trans('page-insurance-names.pages.fields.exit') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="hide" id="hidden-values">
            <input id="general_def_quick" type="hidden" value="{{url('/addNewValue')}}">
        </div>
    </div>
@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/insurance-names.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





