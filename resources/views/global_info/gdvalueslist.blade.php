@extends('layouts.masteradminpanel')


@section('title')
    {{ $titlegd }}
@endsection

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
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><a href="{{url('/gdef-list')}}"><i class="fas fa-angle-double-left"></i><span style="color:red"> جدول المعلومات العامة</span ></a>--}}
{{--                        <br><br>{{ $titlegd }}</h6>--}}
                    <div class="row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/gdef-list')}}">{{ trans('global.generalinfolist') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><span style="color:black"></span><span style="color:red">{{ $titlegd }}</span ></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <button class="create-modal btn btn-primary btn-lg btn-block" >
                                <i class="fas fa-plus-circle"></i>
                                {{ trans('global.addgeninfo') }}
                            </button>
                        </div>
                    </div>
                    <div class="hide" id="hidden-values">
                        <input id="gd_tb" type="hidden" name="gd_tb" value="{{ $tbid }}">
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
                                <th width="150px" style="display:none;" >{{ trans('global.serialcode') }}</th>
                                <th>{{ trans('global.definition') }}</th>
                                <th class="text-center" width="150px">{{ trans('global.actionsdef') }}</th>
                            </tr>
                            </thead>
{{--                            <tfoot>--}}
{{--                            <tr>--}}
{{--                                <th width="150px" style="display:none;">رقم التسلسلي</th>--}}
{{--                                <th>التعريف</th>--}}
{{--                                <th class="text-center" width="150px" >الاجراءات</th>--}}
{{--                            </tr>--}}
{{--                            </tfoot>--}}
                            <tbody>
                            @foreach($gdlist as $dlist)
                                <tr class="gdrows{{$dlist -> id}}">
                                    <td style="display:none;" >{{$dlist -> id}}</td>
                                    <td>{{$dlist -> Description}}</td>
                                    <td class="text-center">
{{--                                        <a href="#" class="show-modal btn btn-info btn-sm" data-id="{{$dlist->id}}" data-title="{{$dlist->Description}}" >--}}
{{--                                            <i class="fa fa-eye"></i>--}}
{{--                                        </a>--}}
                                        <button class="edit-modal btn btn-warning btn-sm" data-id="{{$dlist->id}}" data-title="{{$dlist->Description}}" >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="delete-modal btn btn-danger btn-sm" data-id="{{$dlist->id}}" data-title="{{$dlist->Description}}" >
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
                            <label class="control-label col-sm-4" for="title">التعريف :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" name="title"
                                       placeholder="إدخال التعريف" required>

                                <div class="alert alert-danger" id="err_details" style="display:none">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="add">
                        <span class="fas fa-plus"></span>     حفظ التعريف
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>   خروج
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
                            <label class="control-label col-sm-4"for="id">الرقم التسلسلي :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fid" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4"for="title">التعريف :</label>
                            <div class="col-sm-10">
                                <input type="name" class="form-control" id="t">
                                <div class="alert alert-danger" id="err_details_up" style="display:none"></div>
                            </div>
                        </div>
                    </form>
                    {{-- Form Delete Post --}}
                    <div class="deleteContent">
                        هل تريد فعلا حذف هذا التعريف ؟ -  <span class="title"></span>
                        <span class="hidden id"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="fas fa-door-open"></span> خروج
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/gddefinition.js') }}></script>
@endpush




