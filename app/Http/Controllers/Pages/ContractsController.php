<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
//use App\Http\Requests\StoreCdetRequest;
use App\Http\Requests\StoreAccidentDetailsRequest;
use App\Http\Requests\StoreContractDetailsRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Requests\UpdateContractDetailsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ContractsController extends Controller
{
   public function index($client_id)
   {
       abort_if(Gate::denies('contract_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

       if (Auth::user()->can('all_access')) {
           $contractlist = DB::table('clients_contracts')
               ->select('id' , 'client', 'cocode', 'codate','coname','cocars','coamount','cocurr')
               ->where('client', '=', $client_id)
               ->get();
       }else{
           $bIds = Auth::user()->branch_id;
           $contractlist = DB::table('contract')
               ->select('id', 'client', 'cocode', 'codate','coname','cocars','coamount','cocurr')
               ->where([
                   ['branch_id', '=', $bIds],
                   ['client', '=', $client_id],
               ])
               ->get();
       }

       $clientslist = DB::table('clients')
           ->select('cname')
           ->where('id', $client_id)
           ->get();

       $clientname = $clientslist[0]->cname;

       return view('pages.Contracts.index', compact('contractlist','clientname','client_id'));
     }

    public function showall()
    {
        abort_if(Gate::denies('contract_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts')
                ->select('id' , 'client', 'cocode', 'codate','coname','cocars','coamount','cocurr')
                ->orderBy('codate', 'desc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('contract')
                ->select('id', 'client', 'cocode', 'codate','coname','cocars','coamount','cocurr')
                ->where([
                    ['branch_id', '=', $bIds],
                ])
                ->orderBy('codate', 'desc')
                ->get();
        }

        return view('pages.Contracts.showall', compact('contractlist'));
    }

    public function getcontdetinfo(Request $request){
        $cdetlist = DB::table('condet')
            ->select('id','officedatein','officetimein','hcost','extratime','extracost','carback')
            ->where('id','=',$request->get('contdetid'))
            ->get();

        $rec1 = $cdetlist[0]->officedatein ;
        $rec2 = $cdetlist[0]->officetimein ;
        $rec3 = $cdetlist[0]->hcost ;
        $rec4 = $cdetlist[0]->extratime ;
        $rec5 = $cdetlist[0]->extracost ;
        $rec6 = $cdetlist[0]->carback ;
//        dd($cdetlist);

//            return response()->json($clist);
            return response()->json(['officedatein' => $rec1,'officetimein' => $rec2,'hcost' => $rec3,'extratime' => $rec4,'extracost' => $rec5,'carback' => $rec6]);

    }

    public function updatecontdetinfo(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'officedatein' => 'required|date',
                'officetimein' =>'required',
                'hcost' =>'required',
                'extratime' =>'required',
                'extracost' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('condet')
                ->where('id', $request->get('contdetid'))
                ->update([
                    'officedatein' => $request->get('officedatein'),
                    'officetimein' => $request->get('officetimein'),
                    'hcost' => $request->get('hcost'),
                    'extratime' => $request->get('extratime'),
                    'extracost' => $request->get('extracost'),
                    'carback' => $request->get('carback'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            if($request->get('carback') == "1"){
                DB::table('cars')
                    ->where('id', $request->get('carid'))
                    ->update([
                        'taken' => "0",
                    ]);
            }else if($request->get('carback') == "0") {
                DB::table('cars')
                    ->where('id', $request->get('carid'))
                    ->update([
                        'taken' => "1",
                    ]);
            }
            return response()->json($data);
        }
    }

    public function addcontdetinfo(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'person' => 'required',
                'linum' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'contid' => $request->get('contid'),
                'person' => $request->get('person'),
                'linum' => $request->get('linum'),
            ];

            $liid = DB::table('licontract')->insertGetId($values_to_insert);

            $clist = DB::table('licontract')
                ->select('id','person','linum')
                ->where('id','=',$liid)
                ->get();

            $rec1 = $clist[0]->id;
            $rec2 = $clist[0]->person;
            $rec3 = $clist[0]->linum;

//            return response()->json($clist);
            return response()->json(['id' => $rec1, 'person' => $rec2, 'linum' => $rec3]);
        }
    }


     public function getlinum(Request $request){
         $output = '';
         $rflag = '';
         $output1 = '';
         $clist = DB::table('licontract')
             ->select('id','person','linum')
             ->where('contid','=',$request->get('contid'))
             ->get();
         $total_row = $clist->count();
         if($total_row > 0) {
             $rflag = "1";
             foreach ($clist as $row) {
                 $output1 .=' <tr class="lirows'.$row->id.'">
                                    <td class="text-center" width="150px" style="display:none;" >'.$row->id.'</td>
                                    <td class="text-center" width="600px">'.$row->person.'</td>
                                    <td class="text-center" width="400px">'.$row->linum.'</td>
                                    <td class="text-center" width="250px">
                                        <button type="button" class="edit-modal-li btn btn-warning btn-sm" data-id="'.$row->id.'" data-person="'.$row->person.'" data-linum="'.$row->linum.'">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                         <button type="button" class="delete-modal-li btn btn-danger btn-sm" data-id="'.$row->id.'" >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>';
             }

                 $output .= '
                        <div id="noresult" >
                    <h4>'. trans('page-contract.contract.modals.noresult').'</h4>
                    </div>
                  <form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablemodal" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >'. trans('page-contract.contract.modals.linumid').'</th>
                                <th class="text-center" width="600px">'. trans('page-contract.contract.modals.personli').'</th>
                                <th class="text-center" width="400px">'. trans('page-contract.contract.modals.linumber').'</th>
                                <th class="text-center" width="250px">'. trans('page-contract.contract.modals.actions').'</th>
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
         else{
             $rflag = "0";
             $output .= '<div id="noresult">
                    <h4>'. trans('page-contract.contract.modals.noresult').'</h4>
                    </div>';
         }

         $data = array(
             'li_data'  => $output,
             'rflag'  => $rflag
         );

         echo json_encode($data);
//         return response()->json($clist);
     }

    public function adddriver(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'person' => 'required',
                'linum' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'contid' => $request->get('contid'),
                'person' => $request->get('person'),
                'linum' => $request->get('linum'),
            ];

            $liid = DB::table('licontract')->insertGetId($values_to_insert);

            $clist = DB::table('licontract')
                ->select('id','person','linum')
                ->where('id','=',$liid)
                ->get();

            $rec1 = $clist[0]->id;
            $rec2 = $clist[0]->person;
            $rec3 = $clist[0]->linum;

//            return response()->json($clist);
            return response()->json(['id' => $rec1, 'person' => $rec2, 'linum' => $rec3]);
        }
    }

    public function editdriver(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'person' => 'required',
                'linum' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            DB::table('licontract')
                ->where('id', $request->get('id'))
                ->update([
                    'person' => $request->get('person'),
                    'linum' => $request->get('linum'),
                ]);


            $lidriver = DB::table('licontract')
                ->select('id','person','linum')
                ->where('id', $request->get('id'))
                ->get();

            $liperon = $lidriver[0]->person;
            $linum = $lidriver[0]->linum;

            return response()->json(['id' => $request->get('id'), 'person' => $liperon, 'linum' => $linum]);
        }
    }

    public function deletedriver(Request $request){

        DB::table('licontract')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }

    public function getcontractslist()
    {
        abort_if(Gate::denies('contract_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $bIds = Auth::user()->branch_id;
        $contractlist = DB::table('clients_contracts')
            ->select('id','client','coname', 'cocode','codate')
            ->where('branch_id', $bIds)
            ->get();

        return view('pages.Contracts.contractlist',compact('contractlist'));
    }

    public function getcodate($id){

        $codate = DB::table('contract')
            ->select('codate')
            ->where('id','=',$id)
            ->get();

        $rec1 = $codate[0]->codate;

        return response()->json(['codate'=>$rec1]);
    }
    public function editcodate(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'codate' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            DB::table('contract')
                ->where('id', $request->get('id'))
                ->update([
                    'codate' => $request->get('codate'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

//            $codate = DB::table('contract')
//                ->select('id','cocode','codate')
//                ->where('id','=',$request->get('id'))
//                ->get();
//
//            $rec1 = $codate[0]->cocode;
//            $rec2 = $codate[0]->codate;

            $contractname = DB::table('clients_contracts')
                ->select('id','coname','codate','cocars','coamount','cocurr','cocode')
                ->where('id', $request->get('id'))
                ->get();

            $coname = $contractname[0]->coname;
            $codate = $contractname[0]->codate;
            $cocars = $contractname[0]->cocars;
            $coamount = $contractname[0]->coamount;
            $cocurr = $contractname[0]->cocurr;
            $cocode = $contractname[0]->cocode;

            return response()->json(['id' => $request->get('id'), 'coname' => $coname, 'codate' => $codate,'cocode'=>$cocode,'cocars'=>$cocars,'coamount'=>$coamount,'cocurr'=>$cocurr]);

//            return response()->json(['id' => $request->get('id'), 'cocode' => $rec1, 'codate' => $rec2]);
        }
    }
    public function deletecontract(Request $request){

        $getcount = DB::table('condet')
            ->where('cont','=',$request->get('id'))
            ->get();
        $count = $getcount->count();

        $getcount1 = DB::table('licontract')
            ->where('contid','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();

        if($count == 0 && $count1 == 0) {
            DB::table('contract')
                ->where('id', '=', $request->get('id'))
                ->delete();

            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }

    public function contractdet($contract_id)
    {
        abort_if(Gate::denies('contract_details_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contractdetlist = DB::table('contract_det')
            ->select('codetid','cartype', 'carname','carnumber','carcolor','cardays','carrate','carcurr','clientid','cname','cartotal','car_id')
            ->where('contid', $contract_id)
            ->get();

        $clientslist = DB::table('clients_contracts')
            ->select('coname','cocode','client')
            ->where('id', $contract_id)
            ->get();

        $clientname = $clientslist[0]->coname;
        $clientid = $clientslist[0]->client;
        $codename = $clientslist[0]->cocode;

        return view('pages.Contracts.contdetails',compact('contractdetlist','clientname','codename','clientid','contract_id'));
    }


    public function create($contractid)
    {
        abort_if(Gate::denies('contract_details_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
              $carslist = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->where('taken', '=', "0")
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $carslist = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->where([
                    ['branchid', '=', $bIds],
                    ['taken', '=', "0"],
                ])
                ->get();
        }

        $setcurr = DB::table('Settings')
            ->select('curr')
            ->get();

        $currlist = DB::table('currency')
            ->select('id', 'currname_ara')
            ->where('id','=',$setcurr[0]->curr)
            ->get();

        $contract_id = $contractid;

       return view('pages.Contracts.create',compact('carslist','currlist','contract_id'));
    }

    public function addcontract(Request $request){
        if ($request->isMethod("POST")) {

            $rules = array(
                'client' => 'required',
                'codate' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $contcount = DB::select('select * from contract');

            if ($contcount === null) {
                $conum = 1 ;
                $cocode = "CO-".$conum;
            }else{
                $comax = DB::table('contract')->max('conum');
                $conum = $comax + 1 ;
                $cocode = "CO-".$conum;
            }

            $bIds = Auth::user()->branch_id;

            $values_to_insert = [
                'client' => $request->get('client'),
                'conum' => $conum,
                'cocode' => $cocode,
                'codate' => $request->get('codate'),
                'branch_id' => $bIds,
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $id = DB::table('contract')->insertGetId($values_to_insert);

            $contractname = DB::table('clients_contracts')
                ->select('id','coname','codate','cocars','coamount','cocurr')
                ->where('id', $id)
                ->get();

            $coname = $contractname[0]->coname;
            $codate = $contractname[0]->codate;
            $cocars = $contractname[0]->cocars;
            $coamount = $contractname[0]->coamount;
            $cocurr = $contractname[0]->cocurr;

            return response()->json(['id' => $id, 'coname' => $coname, 'codate' => $codate,'cocode'=>$cocode,'cocars'=>$cocars,'coamount'=>$coamount,'cocurr'=>$cocurr]);
        }
    }

    public function store(StoreContractDetailsRequest $request)
    {
        if ($request->isMethod("POST")) {

            $contract_id =  $request->get('contid');
            $values_to_insert = [
                'cont' => $request->get('contid'),
                'car' => $request->get('carname'),
                'days' => $request->get('days'),
                'dateout' => $request->get('dateout'),
                'timeout' => $request->get('timeout'),
                'datein' => $request->get('datein'),
                'officedatein' => $request->get('datein'),
                'officetimein' => $request->get('timein'),
                'timein' => $request->get('timein'),
                'kmsout' => $request->get('kmsout'),
                'kmsin' => $request->get('kmsin'),
                'gas' => $request->get('gas'),
                'gascost' => $request->get('gascost'),
                'driver' => $request->get('driver') ? true : false,
                'drivercost' => $request->get('drivercost'),
                'dayrate'=> $request->get('dayrate'),
                'stotal'=> $request->get('stotal'),
                'curr'=> $request->get('curr'),
                'deposit'=> $request->get('deposit'),
                'depcurr'=> $request->get('depcurr'),
//                'carback' => $request->get('carback') ? true : false,
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            DB::table('condet')->insert($values_to_insert);

            $this->updatecontractinfo($request->get('contid'));
            $this->updateinsurance($request->get('contid'));

            $values_to_update_cars = [
                'taken' => "1",
            ];

            DB::table('cars')
                ->where('id', '=', $request->get('carname'))
                ->update($values_to_update_cars);

        }
        return redirect()->route('contract-details',  [$contract_id]);
    }

    public function edit($contractdetid)
    {
      abort_if(Gate::denies('contract_details_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $setcurr = DB::table('Settings')
            ->select('curr')
            ->get();

        $currlist = DB::table('currency')
            ->select('id', 'currname_ara')
            ->where('id','=',$setcurr[0]->curr)
            ->get();

        $contractdetails = DB::table('condet')
            ->select('id', 'cont', 'car', 'days', 'dateout', 'timeout', 'datein', 'timein', 'kmsout', 'kmsin', 'gas', 'gascost', 'driver', 'drivercost', 'dayrate', 'stotal', 'curr', 'deposit', 'depcurr')
            ->where('id',$contractdetid)
            ->get();

        $carids = $contractdetails[0]->car;

        if (Auth::user()->can('all_access')) {
            $carslist = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->where('carid', '=', $carids)
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $carslist = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->where([
                    ['branchid', '=', $bIds],
                    ['carid', '=', $carids],
                ])
                ->get();
        }



        return view('pages.contracts.edit',compact('contractdetails','carslist','currlist'));
    }

    public function getcarrate(Request $request){
        $carrate = DB::table('cars')
            ->select('carrate','curr')
            ->where('id','=',$request->get('idcar'))
            ->get();

        $rec1 = $carrate[0]->carrate;
        $rec2 = $carrate[0]->curr;

        return response()->json(['carrate' => $rec1,'curr' => $rec2]);
    }

    public function update(UpdateContractDetailsRequest $request, $contractdetid)
    {
        if ($request->isMethod("POST")) {

            $values_to_update = [
                'cont' => $request->get('contid'),
                'car' => $request->get('carname'),
                'days' => $request->get('days'),
                'dateout' => $request->get('dateout'),
                'timeout' => $request->get('timeout'),
                'datein' => $request->get('datein'),
                'officedatein' => $request->get('datein'),
                'officetimein' => $request->get('timein'),
                'timein' => $request->get('timein'),
                'kmsout' => $request->get('kmsout'),
                'kmsin' => $request->get('kmsin'),
                'gas' => $request->get('gas'),
                'gascost' => $request->get('gascost'),
                'driver' => $request->get('driver') ? true : false,
                'drivercost' => $request->get('drivercost'),
                'dayrate'=> $request->get('dayrate'),
                'stotal'=> $request->get('stotal'),
                'curr'=> $request->get('curr'),
                'deposit'=> $request->get('deposit'),
                'depcurr'=> $request->get('depcurr'),
//                'carback' => $request->get('carback') ? true : false,
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ];

        DB::table('condet')
            ->where('id', '=', $contractdetid)
            ->update($values_to_update);
        }

        $this->updatecontractinfo($request->get('contid'));
        $this->updateinsurance($request->get('contid'));

        return redirect()->route('contract-details',  [$request->get('contid')]);
    }

    public function deletedet(Request $request){
       $flag = '';
        $getcount = DB::table('contprocedures')
            ->where('contdet','=',$request->get('id'))
            ->get();
        $count = $getcount->count();

//        if( $count > 0) {
//            $flag = "1";
//        }else{
//            $flag = "0";
//        }

        if($count = 0) {
            $values_to_update_cars = [
                'taken' => "0",
            ];
            DB::table('cars')
                ->where('id', '=', $request->get('car-id'))
                ->update($values_to_update_cars);

            DB::table('condet')
                ->where('id', '=', $request->get('id'))
                ->delete();

            $this->updatecontractinfo($request->get('cont-id'));
            $this->updateinsurance($request->get('cont-id'));


            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }

    public function updatecontractinfo($contid){
       $allfields = DB::table('contract_index')->get();
        $count = $allfields->count();

       if( $count > 0) {
           $resultcalc = DB::table('contract_index')
               ->select('codetid', DB::raw('COUNT(DISTINCT codetid) AS cocars'), DB::raw('SUM(cartotal) AS coamount'), 'carcurr')
               ->where('contid', '=', $contid)
               ->get();
           $rec1 = $resultcalc[0]->cocars;
           $rec2 = $resultcalc[0]->coamount;
           $rec3 = $resultcalc[0]->carcurr;

           $values_to_update = [
               'cocars' => $rec1,
               'coamount' => $rec2,
               'cocurr' => $rec3,
           ];

           DB::table('contract')
               ->where('id', '=', $contid)
               ->update($values_to_update);
       }else{
           $values_to_update = [
               'cocars' => "0",
               'coamount' => "0.00",
               'cocurr' => "-",
           ];

           DB::table('contract')
               ->where('id', '=', $contid)
               ->update($values_to_update);
       }
    }

    public function createcontractprocedures($contractdet_id)
    {
        abort_if(Gate::denies('contract_details_procedures'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
            $data['carslist'] = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->where('taken', '=', "0")
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $data['carslist'] = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->where([
                    ['branchid', '=', $bIds],
                    ['taken', '=', "0"],
                ])
                ->get();
        }

        $data['setcurr'] = DB::table('Settings')
            ->select('curr')
            ->get();

        $data['currlist'] = DB::table('currency')
            ->select('id', 'currname_ara')
            ->where('id','=',$data['setcurr'][0]->curr)
            ->get();

        $data['locationlist'] = DB::table('location')
            ->select('id', 'Description')
            ->get();

        $data['carsname'] = DB::table('contract_det')
            ->select('carname','carnumber','carcolor','carmodel','codetid','contid')
            ->where('codetid', '=', $contractdet_id)
            ->get();

//        return view('pages.Contracts.createdetactions',compact('carslist','currlist','carsname','locationlist'));
        return view('pages.Contracts.createdetactions',$data);
    }

    public function addNewValueProcLocation(Request $request)
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
                $id = DB::table('location')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }

            if($tbid == "2") {
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('location')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }

            if($tbid == "3") {
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('location')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }
        }
    }

    public function deleteprocedure(Request $request){

        DB::table('contprocedures')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }

//    Create Accident Part
    public function getaccidentlist(Request $request){
        $output = '';
        $rflag = '';
        $output1 = '';
        $accidentlist = DB::table('procedures_list')
            ->select('id','proclocationname','procdate','procdetails','proccost','proccurrname','proclocationid','proccurrid')
            ->where([
                ['contdetid', '=', $request->get('contdetid')],
                ['proctypeid', '=', "1"],
            ])
            ->get();

        $total_row = $accidentlist->count();
        if($total_row > 0) {
            $rflag = "1";
            foreach ($accidentlist as $row) {
                $output1 .=' <tr class="accidentrows'.$row->id.'">
                            <td style="display:none;" >'.$row->id.'</td>
                            <td class="text-center" style="vertical-align: middle" width="150px">'.$row->proclocationname.'</td>
                            <td class="text-center" style="vertical-align: middle" width="150px">'.$row->procdate.'</td>
                            <td class="text-center" style="vertical-align: middle" width="120px">'.$row->proccost.'</td>
                            <td class="text-center" style="vertical-align: middle" width="50px">'.$row->proccurrname.'</td>
                            <td class="text-center" width="100px">
                                <button type="button" class="edit-btn btn btn-warning btn-sm" data-id="'.$row->id.'" data-locid1="'.$row->proclocationid.'" data-locname1="'.$row->proclocationname.'" data-accdate1="'.$row->procdate.'" data-accdetails1="'.$row->procdetails.'" data-acccost1="'.$row->proccost.'" data-acccurrid1="'.$row->proccurrid.'" data-acccurrname1="'.$row->proccurrname.'" title="'.trans('page-contract.contract.tabs.editaccident').'">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button type="button" class="delete-btn btn btn-danger btn-sm" data-id="'.$row->id.'" title="'.trans('page-contract.contract.tabs.deleteaccident').'">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            </tr>';
            }

            $output .= '
                        <div id="noresult" >
                    <h4>'. trans('page-contract.contract.tabs.accidentnoresult').'</h4>
                    </div>
                  <form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableaccident" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >'. trans('page-contract.contract.tabs.id') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tabs.accidentlocation') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tabs.accidentdate') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="120px">'. trans('page-contract.contract.tabs.accidentcost') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="50px">'. trans('page-contract.contract.tabs.accidentcurr') .'</th>
                                <th class="text-center" style="vertical-align: middle" width="100px">'. trans('page-contract.contract.tables.actions') .'</th>
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
        else{
            $rflag = "0";
            $output .= '<div id="noresult">
                    <h4>'. trans('page-contract.contract.tabs.accidentnoresult').'</h4>
                    </div>';
        }

        $data = array(
            'accident_data'  => $output,
            'rflag'  => $rflag
        );

        echo json_encode($data);
//         return response()->json($accidentlist);
    }

    public function storeaccident(Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'location1' => 'required',
                'actiondate1' => 'required|date',
                'actiondetails1' =>'required',
                'actioncost1' =>'required',
                'actioncurr1' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $contractdet_id =  $request->get('contdetid');
            $values_to_insert = [
                'contdet' => $request->get('contdetid'),
                'location' => $request->get('location1'),
                'actiondate' => $request->get('actiondate1'),
                'actiondetails' => $request->get('actiondetails1'),
                'actioncost' => $request->get('actioncost1'),
                'actioncurr' => $request->get('actioncurr1'),
                'actiontype' => '1',
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('contprocedures')->insert($values_to_insert);

//            $this->updatecontractinfo($request->get('contid'));

        }
//        return redirect()->route('contract-details',  [$contract_id]);
//        return response()->json(['id' => $rec1, 'person' => $rec2, 'linum' => $rec3]);
        return response()->json($data);
    }

    public function editaccident(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'location1' => 'required',
                'actiondate1' => 'required|date',
                'actiondetails1' =>'required',
                'actioncost1' =>'required',
                'actioncurr1' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('contprocedures')
                ->where('id', $request->get('id'))
                ->update([
                    'location' => $request->get('location1'),
                    'actiondate' => $request->get('actiondate1'),
                    'actiondetails' => $request->get('actiondetails1'),
                    'actioncost' => $request->get('actioncost1'),
                    'actioncurr' => $request->get('actioncurr1'),
                    'actiontype' => '1',
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            return response()->json($data);
        }
    }

    //    Create Speed Part
    public function getspeedlist(Request $request){
        $output = '';
        $rflagspeed = '';
        $output1 = '';
        $speedlist = DB::table('procedures_list')
            ->select('id','proclocationname','procdate','procdetails','proccost','proccurrname','proclocationid','proccurrid')
            ->where([
                ['contdetid', '=', $request->get('contdetid')],
                ['proctypeid', '=', "2"],
            ])
            ->get();

        $total_row = $speedlist->count();
        if($total_row > 0) {
            $rflagspeed = "1";
            foreach ($speedlist as $row) {
                $output1 .=' <tr class="speedrows'.$row->id.'">
                            <td style="display:none;" >'.$row->id.'</td>
                            <td class="text-center" style="vertical-align: middle" width="150px">'.$row->proclocationname.'</td>
                            <td class="text-center" style="vertical-align: middle" width="150px">'.$row->procdate.'</td>
                            <td class="text-center" style="vertical-align: middle" width="120px">'.$row->proccost.'</td>
                            <td class="text-center" style="vertical-align: middle" width="50px">'.$row->proccurrname.'</td>
                            <td class="text-center" width="100px">
                                <button type="button" class="edit-btn-speed btn btn-warning btn-sm" data-id="'.$row->id.'" data-locid2="'.$row->proclocationid.'" data-locname2="'.$row->proclocationname.'" data-accdate2="'.$row->procdate.'" data-accdetails2="'.$row->procdetails.'" data-acccost2="'.$row->proccost.'" data-acccurrid2="'.$row->proccurrid.'" data-acccurrname2="'.$row->proccurrname.'" title="'.trans('page-contract.contract.tabs.editspeed').'">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button type="button" class="delete-btn-speed btn btn-danger btn-sm" data-id="'.$row->id.'" title="'.trans('page-contract.contract.tabs.deletespeed').'">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            </tr>';
            }

            $output .= '
                        <div id="noresultspeed" >
                    <h4>'. trans('page-contract.contract.tabs.speednoresult').'</h4>
                    </div>
                  <form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablespeed" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >'. trans('page-contract.contract.tabs.id') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tabs.speedlocation') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tabs.speeddate') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="120px">'. trans('page-contract.contract.tabs.speedcost') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="50px">'. trans('page-contract.contract.tabs.speedcurr') .'</th>
                                <th class="text-center" style="vertical-align: middle" width="100px">'. trans('page-contract.contract.tables.actions') .'</th>
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
        else{
            $rflagspeed = "0";
            $output .= '<div id="noresultspeed">
                    <h4>'. trans('page-contract.contract.tabs.speednoresult').'</h4>
                    </div>';
        }

        $data = array(
            'speed_data'  => $output,
            'rflagspeed'  => $rflagspeed
        );

        echo json_encode($data);
//         return response()->json($accidentlist);
    }

    public function storespeed(Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'location2' => 'required',
                'actiondate2' => 'required|date',
                'actiondetails2' =>'required',
                'actioncost2' =>'required',
                'actioncurr2' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $contractdet_id =  $request->get('contdetid');
            $values_to_insert = [
                'contdet' => $request->get('contdetid'),
                'location' => $request->get('location2'),
                'actiondate' => $request->get('actiondate2'),
                'actiondetails' => $request->get('actiondetails2'),
                'actioncost' => $request->get('actioncost2'),
                'actioncurr' => $request->get('actioncurr2'),
                'actiontype' => '2',
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('contprocedures')->insert($values_to_insert);

//            $this->updatecontractinfo($request->get('contid'));

        }
//        return redirect()->route('contract-details',  [$contract_id]);
//        return response()->json(['id' => $rec1, 'person' => $rec2, 'linum' => $rec3]);
        return response()->json($data);
    }

    public function editspeed(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'location2' => 'required',
                'actiondate2' => 'required|date',
                'actiondetails2' =>'required',
                'actioncost2' =>'required',
                'actioncurr2' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('contprocedures')
                ->where('id', $request->get('id'))
                ->update([
                    'location' => $request->get('location2'),
                    'actiondate' => $request->get('actiondate2'),
                    'actiondetails' => $request->get('actiondetails2'),
                    'actioncost' => $request->get('actioncost2'),
                    'actioncurr' => $request->get('actioncurr2'),
                    'actiontype' => '2',
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            return response()->json($data);
        }
    }

    //    Create Failure Part
    public function getfailurelist(Request $request){
        $output = '';
        $rflagfailure = '';
        $output1 = '';
        $failurelist = DB::table('procedures_list')
            ->select('id','proclocationname','procdate','procdetails','proccost','proccurrname','proclocationid','proccurrid')
            ->where([
                ['contdetid', '=', $request->get('contdetid')],
                ['proctypeid', '=', "3"],
            ])
            ->get();

        $total_row = $failurelist->count();
        if($total_row > 0) {
            $rflagfailure = "1";
            foreach ($failurelist as $row) {
                $output1 .=' <tr class="failurerows'.$row->id.'">
                            <td style="display:none;" >'.$row->id.'</td>
                            <td class="text-center" style="vertical-align: middle" width="150px">'.$row->proclocationname.'</td>
                            <td class="text-center" style="vertical-align: middle" width="150px">'.$row->procdate.'</td>
                            <td class="text-center" style="vertical-align: middle" width="120px">'.$row->proccost.'</td>
                            <td class="text-center" style="vertical-align: middle" width="50px">'.$row->proccurrname.'</td>
                            <td class="text-center" width="100px">
                                <button type="button" class="edit-btn-failure btn btn-warning btn-sm" data-id="'.$row->id.'" data-locid3="'.$row->proclocationid.'" data-locname3="'.$row->proclocationname.'" data-accdate3="'.$row->procdate.'" data-accdetails3="'.$row->procdetails.'" data-acccost3="'.$row->proccost.'" data-acccurrid3="'.$row->proccurrid.'" data-acccurrname3="'.$row->proccurrname.'" title="'.trans('page-contract.contract.tabs.editfailure').'">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button type="button" class="delete-btn-failure btn btn-danger btn-sm" data-id="'.$row->id.'" title="'.trans('page-contract.contract.tabs.deletefailure').'">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            </tr>';
            }

            $output .= '
                        <div id="noresultfailure" >
                    <h4>'. trans('page-contract.contract.tabs.failurenoresult').'</h4>
                    </div>
                  <form>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablefailure" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="150px" style="display:none;" >'. trans('page-contract.contract.tabs.id') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tabs.failurelocation') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tabs.failuredate') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="120px">'. trans('page-contract.contract.tabs.failurecost') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="50px">'. trans('page-contract.contract.tabs.failurecurr') .'</th>
                                <th class="text-center" style="vertical-align: middle" width="100px">'. trans('page-contract.contract.tables.actions') .'</th>
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
        else{
            $rflagfailure = "0";
            $output .= '<div id="noresultfailure">
                    <h4>'. trans('page-contract.contract.tabs.failurenoresult').'</h4>
                    </div>';
        }

        $data = array(
            'failure_data'  => $output,
            'rflagfailure'  => $rflagfailure
        );

        echo json_encode($data);
//         return response()->json($accidentlist);
    }

    public function storefailure(Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'location3' => 'required',
                'actiondate3' => 'required|date',
                'actiondetails3' =>'required',
                'actioncost3' =>'required',
                'actioncurr3' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $contractdet_id =  $request->get('contdetid');
            $values_to_insert = [
                'contdet' => $request->get('contdetid'),
                'location' => $request->get('location3'),
                'actiondate' => $request->get('actiondate3'),
                'actiondetails' => $request->get('actiondetails3'),
                'actioncost' => $request->get('actioncost3'),
                'actioncurr' => $request->get('actioncurr3'),
                'actiontype' => '3',
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('contprocedures')->insert($values_to_insert);

//            $this->updatecontractinfo($request->get('contid'));

        }
//        return redirect()->route('contract-details',  [$contract_id]);
//        return response()->json(['id' => $rec1, 'person' => $rec2, 'linum' => $rec3]);
        return response()->json($data);
    }

    public function editfailure(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'location3' => 'required',
                'actiondate3' => 'required|date',
                'actiondetails3' =>'required',
                'actioncost3' =>'required',
                'actioncurr3' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('contprocedures')
                ->where('id', $request->get('id'))
                ->update([
                    'location' => $request->get('location3'),
                    'actiondate' => $request->get('actiondate3'),
                    'actiondetails' => $request->get('actiondetails3'),
                    'actioncost' => $request->get('actioncost3'),
                    'actioncurr' => $request->get('actioncurr3'),
                    'actiontype' => '3',
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            return response()->json($data);
        }
    }

    public function updateinsurance($contid){
        $allfields = DB::table('deposit_contract_det')->get();
        $count = $allfields->count();

        if( $count > 0) {
            $resultcalc = DB::table('deposit_contract_det')
                ->select('codetid', DB::raw('SUM(deposit) AS cdeposit'), 'dcurr')
                ->where('contid', '=', $contid)
                ->get();
            $rec1 = $resultcalc[0]->cdeposit;
            $rec2 = $resultcalc[0]->dcurr;

            $values_to_update = [
                'deposit' => $rec1,
                'dcurr' => $rec2,
            ];

            DB::table('contract')
                ->where('id', '=', $contid)
                ->update($values_to_update);
        }else{
            $values_to_update = [
                'deposit' => "0.00",
                'dcurr' => "-",
            ];
            DB::table('contract')
                ->where('id', '=', $contid)
                ->update($values_to_update);
        }
    }

    //    Payment Section
    public function indexpayments($client_id)
    {
        abort_if(Gate::denies('contract_payment'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts')
                ->select('id' , 'client', 'cocode', 'codate','coname','cocars','coamount','cocurr','deposit','dcurr')
                ->where('client', '=', $client_id)
                ->orderBy('codate', 'desc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('contract')
                ->select('id', 'client', 'cocode', 'codate','coname','cocars','coamount','cocurr','deposit','dcurr')
                ->where([
                    ['branch_id', '=', $bIds],
                    ['client', '=', $client_id],
                ])
                ->orderBy('codate', 'desc')
                ->get();
        }

        $setcurr = DB::table('Settings')
            ->select('curr')
            ->get();

        $currlist = DB::table('currency')
            ->select('id', 'currname_ara')
            ->where('id','=',$setcurr[0]->curr)
            ->get();

        $paymentforlist = DB::table('payment')
            ->select('id', 'Description')
            ->get();

        $paymenttype = DB::table('paymenttype')
            ->select('id', 'Description')
            ->get();

        $paymentstatus = DB::table('paymentstatus')
            ->select('id', 'Description')
            ->get();


        $clientslist = DB::table('clients')
            ->select('cname')
            ->where('id', $client_id)
            ->get();

        $clientname = $clientslist[0]->cname;

        return view('pages.Contracts.payments', compact('contractlist','clientname','client_id','currlist','paymentforlist','paymenttype','paymentstatus'));
    }


    public function getpaymentslist(Request $request){
        $output = '';
        $rflagpayment = '';
        $output1 = '';
        $paymentlist = DB::table('getclient_payments')
            ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paystatusid','paystatus','paychecknum')
            ->where('payclientid', '=', $request->get('clientid'))
            ->orderBy('paydate', 'desc')
            ->get();

        $total_row = $paymentlist->count();
        if($total_row > 0) {
            $rflagpayment = "1";
            foreach ($paymentlist as $row) {
                $output1 .=' <tr class="paymentsrows'.$row->payid.'">
                            <td style="display:none;" >'.$row->payid.'</td>
                            <td class="text-center" style="vertical-align: middle" width="250px">'.$row->paydate.'</td>
                            <td class="text-center" style="vertical-align: middle" width="120px">'.$row->payamount.' ' .$row->paycurr.'</td>
                            <td class="text-center" style="vertical-align: middle" width="150px">'.$row->payamountfor.'</td>
                            <td class="text-center" style="vertical-align: middle" width="100px">'.$row->paytype.'</td>
                            <td class="text-center" style="display:none;">'.$row->payamount.'</td>
                            <td class="text-center" width="150px">
                                <button type="button" class="edit-btn btn btn-warning btn-sm" data-id="'.$row->payid.'" data-paytypeid="'.$row->paytypeid.'" data-paytype="'.$row->paytype.'" data-paychecknum="'.$row->paychecknum.'" data-payamountforid="'.$row->payamountforid.'" data-payamountfor="'.$row->payamountfor.'" data-paycurrid="'.$row->paycurrid.'" data-paycurr="'.$row->paycurr.'" data-paystatusid="'.$row->paystatusid.'" data-paystatus="'.$row->paystatus.'" data-paydate="'.$row->paydate.'" data-payamount="'.$row->payamount.'" title="'.trans('page-contract.contract.tabs.editpayment').'">
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button type="button" class="delete-btn btn btn-danger btn-sm" data-id="'.$row->payid.'" title="'.trans('page-contract.contract.tabs.deletepayment').'">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            </tr>';
            }

            $output .= '
                        <div id="noresultpayment" >
                    <h4>'. trans('page-contract.contract.tabs.paymentnoresult').'</h4>
                    </div>
                  <form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sizeTEXT" id="tablepayments" width="100%" cellspacing="0">
                            <thead>
                             <tr>
                                <th width="150px" style="display:none;" >'. trans('page-contract.contract.tables.payid') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="250px" >'. trans('page-contract.contract.tables.paydate') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="120px">'. trans('page-contract.contract.tables.payamount') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tables.payamountfor') .'</th>
                                <th class="text-center " style="vertical-align: middle" width="100px">'. trans('page-contract.contract.tables.paytype') .'</th>
                                <th class="text-center " style="display:none;">'. trans('page-contract.contract.tables.paytype') .'</th>
                                <th  class="text-center " style="vertical-align: middle" width="150px">'. trans('page-contract.contract.tables.actions') .'</th>
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
        else{
            $rflagpayment = "0";
            $output .= '<div id="noresultpayment">
                    <h4>'. trans('page-contract.contract.tabs.paymentnoresult').'</h4>
                    </div>';
        }

        $data = array(
            'payment_data'  => $output,
            'rflagpayment'  => $rflagpayment
        );

        echo json_encode($data);
//         return response()->json($accidentlist);
    }

    public function storepayment(Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'paymentdate' => 'required|date',
                'paymenttype' => 'required',
                'amount' =>'required',
                'curr' =>'required',
                'amountfor' =>'required',
                'paymentstatus' =>'required',
                'checknum' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'client' => $request->get('client'),
                'paymentdate' => $request->get('paymentdate'),
                'paymenttype' => $request->get('paymenttype'),
                'amount' => $request->get('amount'),
                'curr' => $request->get('curr'),
                'amountfor' => $request->get('amountfor'),
                'paymentstatus' => $request->get('paymentstatus'),
                'checknum' => $request->get('checknum'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('clientpayments')->insert($values_to_insert);
        }
        return response()->json($data);
    }

    public function editpayment(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'paymentdate' => 'required|date',
                'paymenttype' => 'required',
                'amount' =>'required',
                'curr' =>'required',
                'amountfor' =>'required',
                'paymentstatus' =>'required',
                'checknum' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('clientpayments')
                ->where('id', $request->get('id'))
                ->update([
                    'paymentdate' => $request->get('paymentdate'),
                    'paymenttype' => $request->get('paymenttype'),
                    'amount' => $request->get('amount'),
                    'curr' => $request->get('curr'),
                    'amountfor' => $request->get('amountfor'),
                    'paymentstatus' => $request->get('paymentstatus'),
                    'checknum' => $request->get('checknum'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            return response()->json($data);
        }
    }

    public function deletepayment(Request $request){

        DB::table('clientpayments')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }
}
