<?php

namespace App\Http\Controllers\AController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
   public function getallusers()
   {
       $ulist = User::get();
//      $ulist -> usertype;
       return view('adminpanel.userslist',compact('ulist'));
   }

    public function getallbrusers($id)
    {
        $ulist = User::where('branch_id',$id)->get();

        return view('adminpanel.userslist',compact('ulist'));
    }


   public function getuser(Request $request , $id)
   {
       $users = User::findOrFail($id);
       return view('adminpanel.user-edit',compact('users'));
   }

    public function userupdate(Request $request , $id)
    {
        $users = User::find($id);
        $users->name = $request ->input('username');
        $users->email = $request ->input('email');
        $users->role = $request ->input('role');
        $users->update();

       return redirect('/users-list')->with('status','تم تعديل المعلومات بنجاح');
    }


    public function userdelete($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect('/users-list')->with('status','تم حذف المستخدم بنجاح');
    }

//    public function getallbranchs(){
//       $blist = DB::table('branch')
//           ->select('id','name')
//           ->get();
//        return view('adminpanel.branchlist',compact('blist'));
//    }

}
