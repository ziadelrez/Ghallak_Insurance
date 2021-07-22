<?php

namespace App\Http\Controllers\AController;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{

    public function getbrusers($id)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::where('branch_id',$id)->get();
        $value = $id;

        $brdetails = DB::table('branch')
            ->select('name')
            ->where('id','=',$id)
            ->get();

        $titlebr = $brdetails[0]->name;

        return view('adminpanel.users.index', compact('users','value','titlebr'));
    }

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $users = User::all();
        $users = User::where('branch_id', '!=', 999999)->get();
        return view('adminpanel.users.index', compact('users'));
    }

    public function create($id)
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        return view('adminpanel.users.create', compact('roles','id'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('adminpanel.busers',$request->branch_id);
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id');

        $user->load('roles');

        $brids = DB::table('users')
            ->select('branch_id')
            ->where('id','=',$user->id)
            ->get();

        $idbr = $brids[0]->branch_id;

        return view('adminpanel.users.edit', compact('roles', 'user','idbr'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('adminpanel.busers',$request->branch_id);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('roles');

        return view('adminpanel.users.show', compact('user'));
    }

    public function deleteuser(Request $request){
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $getcount1 = DB::table('role_user')
            ->where('user_id','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();

        $getcount2 = DB::table('branch')
            ->where('created_by','=',$request->get('id'))
            ->get();
        $count2 = $getcount2->count();

        $getcount3 = DB::table('cars')
            ->where('created_by','=',$request->get('id'))
            ->get();
        $count3 = $getcount3->count();

        $getcount4 = DB::table('clients')
            ->where('created_by','=',$request->get('id'))
            ->get();
        $count4 = $getcount4->count();

        $getcount5 = DB::table('contract')
            ->where('created_by','=',$request->get('id'))
            ->get();
        $count5 = $getcount5->count();

//

        if($count1 == 0  && $count2 == 0 && $count3 == 0 && $count4 == 0 && $count5 == 0) {
            DB::table('users')
                ->where('id','=', $request->get('id'))
                ->delete();

            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }

    public function changeAccStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'uid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::table('users')
                ->where([
                    ['id', '=', $request->get('uid')],
                ])
                ->update(['status' => $request->get('sts')]);
            return response()->json(array('msg' => 'msg'), 200);
        }
    }
}
