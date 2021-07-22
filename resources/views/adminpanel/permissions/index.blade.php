@extends('layouts.masteradminpanel')

@section('title')
    {{ trans('cruds.permission.title_singular') }}
@endsection

@section('content')

    @include('includes.adminpanel.header')


<div class="container">
<div class="card">
    <div class="card-header">
        {{ trans('cruds.permission.title_singular') }}
        <div class="float-left">
            @can('permission_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route("adminpanel.permissions.create") }}">
                           {{ trans('cruds.permission.addpermission') }}
                        </a>
                    </div>
                </div>
             @endcan
        </div>

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="table" class=" table table-bordered table-striped table-hover datatable datatable-Permission">
                <thead>
                    <tr>
                        <th width="10" style="display:none;">

                        </th>
                        <th style="display:none;">
                            {{ trans('cruds.permission.fields.id') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                        <th class="text-center">
                            &nbsp;{{ trans('cruds.permission.fields.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr data-entry-id="{{ $permission->id }}">
                            <td style="display:none;">

                            </td>
                            <td style="display:none;">
                                {{ $permission->id ?? '' }}
                            </td>
                            <td class="text-center">
                                {{ $permission->title ?? '' }}
                            </td>
                            <td class="text-center">
{{--                                @can('permission_show')--}}
{{--                                    <a class="btn btn-xs btn-primary" href="{{ route('adminpanel.permissions.show', $permission->id) }}">--}}
{{--                                        <i class="fas fa-eye"></i>--}}
{{--                                    </a>--}}
{{--                                @endcan--}}

                                @can('permission_edit')
                                    <a class="btn btn-xs btn-warning" href="{{ route('adminpanel.permissions.edit', $permission->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan

                                @can('permission_delete')
{{--                                    <form action="{{ route('adminpanel.permissions.destroy', $permission->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">--}}
{{--                                        <input type="hidden" name="_method" value="DELETE">--}}
{{--                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">--}}
{{--                                    </form>--}}
                                    <button class="delete-modal btn btn-danger btn-sm" data-id="{{$permission->id}}" data-title="{{$permission->title}}" >
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
        <input id="delete_user" type="hidden" value="{{url('/adminpanel/deletepermission')}}">
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
                        هل تريد فعلا حذف هذا المهام ؟ -  <span class="title"></span>
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
    <script src={{ asset('adminassets/js/custom/permissions.js') }}></script>
    {{--    <script src="{{ asset('js/lib/data-table/datatables.min.js') }}"></script>--}}
    {{--    <script src="{{ asset('js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>--}}
    {{--    <script src="{{ asset('js/lib/data-table/datatables-init.js') }}"></script>--}}
@endpush
@section('scripts')
@parent
{{--<script>--}}
{{--    $(function () {--}}
{{--  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)--}}
{{--@can('permission_delete')--}}
{{--  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'--}}
{{--  let deleteButton = {--}}
{{--    text: deleteButtonTrans,--}}
{{--    url: "{{ route('adminpanel.permissions.massDestroy') }}",--}}
{{--    className: 'btn-danger',--}}
{{--    action: function (e, dt, node, config) {--}}
{{--      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {--}}
{{--          return $(entry).data('entry-id')--}}
{{--      });--}}

{{--      if (ids.length === 0) {--}}
{{--        alert('{{ trans('global.datatables.zero_selected') }}')--}}

{{--        return--}}
{{--      }--}}

{{--      if (confirm('{{ trans('global.areYouSure') }}')) {--}}
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
{{--  $('.datatable-Permission:not(.ajaxTable)').DataTable({ buttons: dtButtons })--}}
{{--    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){--}}
{{--        $($.fn.dataTable.tables(true)).DataTable()--}}
{{--            .columns.adjust();--}}
{{--    });--}}
{{--})--}}

{{--</script>--}}
@endsection
