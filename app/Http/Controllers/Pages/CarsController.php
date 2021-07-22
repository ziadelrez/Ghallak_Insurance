<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarsRequest;
use App\Http\Requests\UpdateCarsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class CarsController extends Controller
{
   public function index()
   {
       abort_if(Gate::denies('cars_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

       if (Auth::user()->can('all_access')) {
//           $brID = Auth::user()->branch_id;
           $carslist = DB::table('getcarslist')
               ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename','carrate','curr')
//               ->where('branchid','=',$brID)
               ->orderBy('carid', 'desc')
               ->get();
           $carscount = DB::table('getcarslist')
               ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename','carrate','curr')
//               ->where('branchid','=',$brID)
               ->count();
       }else{
           $brID = Auth::user()->branch_id;
           $carslist = DB::table('getcarslist')
               ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename','carrate','curr')
               ->where('branchid','=',$brID)
               ->orderBy('carid', 'desc')
               ->get();
           $carscount = DB::table('getcarslist')
               ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename','carrate','curr')
               ->where('branchid','=',$brID)
               ->count();
       }

        return view('pages.cars.index',compact('carslist','carscount'));
   }

    function action(Request $request)
    {
            $output = '';
            $output1 = '';
//            $ifcarsview = '';
//            $ifcarsimg = '';
//            $ifcarstransaction = '';
//            $ifcarsedit = '';
//            $ifcarsdelete = '';
//            $rname = '';

            $query = $request->get('query');
            $sqlstr = $request->get('sqlstr');

            if($query != '' and $sqlstr != '')
            {
                $data = DB::table('getcarslist')
                    ->where('carname', 'like', '%'.$query.'%')
                    ->orWhere('carnumber', 'like', '%'.$query.'%')
                    ->orWhere('cartype', 'like', '%'.$query.'%')
                    ->orWhere('carcolor', 'like', '%'.$query.'%')
                    ->orWhere('caryear', 'like', '%'.$query.'%')
                    ->orWhere('carrate', 'like', '%'.$query.'%')
                    ->where('taken', '=',  $sqlstr)
                    ->orderBy('carid', 'desc')
                    ->get();

            }
            elseif($query != '' and $sqlstr == '')
            {
                $data = DB::table('getcarslist')
                    ->where('carname', 'like', '%'.$query.'%')
                    ->orWhere('carnumber', 'like', '%'.$query.'%')
                    ->orWhere('cartype', 'like', '%'.$query.'%')
                    ->orWhere('carcolor', 'like', '%'.$query.'%')
                    ->orWhere('caryear', 'like', '%'.$query.'%')
                    ->orWhere('carrate', 'like', '%'.$query.'%')
                    ->orderBy('carid', 'desc')
                    ->get();

            }
            elseif($query == '' and $sqlstr != '')
            {
                $data = DB::table('getcarslist')
                    ->where('taken', '=',  $sqlstr)
                    ->orderBy('carid', 'desc')
                    ->get();

            }
            else
            {
                $data = DB::table('getcarslist')
                    ->orderBy('carid', 'desc')
                    ->get();
            }
            $total_row = $data->count();

            $datatables = Datatables::of($data)
                ->editColumn('car_id', function ($car) {
                    return $car->carid;
                })
                ->editColumn('car_name', function ($car) {
                    return $car->carname;
                })
                ->editColumn('car_number', function ($car) {
                    return $car->carnumber;
                })
                ->editColumn('car_type', function ($car) {
                    return $car->cartype;
                })
                ->editColumn('car_color', function ($car) {
                    return $car->carcolor;
                })
                ->editColumn('car_model', function ($car) {
                    return $car->caryear;
                })
                ->editColumn('car_rates', function ($car) {
                    return $car->carrate . ' ' . $car->curr;
                })
                ->editColumn('car_photo', function ($car) {
                    if(isset($car -> img_filename)) {
                        $ifimage = asset('/files/cars/'. $car->carid . '/' . $car->img_filename);
                        return '<img src='.$ifimage.' style="width: 70px; height: 70px;" class="img-circle">';
                    }else{
                        $ifimage = asset('/files/images/no-photo.jpg');
                        $imgsource = '<img src="' . $ifimage . '"  style="width: 70px; height: 70px;" class="img-circle">';
                        return $imgsource ;
                    };
                })
                ->editColumn('car_action', function ($car) {
                    $buttons = "";
                    if (Auth::user()->can('cars_img')) {
                        $buttons = '<a class="btn btn-primary btn-sm" title="'. trans('page-cars.cars.titles.addpic') .'" href="'. route('cars.images', $car -> carid) .'"><i class="fas fa-images"></i></a> ';
                    }
                    if (Auth::user()->can('cars_edit')) {
                        $buttons .= '<a class="btn btn-warning btn-sm" title="'. trans('page-cars.cars.titles.edit') .'" href="'. route('cars.edit', $car -> carid) .'"><i class="fa fa-edit"></i></a> ';
                    }
                    if (Auth::user()->can('cars_delete')) {
                        $buttons .= '<button class="btn btn-danger btn-sm" title="'. trans('page-cars.cars.titles.delete') .'" data-id="'.$car -> carid.'" data-title="'.$car -> carname.'"><i class="fas fa-trash"></i></button>';
                    }
                    return $buttons;
                })->rawColumns(['car_photo','car_action']);

        return $datatables->make(true);
    }

    public function create()
    {
        abort_if(Gate::denies('cars_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['cartypelist'] = DB::table('cartype')
            ->select('id', 'Description')
            ->get();

        $data['carmodellist']  = DB::table('years')
            ->select('id', 'Description')
            ->get();

        $data['carcolorlist'] = DB::table('carcolors')
            ->select('id', 'Description')
            ->get();

        $data['carenginelist'] = DB::table('carsenginetype')
            ->select('id', 'Description')
            ->get();

        $data['cartransmissionlist'] = DB::table('carstransmission')
            ->select('id', 'Description')
            ->get();

        $data['carspecslist'] = DB::table('carsspecs')
            ->select('id', 'Description')
            ->get();

        $data['setcurr'] = DB::table('Settings')
            ->select('curr')
            ->get();

       $data['currlist'] = DB::table('currency')
           ->select('id', 'currname_ara')
           ->where('id','=',$data['setcurr'][0]->curr)
           ->get();

        $data['branchlist'] = DB::table('branch')
            ->select('id', 'name')
            ->get();


//        $brID = Auth::user()->branch_id;
       return view('pages.cars.create', $data);
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
                $id = DB::table('cartype')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }elseif($tbid == "2"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('years')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "3"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('carcolors')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "4"){
                $values_to_insert = [
                    'currname_eng' => $request->get('description'),
                ];
                $id = DB::table('currency')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "5"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('carsenginetype')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "6"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('carsspecs')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }elseif($tbid == "7"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('carstransmission')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }
        }
    }

    public function store(StoreCarsRequest $request)
    {
        if ($request->isMethod("POST")) {

           $values_to_insert = [
               'carname' => $request->get('carname'),
               'platnumber' => $request->get('platnumber'),
               'cartype' => $request->get('cartype'),
               'carmodel' => $request->get('carmodel'),
               'enginetype' => $request->get('carenginetype'),
               'carcolor' => $request->get('carcolor'),
               'chanum' => $request->get('chanum'),
               'engnum' => $request->get('engnum'),
               'carrate' => $request->get('carrate'),
               'curr' => $request->get('curr'),
               'carused' => $request->get('carused'),
               'carstop' => $request->get('carstop') ? true : false,
//               'img_filename' => $request->get('photo'),
//               'img_extension' => $request->get('carimage'),
               'stopdate' => $request->get('stopdate'),
               'passenger' => $request->get('passenger'),
               'bags' => $request->get('bags'),
               'doors' => $request->get('doors'),
               'transmission' => $request->get('transmission'),
               'branch'=> $request->get('branch_id'),
               'created_by'=> Auth::user()->id,
               'created_at' => date('Y-m-d'),
           ];

           $carid = DB::table('cars')->insertGetId($values_to_insert);

            $counter = 1;
            $path_info = pathinfo($request->file('photo')->getClientOriginalName());
            $file_name = $path_info["filename"];
            $extension = $path_info["extension"];


            while (file_exists(public_path() . '/files/cars/'. $carid . '/' . $file_name . '.' . $extension)) {
                $file_name = $path_info["filename"] . '_' . $counter;
                $counter++;
            }
            if ($request->file('photo')->isValid()) {
                $request->file('photo')->move('files/cars/' . $carid, $file_name . '.' . $extension);

                DB::table('cars')
                    ->where('id', $carid)
                    ->update([
                        'img_filename' => $file_name . '.' . $extension,
                        'img_extention' => $extension,
                    ]);

                foreach($request->carsspecs as $specsid) {
                    $values_to_insert_specs = [
                        'car_id'   => $carid,
                        'carspecs_id' => $specsid,
                    ];
                    DB::table('cars_specs')->insert($values_to_insert_specs);
                }
            }
        }
        return redirect()->route('cars-list');
    }

    public function edit($carsid)
    {
        abort_if(Gate::denies('cars_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['cartypelist'] = DB::table('cartype')
            ->select('id', 'Description')
            ->get();

        $data['carmodellist']  = DB::table('years')
            ->select('id', 'Description')
            ->get();

        $data['carcolorlist'] = DB::table('carcolors')
            ->select('id', 'Description')
            ->get();

        $data['carenginelist'] = DB::table('carsenginetype')
            ->select('id', 'Description')
            ->get();

        $data['cartransmissionlist'] = DB::table('carstransmission')
            ->select('id', 'Description')
            ->get();

        $data['carspecslist'] = DB::table('carsspecs')
            ->select('id', 'Description')
            ->get();

        $data['setcurr'] = DB::table('Settings')
            ->select('curr')
            ->get();

        $data['currlist'] = DB::table('currency')
            ->select('id', 'currname_ara')
            ->where('id','=',$data['setcurr'][0]->curr)
            ->get();

//        $data['slist'] = DB::table('cars_specs')
//            ->select('carspecs_id')
//            ->where('car_id',$carsid)
//            ->get();

        $slist = DB::table('cars_specs')
            ->select('carspecs_id')
            ->where('car_id',$carsid)
            ->get();


        $data['branchlist'] = DB::table('branch')
            ->select('id', 'name')
            ->get();

        $slist1 = collect($slist)->pluck('carspecs_id');

        $data['slist2'] = $slist1;

//        dd($data['slist2']);

//       $list=array_combine($data['carspecslist'], $data['slist']);

//        $data['specslist'] = explode(',', $slist);
//
//        dd($list);
//
//        echo '<pre>';
//        print_r($data['specslist']);
//        echo '</pre>';

        $data['carsdetails'] = DB::table('cars')
            ->select('id', 'carname','platnumber','cartype','carmodel','enginetype', 'carcolor', 'chanum', 'engnum', 'carrate', 'curr', 'carused', 'carstop','passenger','bags','doors','transmission','stopdate','branch','img_filename')
            ->where('id',$carsid)
            ->get();

        return view('pages.cars.edit',$data);
//        ->with($slist);
    }

    public function update(UpdateCarsRequest $request, $carsid)
    {
        if ($request->isMethod("POST")) {

            $values_to_update = [
                'carname' => $request->get('carname'),
                'platnumber' => $request->get('platnumber'),
                'cartype' => $request->get('cartype'),
                'carmodel' => $request->get('carmodel'),
                'enginetype' => $request->get('carenginetype'),
                'carcolor' => $request->get('carcolor'),
                'chanum' => $request->get('chanum'),
                'engnum' => $request->get('engnum'),
                'carrate' => $request->get('carrate'),
                'curr' => $request->get('curr'),
                'carused' => $request->get('carused'),
                'carstop' => $request->get('carstop') ? true : false,
//               'img_filename' => $request->get('photo'),
//               'img_extension' => $request->get('carimage'),
                'stopdate' => $request->get('stopdate'),
                'passenger' => $request->get('passenger'),
                'bags' => $request->get('bags'),
                'doors' => $request->get('doors'),
                'transmission' => $request->get('transmission'),
                'branch'=> $request->get('branch'),
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ];

        DB::table('cars')
            ->where('id', '=', $carsid)
            ->update($values_to_update);

            if($request->hasFile('photo')) {
                $counter = 1;
                    $path_info = pathinfo($request->file('photo')->getClientOriginalName());
                    $file_name = $path_info["filename"];
                    $extension = $path_info["extension"];


                    while (file_exists(public_path() . '/files/cars/'. $carsid . '/' . $file_name . '.' . $extension)) {
                        $file_name = $path_info["filename"] . '_' . $counter;
                        $counter++;
                    }
                    if ($request->file('photo')->isValid()) {
                        $request->file('photo')->move('files/cars/' . $carsid, $file_name . '.' . $extension);

                        DB::table('cars')
                            ->where('id', $carsid)
                            ->update([
                                'img_filename' => $file_name . '.' . $extension,
                                'img_extention' => $extension,
                            ]);
                    }
            }
                DB::table('cars_specs')
                    ->where('car_id', $carsid)
                    ->delete();

                foreach($request->carsspecs as $specsid) {
                    $values_to_insert_specs = [
                        'car_id'   => $carsid,
                        'carspecs_id' => $specsid,
                    ];
                    DB::table('cars_specs')->insert($values_to_insert_specs);
                }

        }
        return redirect()->route('cars-list');
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

    public function deletecars(Request $request){
        $getcount1 = DB::table('carcollection')
            ->where('carid','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();

        $getcount = DB::table('condet')
            ->where('car','=',$request->get('id'))
            ->get();
        $count = $getcount->count();

        $getcount2 = DB::table('booking')
            ->where('car','=',$request->get('id'))
            ->get();
        $count2 = $getcount2->count();


        if($count == 0 && $count1 == 0 && $count2 == 0) {
                DB::table('cars')
                    ->where('id','=', $request->get('id'))
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
            ->select('id', 'clid','cname','docname','att_filename','att_extension')
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

    function caruploadimg(Request $request)
    {
//        $carid = $request->get('car__id');
//        echo $request->get('car__id');
//        exit();
        $counter = 1;
        $path_info = pathinfo($request->file('file')->getClientOriginalName());
        $file_name = $path_info["filename"];
        $extension = $path_info["extension"];


        while (file_exists(public_path() . '/files/cars/'. $request->get('car_id') . '/' . $file_name . '.' . $extension)) {
        $file_name = $path_info["filename"] . '_' . $counter;
        $counter++;
    }
        if ($request->file('file')->isValid()) {
            $request->file('file')->move('files/cars/' . $request->get('car_id'), $file_name . '.' . $extension);

            DB::table('cars')
                ->where('id', $request->get('car_id'))
                ->update([
                    'img_filename' => $file_name . '.' . $extension,
                    'img_extention' => $extension,
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);
        }


    }

    function saveImage($photo,$folder){
        $file_extension = $photo -> getClientOriginalExtension();
        $file_name = time().'.'.$file_extension;
        $path = $folder;
        $photo -> move($path,$file_name);
        return $file_name;
    }

    public function image_delete_file(Request $request,$carid){
        $filename = $request->id;
        $path_image = public_path() . '/files/cars/'. $carid . '/' . $filename;

        if (file_exists($path_image)) {
            unlink($path_image);
        }
        DB::table('cars')
            ->where('id', $carid)
            ->update([
                'img_filename' => '',
                'img_extention' => '',
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ]);
//        return Response::json(['success' => 'File successfully delete'], 200);
        }

    public function savedocfile(Request $request,$clientid){
//        $filename = $request->filename;
        if ($request->isMethod("POST")) {

            $rules = array(
                'docname' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

//            $path_info = pathinfo($request->file('file')->getClientOriginalName());
//            $att_filename =
            $path_info =$request->file('file');
//           echo $path_info;
            $file_name = pathinfo( $path_info,PATHINFO_FILENAME);
            $extension = pathinfo( $path_info,PATHINFO_EXTENSION);

            $values_to_insert = [
                'cid' => $request->get('cid'),
                'docname' => $request->get('docname'),
                'att_filename' => $file_name,
                'att_extension' => $extension,
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

    public function attachimages($carsid)
    {
        abort_if(Gate::denies('clients_attach_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cars_ids = $carsid;
        $getattachfiles = DB::table('carcollection')
            ->select('file_type','file_name','file_extention')
            ->where('id',$cars_ids)
            ->get();

        $carname = DB::table('cars')
            ->select('carname')
            ->where('id',$cars_ids)
            ->get();


//        $brID = Auth::user()->branch_id;
        return view('pages.cars.attachimages',compact('cars_ids','getattachfiles','carname'));
    }

    public function storeIMAGES(Request $request)
    {
        $this->storeFile($request, 'images-files');
    }

    public function storeDOCS(Request $request)
    {
        $this->storeFile($request, 'docs-files');
    }

    private function storeFile(Request $request, $file_type)
    {
        $counter = 1;
        $path_info = pathinfo($request->file('file')->getClientOriginalName());
        $file_name = $path_info["filename"];
        $extension = $path_info["extension"];

        while (file_exists(public_path() . '/files/cars/'.$request->get('car_id').'/' . $file_type. '/' . $file_name . '.' . $extension)) {
            $file_name = $path_info["filename"] . '_' . $counter;
            $counter++;
        }

        if ($request->file('file')->isValid()) {
            $request->file('file')->move('files/cars/'.$request->get('car_id').'/' . $file_type, $file_name . '.' . $extension);

            $values_to_insert = [
                'carid' =>  $request->get('car_id'),
                'file_name' => $file_name . '.' . $extension,
                'file_extention' => $extension,
                'file_type' => $file_type,
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

           DB::table('carcollection')->insert($values_to_insert);
        }
    }

    public function getfileslist(Request $request){
        $output = '';
        $rflag = '';
        $output1 = '';
        $button1='';
        $button2='';
        $button3='';
        $filestlist = DB::table('carcollection')
            ->select('id','carid','file_type','file_name','file_extention')
            ->where('carid',$request->get('car_id'))
            ->get();

        $total_row = $filestlist->count();
        if($total_row > 0) {
            $rflag = "1";
            foreach ($filestlist as $row) {
                $path = url('/files/cars/'.$row->carid. '/' .$row->file_type. '/' .$row->file_name);
                if ($row->file_extention == "pdf" || $row->file_extention == "txt") {
                    $button1 = '<a data-id="' . $row->id. '" class="btn btn-outline-primary btn-xs asDoc" href="javascript:;" data-path="' . $path . '"  ><i class="fa fa-search-plus"></i></a>';
                }else{
                    $button1 = '<a data-id="' . $row->id . '" class="btn btn-outline-primary btn-xs asImage" href="' . $path . '" data-featherlight="' . $path . '" ><i class="fa fa-search-plus"></i></a>';
                }
                $button2 = '<a data-id="' . $row->id . '" target="_blank" class="btn btn-outline-success btn-xs" href="' . url('/download-patient-files/' . $row->id) . '"><i class="fa fa-download"></i></a> ';
                $button3 = '<a data-id="' . $row->id . '" class="btn btn-outline-danger btn-xs"  href="javascript:;"><i class="fa fa-trash"></i> </a>';

                $output1 .=' <tr class="filesrows'.$row->id.'">
                            <td style="display:none;" >'.$row->id.'</td>
                            <td class="text-center" style="vertical-align: middle" width="20%">'.ucfirst($row->file_type).'</td>
                            <td class="text-center" style="vertical-align: middle" width="60%">'.$row->file_name.'</td>
                            <td class="text-center" width="20%">
                            '.$button1.'
                            '.$button2.'
                            '.$button3.'
                            </td>
                            </tr>';
            }

            $output .= '
                  <form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th style="display:none;" width="20%">'. trans('page-cars.cars.tables.id') .'</th>
                                <th width="20%">'. trans('page-cars.cars.tables.filetype') .'</th>
                                <th width="60%">'. trans('page-cars.cars.tables.filename') .'</th>
                                <th width="20%">'. trans('page-cars.cars.tables.attchactions') .'</th>
                            </tr>
                            </thead>

                            <tbody>
                                 '.$output1.'
                            </tbody>
                        </table>
                    </div>
                </form>
                 ';
        } else{
            $rflag = "0";
            $output .= '
            <form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th style="display:none;" width="20%">'. trans('page-cars.cars.tables.id') .'</th>
                                <th width="20%">'. trans('page-cars.cars.tables.filetype') .'</th>
                                <th width="60%">'. trans('page-cars.cars.tables.filename') .'</th>
                                <th width="20%">'. trans('page-cars.cars.tables.attchactions') .'</th>
                            </tr>
                            </thead>

                            <tbody>
                                 '.$output1.'
                            </tbody>
                        </table>
                    </div>
                </form>
            ';
        }


        $data = array(
            'files_data'  => $output,
            'rflag'  => $rflag
        );

        echo json_encode($data);
//         return response()->json($accidentlist);
    }

    public function downloadFiles($id)
    {
        $row = DB::table('carcollection')
            ->where('id','=',$id)->first();

        $path = 'files/cars/'.$row->carid. '/' .$row->file_type. '/' .$row->file_name;

        return response()->download($path);
    }

    public function deleteFile(Request $request)
    {
        $row = DB::table('carcollection')
            ->where('id','=',$request->get('fid'))->first();

        $path = 'files/cars/'.$row->carid. '/' .$row->file_type. '/' .$row->file_name;

        if (File::exists($path)) {
            File::delete($path);
            DB::table('carcollection')
                ->where('id','=',$request->get('fid'))->delete();

            return response()->json(['data' => 'ok']);
        }

    }

}
