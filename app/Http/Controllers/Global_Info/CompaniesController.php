<?php

namespace App\Http\Controllers\Global_Info;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class CompaniesController extends Controller
{
    public function getcompanies(){
        abort_if(Gate::denies('companies_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['reglist'] = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $data['complist'] = DB::table('companies')
            ->select('id', 'compname')
            ->get();

        return view('adminpanel.companieslist',$data);
    }

    public function addcompany(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'compname' => 'required',
                'contactperson' => 'required',
                'region' => 'required',
                'adr' => 'required',
                'mob' => 'required',
                'land' => 'required',
                'fax' => 'required',
                'email' => 'required',
                'website' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'compname' => $request->get('compname'),
                'contactperson' => $request->get('contactperson'),
                'region' => $request->get('region'),
                'adr' => $request->get('adr'),
                'mob' => $request->get('mob'),
                'land' => $request->get('land'),
                'fax' => $request->get('fax'),
                'email' => $request->get('email'),
                'website' => $request->get('website'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $id = DB::table('companies')->insertGetId($values_to_insert);


            $coname = DB::table('companies')
                ->select('id','compname')
                ->where('id', $id)
                ->get();

            $compname = $coname[0]->compname;

            return response()->json(['id' => $id, 'compname' => $compname]);
        }
    }

    public function getcompanydetails($id){

        $compdetails = DB::table('companiesdetails')
            ->select('id','compname','contactperson','region','adr','mob','land','fax','email','website','regionname')
            ->where('id','=',$id)
            ->get();


        $rec1 = $compdetails[0]->id;
        $rec2 = $compdetails[0]->compname;
        $rec3 = $compdetails[0]->contactperson;
        $rec4 = $compdetails[0]->region;
        $rec5 = $compdetails[0]->adr;
        $rec6 = $compdetails[0]->mob;
        $rec7 = $compdetails[0]->land;
        $rec8 = $compdetails[0]->fax;
        $rec9 = $compdetails[0]->email;
        $rec10 = $compdetails[0]->website;
        $rec11 = $compdetails[0]->regionname;


        return response()->json(['id'=>$rec1,'compname'=>$rec2, 'contactperson'=>$rec3,'region'=>$rec4,'adr'=>$rec5,'mob'=>$rec6,'land'=>$rec7, 'fax'=>$rec8,'email'=>$rec9,'website'=>$rec10,'regionname'=>$rec11]);

    }

    public function editcompany(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'compname' => 'required',
                'contactperson' => 'required',
                'region' => 'required',
                'adr' => 'required',
                'mob' => 'required',
                'land' => 'required',
                'fax' => 'required',
                'email' => 'required',
                'website' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            DB::table('companies')
                ->where('id', $request->get('id'))
                ->update([
                    'compname' => $request->get('compname'),
                    'contactperson' => $request->get('contactperson'),
                    'region' => $request->get('region'),
                    'adr' => $request->get('adr'),
                    'mob' => $request->get('mob'),
                    'land' => $request->get('land'),
                    'fax' => $request->get('fax'),
                    'email' => $request->get('email'),
                    'website' => $request->get('website'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            $coname = DB::table('companies')
                ->select('compname')
                ->where('id', $request->get('id'))
                ->get();

            $compname = $coname[0]->compname;

            return response()->json(['id' => $request->get('id'), 'compname' => $compname]);
        }
    }

    public function deletecompany(Request $request){

        $getcount1 = DB::table('company_ins')
            ->where('company_id','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();

        $getcount2 = DB::table('condet')
            ->where('companyid','=',$request->get('id'))
            ->get();
        $count2 = $getcount2->count();

        if($count1 == 0 && $count2 == 0 ) {
            DB::table('companies')
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

            $id = DB::table('reg')->insertGetId($values_to_insert);

            return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
        }
    }


    //////// Insurance Plans Of Company Section
    public function getcompaniesins($id){
        abort_if(Gate::denies('company_ins_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');


        $data['inslist'] = DB::table('insnames')
            ->select('id', 'insname')
            ->get();

        $data['currlist'] = DB::table('currency')
            ->select('id', 'currname_eng')
            ->get();

        $data['compinslist'] = DB::table('get_company_ins')
            ->select('id', 'company_id','compname','ins_id','insname','cost','curr','currname','instypeid','instype')
            ->where('company_id','=',$id)
            ->get();


        $data['comnames'] = DB::table('companies')
            ->select('id', 'compname')
            ->where('id','=',$id)
            ->get();


        $coname = $data['comnames'][0]->compname;

        $inscount = DB::table('get_company_ins')
            ->select('id', 'company_id','compname','ins_id','insname','cost','curr','currname','instypeid','instype')
            ->where('company_id','=',$id)
            ->count();

        return view('adminpanel.companiesinslist',$data)->with(compact('coname','inscount','id'));
    }

    public function getcompanydetailsins(Request $request)
    {
        abort_if(Gate::denies('company_ins_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');


        $compinslist = DB::table('get_company_ins')
            ->select('id', 'company_id','compname','ins_id','insname','cost','curr','currname','instypeid','instype')
            ->where('company_id','=',$request->get('ccid'))
            ->get();

        $datatables = Datatables::of($compinslist)
            ->editColumn('id', function ($cins) {
                return $cins->id;
            })
            ->editColumn('insname', function ($cins) {
                return $cins->insname;
            })
            ->editColumn('cost', function ($cins) {
                return $cins->cost;
            })
            ->editColumn('currcost', function ($cins) {
                return $cins->currname;
            })
            ->editColumn('cinsaction', function ($cins) {
                $buttons = "";
                if (Auth::user()->can('company_ins_edit')) {
                    $buttons .= '<button class="edit-btn btn btn-warning btn-sm" title="'. trans('page-companies.pages.fields.edit') .'" data-id="'.$cins -> id.'" data-insid="'.$cins -> ins_id.'" data-insname="'.$cins -> insname.'" data-cost="'.$cins -> cost.'" data-currid="'.$cins -> curr.'" data-currname="'.$cins -> currname.'" ><i class="fa fa-edit"></i></button> ';
                }
                if (Auth::user()->can('company_ins_delete')) {
                    $buttons .= '<button class="delete-btn btn btn-danger btn-sm" title="'. trans('page-companies.pages.fields.delete') .'" data-id="'.$cins -> id.'" data-title="'.$cins -> insname.'"><i class="fas fa-trash"></i></button>';
                }
                return $buttons;
            })->rawColumns(['cinsaction']);

//        if ($start = $request->get('fromdate')) {
//            $datatables->where('expdate', '>=', $start);
//        }
//
//        if ($end = $request->get('todate')) {
//            $datatables->where('expdate', '<=', $end);
//        }


        return $datatables->make(true);

    }

    public function addcompanyins(Request $request){
        if ($request->isMethod("POST")) {

            $getcheck = DB::table('company_ins')
            ->where('company_id','=',$request->get('compid'))
            ->where('ins_id','=',$request->get('insname'))
            ->get();

            $count = $getcheck->count();

        if($count == 0 ) {
            $rules = array(
                'insname' => 'required',
                'cost' => 'required',
                'currcost' => 'required',
                'compid' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'ins_id' => $request->get('insname'),
                'cost' => $request->get('cost'),
                'curr' => $request->get('currcost'),
                'company_id' => $request->get('compid'),
            ];

            $data = DB::table('company_ins')->insert($values_to_insert);

            return response()->json($data);
        }else{
            return response()->json(['flag'=>"1"]);
        }


        }
    }

    public function editcompanyins(Request $request){
        if ($request->isMethod("POST")) {

            $getcheck = DB::table('company_ins')
                ->where('company_id','=',$request->get('compid'))
                ->where('ins_id','=',$request->get('insname'))
                ->where('cost','=',$request->get('cost'))
                ->where('curr','=',$request->get('currcost'))
                ->get();

            $count = $getcheck->count();

            if($count == 0 ) {

                $rules = array(
                    'insname' => 'required',
                    'cost' => 'required',
                    'currcost' => 'required',
                );


                $validator = Validator::make($request->all(),$rules);

                if ($validator->fails()) {
                    return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
                }

                $data = DB::table('company_ins')
                    ->where('id', $request->get('id'))
                    ->update([
                        'ins_id' => $request->get('insname'),
                        'cost' => $request->get('cost'),
                        'curr' => $request->get('currcost'),
                    ]);

                return response()->json($data);
            }else{
                return response()->json(['flag'=>"1"]);
            }
        }
    }

    public function deletecompanyins(Request $request){

//        $getcount1 = DB::table('company_ins')
//            ->where('company_id','=',$request->get('id'))
//            ->get();
//        $count1 = $getcount1->count();
//
////        $getcount2 = DB::table('contract')
////            ->where('branch_id','=',$request->get('id'))
////            ->get();
////        $count2 = $getcount2->count(); && $count2 == 0

//        if($count1 == 0 ) {
//            DB::table('companies')
//                ->where('id','=', $request->get('id'))
//                ->delete();
//
//            return response()->json(['flag'=>"0"]);
//        }else{
//            return response()->json(['flag'=>"1"]);
//        }
//        return $request->get('id');
        DB::table('company_ins')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
    }

    public function addNewValueDEF(Request $request)
    {
        if ($request->isMethod("POST")) {
            $rules = array(
                'description' => 'required',
            );
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }
            $tbid = $request->get('tid');

            if($tbid == "1") {
                $values_to_insert = [
                    'currname_eng' => $request->get('description'),
                ];
                $id = DB::table('currency')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }
        }
    }
}
