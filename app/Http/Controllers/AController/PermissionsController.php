<?php

namespace App\Http\Controllers\AController;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PermissionsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('permission_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $permissions = \App\Models\Permission::all();

        return view('adminpanel.permissions.index', compact('permissions'));
    }

    public function create()
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('adminpanel.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = Permission::create($request->all());

        return redirect()->route('adminpanel.permissions.index');
    }

    public function edit(Permission $permission)
    {
        abort_if(Gate::denies('permission_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('adminpanel.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->all());

        return redirect()->route('adminpanel.permissions.index');
    }

    public function show(Permission $permission)
    {
        abort_if(Gate::denies('permission_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('adminpanel.permissions.show', compact('permission'));
    }

//    public function destroy(Permission $permission)
//    {
//        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        $permission->delete();
//
//        return back();
//    }
//
//    public function massDestroy(MassDestroyPermissionRequest $request)
//    {
//        Permission::whereIn('id', request('ids'))->delete();
//
//        return response(null, Response::HTTP_NO_CONTENT);
//    }
    public function deletepermission(Request $request){
        abort_if(Gate::denies('permission_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $getcount2 = DB::table('permission_role')
            ->where('permission_id','=',$request->get('id'))
            ->get();
        $count2 = $getcount2->count();


        if($count2 == 0 ) {
            DB::table('permissions')
                ->where('id','=', $request->get('id'))
                ->delete();

            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }
}
