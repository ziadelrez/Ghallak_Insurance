@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.menu.contracts') }}
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
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><a href="{{url('/clients-list')}}"> {{ trans('global.backtoclient') }}  </a></h6>--}}
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">  /  {{ trans('global.clientcontracts') }}</span ><span style="color:black"> : </span><span style="color:red">{{$clientname}}</span ></h6>--}}

                    <div class="row">
                        <div class="col-9">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{url('/clients-list')}}">{{ trans('global.backtoclient') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('global.clientcontracts') }}<span style="color:black"> : </span><span style="color:red">{{$clientname}}</span ></li>
                                </ol>
                            </nav>
                        </div>

                        <div class="col-3">
                            <div class="float-left">
                                <button class="create-modal btn btn-primary btn-lg" >
                                    <i class="fas fa-plus-circle"></i>
                                    {{ trans('page-contract.contract.buttons.btnadd') }}
                                </button>
                            </div>
                        </div>
                    </div>


                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <input id="client_id" type="hidden" name="client_id" value="{{$client_id}}">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >{{ trans('page-contract.contract.tables.id') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.code') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.date') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.billnum') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.coinscount') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.coinsname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.totalamountusd') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.totalamountlbp') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.actionsins') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($contractlist as $colist)
                                <input id="contract_id" type="hidden" name="contract_id" value="">
                                <tr class="corrows{{$colist -> id}}">
                                    <td style="display:none;" >{{$colist -> id}}</td>
                                    <td class="text-center align-middle text-nowrap">{{$colist -> cocode}}</td>
                                    <td class="text-center align-middle text-nowrap">{{$colist -> codate}}</td>
                                    <td class="text-center align-middle text-nowrap">{{$colist -> codestr}}</td>
                                    <td class="text-center align-middle text-nowrap">{{$colist -> coinscount}}</td>
                                    <td class="text-center align-middle text-nowrap">{{$colist -> coinsname}}</td>
                                    <td class="text-center align-middle text-nowrap">{{$colist -> coamount}} {{$colist -> cocurr}}</td>
                                    <td class="text-center align-middle text-nowrap">{{$colist -> coamountlbp}} {{$colist -> cocurrlbp}}</td>
                                    <td class="text-center align-middle text-nowrap">
                                        <a href="{{ route('contract-details',$colist -> id)}}" class="btn btn-info btn-sm" title="{{ trans('page-contract.contract.titles.cdetails') }}">
                                            <i class="fa fa-user-shield"></i>
                                        </a>
                                        <a href="{{ route('print-bill-client',$colist -> id)}}" target="_blank" class="btn btn-outline-primary btn-sm" title="{{ trans('page-contract.contract.titles.printbill') }}">
                                            <i class="fa fa-money-bill-alt"></i>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle text-nowrap">
                                        <button class="edit-modal btn btn-warning btn-sm" data-id="{{$colist -> id}}" data-cocode="{{$colist->cocode}}" data-codate="{{$colist->codate}}" title="{{ trans('page-contract.contract.titles.editcontract') }}">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="delete-modal btn btn-danger btn-sm" data-id="{{$colist -> id}}" data-title="{{$colist->cocode}}" title="{{ trans('page-contract.contract.titles.deletecontract') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <input type="hidden" id="cdetails" value="{{url('/contract-details')}}">
                        <input type="hidden" id="printbilldetails" value="{{url('/print-bill-client')}}">
                        <input type="hidden" id="t1" value="{{ trans('page-contract.contract.titles.cdetails') }}">
                        <input type="hidden" id="tprint" value="{{ trans('page-contract.contract.titles.printbill') }}">
                        <input type="hidden" id="t2" value="{{ trans('page-contract.contract.titles.adddriver') }}">
                        <input type="hidden" id="t3" value="{{ trans('page-contract.contract.titles.cpayments') }}">
                        <input type="hidden" id="t4" value="{{ trans('page-contract.contract.titles.editcontract') }}">
                        <input type="hidden" id="t5" value="{{ trans('page-contract.contract.titles.deletecontract') }}">
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>


    {{-- Modal Form Create Post --}}
    <div id="createdriver" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <input id="contract_id_1" type="hidden" name="contract_id_1" value="">
                    <input id="cflag" type="hidden" name="cflag" value="">
                    <input id="liid" type="hidden" name="liid" value="">
{{--                    <span class="hidden idli"></span>--}}
                    <form class="form-horizontal" role="form">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="form-group">
                                <label class="control-label " for="lblcocode">{{ trans('page-contract.contract.modals.lblcocode') }} : </label>
                                <input class="form-control" id="lblcocode" type="text" name="lblcocode" value="" disabled>
                            </div>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="form-group">
                                <label class="control-label " for="person">{{ trans('page-contract.contract.modals.personli') }} : </label>
                                <input type="text" class="form-control" id="person" name="person"
                                       placeholder="{{ trans('page-contract.contract.modals.personliholder') }}" required>

                                <div class="alert alert-danger" id="err_details_person" style="display:none">

                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="linum">{{ trans('page-contract.contract.modals.linumber') }} :</label>
                            <input type="text" class="form-control" id="linum" name="linum"
                                   placeholder="{{ trans('page-contract.contract.modals.linumberholder') }}" required>

                            <div class="alert alert-danger" id="err_details_linum" style="display:none">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group" data-label="1">
                            <label class="control-label " for="liplace">{{ trans('page-contract.contract.modals.lbl_license_place') }} :</label>
                            <select id="liplace" name="liplace" class="form-control p selectionliplace2"
                                    aria-required="true" aria-invalid="false">
                                <option></option>
                                {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
{{--                                @foreach($liplacelist as $pliclist)--}}
{{--                                    <option value="{{$pliclist -> id}}">{{$pliclist -> Description}}</option>--}}
{{--                                @endforeach--}}
                            </select>

                            <div class="alert alert-danger" id="err_details_liplace" style="display:none">

                            </div>
                        </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                            <label for="lidate"
                                   class="control-label ">{{trans('page-contract.contract.modals.lbl_license_date')}} :</label>
                            <input id="lidate" name="lidate" type="date"
                                   class="form-control lidate valid" required>
                            <div class="alert alert-danger" id="err_details_lidate" style="display:none">

                            </div>
                        </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="adddriver">
                        <span id="adddrivericon" class="fas"></span>
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>   {{ trans('page-contract.contract.fields.exit') }}
                    </button>
                </div>
                <div class="container">
                      <form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablemodal" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >{{ trans('page-contract.contract.modals.linumid') }}</th>
                                <th class="text-center" width="600px">{{ trans('page-contract.contract.modals.personli') }}</th>
                                <th class="text-center" width="400px">{{ trans('page-contract.contract.modals.linumber') }}</th>
                                <th class="text-center" width="250px">{{ trans('page-contract.contract.modals.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                                <tr class="lirows">
                                    <td class="text-center" width="150px" style="display:none;" ></td>
                                    <td class="text-center" width="600px"></td>
                                    <td class="text-center" width="400px"></td>
                                    <td class="text-center" width="250px">
                                        <button type="button" class="edit-modal-li btn btn-warning btn-sm" data-id="" data-person="" data-linum="">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="delete-modal-li btn btn-danger btn-sm" data-id="" >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <div id="create" class="modal fade" role="dialog" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <input id="contract_id_1" type="hidden" name="contract_id_1" value="">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="required" for="codate"
                                   class="control-label mb-1">{{trans('page-contract.contract.fields.codate')}}</label>
                            <input id="codate" name="codate" type="date"
                                   class="form-control codate valid"
                                   value="{{old('codate')}}">

                            <div class="alert alert-danger" id="err_details_codate" style="display:none"> </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="add">
                        <span class="fas fa-plus"></span>{{ trans('page-contract.contract.fields.save') }}
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>   {{ trans('page-contract.contract.fields.exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Form Edit and Delete Post --}}
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="modal">

                        <div class="form-group">
{{--                            <label class="control-label col-sm-4"for="id">{{ trans('page-contract.contract.fields.id') }} :</label>--}}
                            <input type="hidden" class="form-control" id="fid" disabled>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4" for="editcocode">{{ trans('page-contract.contract.tables.code') }} :</label>
                            <input type="text" class="form-control" id="editcocode" name="editcocode" disabled>
                        </div>

                        <div class="form-group ">
                            <label class="required" for="editcodate"
                                   class="control-label mb-1">{{trans('page-contract.contract.fields.codate')}} : </label>
                            <input id="editcodate" name="editcodate" type="date"
                                   class="form-control editcodate valid"
                                   value="{{old('codate')}}">
                            @error('codate')
                            <small class="form-text text-danger">{{trans('validation.contracts.codate_required')}}</small>
                            @enderror
                        </div>

                    </form>
                    {{-- Form Delete Post --}}
                    <div class="deleteContent">
                        هل تريد فعلا إلغاء هذا العقد ؟ -  <span class="title"></span>
                        <span class="hidden id"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <span class="fas fa-window-close"></span> {{ trans('page-contract.contract.fields.noanswer') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="hide" id="hidden-values">
            <input id="def_quick_add" type="hidden" value="{{url('/addNewValueliplace')}}">
        </div>
    </div>
@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/contracts-index.js') }}></script>
    <script src={{ asset('adminassets/js/custom/contracts-license.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





