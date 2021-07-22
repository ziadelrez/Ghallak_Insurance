@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.title') }}
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
                                <th width="150px" style="display:none;" >{{ trans('page-client.clients.tables.id') }}</th>
                                <th width="200px">{{ trans('page-client.clients.tables.name') }}</th>
                                <th class="text-center" width="100px" >{{ trans('page-client.clients.tables.mobile') }}</th>
                                <th width="120px">{{ trans('page-client.clients.tables.region') }}</th>
                                <th class="text-center" width="120px" style="display:none;">{{ trans('page-client.clients.tables.client_type') }}</th>
                                <th class="text-center" width="200px">{{ trans('page-client.clients.tables.actions') }}</th>
                                @can('contract_access')
                                <th class="text-center" width="200px">{{ trans('page-client.clients.tables.contractactions') }}</th>
                                @endcan
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($clientslist as $clist)
                                <tr class="clrows{{$clist -> id}}">
                                    <td style="display:none;" >{{$clist -> id}}</td>
                                    <td>{{$clist -> cname}}</td>
                                    <td class="text-center">{{$clist -> cmob}}</td>
                                    <td>{{$clist -> region}}</td>
                                    <td class="text-center" style="display:none;">{{$clist -> client_type}}</td>
                                    <td class="text-center">
                                        @can('clients_view')
                                            <a class="btn btn-info btn-sm" title="{{ trans('page-client.clients.titles.view') }}"  href="{{ route('clients.show', $clist->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endcan

                                        @can('clients_license_access')
                                            <a class="btn btn-primary btn-sm" title="{{ trans('page-client.clients.titles.license') }}" href="{{ route('clients.licenses', $clist->id) }}">
                                                <i class="fas fa-id-badge"></i>
                                            </a>
                                        @endcan

                                        @can('clients_attach_access')
                                            <a class="btn btn-success btn-sm" title="{{ trans('page-client.clients.titles.docs') }}" href="{{ route('clients.docs', $clist->id) }}">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @endcan

                                        @can('clients_edit')
                                            <a class="btn btn-warning btn-sm" title="{{ trans('page-client.clients.titles.edit') }}" href="{{ route('clients.edit', $clist->id) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('clients_delete')
                                            <button class="delete-modal btn btn-danger btn-sm" title="{{ trans('page-client.clients.titles.delete') }}" data-id="{{$clist->id}}" data-title="{{$clist->cname}}" >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                    @can('contract_access')
                                        <td class="text-center">
                                                <a class="btn btn-primary btn-sm"  href="{{ route('contract-client', $clist->id) }}">
                                                    <i class="fas fa-th-list"></i>
                                                    {{ trans('page-client.clients.buttons.btnaddcontact') }}
                                                </a>
                                            @can('contract_payment')
                                                <a href="{{ route('payment-client',$clist -> id)}}" class="btn btn-success btn-sm" title="{{ trans('page-contract.contract.titles.cpayments') }}">
                                                    <i class="fa fa-dollar-sign"></i>
                                                </a>
                                            @endcan
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
