@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-accidents.menu.accidents-list') }}
@endsection

@push('css_content')
    <link href={{ asset('adminassets/vendor/dropzone/css/dropzone.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/featherlight/featherlight.css') }} rel="stylesheet" type="text/css"/>
    <link href={{ asset('adminassets/vendor/select2/select2.css') }} rel="stylesheet" type="text/css"/>
    {{--    <link href="{{ URL::asset('css/customstyles.css') }}" rel="stylesheet" />--}}
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
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12" >
                            <h4 class="m-0 font-weight-bold text-primary float-right"> {{ trans('page-accidents.menu.accidents-list') }} </h4>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12" >
                            @can('accident_create')
                            <div class="float-left">
                                <a class="btn btn-primary btn-lg btn-block" href="{{ route('accidents.create') }}">
                                    <i class="fas fa-plus-circle"></i>
                                    {{ trans('page-accidents.fields.btnadd') }}
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12" style="border-style: dotted;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <input id="billedvalue" type="hidden" name="billed" value="">
                                        <input type="radio" id="allbills" name="billed" data-id="" checked/>
                                        <label for="allbills" >{{trans('page-accidents.tables.allbills')}} </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="radio" id="billsclosed" name="billed" data-id="1" />
                                        <label for="billsclosed" >{{trans('page-accidents.tables.billsclosed')}} </label>
                                    </div>
                                    <div class="col-md-5 col-sm-4 col-xs-12">
                                        <input type="radio" id="billsnotclosed" name="billed" data-id="0"/>
                                        <label for="billsnotclosed" >{{trans('page-accidents.tables.billsnotclosed')}} </label><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12" style="border-style: dotted;">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3 col-sm-4 col-xs-12">
                                        <input id="statusvalue" type="hidden" name="statusins" value="">
                                        <input type="radio" id="allstatus" name="statusins" data-id="" checked/>
                                        <label for="allstatus" >{{trans('page-accidents.tables.allstatus')}} </label>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <input type="radio" id="statusclosed" name="statusins" data-id="1" />
                                        <label for="statusclosed" >{{trans('page-accidents.tables.statusclosed')}} </label>
                                    </div>
                                    <div class="col-md-5 col-sm-4 col-xs-12">
                                        <input type="radio" id="statusnotclosed" name="statusins" data-id="0"/>
                                        <label for="statusnotclosed" >{{trans('page-accidents.tables.statusnotclosed')}} </label><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tbaccidents" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;">{{ trans('page-accidents.tables.id') }}</th>
                                <th width="150px" style="display:none;">{{ trans('page-accidents.tables.billid') }}</th>
                                <th width="150px" style="display:none;">{{ trans('page-accidents.tables.statusid') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-accidents.tables.billactions') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-accidents.tables.statusactions') }}</th>
                                @can('accident_access')
                                <th class="text-center align-middle text-nowrap">{{ trans('page-accidents.tables.actions') }}</th>
                                @endcan
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.accaperson') }}</th>
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.acccode') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-accidents.tables.acctype') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-accidents.tables.accdate') }}</th>
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.accperson') }}</th>
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.accinsname') }}</th>
                                <th class="text-center align-middle text-nowrap">{{ trans('page-accidents.tables.acccar') }}</th>
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.accgarage') }}</th>
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.accexpert') }}</th>
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.acccost') }}</th>
                                <th class="text-center align-middle text-nowrap" >{{ trans('page-accidents.tables.acccurr') }}</th>
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>

    <div class="hide" id="hidden-values">
        <input id="change_status_billing" type="hidden" value="{{url('/billing-accident-status')}}">
        <input id="user_role" type="hidden" value="{{ $user_role[0]->role_id }} ">
        <input id="change_status_ins" type="hidden" value="{{url('/accident-status')}}">
        <input id="change_status_aperson" type="hidden" value="{{url('/aperson-status')}}">
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
                    <input id="accident_id_1" type="hidden" name="accident_id_1" value="">
                    <input id="cflag" type="hidden" name="cflag" value="">
                    <input id="apersonid" type="hidden" name="apersonid" value="">
                    <form class="form-horizontal" role="form" id="formcreate">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                        {{--##Bill Code & aPerson Name--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label " for="lblcocode">{{ trans('page-accidents.modals.lblcocode') }} : </label>
                                                    <input class="form-control" id="lblcocode" type="text" name="lblcocode" value="" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="control-label col-sm-6" for="aperson">{{ trans('page-accidents.modals.aperson') }} :</label>
                                                    <select id="aperson" name="aperson" class="form-control p selectionaperson"
                                                            aria-required="true" aria-invalid="false">
                                                        <option></option>
                                                        {{--                                    <option value="" disabled selected hidden>أدخل مكان الفرع</option>--}}
                                                        @foreach($apersonlist as $alist)
                                                            <option value="{{$alist -> id}}">{{$alist -> cname}}</option>
                                                        @endforeach
                                                    </select>

                                                    <div class="alert alert-danger" id="err_details_aperson" style="display:none">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Acost & Acurr--}}
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="accost" class="control-label mb-1">{{trans('page-accidents.modals.accost')}}</label>
                                                    <input id="accost" name="accost" type="number"
                                                           class="form-control accost valid" value="" required>
                                                    <div class="alert alert-danger" id="err_details_accost" style="display:none">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                <div class="form-group" data-label="4">
                                                    <label class="required" class="control-label col-sm-4" for="acccurr">{{trans('page-accidents.modals.acccurr')}}</label>
                                                    <select id="acccurr" name="acccurr" class="form-control p selectionacccurr"
                                                            aria-required="true" aria-invalid="false" required>
                                                        <option></option>
                                                        @foreach($currlist as $ecurrlist)
                                                            <option value="{{$ecurrlist -> id}}">{{$ecurrlist -> currname_eng}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="alert alert-danger" id="err_details_acccurr" style="display:none">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{--##Acost & Acurr--}}
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group has-success">
                                                    <label class="required" for="adetails" class="control-label mb-1">{{trans('page-accidents.modals.adetails')}}</label>
                                                    <textarea class="form-control rounded-0" name="adetails" id="adetails" rows="3" required></textarea>
                                                    <div class="alert alert-danger" id="err_details_adetails" style="display:none">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <form>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tablemodal" width="100%" cellspacing="0">
                                            <thead>
                                            <tr>
                                                <th width="150px" style="display:none;" >{{ trans('page-accidents.modals.apersonid') }}</th>
                                                <th class="text-center" width="250px">{{ trans('page-accidents.modals.aclosedactions') }}</th>
                                                <th class="text-center" width="600px">{{ trans('page-accidents.modals.apersonname') }}</th>
                                                <th class="text-center" width="400px">{{ trans('page-accidents.modals.apersoncost') }}</th>
                                                <th class="text-center" width="400px">{{ trans('page-accidents.modals.apersoncurr') }}</th>
                                                <th class="text-center" width="250px">{{ trans('page-accidents.modals.actions') }}</th>
                                            </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit" id="saveaperson">
                        <span class="fas fa-plus"></span> {{ trans('page-accidents.modals.save') }}
                    </button>
                    <button class="btn btn-warning" type="button" data-dismiss="modal">
                        <span class="fas fa-door-open"></span>   {{ trans('page-accidents.modals.exit') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/accidents.js') }}></script>
    <script src={{ asset("adminassets/vendor/select2/select3.min.js") }}></script>
@endpush
