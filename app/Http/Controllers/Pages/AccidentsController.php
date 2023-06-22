<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class AccidentsController extends Controller
{
    public function indexaccidents(){
        abort_if(Gate::denies('accident_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userIds = Auth::user()->id;

        $userIdsperson = Auth::user()->person;

        $data['user_role'] = DB::table('role_user')
            ->select('role_id')
            ->where('user_id','=',$userIds)
            ->get();


        $data['apersonlist'] = DB::table('clients')
            ->select('id', 'cname')
            ->where('display','=','0')
            ->orWhere('aperson','=','1')
            ->get();

        $data['currlist'] = DB::table('currency')
            ->select('id', 'currname_eng')
            ->get();

        return view('pages.Accidents.index',$data)->with(compact('userIdsperson'));
    }

    public function getaccidents(Request $request)
    {
        abort_if(Gate::denies('accident_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sqlstr = $request->get('sqlstr');
        $sqlstrstatus = $request->get('sqlstrstatus');

        $userIds = Auth::user()->person;

        if (Auth::user()->can('all_access')) {
            if ($sqlstr != '' && $sqlstrstatus == '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','garagedetails','ccode','insname')
                    ->where('billclosed', '=', $sqlstr)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','garagedetails','ccode','insname')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','garagedetails','ccode','insname')
                    ->where('status', '=', $sqlstrstatus)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','garagedetails','ccode','insname')
                    ->get();
            }
        }else{
            $bIds = Auth::user()->branch_id;
            if ($sqlstr != '' && $sqlstrstatus == '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','branchid','brname','garagedetails','ccode','insname')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('garage', '=',  $userIds)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','branchid','brname','garagedetails','ccode','insname')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('garage', '=',  $userIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','branchid','brname','garagedetails','ccode','insname')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('garage', '=',  $userIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '') {
                $accidentsdetails = DB::table('getaccidents')
                    ->select('id', 'cname', 'garagename', 'expertname', 'accdate', 'totalcost', 'currname', 'carnumber', 'status', 'carname', 'billclosed', 'regname', 'accidenttypename', 'codestr', 'clientcarname','branchid','brname','garagedetails','ccode','insname')
                    ->where('garage', '=',  $userIds)
                    ->get();
            }
        }

        $datatables = Datatables::of($accidentsdetails)
            ->editColumn('id', function ($acclist) {
                return $acclist->id;
            })
            ->editColumn('billid', function ($acclist) {
                return $acclist->billclosed;
            })
            ->editColumn('statusid', function ($acclist) {
                return $acclist->status;
            })
            ->editColumn('accbill', function ($acclist) {
                    $statusbuttons = "";
                    if ($acclist->billclosed) {
                        $statusbuttons .= '<a href="javascript:;" data-id="' . $acclist->id . '" data-to="0" class="btn btn-bill btn-sm btn-outline-success btn-block">' . trans('page-accidents.tables.closed') . '</a>';
                    } else {
                        $statusbuttons .= '<a href="javascript:;" data-id="' . $acclist->id . '" data-to="1" class="btn btn-bill btn-sm btn-outline-danger btn-block">' . trans('page-accidents.tables.notclosed') . '</a>';
                    }
                    return $statusbuttons;
            })
            ->editColumn('accstatus', function ($acclist) {
                    $statusbuttons = "";
                    if ($acclist->status) {
                        $statusbuttons .= '<a href="javascript:;" data-id="' . $acclist->id . '" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">' . trans('page-accidents.tables.notonprocess') . '</a>';
                    } else {

                        $statusbuttons .= '<a href="javascript:;" data-id="' . $acclist->id . '" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">' . trans('page-accidents.tables.onprocess') . '</a>';
                    }
                    return $statusbuttons;
            })
            ->editColumn('accaction', function ($acclist) {
                $buttons = "";
                if (Auth::user()->can('accident_edit')) {
                    $buttons .= '<a class="btn btn-info btn-sm" href="' . url('/accident/edit/' . $acclist->id) . '" title="' . trans('page-accidents.tables.editcontract') . '"><i class="fa fa-edit"></i></a> ';
                }
                if (Auth::user()->can('accident_delete')) {
                    $buttons .= '<button class="delete-btn-accident btn-danger btn-sm" title="'. trans('page-accidents.tables.deletecontract') .'" data-id="'.$acclist -> id.'" data-title="'.$acclist -> cname.'"><i class="fas fa-trash"></i></button>';
                }
                return $buttons;
            })->editColumn('accaperson', function ($acclist) {
                $buttons = "";
                    $buttons .= '<button class="create-modal btn btn-primary btn-sm" data-id="' . $acclist->id . '" data-code="' . $acclist->codestr . '"  title="' . trans('page-accidents.tables.aperson') . '"><i class="fa fa-people-carry"></i></button> ';
               return $buttons;
            })
            ->editColumn('acccode', function ($acclist) {
                return $acclist->codestr;
            })
            ->editColumn('acctype', function ($acclist) {
                return $acclist->accidenttypename;
            })
            ->editColumn('accdate', function ($acclist) {
                return $acclist->accdate;
            })
            ->editColumn('accperson', function ($acclist) {
                if($acclist->cname == "NONE") {
                    return $acclist->clientcarname;
                }else{
                    return $acclist->cname;
                }
            })
            ->editColumn('accinsname', function ($acclist) {
                return $acclist->ccode . ' , ' . $acclist->insname;
            })
            ->editColumn('acccar', function ($acclist) {
                return $acclist->carname . ' - ' . $acclist->carnumber;
            })
            ->editColumn('accgarage', function ($acclist) {
                return $acclist->garagename;
            })
            ->editColumn('accexpert', function ($acclist) {
                return $acclist->expertname;
            })
            ->editColumn('acccost', function ($acclist) {
                    return $acclist->totalcost;
            })
            ->editColumn('acccurr', function ($acclist) {
                    return $acclist->currname;
            })
            ->rawColumns(['accbill','accstatus','accaction','accaperson']);

        return $datatables->make(true);
    }

    public function changeAccidentBillingStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'bid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::table('accident')
                ->where([
                    ['id', '=', $request->get('bid')],
                ])
                ->update(['billclosed' => $request->get('sts')]);
            return response()->json(array('msg' => 'msg'), 200);
        }
    }

    public function changeAccStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'bid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::table('accident')
                ->where([
                    ['id', '=', $request->get('bid')],
                ])
                ->update(['status' => $request->get('sts')]);
            return response()->json(array('msg' => 'msg'), 200);
        }
    }

    public function getcarvalide(Request $request){
        $carvalide = DB::table('condet')
            ->select('status')
            ->where('carid','=',$request->get('carid'))
            ->get();
        $count = $carvalide->count();

        if( $count > 0) {
            $flag = "1";
            $rec1 = $carvalide[0]->status;
            $rec2 = $flag;
        }else{
            $flag = "0";
            $rec1 = "-";
            $rec2 = $flag;
        }

        return response()->json(['status'=>$rec1,'flag'=>$rec2]);
    }

    public function create()
    {
        abort_if(Gate::denies('accident_create'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brID = Auth::user()->branch_id;

        $userIds = Auth::user()->id;

        $userIdsperson = Auth::user()->person;

        $data['user_role'] = DB::table('role_user')
            ->select('role_id')
            ->where('user_id', '=', $userIds)
            ->get();

        $data['reglist'] = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $data['accidenttype'] = DB::table('accidenttype')
            ->select('id', 'Description')
            ->get();

        if ($data['user_role'][0]->role_id == "6") {
            $data['garagelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->Where('id', '=', $userIdsperson)
                ->get();

            $data['clientslist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere('nclient', '=', '1')
                ->get();

            $data['expertlist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere('expert', '=', '1')
                ->get();

            $data['carslist'] = DB::table('cars')
                ->select('id', 'carname', 'platnumber')
                ->get();

        }elseif ($data['user_role'][0]->role_id == "7"){
            $data['garagelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display','=','0')
                ->orWhere('garage','=','1')
                ->get();

            $bIds = Auth::user()->branch_id;
            $data['clientslist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere(function ($query) {
                    $bIds = Auth::user()->branch_id;
                    $query->where('nclient', '=', '1')
                        ->where('branch', '=', $bIds);
                })
                ->get();


            $data['expertlist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere(function ($query) {
                    $bIds = Auth::user()->branch_id;
                    $query->where('expert', '=', '1')
                        ->where('branch', '=', $bIds);
                })
                ->get();

            $brID = Auth::user()->branch_id;
            $data['carslist'] = DB::table('cars')
                ->select('id', 'carname', 'platnumber')
                ->where('branch', '=', $bIds)
                ->get();

        }else{
            $data['garagelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display','=','0')
                ->orWhere('garage','=','1')
                ->get();

            $data['clientslist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere('nclient', '=', '1')
                ->get();

            $data['expertlist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere('expert', '=', '1')
                ->get();

            $data['carslist'] = DB::table('cars')
                ->select('id', 'carname', 'platnumber')
                ->get();

        }



        $data['hosplist'] = DB::table('hospitals')
            ->select('id', 'Description')
            ->get();

        $data['currlist'] = DB::table('currency')
            ->select('id', 'currname_eng')
            ->get();

        $brID = Auth::user()->branch_id;

        return view('pages.Accidents.create',$data)->with(compact('brID'));
    }

    public function getaperson()
    {
        if (Auth::user()->can('all_access')) {
            return
                response()->json(
                    DB::table('clients')
                        ->select('id', 'cname')
                        ->Where('aperson','=','1')
                        ->get()
                );
        }else {
            $bIds = Auth::user()->branch_id;
            return
                response()->json(
                    DB::table('clients')
                        ->select('id', 'cname')
                        ->Where('aperson','=','1')
                        ->Where('branch','=',$bIds)
                        ->get()
                );
        }
    }

    public function addNewValueDEFacc(Request $request)
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
                $id = DB::table('accidenttype')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "3"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('hospitals')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "4"){
                $values_to_insert = [
                    'currname_eng' => $request->get('description'),
                ];
                $id = DB::table('currency')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->isMethod("POST")) {

            $accnum = DB::table('settings')
                ->select('accnum')
                ->get();

            $currentyear = now()->year;

            $cyear = substr($currentyear,2);

            $codestr = "ACC-".$cyear."-".$accnum[0]->accnum;

            $values_to_insert = [
                'accidenttype' => $request->get('accidenttype'),
                'accdate' => $request->get('accdate'),
                'reg' => $request->get('reg'),
                'client' => $request->get('client'),
                'garage' => $request->get('garage'),
                'gcost' => $request->get('gcost'),
                'gcurr' => $request->get('gcurr'),
                'gcost2' => $request->get('gcost2'),
                'gcurr2' => $request->get('gcurr2'),
                'car' => $request->get('car'),
                'expert' => $request->get('expert'),
                'ecost' => $request->get('ecost'),
                'ecurr' => $request->get('ecurr'),
                'hospital'=> $request->get('hospital'),
                'hcost'=> $request->get('hcost'),
                'hcurr'=> $request->get('hcurr'),
                'details'=> $request->get('details'),
                'garagedetails'=> $request->get('garagedetails'),
                'totalcost'=> $request->get('totalcost'),
                'curr'=> $request->get('tcurr'),
                'branch'=> $request->get('branch_id'),
                'contid'=> $request->get('insname'),
                'codenum' => $accnum[0]->accnum,
                'codestr' => $codestr,
                'compacccode' => $request->get('compacccode'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
           DB::table('accident')->insert($values_to_insert);

            $values_to_update_accnum = [
                'accnum' => $accnum[0]->accnum + 1 ,
            ];

            DB::table('settings')
                ->update($values_to_update_accnum);
        }

        return redirect()->route('accidents-list');
    }

    public function edit($accid)
    {
        abort_if(Gate::denies('accident_edit'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brID = Auth::user()->branch_id;

        $userIds = Auth::user()->id;

        $userIdsperson = Auth::user()->person;

        $data['user_role'] = DB::table('role_user')
            ->select('role_id')
            ->where('user_id','=',$userIds)
            ->get();

        $data['accidentsdetails'] = DB::table('accident')
            ->select('id', 'accidenttype','accdate', 'reg', 'garage','gcost', 'gcurr','gcost2', 'gcurr2', 'car','expert', 'ecost', 'ecurr', 'hospital','hcost','hcurr','details','totalcost','curr','compacccode','client','garagedetails','contid')
            ->where('id', '=', $accid)
            ->get();

        $data['reglist'] = DB::table('reg')
            ->select('id', 'Description')
            ->get();

        $data['clientslist'] = DB::table('clients')
            ->select('id', 'cname')
            ->where('display','=','0')
            ->orWhere('nclient','=','1')
            ->get();

        $data['accidenttype'] = DB::table('accidenttype')
            ->select('id', 'Description')
            ->get();

        if($data['user_role'][0]->role_id == "6"){
            $data['garagelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->Where('id','=',$userIdsperson)
                ->get();
        }elseif ($data['user_role'][0]->role_id == "7"){
            $data['garagelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display','=','0')
                ->orWhere('garage','=','1')
                ->get();
        }else{
            $data['garagelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display','=','0')
                ->orWhere('garage','=','1')
                ->get();
        }


        $data['carslist'] = DB::table('cars')
            ->select('id', 'carname','platnumber')
            ->get();

        $data['expertlist'] = DB::table('clients')
            ->select('id', 'cname')
            ->where('display','=','0')
            ->orWhere('expert','=','1')
            ->get();

        $data['hosplist'] = DB::table('hospitals')
            ->select('id', 'Description')
            ->get();

        $data['currlist'] = DB::table('currency')
            ->select('id', 'currname_eng')
            ->get();

        $flag = "1";

        return view('pages.Accidents.edit',$data)->with(compact('flag'));
    }

    public function update(Request $request, $accid)
    {
        if ($request->isMethod("POST")) {

            $values_to_update = [
                'accidenttype' => $request->get('accidenttype'),
                'accdate' => $request->get('accdate'),
                'reg' => $request->get('reg'),
                'client' => $request->get('client'),
                'garage' => $request->get('garage'),
                'gcost' => $request->get('gcost'),
                'gcurr' => $request->get('gcurr'),
                'gcost2' => $request->get('gcost2'),
                'gcurr2' => $request->get('gcurr2'),
                'car' => $request->get('car'),
                'expert' => $request->get('expert'),
                'ecost' => $request->get('ecost'),
                'ecurr' => $request->get('ecurr'),
                'hospital'=> $request->get('hospital'),
                'hcost'=> $request->get('hcost'),
                'hcurr'=> $request->get('hcurr'),
                'details'=> $request->get('details'),
                'garagedetails'=> $request->get('garagedetails'),
                'totalcost'=> $request->get('totalcost'),
                'curr'=> $request->get('tcurr'),
                'compacccode' => $request->get('compacccode'),
                'contid'=> $request->get('insname'),
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ];

            DB::table('accident')
                ->where('id', '=', $accid)
                ->update($values_to_update);

        }
        return redirect()->route('accidents-list');
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

    public function deleteaccident(Request $request){

        DB::table('accident')
            ->where('id', '=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }

//    Modals Actions

    public function addaperson(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'aperson' => 'required',
                'accost' => 'required',
                'acccurr' => 'required',
                'adetails' => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'accident' => $request->get('accident'),
                'aperson' => $request->get('aperson'),
                'accost' => $request->get('accost'),
                'acccurr' => $request->get('acccurr'),
                'adetails' => $request->get('adetails'),
            ];

            $data = DB::table('accidentdet')->insert($values_to_insert);

            return response()->json();
        }

}

    public function editaperson(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'aperson' => 'required',
                'accost' => 'required',
                'acccurr' => 'required',
                'adetails' => 'required',
            );


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data = DB::table('accidentdet')
                ->where('id', $request->get('id'))
                ->update([
                    'aperson' => $request->get('aperson'),
                    'accost' => $request->get('accost'),
                    'acccurr' => $request->get('acccurr'),
                    'adetails' => $request->get('adetails'),
                ]);

            return response()->json();
        }

    }

    public function deleteaperson(Request $request){
        DB::table('accidentdet')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
    }

    public function getapesonacclist(Request $request){

        $apersonlist = DB::table('getaccidentsaperson')
            ->select('id','accidentid','apersonid','apersonname','accost','acccurr','currname','adetails','closed')
            ->where('accidentid', '=', $request->get('accid'))
            ->orderBy('id', 'desc')
            ->get();

        $datatables = Datatables::of($apersonlist)
            ->editColumn('id', function ($aplist) {
                return $aplist->id;
            })
            ->editColumn('closedactions', function ($acclist) {
                $statusbuttons = "";
                if ($acclist->closed) {
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$acclist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-accidents.modals.closed') .'</a>';
                }
                else{

                    $statusbuttons .= '<a href="javascript:;" data-id="'.$acclist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-accidents.modals.notclosed') .'</a>';
                }
                return $statusbuttons;
            })
            ->editColumn('aperson', function ($aplist) {
                return $aplist->apersonname;
            })
            ->editColumn('acost', function ($aplist) {
                return $aplist->accost;
            })
            ->editColumn('acurr', function ($aplist) {
                return $aplist->currname;
            })
            ->editColumn('apersonactions', function ($aplist) {
                $buttons = "";
                $buttons .= '<a href="javascript:;" class="edit-btn-aperson btn btn-warning btn-sm inline" data-id="'.$aplist->id.'" data-accidentid="'.$aplist->accidentid.'" data-apersonid="'.$aplist->apersonid.'" data-apersonname="'.$aplist->apersonname.'" data-accost="'.$aplist->accost.'" data-acccurr="'.$aplist->acccurr.'" data-currname="'.$aplist->currname.'" data-adetails="'.$aplist->adetails.'"  title="'.trans('page-accidents.modals.editaperson').'"><i class="fas fa-edit"></i></a>';
                $buttons .= '<a href="javascript:;" class="delete-btn-aperson btn btn-danger btn-sm inline" title="'. trans('page-accidents.modals.deleteaperson') .'" data-id="'.$aplist -> id.'" data-title="'.$aplist -> apersonname.'"><i class="fas fa-trash"></i></a>';

                return $buttons;
            })
            ->rawColumns(['closedactions','apersonactions']);

        return $datatables->make(true);
    }

    public function changeApersonStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'bid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::table('accidentdet')
                ->where([
                    ['id', '=', $request->get('bid')],
                ])
                ->update(['closed' => $request->get('sts')]);
            return response()->json(array('msg' => 'msg'), 200);
        }
    }

    public function getinsurancecode(Request $request){

        $data['insname'] = DB::table('clients_products_list')
            ->select('id','ccode','insname')
            ->where('client','=',$request->get('idclient'))
            ->where('status','=',"0")
            ->get();

//        $rec1 = $insname[0]->ins_id;
//        $rec2 = $insname[0]->insname;

        return response()->json($data);
//        return response()->json(['ins_id' => $rec1,'insname' => $rec2]);
    }
    public function getinsnamecode($id){
        $insname = DB::table('clients_products_list')
            ->select('id','ccode','insname')
            ->where('id','=',$id)
            ->get();

        $rec1 = $insname[0]->id;
        $rec2 = $insname[0]->ccode;
        $rec3 = $insname[0]->insname;

        return response()->json(['contdetid'=>$rec1,'ccode'=>$rec2,'insname'=>$rec3]);
    }

}
