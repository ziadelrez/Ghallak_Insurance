<?php

namespace App\Http\Controllers\Global_Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class InsTypeController extends Controller
{
    public function get_ins_type(){
        abort_if(Gate::denies('instype_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['ptype'] = DB::table('planstype')
            ->select('id', 'Description')
            ->get();

        $data['inslist'] = DB::table('insname_type')
            ->select('insid', 'insname','instype')
            ->get();

        return view('adminpanel.insurancelist',$data);
    }

    public function addinsname(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'insname' => 'required',
                'instype' => 'required',
                'details' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'insname' => $request->get('insname'),
                'instype' => $request->get('instype'),
                'details' => $request->get('details'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $id = DB::table('insnames')->insertGetId($values_to_insert);


            $insname = DB::table('insname_type')
                ->select('insname','instype')
                ->where('insid', $id)
                ->get();

            $iname = $insname[0]->insname;
            $pname = $insname[0]->instype;

            return response()->json(['id' => $id, 'insname' => $iname, 'instype' => $pname]);
        }
    }

    public function getinsdetails($id){

        $insdetails = DB::table('insname_type')
            ->select('insid','insname','instype','instypeid','details')
            ->where('insid','=',$id)
            ->get();


        $rec1 = $insdetails[0]->insid;
        $rec2 = $insdetails[0]->insname;
        $rec3 = $insdetails[0]->instype;
        $rec4 = $insdetails[0]->instypeid;
        $rec5 = $insdetails[0]->details;


        return response()->json(['id'=>$rec1,'insname'=>$rec2, 'instype'=>$rec3,'instypeid'=>$rec4,'details'=>$rec5]);

    }

    public function editinsname(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'insname' => 'required',
                'instype' => 'required',
                'details' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            DB::table('insnames')
                ->where('id', $request->get('id'))
                ->update([
                    'insname' => $request->get('insname'),
                    'instype' => $request->get('instype'),
                    'details' => $request->get('details'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            $insname = DB::table('insname_type')
                ->select('insname','instype')
                ->where('insid', $request->get('id'))
                ->get();

            $iname = $insname[0]->insname;
            $pname = $insname[0]->instype;

            return response()->json(['id' => $request->get('id'), 'insname' => $iname, 'instype' => $pname]);
        }
    }

    public function deleteinsname(Request $request){

        $getcount1 = DB::table('condet')
            ->where('insid','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();

        $getcount2 = DB::table('company_ins')
            ->where('ins_id','=',$request->get('id'))
            ->get();
        $count2 = $getcount2->count();

        if($count1 == 0 && $count2 == 0) {
            DB::table('insnames')
                ->where('id','=', $request->get('id'))
                ->delete();

            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }

    public function addNewValueGD(Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'description' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }


            $values_to_insert = [
                'Description' => $request->get('description'),
            ];

            $id = DB::table('planstype')->insertGetId($values_to_insert);

            return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
        }
    }
}
