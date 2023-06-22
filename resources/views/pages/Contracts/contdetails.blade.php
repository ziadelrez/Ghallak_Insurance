@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-contract.menu.contractsdet') }}
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
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">{{ trans('global.clientcontractsdet') }}</span ><span style="color:black"> : </span><span style="color:red">{{ $codename }} , {{ $clientname }}</span >--}}
{{--                        <br><br><a href="{{ route('contract-client', $clientid) }}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtocontractdet') }}</a></h6>--}}

                    <div class="row">
                        <div class="col-md-8 col-sm-9 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('contract-client', $clientid) }}">{{ trans('global.backtocontractdet') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('global.clientcontractsdet') }}<span style="color:black"> : </span><span style="color:red">{{ $codename }} , {{ $clientname }}</span ></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-md-4 col-sm-3 col-xs-12">
                            <a class="btn btn-primary btn-lg btn-block" href="{{ route('contract-ins-details.create', $contract_id) }}">
                                <i class="fas fa-plus-circle"></i>
                                {{ trans('page-contract.contract.buttons.btnaddcontactdet') }}
                            </a>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <input id="contid_id" type="hidden" name="contid_id" value="{{$contract_id}}">
                <input id="contdet_id" type="hidden" name="contid_id" value="">
                <input id="car_id" type="hidden" name="car_id" value="">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;">{{ trans('page-contract.contract.tables.id') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.compname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.carnameins') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.maidname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.insname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.fromdate') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.todate') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.dayscount') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.cost') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.curr') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-contract.contract.tables.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($contractdetlist as $colist)
                                <tr class="codetrrows{{$colist -> codetid}}">
                                        <td style="display:none;" >{{$colist -> codetid}}</td>
                                        <td class="text-center align-middle text-nowrap ">{{$colist -> compname}}</td>
                                        <td class="text-center align-middle text-nowrap ">{{$colist -> carname}} - {{$colist -> carnumber}}</td>
                                        <td class="text-center align-middle text-nowrap ">{{$colist -> maidname}} - {{$colist -> passport}}</td>
                                        <td class="text-center align-middle text-nowrap ">{{$colist -> insname}}</td>
                                        <td class="text-center align-middle text-nowrap ">{{$colist -> sdate}}</td>
                                        <td class="text-center align-middle text-nowrap " >{{$colist -> edate}}</td>
                                        <td class="text-center align-middle text-nowrap " >{{$colist -> days}}</td>
                                        <td class="text-center align-middle text-nowrap ">{{$colist -> totalcost}}</td>
                                        <td class="text-center align-middle text-nowrap ">{{$colist -> currname}}</td>
                                        <td class="text-center align-middle text-nowrap" >
                                            <a class="btn btn-warning btn-sm" title="{{ trans('page-contract.contract.titles.edit') }}" href="{{ route('contract-details.edit', $colist->codetid) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <button class="delete-modal btn btn-danger btn-sm" title="{{ trans('page-contract.contract.titles.delete') }}" data-id="{{$colist -> codetid}}" data-title="{{$colist->carname}}" >
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

                        {{--##Office Date & TIME IN--}}
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="officedatein"
                                            class="control-label mb-1">{{trans('page-contract.contract.fields.officedatein')}}</label>
                                    <input id="officedatein" name="officedatein" type="date"
                                           class="form-control officedatein valid"
                                           value="{{old('officedatein')}}">
                                    {{--                                            @error('officedatein')--}}
                                    {{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.officedatein_required')}}</small>--}}
                                    {{--                                            @enderror--}}
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="officetimein"
                                            class="control-label mb-1">{{trans('page-contract.contract.fields.officetimein')}}</label>
                                    <input id="officetimein" name="officetimein" type="time"
                                           class="form-control timeout valid"
                                           value="{{old('officetimein')}}">
                                    {{--                                            @error('officetimein')--}}
                                    {{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.officetimein_required')}}</small>--}}
                                    {{--                                            @enderror--}}
                                </div>
                            </div>
                        </div>

                        {{--##Extra Hours Cost--}}
                        <div class="form-group has-success">
                            <label  for="hcost" class="control-label mb-1">{{trans('page-contract.contract.fields.hcost')}}</label>
                            <input id="hcost" name="hcost" type="number"
                                   class="form-control hcost valid" value="0">
                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                  data-valmsg-replace="true"></span>
                            {{--                                    @error('hcost')--}}
                            {{--                                    <small class="form-text text-danger">{{trans('validation.contractsdet.hcost_required')}}</small>--}}
                            {{--                                    @enderror--}}
                        </div>

                        {{--##Extra time & Extra cost--}}
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="extratime" class="control-label mb-1">{{trans('page-contract.contract.fields.extratime')}}</label>
                                    <input id="extratime" name="extratime" type="number"
                                           class="form-control extratime valid" value="0">
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                          data-valmsg-replace="true"></span>
                                    {{--                                            @error('extratime')--}}
                                    {{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.extratime_required')}}</small>--}}
                                    {{--                                            @enderror--}}
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group has-success">
                                    <label  for="extracost" class="control-label mb-1">{{trans('page-contract.contract.fields.extracost')}}</label>
                                    <input id="extracost" name="extracost" type="number"
                                           class="form-control extracost valid" value="0">
                                    <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                          data-valmsg-replace="true"></span>
                                    {{--                                            @error('extracost')--}}
                                    {{--                                            <small class="form-text text-danger">{{trans('validation.contractsdet.extracost_required')}}</small>--}}
                                    {{--                                            @enderror--}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-success">
                            <label  for="sumtotal" class="control-label mb-1">{{trans('page-contract.contract.fields.sumtotal')}}</label>
                            <input id="sumtotal" name="sumtotal" type="number"
                                   class="form-control sumtotal valid" value="0">
                            <span class="help-block field-validation-valid" data-valmsg-for="cc-name"
                                  data-valmsg-replace="true"></span>
                            {{--                                    @error('hcost')--}}
                            {{--                                    <small class="form-text text-danger">{{trans('validation.contractsdet.hcost_required')}}</small>--}}
                            {{--                                    @enderror--}}
                        </div>

                        {{--##Car Back--}}
                        <div class="form-group ">
                            <input type="checkbox"  name="carback" id="carback"
                                   class="switchery" data-color="success" {{ old('carback') ? 'checked' : '' }} />
                            <label for="carback" class="card-title ">{{trans('page-contract.contract.fields.carback')}} </label>
                            @error('carback')
                            <small class="form-text text-danger">{{trans('validation.contractsdet.carback_required')}}</small>
                            @enderror
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
                            <input id="editcodate" name="editcodate" type="editcodate"
                                   class="form-control editcodate valid"
                                   value="{{old('codate')}}">
                            @error('codate')
                            <small class="form-text text-danger">{{trans('validation.contracts.codate_required')}}</small>
                            @enderror
                        </div>

                    </form>
                    {{-- Form Delete Post --}}
                    <div class="deleteContent">
                        <span class="hidden id"></span><span> - </span>{{ trans('page-contract.contract.modals.lbl_deleteconfirmationcontractdet') }}<span class="title"></span>
                        <span>{{ trans('page-contract.contract.modals.lbl_questionmark') }}</span>
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
{{--        <div class="hide" id="hidden-values">--}}
{{--            <input id="general_def_quick" type="hidden" value="{{url('/addNewValue')}}">--}}
{{--        </div>--}}
    </div>
@endsection

@push('js_content')
{{--    <script src={{ asset('adminassets/js/custom/contracts-index.js') }}></script>--}}
    <script src={{ asset('adminassets/js/custom/contractdet-index.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush





