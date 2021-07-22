@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-branch.menu.branch-list') }}
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
                    <h5 class="m-0 font-weight-bold text-primary float-right">{{ trans('page-branch.pages.branch-list') }}</h5>
                    <div class="float-left">
                        <button class="create-modal btn btn-primary btn-lg" >
                            <i class="fas fa-plus-circle"></i>
                            {{ trans('page-branch.pages.buttons.btnadd') }}
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
                                <th width="150px" style="display:none;" >{{ trans('page-branch.pages.tables.id') }}</th>
                                <th>{{ trans('page-branch.pages.tables.name') }}</th>
                                <th class="text-center" width="150px">{{ trans('page-branch.pages.tables.actions') }}</th>
                                @can('user_access')
                                <th class="text-center" width="150px">{{ trans('page-branch.pages.tables.users') }}</th>
                                @endcan
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($brlist as $blist)
                                <tr class="brrows{{$blist -> brid}}">
                                    <td style="display:none;" >{{$blist -> brid}}</td>
                                    <td>{{$blist -> brname}} - {{$blist -> locname}}</td>
                                    <td class="text-center">
                                        <button class="edit-modal btn btn-warning btn-sm" data-id="{{$blist->brid}}" data-title="{{$blist->brname}}" >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="delete-modal btn btn-danger btn-sm" data-id="{{$blist->brid}}" data-title="{{$blist->brname}}" >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                    @can('user_access')
                                        <td class="text-center">
                                            <a href="{{ route('adminpanel.busers',$blist->brid)}}" class="btn btn-info btn-sm" >
                                                <i class="fa fa-users"></i>
                                            </a>
                                        </td>
                                    @endcan
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
                            <label class="control-label col-sm-4" for="brname">{{ trans('page-branch.pages.fields.brname') }} : </label>
                            <input type="text" class="form-control" id="brname" name="brname"
                                   placeholder="أدخل اسم الفرع" required>

                            <div class="alert alert-danger" id="err_details_brname" style="display:none">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="location">{{ trans('page-branch.pages.fields.brlocation') }} :</label>
                            <select id="location" name="location" class="form-control p selection"
                                    aria-required="true" aria-invalid="false">
                                <option></option>
                                {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
                                @foreach($location as $loclist)
                                    <option value="{{$loclist -> id}}">{{$loclist -> Description}}</option>
                                @endforeach
                            </select>

                            <div class="alert alert-danger" id="err_details_location" style="display:none">

                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="control-label mb-1" for="landline">{{ trans('page-branch.pages.fields.cland') }} :</label>
                                        <input type="text" class="form-control" id="landline" name="landline"
                                               placeholder="أدخل رقم الهاتف الارضي" required>

                                        <div class="alert alert-danger" id="err_details_landline" style="display:none">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group has-success">
                                        <label class="control-label mb-1" for="mobile">{{ trans('page-branch.pages.fields.cmob') }} :</label>
                                        <input type="text" class="form-control" id="mobile" name="mobile"
                                               placeholder="أدخل رقم الهاتف الخليوي" required>

                                        <div class="alert alert-danger" id="err_details_mobile" style="display:none">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="add">
                        <span class="fas fa-plus"></span>{{ trans('page-branch.pages.fields.save') }}
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>   {{ trans('page-branch.pages.fields.exit') }}
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
                            <label class="control-label col-sm-4"for="id">{{ trans('page-branch.pages.fields.id') }} :</label>
                            <input type="text" class="form-control" id="fid" disabled>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="editbrname">{{ trans('page-branch.pages.fields.brname') }} :</label>
                            <input type="text" class="form-control" id="editbrname" name="editbrname" >
                            <div class="alert alert-danger" id="err_details_editbrname" style="display:none"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="editlocation">{{ trans('page-branch.pages.fields.brlocation') }} :</label>
                            <select id="editlocation" name="editlocation" class="form-control p selection"
                                    aria-required="true" aria-invalid="false">
                                <option></option>
                                @foreach($location as $loclist)
                                    <option value="{{$loclist -> id}}">{{$loclist -> Description}}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger" id="err_details_editlocation" style="display:none"></div>
                        </div>

                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label mb-1" for="editlandline">{{ trans('page-branch.pages.fields.cland') }} :</label>
                                        <input type="text" class="form-control" id="editlandline" name="editlandline">
                                        <div class="alert alert-danger" id="err_details_editlandline" style="display:none"></div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label mb-1" for="editmobile">{{ trans('page-branch.pages.fields.cmob') }} :</label>
                                        <input type="text" class="form-control" id="editmobile" name="editmobile">
                                        <div class="alert alert-danger" id="err_details_editmobile" style="display:none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- Form Delete Post --}}
                    <div class="deleteContent">
                        هل تريد فعلا حذف هذا الفرع ؟ -  <span class="title"></span>
                        <span class="hidden id"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="fas fa-door-open"></span> {{ trans('page-branch.pages.fields.exit') }}
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
    <script src={{ asset('adminassets/js/custom/branches.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





