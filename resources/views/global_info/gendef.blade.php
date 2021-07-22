@extends('layouts.masteradminpanel')


@section('title')
   المعلومات الاولية
@endsection

@section('content')

    <div id="content">

        <!-- Topbar -->
    @include('includes.adminpanel.header')
    <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->


            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary float-right"><p style="color:red">جدول المعلومات العامة </p></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th style="display:none;">رقم التسلسلي</th>
                                <th>اسم الجدول</th>
                                <th width="180px" class="text-center">عرض البيانات</th>

                            </tr>
                            </thead>
{{--                            <tfoot>--}}
{{--                            <tr>--}}
{{--                                <th style="display:none;">رقم التسلسلي</th>--}}
{{--                                <th>اسم الجدول</th>--}}
{{--                                <th width="180px" class="text-center">عرض البيانات</th>--}}

{{--                            </tr>--}}
{{--                            </tfoot>--}}
                            <tbody>
                            @foreach($listgendef as $gdlist)
                                <tr>
                                    <td style="display:none;" >{{$gdlist -> id}}</td>
                                    <td>{{$gdlist -> name}}</td>
                                    <td width="180px" class="text-center">
                                            <a href="{{url('gd-values/'. $gdlist -> id)}}" class="btn btn-primary ">
                                            <i class="fas fa-database"></i>
                                            عرض بيانات الجدول
                                        </a>

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
@endsection





