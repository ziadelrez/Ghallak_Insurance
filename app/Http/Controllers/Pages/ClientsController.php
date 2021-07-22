<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ClientsController extends Controller
{
   public function index()
   {
       abort_if(Gate::denies('clients_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

       $clientslist = DB::table('getclients')
           ->select('id', 'cname','cmob','region','client_type')
           ->get();

        return view('pages.clients.index',compact('clientslist'));
   }

    public function create()
    {
        abort_if(Gate::denies('clients_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $reglist = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $ctypelist = DB::table('ctype')
            ->select('id', 'Description')
            ->get();

        $nlist = DB::table('natio')
            ->select('id', 'Description')
            ->get();

        $bplacelist = DB::table('place')
            ->select('id', 'Description')
            ->get();

        $passplacelist = DB::table('passplace')
            ->select('id', 'Description')
            ->get();

//        $brID = Auth::user()->branch_id;
       return view('pages.clients.create',compact('reglist','ctypelist','nlist','bplacelist','passplacelist'));
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
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('reg')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }elseif($tbid == "2"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('ctype')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "3"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('natio')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "4"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('place')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "5"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('passplace')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }
        }
    }

    public function store(StoreClientRequest $request)
    {
        if ($request->isMethod("POST")) {

           $values_to_insert = [
               'cname' => $request->get('cname'),
               'moname' => $request->get('moname'),
               'cadr' => $request->get('cadr'),
               'creg' => $request->get('creg'),
               'cctype' => $request->get('cctype'),
               'natio' => $request->get('natio'),
               'cmob' => $request->get('cmob'),
               'cmob1' => $request->get('cmob1'),
               'cland' => $request->get('cland'),
               'sigil' => $request->get('sigil'),
               'place' => $request->get('place'),
               'birthdate' => $request->get('birthdate'),
               'passnum' => $request->get('passnum'),
               'passplace' => $request->get('passplace'),
               'passdate' => $request->get('passdate'),
//               'branch_id'=> $request->get('branch_id'),
               'created_by'=> Auth::user()->id,
               'created_at' => date('Y-m-d'),
           ];
            DB::table('clients')->insert($values_to_insert);
        }

        return redirect()->route('clients-list');
    }

    public function edit($clientid)
    {
        abort_if(Gate::denies('clients_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reglist = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $ctypelist = DB::table('ctype')
            ->select('id', 'Description')
            ->get();

        $nlist = DB::table('natio')
            ->select('id', 'Description')
            ->get();

        $bplacelist = DB::table('place')
            ->select('id', 'Description')
            ->get();

        $passplacelist = DB::table('passplace')
            ->select('id', 'Description')
            ->get();

        $clientdetails = DB::table('clients')
            ->select('id', 'cname','moname','cadr','creg', 'cctype', 'natio', 'cmob', 'cmob1', 'cland', 'sigil', 'place', 'birthdate', 'passnum', 'passplace', 'passdate')
            ->where('id',$clientid)
            ->get();

        return view('pages.clients.edit',compact('reglist','ctypelist','nlist','bplacelist','passplacelist','clientdetails'));
    }

    public function update(UpdateClientRequest $request, $clientid)
    {
        if ($request->isMethod("POST")) {

            $values_to_update = [
                'cname' => $request->get('cname'),
                'moname' => $request->get('moname'),
                'cadr' => $request->get('cadr'),
                'creg' => $request->get('creg'),
                'cctype' => $request->get('cctype'),
                'natio' => $request->get('natio'),
                'cmob' => $request->get('cmob'),
                'cmob1' => $request->get('cmob1'),
                'cland' => $request->get('cland'),
                'sigil' => $request->get('sigil'),
                'place' => $request->get('place'),
                'birthdate' => $request->get('birthdate'),
                'passnum' => $request->get('passnum'),
                'passplace' => $request->get('passplace'),
                'passdate' => $request->get('passdate'),
//               'branch_id'=> $request->get('branch_id'),
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ];

        DB::table('clients')
            ->where('id', '=', $clientid)
            ->update($values_to_update);
        }
        return redirect()->route('clients-list');
    }

    public function show($clientid)
    {
        abort_if(Gate::denies('clients_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reglist = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $ctypelist = DB::table('ctype')
            ->select('id', 'Description')
            ->get();

        $nlist = DB::table('natio')
            ->select('id', 'Description')
            ->get();

        $bplacelist = DB::table('place')
            ->select('id', 'Description')
            ->get();

        $passplacelist = DB::table('passplace')
            ->select('id', 'Description')
            ->get();

        $clientdetails = DB::table('clients')
            ->select('id', 'cname','moname','cadr','creg', 'cctype', 'natio', 'cmob', 'cmob1', 'cland', 'sigil', 'place', 'birthdate', 'passnum', 'passplace', 'passdate')
            ->where('id',$clientid)
            ->get();

        return view('pages.clients.show',compact('reglist','ctypelist','nlist','bplacelist','passplacelist','clientdetails'));
    }

    public function deleteclient(Request $request){
        $getcount = DB::table('linum')
            ->where('client','=',$request->get('id'))
            ->get();
        $count = $getcount->count();

        $getcount1 = DB::table('clientdoc')
            ->where('cid','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();

        $getcount2 = DB::table('contract')
            ->where('client','=',$request->get('id'))
            ->get();
        $count2 = $getcount2->count();

        $getcount3 = DB::table('clientpayments')
            ->where('client','=',$request->get('id'))
            ->get();
        $count3 = $getcount3->count();

        if($count == 0 && $count1 == 0 && $count2 == 0 && $count3 == 0) {
            DB::table('clients')
                ->where('id', '=', $request->get('id'))
                ->delete();

            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }


    public function licenses($clientid)
    {
        abort_if(Gate::denies('clients_license_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

         $passplacelist = DB::table('passplace')
            ->select('id', 'Description')
            ->get();

        $licensedetails = DB::table('client_license')
            ->select('liid', 'clid','cname','drivername','lnum','dateend','placeid', 'placename')
            ->where('clid',$clientid)
            ->get();

        $client_id = $clientid;
        $getclientname = DB::table('clients')
            ->select('cname')
            ->where('id',$clientid)
            ->get();
        $client_name = $getclientname[0]->cname;

        return view('pages.clients.license',compact('passplacelist','licensedetails','client_id','client_name'));
    }

    public function addlicenses(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'drivername' => 'required',
                'lnum' => 'required',
                'place' => 'required',
                'dateend' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'client' => $request->get('client'),
                'drivername' => $request->get('drivername'),
                'lnum' => $request->get('lnum'),
                'place' => $request->get('place'),
                'dateend' => $request->get('dateend'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $liid = DB::table('linum')->insertGetId($values_to_insert);

            $lidetails = DB::table('client_license')
                ->select('liid', 'clid','cname','drivername','lnum','dateend','placeid', 'placename')
                ->where('liid',$liid)
                ->get();

            $det1 = $lidetails[0]->drivername;
            $det2 = $lidetails[0]->lnum;
            $det3 = $lidetails[0]->placename;
            $det4 = $lidetails[0]->dateend;

            return response()->json(['id' => $liid, 'drivername' => $det1, 'lnum' => $det2, 'place' => $det3, 'dateend' => $det4]);
        }
    }

    public function getlicensedetails($id){

        $lidetails = DB::table('client_license')
            ->select('liid', 'clid','cname','drivername','lnum','dateend','placeid', 'placename')
            ->where('liid',$id)
            ->get();

        $rec1 = $lidetails[0]->liid;
        $rec2 = $lidetails[0]->drivername;
        $rec3 = $lidetails[0]->lnum;
        $rec4 = $lidetails[0]->placeid;
        $rec5 = $lidetails[0]->placename;
        $rec6 = $lidetails[0]->dateend;
//        'locid'=>$locrec1,'locname'=>$locrec2
        return response()->json(['id'=>$rec1,'drivername'=>$rec2, 'lnum'=>$rec3,'placeid'=>$rec4,'placename'=>$rec5,'dateend'=>$rec6]);

    }

    public function editlicense(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'drivername' => 'required',
                'lnum' => 'required',
                'place' => 'required',
                'dateend' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            DB::table('linum')
                ->where('id', $request->get('id'))
                ->update([
                    'drivername' => $request->get('drivername'),
                    'lnum' => $request->get('lnum'),
                    'place' => $request->get('place'),
                    'dateend' => $request->get('dateend'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            $lidetails = DB::table('client_license')
                ->select('liid', 'clid','cname','drivername','lnum','dateend','placeid', 'placename')
                ->where('liid',$request->get('id'))
                ->get();

            $rec1 = $lidetails[0]->liid;
            $rec2 = $lidetails[0]->drivername;
            $rec3 = $lidetails[0]->lnum;
            $rec4 = $lidetails[0]->placeid;
            $rec5 = $lidetails[0]->placename;
            $rec6 = $lidetails[0]->dateend;
//        'locid'=>$locrec1,'locname'=>$locrec2
            return response()->json(['id'=>$rec1,'drivername'=>$rec2, 'lnum'=>$rec3,'placeid'=>$rec4,'place'=>$rec5,'dateend'=>$rec6]);

        }
    }

    public function deletelicense(Request $request){

        DB::table('linum')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }

    public function addNewValuePlace(Request $request)
    {
        if ($request->isMethod("POST")) {
            $rules = array(
                'description' => 'required',
            );
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'Description' => $request->get('description'),
            ];
            $id = DB::table('passplace')->insertGetId($values_to_insert);
            return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);

        }
    }

    public function attachclient($clientid)
    {
        abort_if(Gate::denies('clients_attach_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $docdetails = DB::table('client_doc')
            ->select('id', 'clid','cname','docname','img_filename','img_extention')
            ->where('clid',$clientid)
            ->get();

        $client_id = $clientid;

        $getclientname = DB::table('clients')
            ->select('cname')
            ->where('id',$clientid)
            ->get();
        $client_name = $getclientname[0]->cname;

        return view('pages.clients.attach_client',compact('docdetails','client_id','client_name'));
    }

    function uploadfiles(Request $request)
    {
        $clientid = $request->get('client_id');
        $counter = 1;
        $path_info = pathinfo($request->file('file')->getClientOriginalName());
        $file_name = $path_info["filename"];
        $extension = $path_info["extension"];


        while (file_exists(public_path() . '/files/clients/'. $clientid . '/' . $file_name . '.' . $extension)) {
            $file_name = $path_info["filename"] . '_' . $counter;
            $counter++;
        }
        if ($request->file('file')->isValid()) {
            $request->file('file')->move('files/clients/' . $clientid, $file_name . '.' . $extension);

            DB::table('clientdoc')
                ->where('id', $request->get('doc_id'))
                ->update([
                    'img_filename' => $file_name . '.' . $extension,
                    'img_extention' => $extension,
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

        }
    }

    public function image_delete_file(Request $request,$clientid){
       $docid = $request->docid;
        $filename = $request->id;
        $path_image = public_path() . '/files/clients/'. $clientid . '/' . $filename;

        if (file_exists($path_image)) {
            unlink($path_image);
        }
        DB::table('clientdoc')
            ->where('id', $docid)
            ->update([
                'img_filename' => '',
                'img_extention' => '',
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ]);
//        return Response::json(['success' => 'File successfully delete'], 200);
    }

    public function savedocfile(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'docname' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'cid' => $request->get('cid'),
                'docname' => $request->get('docname'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $docid = DB::table('clientdoc')->insertGetId($values_to_insert);

            $docdetails = DB::table('clientdoc')
                ->select('id', 'docname')
                ->where('id',$docid)
                ->get();

            $det1 = $docdetails[0]->docname;

            return response()->json(['id' => $docid, 'docname' => $det1]);
        }
    }

    public function getdocdetails($id){

        $docdetails = DB::table('clientdoc')
            ->select('id','docname')
            ->where('id','=',$id)
            ->get();

        $rec1 = $docdetails[0]->id;
        $rec2 = $docdetails[0]->docname;

//        'locid'=>$locrec1,'locname'=>$locrec2
        return response()->json(['id'=>$rec1,'docname'=>$rec2]);

    }

    public function editdoc(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'docname' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            DB::table('clientdoc')
                ->where('id', $request->get('id'))
                ->update([
                    'docname' => $request->get('docname'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);
            return response()->json(['id' => $request->get('id'), 'docname' => $request->get('docname')]);
        }
    }

    public function deletedoc(Request $request){

        DB::table('clientdoc')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }

    public function printdoc($id){

        $docdetails = DB::table('clientdoc')
            ->select('id','cid','docname','img_filename')
            ->where('id','=',$id)
            ->get();

        $rec1 = $docdetails[0]->cid;
        $rec2 = $docdetails[0]->docname;
        $rec3 = $docdetails[0]->img_filename;


        return view('pages.clients.printout.docprint',compact('rec1','rec2','rec3'));
    }

}
