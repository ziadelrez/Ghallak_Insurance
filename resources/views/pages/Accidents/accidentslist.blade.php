@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-accidents.menu.accidents-list') }}
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
                    <h5 class="m-0 font-weight-bold text-primary float-right">{{ trans('page-accidents.pages.accidents-list') }}</h5>
                    <div class="float-left">
                        <button class="create-modal btn btn-primary btn-lg" >
                            <i class="fas fa-plus-circle"></i>
                            {{ trans('page-accidents.pages.buttons.btnadd') }}
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
                                <th width="150px" style="display:none;" >{{ trans('page-accidents.pages.tables.id') }}</th>
                                <th>{{ trans('page-accidents.pages.tables.compname') }}</th>
                                @can('accident_actions')
                                    <th class="text-center" width="150px">{{ trans('page-accidents.pages.tables.actions') }}</th>
                                @endcan
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($complist as $colist)
                                <tr class="brrows{{$colist -> id}}">
                                    <td style="display:none;" >{{$colist -> id}}</td>
                                    <td>{{$colist -> compname}}</td>
                                    <td class="text-center">
                                        @can('companies_edit')
                                            <button class="edit-modal btn btn-warning btn-sm" data-id="{{$colist->id}}" data-title="{{$colist->compname}}" >
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        @endcan
                                        @can('companies_delete')
                                            <button class="delete-modal btn btn-danger btn-sm" data-id="{{$colist->id}}" data-title="{{$colist->compname}}" >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                    @can('instype_access')
                                        <td class="text-center">
                                            <a href=" {{ route('companies.plans.list',$colist->id)}}" class="btn btn-primary btn-sm" >
                                                <i class="fa fa-shield-alt"></i>
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
        <input type="hidden" id="inslist" value="{{url('/companies-insurance-list/')}}">
    </div>


    {{-- Modal Form Create Post --}}
    <div id="create" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" id="formcreate">

                        {{--##Company Name & Contact Person Name--}}
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="compname">{{ trans('page-accidents.pages.fields.compname') }} : </label>
                                    <input type="text" class="form-control" id="compname" name="compname"
                                           placeholder="أدخل اسم شركة التأمين" required>

                                    <div class="alert alert-danger" id="err_details_compname" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="contactperson">{{ trans('page-accidents.pages.fields.contactperson') }} : </label>
                                    <input type="text" class="form-control" id="contactperson" name="contactperson"
                                           placeholder="أدخل اسم المسؤول عن التواصل مع الشركة" required>

                                    <div class="alert alert-danger" id="err_details_contactperson" style="display:none">

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--##Address Company--}}
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="adr">{{ trans('page-accidents.pages.fields.adr') }} : </label>
                            <input type="text" class="form-control" id="adr" name="adr"
                                   placeholder="أدخل عنوان الشركة" required>

                            <div class="alert alert-danger" id="err_details_adr" style="display:none">

                            </div>
                        </div>

                        {{--##Region & Mobile & LandLine--}}
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="region">{{ trans('page-accidents.pages.fields.region') }} :</label>
                                    <select id="region" name="region" class="form-control p selection"
                                            aria-required="true" aria-invalid="false">
                                        <option></option>
                                        {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
                                        @foreach($reglist as $regionlist)
                                            <option value="{{$regionlist -> id}}">{{$regionlist -> Description}}</option>
                                        @endforeach
                                    </select>

                                    <div class="alert alert-danger" id="err_details_region" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="mob">{{ trans('page-accidents.pages.fields.mob') }} : </label>
                                    <input type="text" class="form-control" id="mob" name="mob"
                                           placeholder="أدخل رقم الخليوي" required>

                                    <div class="alert alert-danger" id="err_details_mob" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="land">{{ trans('page-accidents.pages.fields.land') }} : </label>
                                    <input type="text" class="form-control" id="land" name="land"
                                           placeholder="أدخل رقم الهاتف الأرضي"  required>

                                    <div class="alert alert-danger" id="err_details_land" style="display:none">

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--##Fax & Email & Website--}}
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="fax">{{ trans('page-accidents.pages.fields.fax') }} : </label>
                                    <input type="text" class="form-control" id="fax" name="fax"
                                           placeholder="أدخل رقم الفاكس" required>

                                    <div class="alert alert-danger" id="err_details_fax" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="email">{{ trans('page-accidents.pages.fields.email') }} : </label>
                                    <input type="text" class="form-control" id="email" name="email"
                                           placeholder="أدخل البريد الإلكتروني" required>

                                    <div class="alert alert-danger" id="err_details_email" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="website">{{ trans('page-accidents.pages.fields.website') }} : </label>
                                    <input type="text" class="form-control" id="website" name="website"
                                           placeholder="أدخل إسم موقع الشركة" required>

                                    <div class="alert alert-danger" id="err_details_website" style="display:none">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="add">
                        <span class="fas fa-plus"></span>{{ trans('page-accidents.pages.fields.save') }}
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>   {{ trans('page-accidents.pages.fields.exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Show POST --}}
    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="modal">

                        <div class="form-group">
                            <label class="control-label col-sm-4"for="id">{{ trans('page-accidents.pages.fields.id') }} :</label>
                            <input type="text" class="form-control" id="fid" disabled>
                        </div>

                        {{--##Company Name & Contact Person Name--}}
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="editcompname">{{ trans('page-accidents.pages.fields.compname') }} : </label>
                                    <input type="text" class="form-control" id="editcompname" name="editcompname"
                                           placeholder="أدخل اسم شركة التأمين" required>

                                    <div class="alert alert-danger" id="err_details_editcompname" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="editcontactperson">{{ trans('page-accidents.pages.fields.contactperson') }} : </label>
                                    <input type="text" class="form-control" id="editcontactperson" name="editcontactperson"
                                           placeholder="أدخل اسم المسؤول عن التواصل مع الشركة" required>

                                    <div class="alert alert-danger" id="err_details_editcontactperson" style="display:none">

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--##Address Company--}}
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="editadr">{{ trans('page-accidents.pages.fields.adr') }} : </label>
                            <input type="text" class="form-control" id="editadr" name="editadr"
                                   placeholder="أدخل عنوان الشركة" required>

                            <div class="alert alert-danger" id="err_details_editadr" style="display:none">

                            </div>
                        </div>

                        {{--##Region & Mobile & LandLine--}}
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="editregion">{{ trans('page-accidents.pages.fields.region') }} :</label>
                                    <select id="editregion" name="editregion" class="form-control p selection"
                                            aria-required="true" aria-invalid="false">
                                        <option></option>
                                        {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
                                        @foreach($reglist as $regionlist)
                                            <option value="{{$regionlist -> id}}">{{$regionlist -> Description}}</option>
                                        @endforeach
                                    </select>

                                    <div class="alert alert-danger" id="err_details_editregion" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="editmob">{{ trans('page-accidents.pages.fields.mob') }} : </label>
                                    <input type="text" class="form-control" id="editmob" name="editmob"
                                           placeholder="أدخل رقم الخليوي" required>

                                    <div class="alert alert-danger" id="err_details_editmob" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="editland">{{ trans('page-accidents.pages.fields.land') }} : </label>
                                    <input type="text" class="form-control" id="editland" name="editland"
                                           placeholder="أدخل رقم الهاتف الأرضي" required>

                                    <div class="alert alert-danger" id="err_details_editland" style="display:none">

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--##Fax & Email & Website--}}
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="editfax">{{ trans('page-accidents.pages.fields.fax') }} : </label>
                                    <input type="text" class="form-control" id="editfax" name="editfax"
                                           placeholder="أدخل رقم الفاكس" required>

                                    <div class="alert alert-danger" id="err_details_editfax" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="editemail">{{ trans('page-accidents.pages.fields.email') }} : </label>
                                    <input type="text" class="form-control" id="editemail" name="editemail"
                                           placeholder="أدخل البريد الإلكتروني" required>

                                    <div class="alert alert-danger" id="err_details_editemail" style="display:none">

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="control-label col-sm-6" for="editwebsite">{{ trans('page-accidents.pages.fields.website') }} : </label>
                                    <input type="text" class="form-control" id="editwebsite" name="editwebsite"
                                           placeholder="أدخل إسم موقع الشركة" required>

                                    <div class="alert alert-danger" id="err_details_editwebsite" style="display:none">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                    {{-- Form Delete Post --}}
                    <div class="deleteContent">
                        هل تريد فعلا حذف هذه الشركة ؟ -  <span class="title"></span>
                        <span class="hidden id"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="fas fa-door-open"></span> {{ trans('page-accidents.pages.fields.exit') }}
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
    <script src={{ asset('adminassets/js/custom/companies.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





