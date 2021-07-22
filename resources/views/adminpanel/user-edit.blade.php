@extends('layouts.masteradminpanel')


@section('title')
   تعديل اسم المستخدم --
@endsection

@section('content')
    <div id="content">

        <!-- Topbar -->
    @include('includes.adminpanel.header')
    <!-- Begin Page Content -->
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h2>تعديل في معلومات المستخدم</h2>
                            </div>
                            <div class="card-body">
                               <div class="row">
                                   <div class="col-md-6">
                                       <form action="/user-edit-info/{{ $users->id }}" method="POST">
                                          {{ csrf_field() }}
                                           {{ method_field('PUT') }}
                                           <div class="form-group">
                                               <label >اسم المستخدم : </label>
                                               <input type="text" class="form-control" value = {{ $users -> name }} name="username" >
                                           </div>
                                           <div class="form-group">
                                               <label >البريد الاكتروني : </label>
                                               <input type="email" class="form-control" value = {{ $users -> email }} name="email" >
                                           </div>
                                           <div class="form-group">
                                               <label >صلاحيات المستخدم : </label>
                                               <select name="role" class="form-control">
                                                   <option value="admin">Admin</option>
                                                   <option value="user">Normal User</option>
                                               </select>
                                           </div>
                                           <button type="submit" class="btn btn-primary">تعديل</button>
                                           <a href="/users-list" class="btn btn-danger">الغاء التعديل
                                           </a>
                                       </form>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>


        </div>
        <!-- /.container-fluid -->

    </div>

@endsection




