<?php

namespace App\Http\Controllers\Global_Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Gate;

class BranchesController extends Controller
{
    public function get_br_location(){
        abort_if(Gate::denies('branch_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['location'] = DB::table('branch_location')
                        ->select('id', 'Description')
                        ->get();

        $data['brtype'] = DB::table('dealertype')
            ->select('id', 'dealertype')
            ->get();

        $data['brlist'] = DB::table('br_location')
            ->select('brid', 'brname','locname','dealertype','dealertypeid')
            ->get();

        return view('adminpanel.branchlist',$data);
    }

    public function addbranches(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'brname' => 'required',
                'location' => 'required',
                'landline' => 'required',
                'mobile' => 'required',
                'brtype' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'name' => $request->get('brname'),
                'location' => $request->get('location'),
                'landline' => $request->get('landline'),
                'mobile' => $request->get('mobile'),
                'dealertype' => $request->get('brtype'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $id = DB::table('branch')->insertGetId($values_to_insert);

            $brname = DB::table('br_location')
                ->select('brid', 'brname','locname','dealertype','dealertypeid')
                ->where('brid', $id)
                ->get();

            $bname = $brname[0]->brname;
            $loname = $brname[0]->locname;
            $brtype = $brname[0]->dealertype;

            return response()->json(['id' => $id, 'brname' => $bname, 'location' => $loname, 'brtype' => $brtype]);
        }
    }

    public function getbrdetails($id){

        $brdetails = DB::table('brdetails')
            ->select('brid','brname','brlandline','brmobile','brlocid','locname','dealertype','dealertypeid')
            ->where('brid','=',$id)
            ->get();

//        $locationdb = DB::table('branch_location')
//            ->select('id', 'Description')
//            ->get();
//
//        $locrec1 = $locationdb[0]->id;
//        $locrec2 = $locationdb[0]->Description;

        $rec1 = $brdetails[0]->brid;
        $rec2 = $brdetails[0]->brname;
        $rec3 = $brdetails[0]->locname;
        $rec4 = $brdetails[0]->brlandline;
        $rec5 = $brdetails[0]->brmobile;
        $rec6 = $brdetails[0]->brlocid;
        $rec7 = $brdetails[0]->dealertype;
        $rec8 = $brdetails[0]->dealertypeid;
//        'locid'=>$locrec1,'locname'=>$locrec2
        return response()->json(['id'=>$rec1,'brname'=>$rec2, 'brlocname'=>$rec3,'brlandline'=>$rec4,'brmobile'=>$rec5,'brlocid'=>$rec6,'brtype'=>$rec7,'brtypeid'=>$rec8]);

    }

    public function editbranches(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'brname' => 'required',
                'location' => 'required',
                'landline' => 'required',
                'mobile' => 'required',
                'brtype' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            DB::table('branch')
                ->where('id', $request->get('id'))
                ->update([
                    'name' => $request->get('brname'),
                    'location' => $request->get('location'),
                    'landline' => $request->get('landline'),
                    'mobile' => $request->get('mobile'),
                    'dealertype' => $request->get('brtype'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            $brname = DB::table('br_location')
                ->select('brid', 'brname','locname','dealertype','dealertypeid')
                ->where('brid', $request->get('id'))
                ->get();

            $bname = $brname[0]->brname;
            $loname = $brname[0]->locname;
            $brtype = $brname[0]->dealertype;

            return response()->json(['id' => $request->get('id'), 'brname' => $bname, 'location' => $loname, 'brtype' => $brtype]);
        }
    }

    public function deletebr(Request $request){

        $getcount1 = DB::table('cars')
            ->where('branch','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();

        $getcount2 = DB::table('contract')
            ->where('branch_id','=',$request->get('id'))
            ->get();
        $count2 = $getcount2->count();

        $getcount3 = DB::table('expenses')
            ->where('branch','=',$request->get('id'))
            ->get();
        $count3 = $getcount3->count();

        $getcount4 = DB::table('booking')
            ->where('branch','=',$request->get('id'))
            ->get();
        $count4 = $getcount4->count();

        $getcount5 = DB::table('users')
            ->where('branch_id','=',$request->get('id'))
            ->get();
        $count5 = $getcount5->count();


        if($count1 == 0 && $count2 == 0 && $count3 == 0 && $count4 == 0 && $count5 == 0) {
                DB::table('branch')
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

            $id = DB::table('branch_location')->insertGetId($values_to_insert);

            return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
        }
    }

}
