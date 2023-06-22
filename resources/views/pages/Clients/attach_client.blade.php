@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.attach_title') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />--}}
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
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">{{ trans('page-client.clients.attach_title') }} :</span> <span style="color:red">{{$client_name}}</span>--}}
{{--                    <br><br><a href="{{ route("clients-list") }}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtoclient') }}</a></h6>--}}
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route("clients-list") }}">{{ trans('global.backtoclient') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('page-client.clients.attach_title') }}<span style="color:black"> : </span><span style="color:red">{{$client_name}}</span ></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <button class="create-modal btn btn-primary btn-lg" >
                                <i class="fas fa-plus-circle"></i>
                                {{ trans('page-client.clients.clients_docs_add') }}
                            </button>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <input type="hidden" id="client_id" value="{{$client_id}}">
                <input type="hidden" id="doc_id" name="doc_id" value="">

                <div class="card-body">
                   <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >{{ trans('page-client.clients.tables.attach_id') }}</th>
                                <th width="400px" >{{ trans('page-client.clients.tables.docname') }}</th>
                                <th class="text-center" width="200px">{{ trans('page-client.clients.tables.license_actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($docdetails as $doclist)
                                <tr class="attachrows{{$doclist -> id}}">
                                    <td style="display:none;" width="150px">{{$doclist -> id}} </td>
                                    <td width="400px">{{$doclist -> docname}}</td>
                                    <td class="text-center" width="200px">

                                        <a class="viewdoc-modal btn btn-info btn-sm" title="{{ trans('page-client.clients.titles.viewdoc') }}" href="{{ route('print.doc', $doclist -> id) }}" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <button class="createimg-modal btn btn-primary btn-sm" title="{{ trans('page-client.clients.titles.addimg') }}" data-id="{{$doclist -> id}}" data-title="{{$doclist -> docname}}">
                                            <i class="fas fa-images"></i>
                                        </button>

                                        <button class="edit-modal btn btn-warning btn-sm" title="{{ trans('page-client.clients.titles.editdoc') }}" data-id="{{$doclist->id}}" data-title="{{$doclist->docname}}" >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="delete-modal btn btn-danger btn-sm" title="{{ trans('page-client.clients.titles.deletedoc') }}" data-id="{{$doclist->id}}" data-title="{{$doclist->docname}}" >
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


    {{-- Modal Form Create Document Name --}}
    <div id="create" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-sm-4 required" for="docname">{{ trans('page-client.clients.modals.lbl_doc_cname') }}</label>
                            <input type="text" class="form-control" id="docname" name="docname">
                            <input id="clid" type="hidden" name="clid" class="form-control" value="{{$client_id}}">

                            <div class="alert alert-danger" id="err_details_docname" style="display:none"></div>
                        </div>
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

    {{-- Modal Form Make Attachement --}}
    <div id="createimg" class="modal fade" role="dialog" >
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
                                <i class="fas fa-paperclip"></i> {{trans('global.attach')}}
                                <span id="counter"></span>
                            </strong>
                        </div>
                        <div class="card-body">
                            {{--                                <div class="form-group">--}}
                            <form action="{{route('clients.attach')}}" class="dropzone margin-top-10"
                                  id="my-dropzone">
                                @csrf
                                <div class="dz-message text-center" data-dz-message ><span><div>{{trans('global.drop')}}
                                    <span class="text-danger">{{trans('global.files')}}</span> {{trans('global.here')}} <br>{{trans('global.click')}} <br>{{trans('global.direct')}}</div></span>
                                </div>
                            </form>
                        </div>
                    </div> <!-- .card -->
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
                            <label class="control-label col-sm-4 required" for="editdoc">{{ trans('page-client.clients.modals.lbl_doc_cname') }}</label>
                            <input type="text" class="form-control" id="editdoc" name="editdoc">
                            <input id="editdocid" type="hidden" name="editdocid"  value = "" class="form-control" >

                            <div class="alert alert-danger" id="err_details_editdoc" style="display:none"></div>


                        </div>
                    </form>

{{--                     Form Delete Post --}}
                    <div class="deleteContent">
                        <span class="hidden id"></span><span> - </span>{{ trans('page-client.clients.modals.lbl_license_deletedocconfirmation') }}<span class="title"></span><span>{{ trans('page-client.clients.modals.lbl_license_questionmark') }}</span>

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
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
    <script src={{ asset("adminassets/vendor/dropzone/dropzone.js") }}></script>
    <script src={{ asset("adminassets/vendor/featherlight/featherlight.js") }}></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>--}}
    <script src={{ asset('adminassets/js/custom/clients-docs.js') }}></script>
@endpush





