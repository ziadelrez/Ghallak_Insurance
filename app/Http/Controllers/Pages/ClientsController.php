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
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class ClientsController extends Controller
{
   public function index()
   {
       abort_if(Gate::denies('clients_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

       return view('pages.Clients.index');
   }

    public function fecthdataclients(Request $request)
    {
        abort_if(Gate::denies('clients_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sqlstr = $request->get('sqlstr');
        $sqlstrstatus = $request->get('sqlstrstatus');
        $sqlstop = $request->get('sqlstop');

        if (Auth::user()->can('all_access')) {
            $clientslist = DB::table('getclients')
                ->select('id', 'cname','cmob','region','relig','nclient','employee','broker','garage','expert','office','aperson','brname','followby','followbyid','evalid','evaldesc')
                ->where('display','=','1')
                ->orderBy('id','desc')
                ->get();
        }else {
            $bIds = Auth::user()->branch_id;
            $clientslist = DB::table('getclients')
                ->select('id', 'cname','cmob','region','relig','branchid','nclient','employee','broker','garage','expert','office','aperson','brname','followby','followbyid','evalid','evaldesc')
                ->where('display','=','1')
                ->where('branchid','=',$bIds)
                ->orderBy('id','desc')
                ->get();
        }

        $datatables = Datatables::of($clientslist)
            ->editColumn('id', function ($inscontlist) {
                return $inscontlist->id;
            })
            ->editColumn('eval', function ($inscontlist) {
                return $inscontlist->evaldesc;
            })
            ->editColumn('clientname', function ($inscontlist) {
                return $inscontlist->cname;
            })
            ->editColumn('followby', function ($inscontlist) {
                return $inscontlist->followby;
            })
            ->editColumn('mobile', function ($inscontlist) {
                return $inscontlist->cmob;
            })
            ->editColumn('branch', function ($inscontlist) {
                return $inscontlist->brname;
            })
            ->editColumn('clientaction', function ($inscontlist) {
                $buttons = "";
                if (Auth::user()->can('clients_cars')) {
                    $buttons .= '<a class="btn btn-dark btn-sm" target="_blank" title="'. trans('page-client.clients.titles.housemaid') .'" href="'. route('clients.showmaids', $inscontlist->id) .'"><i class="fas fa-restroom"></i></a> ';
                }
                if (Auth::user()->can('clients_cars')) {
                    $buttons .= '<a class="btn btn-primary btn-sm" target="_blank" title="'. trans('page-client.clients.titles.cars') .'" href="'. route('clients.showcars', $inscontlist->id) .'"><i class="fas fa-car"></i></a> ';
                }
                if (Auth::user()->can('clients_view')) {
                    $buttons .= '<a class="btn btn-info btn-sm" target="_blank" title="'. trans('page-client.clients.titles.view') .'" href="'. route('clients.show', $inscontlist->id) .'"><i class="fas fa-eye"></i></a> ';
                }
                if (Auth::user()->can('clients_attach_access')) {
                    $buttons .= '<a class="btn btn-success btn-sm" target="_blank" title="'. trans('page-client.clients.titles.docs') .'" href="'. route('clients.attachment', $inscontlist->id) .'"><i class="fas fa-file-alt"></i></a> ';
                }
                if (Auth::user()->can('clients_edit')) {
                    $buttons .= '<a class="btn btn-warning btn-sm" target="_blank" title="'. trans('page-client.clients.titles.edit') .'" href="'. route('clients.edit', $inscontlist->id) .'"><i class="fa fa-edit"></i></a> ';
                }
                if (Auth::user()->can('clients_delete')) {
                    $buttons .= '<button class="delete-modal btn btn-danger btn-sm" title="'. trans('page-client.clients.titles.delete') .'" data-id="'.$inscontlist -> id.'" data-title="'.$inscontlist -> cname.'"><i class="fas fa-trash"></i></button>';
                }
                return $buttons;
            })
            ->editColumn('contractaction', function ($inscontlist) {
                $contractbuttons = "";
//                if (Auth::user()->can('clients_attach_print')) {
//                    $contractbuttons .= '<a class="btn btn-secondary btn-sm" target="_blank" title="'. trans('page-contract.contract.titles.printpayments') .'" href="'. route('print-payment-client', $inscontlist->id) .'"><i class="fa fa-print"></i></a> ';
//                }
                if (Auth::user()->can('contract_access')) {
                    $contractbuttons .= '<a class="btn btn-primary btn-sm" target="_blank" title="'. trans('page-client.clients.titles.addcontract') .'" href="'. route('contract-client', $inscontlist->id) .'"><i class="fas fa-th-list"></i></a> ';
                }
                if (Auth::user()->can('payments_access')) {
                    $contractbuttons .= '<a class="btn btn-success btn-sm" target="_blank" title="'. trans('page-contract.contract.titles.cpayments') .'" href="'. route('payment-client', $inscontlist->id) .'"><i class="fa fa-dollar-sign"></i></a> ';
                }
                return $contractbuttons;
            })
            ->rawColumns(['clientaction','contractaction']);

        return $datatables->make(true);
    }

   public function checkcontract(Request $request){
       $rcount = DB::table('contract')
           ->select('*')
           ->where('client','=',$request->get('clientid'))
           ->get();

       $total_row = $rcount->count();
       if($total_row > 0) {
           $rfalg = "1";
       }else{
           $rfalg = "0";
       }

       return response()->json(['rflag'=> $rfalg , 'success' => 'Record is successfully added']);
   }

    public function create()
    {
        abort_if(Gate::denies('clients_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['followlist'] = DB::table('followperson')
            ->select('id', 'Description')
            ->get();

        $data['reglist'] = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $data['evallist'] = DB::table('clientseval')
            ->select('id', 'Description')
            ->get();

        $data['religlist'] = DB::table('religion')
            ->select('id', 'Description')
            ->get();

        $data['natiolist'] = DB::table('natio')
            ->select('id', 'Description')
            ->get();

        if (Auth::user()->can('all_access')) {
            $data['branchlist'] = DB::table('branch')
                ->select('id', 'name')
                ->get();
        }else {
            $bIds = Auth::user()->branch_id;
            $data['branchlist'] = DB::table('branch')
                ->select('id', 'name')
                ->where('id','=',$bIds)
                ->get();
        }

        $titles = ['Clients', 'Garages'];

        $data['roleslist'] = DB::table('roles')
            ->select('id', 'title')
            ->whereIn('title', $titles)
            ->get();

        $strusername = str_pad(mt_rand(1,99999),6,'0',STR_PAD_LEFT);

        $password = str_pad(mt_rand(1,999),4,'0',STR_PAD_LEFT);

//        $brID = Auth::user()->branch_id;
       return view('pages.Clients.create',$data)->with(compact('password','strusername'));
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
                $id = DB::table('religion')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "8") {
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('natio')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }elseif($tbid == "3"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('followperson')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "1002"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('clientseval')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->isMethod("POST")) {

           $values_to_insert = [
               'nclient' => $request->get('nclient') ? true : false,
               'broker' => $request->get('broker') ? true : false,
               'employee' => $request->get('employee') ? true : false,
               'expert' => $request->get('expert') ? true : false,
               'garage' => $request->get('garage') ? true : false,
               'office' => $request->get('office') ? true : false,
               'aperson' => $request->get('aperson') ? true : false,
               'followby' => $request->get('followby'),
               'cname' => $request->get('cname'),
               'birthdate' => $request->get('birthdate'),
               'moname' => $request->get('moname'),
               'cadr' => $request->get('cadr'),
               'creg' => $request->get('creg'),
               'cmob' => $request->get('cmob'),
               'cland' => $request->get('cland'),
               'email' => $request->get('email'),
               'relig' => $request->get('relig'),
               'branch'=> $request->get('branch'),
               'pid'=> $request->get('password'),
               'natio'=> $request->get('natio'),
               'passport'=> $request->get('passport'),
               'eval'=> $request->get('evalclient'),
               'officeshare'=> $request->get('officeshare'),
               'brokershare'=> $request->get('brokershare'),
               'created_by'=> Auth::user()->id,
               'created_at' => date('Y-m-d'),
           ];
            $getclientid = DB::table('clients')->insertGetId($values_to_insert);

            $values_to_insert_users = [
                'name' => $request->get('name'),
                'branch_id'=> $request->get('branch'),
                'email' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
                'status' => '1',
                'person' => $getclientid,
            ];
            $getuserid = DB::table('users')->insertGetId($values_to_insert_users);

            $values_to_insert_users_roles = [
                'user_id' => $getuserid,
                'role_id'=> $request->get('userroles'),
            ];
            DB::table('role_user')->insertGetId($values_to_insert_users_roles);
        }

        return redirect()->route('clients-list');
    }

    public function edit($clientid)
    {
        abort_if(Gate::denies('clients_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['followlist'] = DB::table('followperson')
            ->select('id', 'Description')
            ->get();

        $data['reglist'] = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $data['evallist'] = DB::table('clientseval')
            ->select('id', 'Description')
            ->get();

        $data['religlist'] = DB::table('religion')
            ->select('id', 'Description')
            ->get();

        $data['natiolist'] = DB::table('natio')
            ->select('id', 'Description')
            ->get();

        if (Auth::user()->can('all_access')) {
            $data['branchlist'] = DB::table('branch')
                ->select('id', 'name')
                ->get();
        }else {
            $bIds = Auth::user()->branch_id;
            $data['branchlist'] = DB::table('branch')
                ->select('id', 'name')
                ->where('id','=',$bIds)
                ->get();
        }

//        $data['roleslist'] = DB::table('roles')
//            ->select('id', 'title')
//            ->where('title','=','Clients')
//            ->get();

        $titles = ['Clients', 'Garages'];

        $data['roleslist'] = DB::table('roles')
            ->select('id', 'title')
            ->whereIn('title', $titles)
            ->get();

        $data['clientdetails'] = DB::table('clients')
            ->select('id', 'cname','birthdate','moname','cadr','creg', 'cmob','cland', 'email', 'relig','nclient','broker','employee','garage','aperson','expert','office','branch','officeshare','brokershare','pid','followby','natio','passport','eval')
            ->where('id',$clientid)
            ->get();

        $data['getusersinfo'] = DB::table('users')
            ->select('id', 'name','email','password')
            ->where('person',$clientid)
            ->get();

        $data['getusersrolesinfo'] = DB::table('role_user')
            ->select('role_id')
            ->where('user_id',$data['getusersinfo'][0]->id)
            ->get();

        return view('pages.Clients.edit',$data);
    }

    public function update(Request $request, $clientid)
    {
        if ($request->isMethod("POST")) {

            $values_to_update = [
                'nclient' => $request->get('nclient') ? true : false,
                'broker' => $request->get('broker') ? true : false,
                'employee' => $request->get('employee') ? true : false,
                'expert' => $request->get('expert') ? true : false,
                'garage' => $request->get('garage') ? true : false,
                'office' => $request->get('office') ? true : false,
                'aperson' => $request->get('aperson') ? true : false,
                'followby' => $request->get('followby'),
                'cname' => $request->get('cname'),
                'birthdate' => $request->get('birthdate'),
                'moname' => $request->get('moname'),
                'cadr' => $request->get('cadr'),
                'creg' => $request->get('creg'),
                'cmob' => $request->get('cmob'),
                'cland' => $request->get('cland'),
                'email' => $request->get('email'),
                'relig' => $request->get('relig'),
                'branch'=> $request->get('branch'),
                'pid'=> $request->get('password'),
                'natio'=> $request->get('natio'),
                'passport'=> $request->get('passport'),
                'eval'=> $request->get('evalclient'),
                'officeshare'=> $request->get('officeshare'),
                'brokershare'=> $request->get('brokershare'),
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ];

            DB::table('clients')
                ->where('id', '=', $clientid)
                ->update($values_to_update);

            $values_users_to_update = [
                'name' => $request->get('name'),
                'email' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
            ];

            DB::table('users')
                ->where('person', '=', $clientid)
                ->update($values_users_to_update);

            #####

            $getusersinfo = DB::table('users')
                ->select('id', 'name','email','password')
                ->where('person',$clientid)
                ->get();

            $values_users_roles = [
                'role_id' => $request->get('userroles'),
            ];

            DB::table('role_user')
                ->where('user_id', '=', $getusersinfo[0]->id)
                ->update($values_users_roles);

        }
        return redirect()->route('clients-list');
    }

    public function show($clientid)
    {
        abort_if(Gate::denies('clients_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['followlist'] = DB::table('followperson')
            ->select('id', 'Description')
            ->get();

        $data['reglist'] = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $data['religlist'] = DB::table('religion')
            ->select('id', 'Description')
            ->get();

        $data['branchlist'] = DB::table('branch')
            ->select('id', 'name')
            ->get();

        $data['roleslist'] = DB::table('roles')
            ->select('id', 'title')
            ->where('title','=','Clients')
            ->get();

        $data['clientdetails'] = DB::table('clients')
            ->select('id', 'cname','birthdate','moname','cadr','creg', 'cmob','cland', 'email', 'relig','nclient','aperson','broker','employee','garage','expert','office','branch','officeshare','brokershare','pid','followby')
            ->where('id',$clientid)
            ->get();

        $data['getusersinfo'] = DB::table('users')
            ->select('id', 'name','email','password')
            ->where('person',$clientid)
            ->get();

        $data['getusersrolesinfo'] = DB::table('role_user')
            ->select('role_id')
            ->where('user_id',$data['getusersinfo'][0]->id)
            ->get();

        return view('pages.Clients.show',$data);
    }

    public function deleteclient(Request $request){
        $getcount = DB::table('cars')
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

        $getcount4 = DB::table('accident')
            ->where('expert','=',$request->get('id'))
            ->get();
        $count4 = $getcount4->count();

        $getcount5 = DB::table('accidentdet')
            ->where('aperson','=',$request->get('id'))
            ->get();
        $count5 = $getcount5->count();



        if($count == 0 && $count1 == 0 && $count2 == 0 && $count3 == 0 && $count4 == 0 && $count5 == 0) {
            DB::table('clients')
                ->where('id', '=', $request->get('id'))
                ->delete();

            DB::table('users')
                ->where('person', '=', $request->get('id'))
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

        return view('pages.Clients.license',compact('passplacelist','licensedetails','client_id','client_name'));
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

        return view('pages.Clients.attach_client',compact('docdetails','client_id','client_name'));
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


        return view('pages.Clients.Printout.imgprint',compact('rec1','rec2','rec3'));
    }

    public function autocomplete_clients(Request $request)
    {
        $query = $request->get('term');
        $data = DB::table('clients')
            ->select('cname')
            ->where("cname","LIKE","%".$query."%")
            ->get();

        return response()->json($data);
    }

    public function showmaids($clientid)
    {
        abort_if(Gate::denies('cars_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');


//           $brID = Auth::user()->branch_id;
            $maidslist = DB::table('getclientsmaidslist')
                ->select('id', 'maidname','dob','natioid','passport','natio','natio')
                ->where('client','=',$clientid)
                ->orderBy('id', 'desc')
                ->get();
            $maidscount = DB::table('getclientsmaidslist')
                ->select('id', 'maidname','dob','natioid','passport','natio','natio')
                ->where('client','=',$clientid)
                ->count();



        $client_id = $clientid;
        $getclientname = DB::table('clients')
            ->select('cname')
            ->where('id',$client_id)
            ->get();
        $client_name = $getclientname[0]->cname;

        return view('pages.Clients.showmaids',compact('maidslist','maidscount','client_name','client_id'));
    }

    public function createmaids($clientid)
    {
        abort_if(Gate::denies('cars_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['natio'] = DB::table('natio')
            ->select('id', 'Description')
            ->get();

        $getclientinfo = DB::table('clients')
            ->select('id','cname')
            ->where('id','=',$clientid)
            ->get();

        $clid = $getclientinfo[0]->id;
        $clname = $getclientinfo[0]->cname;

//        $brID = Auth::user()->branch_id;
        return view('pages.Clients.createmaid', $data)->with(compact('clid','clname'));
    }

    public function addNewValueDEFmaids(Request $request)
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
                $id = DB::table('natio')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }
        }
    }

    public function storemaids(Request $request)
    {
        if ($request->isMethod("POST")) {
            $bIds = Auth::user()->branch_id;
            $values_to_insert = [
                'client' => $request->get('clientid'),
                'maidname' => $request->get('maidname'),
                'dob' => $request->get('dob'),
                'natio' => $request->get('natio'),
                'passport' => $request->get('passport'),
                'branch' => $bIds,
                'created_by'=> Auth::user()->id,
            ];

            DB::table('maids')->insert($values_to_insert);
        }
        return redirect()->route('clients.showmaids', $request->get('clientid'));
    }

    public function editmaids($maidid)
    {
        abort_if(Gate::denies('cars_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['natio'] = DB::table('natio')
            ->select('id', 'Description')
            ->get();


        $data['maidsdetails'] = DB::table('maids')
            ->select('id','client', 'maidname','dob','natio','passport','branch')
            ->where('id',$maidid)
            ->get();

        $data['clientname'] = DB::table('clients')
            ->select('id', 'cname')
            ->where('id','=',$data['maidsdetails'][0]->client)
            ->get();

        return view('pages.Clients.editmaid',$data);
//        ->with($slist);
    }

    public function updatemaids(Request $request, $maidid)
    {
        if ($request->isMethod("POST")) {
            $values_to_update = [
                'client' => $request->get('clientid'),
                'maidname' => $request->get('maidname'),
                'dob' => $request->get('dob'),
                'natio' => $request->get('natio'),
                'passport' => $request->get('passport'),
                'updated_by'=> Auth::user()->id,
            ];

            DB::table('maids')
                ->where('id', '=', $maidid)
                ->update($values_to_update);

            $client_id = $request->get('clientid');
        }
        return redirect()->route('clients.showmaids',$client_id );
    }

    public function deletemaids(Request $request){

        $getcount = DB::table('condet')
            ->where('maidid','=',$request->get('id'))
            ->get();
        $count = $getcount->count();


        if($count == 0) {
            DB::table('maids')
                ->where('id','=', $request->get('id'))
                ->delete();

            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }

    function actionclientsmaids(Request $request)
    {
        $output = '';
        $output1 = '';
//            $ifcarsview = '';
//            $ifcarsimg = '';
//            $ifcarstransaction = '';
//            $ifcarsedit = '';
//            $ifcarsdelete = '';
//            $rname = '';


        $clientid = $request->get('clientid');


        $data = DB::table('getclientsmaidslist')
            ->where('client', '=',  $clientid)
            ->orderBy('id', 'desc')
            ->get();

        $total_row = $data->count();

        $datatables = Datatables::of($data)
            ->editColumn('id', function ($maid) {
                return $maid->id;
            })
            ->editColumn('maid_name', function ($maid) {
                return $maid->maidname ;
            })
            ->editColumn('maid_dob', function ($maid) {
                return $maid->dob;
            })
            ->editColumn('maid_natio', function ($maid) {
                return $maid->natio;
            })
            ->editColumn('maid_passport', function ($maid) {
                return $maid->passport;
            })
            ->editColumn('maid_action', function ($maid) {
                $buttons = "";
                if (Auth::user()->can('cars_edit')) {
                    $buttons .= '<a class="btn btn-warning btn-sm" title="'. trans('page-client.clients.titles.editmaid') .'" href="'. route('clients.edit.maids', $maid -> id) .'"><i class="fa fa-edit"></i></a> ';
                }
                if (Auth::user()->can('cars_delete')) {
                    $buttons .= '<button class="btn btn-danger btn-sm" title="'. trans('page-client.clients.titles.deletemaid') .'" data-id="'.$maid -> id.'" data-title="'.$maid -> maidname.'"><i class="fas fa-trash"></i></button>';
                }
                return $buttons;
            })->rawColumns(['maid_action']);

        return $datatables->make(true);
    }

}
