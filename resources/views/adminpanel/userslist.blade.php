@extends('layouts.masteradminpanel')


@section('title')
  لائحة المستخدمين
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
                    <h6 class="m-0 font-weight-bold text-primary float-right">لائحة المستخدمين</h6>
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
                                <th>رقم المستخدم</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الاكتروني</th>
                                <th>صلاحية المستخدم</th>
                                <th>الاجراءات</th>
                            </tr>
                            </thead>
{{--                            <tfoot>--}}
{{--                            <tr>--}}
{{--                                <th>رقم المستخدم</th>--}}
{{--                                <th>اسم المستخدم</th>--}}
{{--                                <th>البريد الاكتروني</th>--}}
{{--                                <th>صلاحية المستخدم</th>--}}
{{--                                <th>الاجراءات</th>--}}
{{--                           </tr>--}}
{{--                            </tfoot>--}}
                            <tbody>
                            @foreach($ulist as $userlist)
                            <tr>
                                <td>{{$userlist -> id}}</td>
                                <td>{{$userlist -> name}}</td>
                                <td>{{$userlist -> email}}</td>
                                <td>{{$userlist -> types -> role}}</td>
                                <td>
                                    <a href="/useredit/{{ $userlist -> id }}" class="btn btn-success ">
                                        <i class="fas fa-user-edit"></i>
                                        تعديل
                                    </a>
                                    <a href="/userdelete/{{ $userlist -> id }}" class="btn btn-danger ">
                                        <i class="fas fa-user-times"></i>
                                        حذف المستخدم
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





