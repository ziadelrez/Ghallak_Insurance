@extends('layouts.masteradminpanel')

@section('title')
    {{ trans('cruds.user.title') }}
@endsection

@section('content')

    @include('includes.adminpanel.header')
<div class="container">
<div class="card">
    <div class="card-header">
{{--        {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}--}}
{{--        <h6 class="m-0 font-weight-bold text-primary float-right"><span style="color:black">{{ trans('global.usersbranches') }}</span ><span style="color:black"> : </span><span style="color:red">{{ $titlebr }}</span >--}}
{{--            <br><br><a href="{{url('/branches-list')}}"><i class="fas fa-fast-backward"></i>  {{ trans('global.backtobranch') }}</a></h6>--}}
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/branches-list')}}">{{ trans('global.backtobranch') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ trans('global.usersbranches') }}<span style="color:black"> : </span><span style="color:red">{{$titlebr}}</span ></li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                @can('user_create')
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">
                            <a class="btn btn-primary btn-lg" href="{{ route('adminpanel.adduser',$value) }}">
                                <i class="fas fa-plus-circle"></i>
                                {{ trans('cruds.user.lblbuttonadd') }}
                            </a>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table  id="table" class=" table table-bordered table-striped table-hover datatable datatable-User">
                <thead>
                    <tr>
                        <th class="text-center" style="display:none;">
                            {{ trans('cruds.user.fields.id') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.user.fields.status') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.user.fields.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $key => $user)
                        <tr data-entry-id="{{ $user->id }}">
                            <td class="text-center" style="display:none;">
                                {{ $user->id ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $user->name ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $user->email ?? '' }}
                            </td>
                            <td class="text-center">
                                @if ($user->status)
                                    <a href="javascript:;" data-id= "{{ $user->id}}" data-to="0" class="btn btn-sts btn-xs btn-outline-success">{{trans('cruds.user.fields.active')}}</a>
                                @else
                                    <a href="javascript:;" data-id= "{{ $user->id}}" data-to="1" class="btn btn-xs btn-sts btn-outline-danger">{{trans('cruds.user.fields.deactivated')}}</a>
                                @endif
                            </td>
                            <td class="text-center">
                                @foreach($user->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @can('user_edit')
                                    <a class="btn btn-warning btn-sm" href="{{ route('adminpanel.users.edit', $user->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan

                                @can('user_delete')
{{--                                    <form action="{{ route('adminpanel.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">--}}
{{--                                        <input type="hidden" name="_method" value="DELETE">--}}
{{--                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                                        <input type="submit" class="btn btn-danger btn-sm" >--}}
{{--                                        <button type="submit" class="btn btn-danger btn-sm" >--}}
{{--                                            <i class="fas fa-trash"></i>--}}
{{--                                        </button>--}}
{{--                                    </form>--}}
                                        <button class="delete-modal btn btn-danger btn-sm" data-id="{{$user->id}}" data-title="{{$user->name}}" >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</div>
</div>
    <div class="hide" id="hidden-values">
        <input id="change_status" type="hidden" value="{{url('/adminpanel/acc-status')}}">
        <input id="delete_user" type="hidden" value="{{url('/adminpanel/deleteuser')}}">
    </div>

    <div id="myModal"class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="modal">


                    </form>
                    {{-- Form Delete Post --}}
                    <div class="deleteContent">
                        هل تريد فعلا حذف هذا المستخدم ؟ -  <span class="title"></span>
                        <span class="hidden id"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button" class="fas"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class="fas fa-door-open"></span> {{ trans('page-branch.pages.fields.exit') }}
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
    <script src={{ asset('adminassets/js/custom/accounts.js') }}></script>
{{--    <script src="{{ asset('js/lib/data-table/datatables.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ asset('js/lib/data-table/datatables-init.js') }}"></script>--}}
@endpush
@section('scripts')
@parent
{{--<script>--}}
{{--    $(function () {--}}
{{--  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)--}}
{{--@can('user_delete')--}}
{{--  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'--}}
{{--  let deleteButton = {--}}
{{--    text: deleteButtonTrans,--}}
{{--    url: "{{ route('adminpanel.users.massDestroy') }}",--}}
{{--    className: 'btn-danger',--}}
{{--    action: function (e, dt, node, config) {--}}
{{--      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {--}}
{{--          return $(entry).data('entry-id')--}}
{{--      });--}}

{{--      if (ids.length === 0) {--}}
{{--        alert('{{ trans('global.datatables.zero_selected') }}')--}}

{{--        return--}}
{{--      }--}}

{{--      if (confirm('{{ trans('global.areYouSureuser') }}')) {--}}
{{--        $.ajax({--}}
{{--          headers: {'x-csrf-token': _token},--}}
{{--          method: 'POST',--}}
{{--          url: config.url,--}}
{{--          data: { ids: ids, _method: 'DELETE' }})--}}
{{--          .done(function () { location.reload() })--}}
{{--      }--}}
{{--    }--}}
{{--  }--}}
{{--  dtButtons.push(deleteButton)--}}
{{--@endcan--}}

{{--  $.extend(true, $.fn.dataTable.defaults, {--}}
{{--    order: [[ 1, 'desc' ]],--}}
{{--    pageLength: 100,--}}
{{--  });--}}
{{--  $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })--}}
{{--    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){--}}
{{--        $($.fn.dataTable.tables(true)).DataTable()--}}
{{--            .columns.adjust();--}}
{{--    });--}}
{{--})--}}

{{--</script>--}}
@endsection

