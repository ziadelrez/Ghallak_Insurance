@extends('layouts.masteradminpanel')


@section('title')
    {{ trans('page-client.clients.attach_title') }}
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
                    <br>
{{--                    <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">{{ trans('page-client.clients.docname') }} :</span> <span style="color:red">{{$rec2}}</span>--}}
{{--                        <br><br><a href="{{ route('clients.docs', $rec1) }}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtodoclist') }}</a></h6>--}}
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('clients.docs', $rec1) }}">{{ trans('global.backtodoclist') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ trans('page-client.clients.docname') }}<span style="color:black"> : </span><span style="color:red">{{$rec2}}</span ></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <img class="card-img-top "  src={{'/files/clients/'.$rec1.'/'.$rec3}} >
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>

@endsection







