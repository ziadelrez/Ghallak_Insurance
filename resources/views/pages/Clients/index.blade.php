@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.clientlist') }}
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
                    <h4 class="m-0 font-weight-bold text-primary float-right">{{ trans('page-client.clients.titletb') }}</h4>
                    @can('clients_create')
                    <div class="float-left">
                        <a class="btn btn-primary btn-lg" href="{{ route('clients.create') }}">
                            <i class="fas fa-plus-circle"></i>
                            {{ trans('page-client.clients.buttons.btnadd') }}
                        </a>
                    </div>
                    @endcan
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
                                <th class="align-middle" width="150px" style="display:none;" >{{ trans('page-client.clients.tables.id') }}</th>
                                <th class="align-middle" width="200px">{{ trans('page-client.clients.tables.eval') }}</th>
                                <th class="align-middle" width="200px">{{ trans('page-client.clients.tables.name') }}</th>
                                <th class="align-middle" width="200px">{{ trans('page-client.clients.tables.followby') }}</th>
                                <th class="align-middle" width="100px" >{{ trans('page-client.clients.tables.mobile') }}</th>
                                <th class="align-middle" width="250px">{{ trans('page-client.clients.tables.branch') }}</th>
                                <th class="align-middle" width="500px">{{ trans('page-client.clients.tables.actions') }}</th>
                                @can('contract_access')
                                <th class="align-middle" width="250px">{{ trans('page-client.clients.tables.contractactions') }}</th>
                                @endcan
                            </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

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
                        <span class="hidden id"></span><span> - </span>{{ trans('page-client.clients.modals.lbl_license_deleteconfirmationclient') }}<span class="title"></span><span>{{ trans('page-client.clients.modals.lbl_license_questionmark') }}</span>

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

    </div>

@endsection

@push('js_content')
    <script src={{ asset('adminassets/js/custom/clients-index.js') }}></script>
@endpush
