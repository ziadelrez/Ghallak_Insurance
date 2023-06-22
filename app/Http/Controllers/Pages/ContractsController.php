<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
//use App\Http\Requests\StoreCdetRequest;
use App\Http\Requests\StoreAccidentDetailsRequest;
use App\Http\Requests\StoreContractDetailsRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Requests\UpdateContractDetailsRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;
use Alkoumi\LaravelArabicTafqeet\Tafqeet;
use Alkoumi\LaravelArabicNumbers\Numbers;


class ContractsController extends Controller
{
   public function index($client_id)
   {
       abort_if(Gate::denies('contract_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

       $contracts = DB::table('clients_contracts')
           ->select('id' , 'client', 'cocode','coname', 'codate','coinscount','coinsname','coamount','cocurr','coamountlbp','cocurrlbp','codestr')
           ->where('client', '=', $client_id)
           ->get();

       foreach ($contracts as $row) {
           $this->updatecontractinfo($row->id);
       }

       if (Auth::user()->can('all_access')) {
           $contractlist = DB::table('clients_contracts')
               ->select('id' , 'client', 'cocode','coname', 'codate','coinscount','coinsname','coamount','cocurr','coamountlbp','cocurrlbp','codestr')
               ->where('client', '=', $client_id)
               ->get();
       }else{
           $bIds = Auth::user()->branch_id;
           $contractlist = DB::table('clients_contracts')
               ->select('id', 'client', 'cocode','coname', 'codate','coinscount','coinsname','coamount','cocurr','coamountlbp','cocurrlbp','codestr')
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
                ->select('id' , 'client', 'cocode', 'codate','coname','coinscount','coinsname')
                ->orderBy('codate', 'desc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('contract')
                ->select('id', 'client', 'cocode', 'codate','coname','coinscount','coinsname')
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
            ->select('id','officedatein','officetimein','hcost','extratime','extracost','carback','stotal','days','dayrate','drivercost','gascost')
            ->where('id','=',$request->get('contdetid'))
            ->get();

        $rec1 = $cdetlist[0]->officedatein ;
        $rec2 = $cdetlist[0]->officetimein ;
        $rec3 = $cdetlist[0]->hcost ;
        $rec4 = $cdetlist[0]->extratime ;
        $rec5 = $cdetlist[0]->extracost ;
        $rec6 = $cdetlist[0]->carback ;
        $rec7 = $cdetlist[0]->stotal ;
        $rec8 = $cdetlist[0]->days ;
        $rec9 = $cdetlist[0]->dayrate ;
        $rec10 = $cdetlist[0]->drivercost ;
        $rec11 = $cdetlist[0]->gascost ;
//        dd($cdetlist);

//            return response()->json($clist);
            return response()->json(['officedatein' => $rec1,'officetimein' => $rec2,'hcost' => $rec3,'extratime' => $rec4,'extracost' => $rec5,'carback' => $rec6,'stotal' => $rec7,'days' => $rec8,'dayrate' => $rec9,'drivercost' => $rec10,'gascost' => $rec11]);

    }

    public function updatecontdetinfo(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'officedatein' => 'required|date',
                'officetimein' =>'required',
                'hcost' =>'required',
                'extratime' =>'required',
                'extracost' =>'required',
                'stotal' =>'required',
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
                    'stotal' => $request->get('stotal'),
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
            $this->updatecontractinfo($request->get('coid'));
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

    public function getcontractslist()
    {
        abort_if(Gate::denies('contract_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $bIds = Auth::user()->branch_id;
        $contractlist = DB::table('clients_contracts')
            ->select('id','client','coname', 'cocode','codate','coinscount','coinsname','coamount','cocurr','codestr')
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

            $billnum = DB::table('settings')
                ->select('billnum')
                ->get();

            $currentyear = now()->year;

            $cyear = substr($currentyear,2);

            $codestr = "INV-".$cyear."-".$billnum[0]->billnum;

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
                'codenum' => $billnum[0]->billnum,
                'codestr' => $codestr,
                'codate' => $request->get('codate'),
                'branch_id' => $bIds,
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $id = DB::table('contract')->insertGetId($values_to_insert);

            $values_to_update_billnum = [
                'billnum' => $billnum[0]->billnum + 1 ,
            ];

            DB::table('settings')
                ->update($values_to_update_billnum);

            $contractname = DB::table('clients_contracts')
                ->select('id','coname','codate','coinscount','coinsname','coamount','cocurr','coamountlbp','cocurrlbp','codestr')
                ->where('id', $id)
                ->get();

            $coname = $contractname[0]->coname;
            $codate = $contractname[0]->codate;
            $coinscount = $contractname[0]->coinscount;
            $coinsname = $contractname[0]->coinsname;
            $coamount = $contractname[0]->coamount;
            $coamountlbp = $contractname[0]->coamountlbp;
            $cocurr = $contractname[0]->cocurr;
            $cocurrlbp = $contractname[0]->cocurrlbp;
            $codestr = $contractname[0]->codestr;

            return response()->json(['id' => $id, 'coname' => $coname, 'codate' => $codate,'cocode'=>$cocode,'coinscount'=>$coinscount,'coinsname'=>$coinsname,'coamount'=>$coamount,'cocurr'=>$cocurr,'coamountlbp'=>$coamountlbp,'cocurrlbp'=>$cocurrlbp,'codestr'=>$codestr]);
        }
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
                ->select('id','coname','codate','coinscount','coinsname','cocode','coamount','cocurr','coamountlbp','cocurrlbp','codestr')
                ->where('id', $request->get('id'))
                ->get();

            $coname = $contractname[0]->coname;
            $codate = $contractname[0]->codate;
            $coinscount = $contractname[0]->coinscount;
            $coinsname = $contractname[0]->coinsname;
            $cocode = $contractname[0]->cocode;
            $coamount = $contractname[0]->coamount;
            $coamountlbp = $contractname[0]->coamountlbp;
            $cocurr = $contractname[0]->cocurr;
            $cocurrlbp = $contractname[0]->cocurrlbp;
            $codestr = $contractname[0]->codestr;

            return response()->json(['id' => $request->get('id'), 'coname' => $coname, 'codate' => $codate,'cocode'=>$cocode,'coinscount'=>$coinscount,'coinsname'=>$coinsname,'coamount'=>$coamount,'cocurr'=>$cocurr,'coamountlbp'=>$coamountlbp,'cocurrlbp'=>$cocurrlbp,'codestr'=>$codestr]);

//            return response()->json(['id' => $request->get('id'), 'cocode' => $rec1, 'codate' => $rec2]);
        }
    }

    public function deletecontract(Request $request){

        $getcount = DB::table('condet')
            ->where('cont','=',$request->get('id'))
            ->get();
        $count = $getcount->count();


        if($count == 0) {
            DB::table('contract')
                ->where('id', '=', $request->get('id'))
                ->delete();

            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
//        return $request->get('id');
    }

    public function printbills($cont_id)
    {
        abort_if(Gate::denies('clients_print_bill'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
            $data['contractlist'] = DB::table('print_bill_clients_contracts_det')
                ->select('id' , 'insname', 'totalcost', 'currname','client','carname','platnumber','ccode')
                ->where('contid', '=', $cont_id)
                ->orderBy('codate', 'desc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $data['contractlist']= DB::table('print_bill_clients_contracts_det')
                ->select('id' , 'insname', 'totalcost', 'currname','client','carname','platnumber','ccode')
                ->where([
                    ['branch_id', '=', $bIds],
                    ['contid', '=', $cont_id],
                ])
                ->orderBy('codate', 'desc')
                ->get();
        }

        $count =  $data['contractlist']->count();

        if($count == 0) {

        }else {

            $client_id = $data['contractlist'][0]->client;
            $data['clientslist'] = DB::table('clients')
                ->select('cname', 'cadr', 'cmob', 'email')
                ->where('id', $client_id)
                ->get();

            $data['contratinfo'] = DB::table('contract')
                ->select('cocode', 'coamount', 'cocurr', 'codestr','coamountlbp','cocurrlbp')
                ->where('id', $cont_id)
                ->get();
//        $data['contratinfo'][0]->codestr
            $currdate = Carbon::now()->toFormattedDateString();
            $InvCode = $data['contratinfo'][0]->codestr;

//        $tafqeetInArabic = Tafqeet::inArabic($data['contratinfo'][0]->coamount,'usd');
            $tafqeetInArabic = Numbers::TafqeetMoney($data['contratinfo'][0]->coamount, $data['contratinfo'][0]->cocurr);
            $tafqeetInArabicLB = Numbers::TafqeetMoney($data['contratinfo'][0]->coamountlbp, $data['contratinfo'][0]->cocurrlbp);

            return view('pages.Clients.Printout.clientsbill', $data)->with(compact('currdate', 'InvCode', 'tafqeetInArabic','tafqeetInArabicLB'));
        }
    }

    public function indexcontractsummary()
    {
//        abort_if(Gate::denies('contract_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userIds = Auth::user()->id;
//        && Gate::denies('accident_access')
        $data['user_role'] = DB::table('role_user')
            ->select('role_id')
            ->where('user_id','=',$userIds)
            ->get();

         return view('pages.Contracts.contsummary',$data);

    }

    public function contractsummary(Request $request)
    {
//        abort_if(Gate::denies('contract_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sqlstr = $request->get('sqlstr');
        $sqlstrstatus = $request->get('sqlstrstatus');
        $sqlstop = $request->get('sqlstop');

        if (Auth::user()->can('all_access')) {
            if ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('status', '=', $sqlstrstatus)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('stopcont', '=', $sqlstop)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('stopcont', '=', $sqlstop)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','maidid','maidname','passport','stopcont')
                    ->get();
            }
        }else {
            $bIds = Auth::user()->branch_id;
            if ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('branchid','=',$bIds)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid','=',$bIds)
                    ->get();
            }elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid','=',$bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber','branchid','maidid','maidname','passport','stopcont')
                    ->where('branchid','=',$bIds)
                    ->get();
            }
        }

        $datatables = Datatables::of($contractdetlist)
            ->editColumn('id', function ($inscontlist) {
                return $inscontlist->id;
            })
            ->editColumn('billid', function ($inscontlist) {
                return $inscontlist->billclosed;
            })
            ->editColumn('statusid', function ($inscontlist) {
                return $inscontlist->status;
            })
            ->editColumn('billstatus', function ($inscontlist) {
                $statusbuttons = "";
                if ($inscontlist->billclosed) {
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-bill btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                }
                else{
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-bill btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                }
                return $statusbuttons;
            })
            ->editColumn('instatus', function ($inscontlist) {
                $statusbuttons = "";
                if ($inscontlist->status) {
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notonprocess') .'</a>';
                }
                else{

                    $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.onprocess') .'</a>';
                }
                return $statusbuttons;
            })
            ->editColumn('insaction', function ($inscontlist) {
                $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/contract-details/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.displaycontract') .'"><i class="fa fa-eye"></i></a> ';
                return $buttons;
            })
            ->editColumn('ccode', function ($inscontlist) {
                return $inscontlist->ccode;
            })
            ->editColumn('cname', function ($inscontlist) {
                return $inscontlist->coname;
            })
            ->editColumn('compname', function ($inscontlist) {
                return $inscontlist->compname;
            })
            ->editColumn('carname', function ($inscontlist) {
                return $inscontlist->carname . ' - ' . $inscontlist->carnumber;
            })
            ->editColumn('maidname', function ($inscontlist) {
                return $inscontlist->maidname . ' - ' . $inscontlist->passport;
            })
            ->editColumn('insname', function ($inscontlist) {
                return $inscontlist->insname;
            })
            ->editColumn('sdate', function ($inscontlist) {
                return $inscontlist->sdate;
            })
            ->editColumn('edate', function ($inscontlist) {
                return $inscontlist->edate;
            })
            ->editColumn('days', function ($inscontlist) {
                return $inscontlist->days;
            })
            ->editColumn('totalcost', function ($inscontlist) {
                return number_format($inscontlist->totalcost);
            })
            ->editColumn('currname', function ($inscontlist) {
                return $inscontlist->currname;
            })
            ->rawColumns(['billstatus','instatus','insaction']);

        return $datatables->make(true);
    }

    public function getsummary_usd(Request $request){

        $sqlstr = $request->get('sqlstr');
        $sqlstrstatus = $request->get('sqlstrstatus');
        $sqlstop = $request->get('sqlstop');

        if (Auth::user()->can('all_access')) {
            if ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            }
        }else {
            $bIds = Auth::user()->branch_id;
            if ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "3")
                    ->groupBy('currname','currid')
                    ->get();
            }
        }


        if(isset($contractdetlist[0]->coamount)) {
            $rec2 = number_format($contractdetlist[0]->coamount);
            $rec3 = $contractdetlist[0]->currname;
        }else{
            $rec2 = "0";
            $rec3 = "USD";
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }

    public function getsummary_lbp(Request $request){

        $sqlstr = $request->get('sqlstr');
        $sqlstrstatus = $request->get('sqlstrstatus');
        $sqlstop = $request->get('sqlstop');

        if (Auth::user()->can('all_access')) {
            if ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            }
        }else {
            $bIds = Auth::user()->branch_id;
            if ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus == '' && $sqlstop != '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('stopcont', '=', $sqlstop)
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '' && $sqlstop == '') {
                $contractdetlist = DB::table('clients_contracts_summary')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->where('branchid','=',$bIds)
                    ->where('currid', '=', "2")
                    ->groupBy('currname','currid')
                    ->get();
            }
        }



        if(isset($contractdetlist[0]->coamount)) {
            $rec2 = number_format($contractdetlist[0]->coamount);
            $rec3 = $contractdetlist[0]->currname;
        }else{
            $rec2 = "0";
            $rec3 = "LBP";
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }

    public function contractdet($contract_id)
    {
        abort_if(Gate::denies('contract_details_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contractdetlist = DB::table('contract_det')
            ->select('codetid','compname', 'insname','sdate','edate','days','totalcost','currname','status','carname','carnumber','maidid','maidname','passport')
            ->where('contid', $contract_id)
            ->get();

        $clientslist = DB::table('clients_contracts')
            ->select('coname','cocode','client')
            ->where('id', $contract_id)
            ->get();

        $clientname = $clientslist[0]->coname;
        $clientid = $clientslist[0]->client;
        $codename = $clientslist[0]->cocode;

        $this->setcontractinfo($contract_id);

        return view('pages.Contracts.contdetails',compact('contractdetlist','clientname','codename','clientid','contract_id'));
    }

    public function addNewValueDEFCONT(Request $request)
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

            if($tbid == "8") {
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('country')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }elseif($tbid == "12"){
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('followperson')->insertGetId($values_to_insert);
                return response()->json(['id'=> $id , 'success' => 'Record is successfully added']);
            }
        }
    }

    public function create($contractid)
    {
        abort_if(Gate::denies('contract_details_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract_id = $contractid;

        $data['contractinfo'] = DB::table('clients_contracts')
            ->select('id', 'coname','cocode','client')
            ->where('id','=',$contract_id)
            ->get();


        $data['followlist'] = DB::table('followperson')
            ->select('id', 'Description')
            ->get();


        $data['countrylist'] = DB::table('country')
            ->select('id', 'Description')
            ->get();

        $data['companieslist'] = DB::table('companies')
            ->select('id', 'compname')
            ->get();

//        $data['inslist'] = DB::table('insnames')
//            ->select('id', 'insname')
//            ->get();

        $data['clientslist'] = DB::table('clients')
            ->select('id', 'cname')
            ->where([
                    ['display','=','1'],
                    ['nclient','=','1'],
                  ])
            ->get();

        if (Auth::user()->can('all_access')) {
            $data['officelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere('office', '=', '1')
                ->get();

            $data['brokerlist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere('broker', '=', '1')
                ->get();
        }else {
            $bIds = Auth::user()->branch_id;
            $data['officelist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere(function ($query) {
                    $bIds = Auth::user()->branch_id;
                    $query->where('office', '=', '1')
                          ->where('branch', '=', $bIds);
                })
                ->get();

            $data['brokerlist'] = DB::table('clients')
                ->select('id', 'cname')
                ->where('display', '=', '0')
                ->orWhere(function ($query) {
                    $bIds = Auth::user()->branch_id;
                    $query->where('broker', '=', '1')
                        ->where('branch', '=', $bIds);
                })
                ->get();
        }

        $data['carslist'] = DB::table('cars')
            ->select('id', 'carname','platnumber')
            ->where('client','=',$data['contractinfo'][0]->client)
            ->orWhere('display','=','0')
            ->get();

        $data['maidslist'] = DB::table('maids')
            ->select('id', 'maidname','passport')
            ->where('client','=',$data['contractinfo'][0]->client)
            ->orWhere('display','=','0')
            ->get();

//        $data['currlist'] = DB::table('currency')
//            ->select('id', 'currname_eng')
//            ->get();

            $flag = "0";

       return view('pages.Contracts.create',$data)->with(compact('contract_id','flag'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod("POST")) {

            $contract_id =  $request->get('contid');
            $values_to_insert = [
                'cont' => $request->get('contid'),
                'ccode' => $request->get('ccode'),
                'sdate' => $request->get('sdate'),
                'edate' => $request->get('edate'),
                'days' => $request->get('days'),
                'companyid' => $request->get('compname'),
                'insid' => $request->get('insname'),
                'carid' => $request->get('carname'),
                'maidid' => $request->get('maidname'),
                'officeid' => $request->get('office'),
                'officeper' => $request->get('officeper'),
                'officeshare' => $request->get('officeshare'),
                'brokerid' => $request->get('broker'),
                'brokerper' => $request->get('brokerper'),
                'brokershare'=> $request->get('brokershare'),
                'totalcost'=> $request->get('totalcost'),
                'netcost'=> $request->get('netcost'),
                'iqar'=> $request->get('iqar'),
                'iqarplace'=> $request->get('iqarplace'),
                'employeenum'=> $request->get('employeenum'),
                'country'=> $request->get('country'),
                'followby'=> $request->get('followby'),
                'stopcont'=> $request->get('stopcont') ? true : false,
                'curr'=> $request->get('curr'),
                'status'=> '0',
//                'carback' => $request->get('carback') ? true : false,
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            DB::table('condet')->insert($values_to_insert);

            $this->updatecontractinfo($request->get('contid'));
//            $this->updateinsurance($request->get('contid'));

        }
        return redirect()->route('contract-details',  [$contract_id]);
    }

    public function edit($contractdetid)
    {
      abort_if(Gate::denies('contract_details_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['contractidinfo'] = DB::table('condet')
            ->select('cont')
            ->where('id','=',$contractdetid)
            ->get();

      $data['contractinfo'] = DB::table('clients_contracts')
            ->select('id', 'coname','cocode','client')
            ->where('id','=',$data['contractidinfo'][0]->cont)
            ->get();

        $data['followlist'] = DB::table('followperson')
            ->select('id', 'Description')
            ->get();


        $data['companieslist'] = DB::table('companies')
            ->select('id', 'compname')
            ->get();

        $data['countrylist'] = DB::table('country')
            ->select('id', 'Description')
            ->get();

//        $data['inslist'] = DB::table('insnames')
//            ->select('id', 'insname')
//            ->get();

        $data['clientslist'] = DB::table('clients')
            ->select('id', 'cname')
            ->where([
                ['display','=','1'],
                ['nclient','=','1'],
            ])
            ->get();

        $data['officelist'] = DB::table('clients')
            ->select('id', 'cname')
            ->where('display','=','0')
            ->orWhere('office','=','1')
            ->get();

        $data['brokerlist'] = DB::table('clients')
            ->select('id', 'cname')
            ->where('display','=','0')
            ->orWhere('broker','=','1')
            ->get();

        $data['carslist'] = DB::table('cars')
            ->select('id', 'carname','platnumber')
            ->where('client','=',$data['contractinfo'][0]->client)
            ->orWhere('display','=','0')
            ->get();

        $data['maidslist'] = DB::table('maids')
            ->select('id', 'maidname','passport')
            ->where('client','=',$data['contractinfo'][0]->client)
            ->orWhere('display','=','0')
            ->get();


        $data['contractdetails'] = DB::table('condet')
            ->select('id', 'cont', 'ccode', 'days', 'sdate', 'edate', 'companyid', 'insid', 'officeid', 'officeper', 'officeshare', 'brokerid', 'brokerper', 'brokershare', 'totalcost', 'netcost', 'curr', 'carid','maidid','iqar','iqarplace','employeenum','country','followby','stopcont')
            ->where('id',$contractdetid)
            ->get();
        $flag = "1";
       return view('pages.Contracts.edit',$data)->with(compact('flag'));
    }

    public function getinsrate(Request $request){
        $data['insname'] = DB::table('get_company_ins')
            ->select('cost','curr','currname')
            ->where([
                ['company_id','=',$request->get('idcomp')],
                ['ins_id','=',$request->get('idins')],
            ])
            ->get();

        return response()->json($data);
    }

    public function getinsname($id){
        $insname = DB::table('contdet_ins')
            ->select('insid','insname','curr','currname')
            ->where('codetid','=',$id)
            ->get();

        $rec1 = $insname[0]->insid;
        $rec2 = $insname[0]->insname;
        $rec3 = $insname[0]->curr;
        $rec4 = $insname[0]->currname;

        return response()->json(['insid'=>$rec1,'insname'=>$rec2,'curr'=>$rec3,'currname'=>$rec4]);
    }

    public function getinsurance(Request $request){

        $data['insname'] = DB::table('get_company_ins')
            ->select('ins_id','insname')
            ->where('company_id','=',$request->get('idcomp'))
            ->get();

//        $rec1 = $insname[0]->ins_id;
//        $rec2 = $insname[0]->insname;

        return response()->json($data);
//        return response()->json(['ins_id' => $rec1,'insname' => $rec2]);
    }

    public function getofficeinfo(Request $request){

       $officeshare = DB::table('clients')
            ->select('officeshare')
            ->where('id','=',$request->get('idoffice'))
            ->get();

        $rec1 = $officeshare[0]->officeshare;
//        $rec2 = $insname[0]->insname;

//        return response()->json($data);
        return response()->json(['officeper' => $rec1]);
    }

    public function getbrokerinfo(Request $request){

        $brokershare = DB::table('clients')
            ->select('brokershare')
            ->where('id','=',$request->get('idbroker'))
            ->get();

        $rec1 = $brokershare[0]->brokershare;
//        $rec2 = $insname[0]->insname;

//        return response()->json($data);
        return response()->json(['brokerper' => $rec1]);
    }

    public function update(Request $request, $contractdetid)
    {
        if ($request->isMethod("POST")) {

            $values_to_update = [
                'ccode' => $request->get('ccode'),
                'sdate' => $request->get('sdate'),
                'edate' => $request->get('edate'),
                'days' => $request->get('days'),
                'companyid' => $request->get('compname'),
                'insid' => $request->get('insname'),
                'carid' => $request->get('carname'),
                'maidid' => $request->get('maidname'),
                'officeid' => $request->get('office'),
                'officeper' => $request->get('officeper'),
                'officeshare' => $request->get('officeshare'),
                'brokerid' => $request->get('broker'),
                'brokerper' => $request->get('brokerper'),
                'brokershare'=> $request->get('brokershare'),
                'totalcost'=> $request->get('totalcost'),
                'netcost'=> $request->get('netcost'),
                'iqar'=> $request->get('iqar'),
                'iqarplace'=> $request->get('iqarplace'),
                'employeenum'=> $request->get('employeenum'),
                'country'=> $request->get('country'),
                'followby'=> $request->get('followby'),
                'stopcont'=> $request->get('stopcont') ? true : false,
                'curr'=> $request->get('curr'),
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ];

        DB::table('condet')
            ->where('id', '=', $contractdetid)
            ->update($values_to_update);
        }

        $this->updatecontractinfo($request->get('contid'));
//        $this->updateinsurance($request->get('contid'));

        return redirect()->route('contract-details',  [$request->get('contid')]);
    }

    public function deletedet(Request $request){

        $getcount = DB::table('accident')
            ->where('contid','=',$request->get('id'))
            ->get();
        $count = $getcount->count();

        $getcount1 = DB::table('clientpayments')
            ->where('contid','=',$request->get('id'))
            ->get();
        $count1 = $getcount1->count();


        if($count == 0 && $count1 == 0) {
            DB::table('condet')
                ->where('id', '=', $request->get('id'))
                ->delete();

            $this->updatecontractinfo($request->get('cont-id'));
            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }


    }

    public function updatecontractinfo($contid){
       $allfields = DB::table('contract_index')->get();
        $count = $allfields->count();

       if( $count > 0) {
           $resultins= DB::table('contract_index')
               ->select('codetid','insname','ccode')
               ->where('contid', '=', $contid)
               ->get();

           $inames = '';
           foreach ($resultins as $key=>$iname) {
               if ($inames == '') {
                   $inames = $iname->insname .' '.$iname->ccode.' ';
               }else{
                   $inames = $inames . ' , ' . $iname->insname .' '.$iname->ccode.' ';
               }

//               $inames = join(' , ', $iname->insname);
//               echo ( $iname->insname);
           }

           $resultcalc = DB::table('contract_index')
               ->select('codetid', DB::raw('COUNT(DISTINCT codetid) AS coins'))
               ->where('contid', '=', $contid)
               ->get();
           $rec1 = $resultcalc[0]->coins;

           $resultamount = DB::table('contract_index')
               ->select('codetid', DB::raw('SUM(totalcost) AS coamount'), 'currname','curr')
               ->where('contid', '=', $contid)
               ->where('curr', '=', "3")
               ->get();
//           $countusd = $resultamount->count();
           if($resultamount[0]->coamount != null) {
               $rec2 = $resultamount[0]->coamount;
               $rec3 = $resultamount[0]->currname;
           }else{
               $rec2 = "0";
               $rec3 = "-";
           }


           $resultamountlbp = DB::table('contract_index')
               ->select('codetid', DB::raw('SUM(totalcost) AS coamountlbp'), 'currname','curr')
               ->where('contid', '=', $contid)
               ->where('curr', '=', "2")
               ->get();

//           $countlbp = $resultamountlbp->count();
           if($resultamountlbp[0]->coamountlbp != null) {
               $rec4 = $resultamountlbp[0]->coamountlbp;
               $rec5 = $resultamountlbp[0]->currname;
           }else{
               $rec4 = "0";
               $rec5 = "-";
           }

           $values_to_update = [
               'coinscount' => $rec1,
               'coinsname' => $inames,
               'coamount' => $rec2,
               'coamountlbp' => $rec4,
               'cocurr' => $rec3,
               'cocurrlbp' => $rec5,
           ];

           DB::table('contract')
               ->where('id', '=', $contid)
               ->update($values_to_update);
       }else{
           $values_to_update = [
               'coinscount' => "0",
               'coinsname' => "-",
               'coamount' => "0",
               'coamountlbp' => "0",
               'cocurr' => "-",
               'cocurrlbp' => "-",
           ];

           DB::table('contract')
               ->where('id', '=', $contid)
               ->update($values_to_update);
       }
    }

    public function setcontractinfo($contid){
        $allfields = DB::table('contract_index')
            ->where('contid', '=', $contid)
            ->get();
        $count = $allfields->count();

        if( $count > 0) {
            $resultins= DB::table('contract_index')
                ->select('codetid','insname','ccode')
                ->where('contid', '=', $contid)
                ->get();

            $inames = '';
            foreach ($resultins as $key=>$iname) {
                if ($inames == '') {
                    $inames = $iname->insname .' '.$iname->ccode.' ';
                }else{
                    $inames = $inames . ' , ' . $iname->insname .' '.$iname->ccode.' ';
                }
            }

            $resultcalc = DB::table('contract_index')
                ->select('codetid', DB::raw('COUNT(DISTINCT codetid) AS coins'))
                ->where('contid', '=', $contid)
                ->get();
            $rec1 = $resultcalc[0]->coins;

            $resultamount = DB::table('contract_index')
                ->select('codetid', DB::raw('SUM(totalcost) AS coamount'), 'currname','curr')
                ->where('contid', '=', $contid)
                ->where('curr', '=', "3")
                ->get();
//            $countusd = $resultamount->count();
            if($resultamount[0]->coamount != null) {
                $rec2 = $resultamount[0]->coamount;
                $rec3 = $resultamount[0]->currname;
            }else{
                $rec2 = "0";
                $rec3 = "-";
            }


            $resultamountlbp = DB::table('contract_index')
                ->select('codetid', DB::raw('SUM(totalcost) AS coamountlbp'), 'currname','curr')
                ->where('contid', '=', $contid)
                ->where('curr', '=', "2")
                ->get();

//            $countlbp = $resultamountlbp->count();
            if($resultamountlbp[0]->coamountlbp != null) {
                $rec4 = $resultamountlbp[0]->coamountlbp;
                $rec5 = $resultamountlbp[0]->currname;
            }else{
                $rec4 = "0";
                $rec5 = "-";
            }


            $values_to_update = [
                'coinscount' => $rec1,
                'coinsname' => $inames,
                'coamount' => $rec2,
                'coamountlbp' => $rec4,
                'cocurr' => $rec3,
                'cocurrlbp' => $rec5,
            ];

            DB::table('contract')
                ->where('id', '=', $contid)
                ->update($values_to_update);
        }else{
            $values_to_update = [
                'coinscount' => "0",
                'coinsname' => "-",
                'coamount' => "0",
                'coamountlbp' => "0",
                'cocurr' => "-",
                'cocurrlbp' => "-",
            ];

            DB::table('contract')
                ->where('id', '=', $contid)
                ->update($values_to_update);
        }
    }

    public function createcontractprocedures($contractdet_id)
    {
        abort_if(Gate::denies('accident_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

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

    public function addNewValueliplace(Request $request)
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
                $id = DB::table('passplace')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }
        }
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

    public function addNewValuepayments(Request $request)
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

            if($tbid == "3") {
                $values_to_insert = [
                    'currname_eng' => $request->get('description'),
                ];
                $id = DB::table('currency')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }elseif($tbid == "1") {
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('banks')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }
        }
    }

    public function indexpayments($client_id)
    {
        abort_if(Gate::denies('contract_payment'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts_det')
                ->select('id' , 'client', 'codate', 'insname','totalcost','currname','billclosed','ccode')
                ->where('client', '=', $client_id)
                ->orderBy('codate', 'asc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('clients_contracts_det')
                ->select('id' , 'client', 'codate', 'insname','totalcost','currname','billclosed','ccode')
                ->where([
                    ['branch_id', '=', $bIds],
                    ['client', '=', $client_id],
                ])
                ->orderBy('codate', 'asc')
                ->get();
        }

//         $setcurr = DB::table('Settings')
//            ->select('curr')
//            ->get();

        $brokerslist = DB::table('cont_brokers_list')
            ->select('brokerid', 'brokername')
            ->where('client', '=', $client_id)
            ->get();

        $followlist = DB::table('cont_follow_list')
            ->select('followby', 'followname')
            ->where('client', '=', $client_id)
            ->get();

        $currlist = DB::table('currency')
            ->select('id', 'currname_eng')
            ->get();


        $accountype = DB::table('transtype')
            ->select('id', 'transtype','type')
            ->whereIn('id',array(2,1))
            ->orderby('id','desc')
            ->get();

        $paymentforlist = DB::table('payment')
            ->select('id', 'Description')
            ->get();

        $bankslist = DB::table('banks')
            ->select('id', 'Description')
            ->get();

        $paymenttype = DB::table('paymenttype')
            ->select('id', 'Description')
            ->get();


        $clientslist = DB::table('clients')
            ->select('cname')
            ->where('id', $client_id)
            ->get();

        $getcontid = DB::table('contract')
            ->select('id')
            ->where('client', $client_id)
            ->get();

        $clientname = $clientslist[0]->cname;
        $total_row = $contractlist->count();
        if($total_row > 0) {
            $rfalg = '';
        }else{
            $rfalg = 'disabled';
        }

        return view('pages.Contracts.payments', compact('clientname','client_id','currlist','paymentforlist','paymenttype','rfalg','bankslist','accountype','brokerslist','followlist'));

    }

    public function getcontractinslist(Request $request)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cid = $request->get('cid');
        $sqlstr = $request->get('sqlstr');
        $followby = $request->get('followby');
        $brokername = $request->get('brokername');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if($followby == '' && $brokername == ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('billclosed', '=', $sqlstr)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }
        }elseif($followby != '' && $brokername == ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('billclosed', '=', $sqlstr)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }
        }elseif($followby == '' && $brokername != ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->where('billclosed', '=', $sqlstr)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }
        }elseif($followby != '' && $brokername != ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->where('followby', '=', $followby)
                        ->where('billclosed', '=', $sqlstr)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                            ['followby', '=', $followby],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->where('followby', '=', $followby)
                        ->orderBy('billclosed', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','brokerid','followby')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                            ['followby', '=', $followby],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }
        }


        $datatables = Datatables::of($contractlist)
            ->editColumn('id', function ($inscontlist) {
                return $inscontlist->id;
            })
            ->editColumn('billid', function ($inscontlist) {
                return $inscontlist->billclosed;
            })
            ->editColumn('billstatus', function ($inscontlist) {
                $statusbuttons = "";
                if ($inscontlist->billclosed) {
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                }
                else{
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                }
                return $statusbuttons;
            })
            ->editColumn('ccode', function ($inscontlist) {
                $statusbuttons = "";
                $statusbuttons .= '<a href="javascript:;" data-contid="'.$inscontlist -> id.'" data-brokerid="'.$inscontlist -> brokerid.'" data-followby="'.$inscontlist -> followby.'" data-id="'.$inscontlist -> ccode.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> ccode .'</a>';
                return $statusbuttons;
            })
            ->editColumn('insname', function ($inscontlist) {
                return $inscontlist->insname;
            })
            ->editColumn('totalcost', function ($inscontlist) {
                return number_format($inscontlist->totalcost);
            })
            ->editColumn('currname', function ($inscontlist) {
                return $inscontlist->currname;
            })
            ->editColumn('insaction', function ($inscontlist) {
                $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/contract-details/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.displaycontract') .'"><i class="fa fa-eye"></i></a> ';
                return $buttons;
            })->rawColumns(['billstatus','ccode','insaction']);

        return $datatables->make(true);

    }

    public function getcontractlistpayment_usd(Request $request){
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $request->get('cid');
        $sqlstr = $request->get('sqlstr');
        $followby = $request->get('followby');
        $brokername = $request->get('brokername');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if($followby == '' && $brokername == ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }
        }elseif($followby != '' && $brokername == ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }
        }elseif($followby == '' && $brokername != ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }
        }elseif($followby != '' && $brokername != ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('brokerid', '=', $brokername)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('brokerid', '=', $brokername)
                        ->where('currid', '=', "3")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }

    public function getcontractlistpayment_lbp(Request $request){
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $request->get('cid');
        $sqlstr = $request->get('sqlstr');
        $followby = $request->get('followby');
        $brokername = $request->get('brokername');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if($followby == '' && $brokername == ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }
        }elseif($followby != '' && $brokername == ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }
        }elseif($followby == '' && $brokername != ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('brokerid', '=', $brokername)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }
        }elseif($followby != '' && $brokername != ''){
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('brokerid', '=', $brokername)
                        ->where('billclosed', '=', $sqlstr)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','billclosed','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['billclosed', '=', $sqlstr],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','billclosed','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where('client', '=', $cid)
                        ->where('followby', '=', $followby)
                        ->where('brokerid', '=', $brokername)
                        ->where('currid', '=', "2")
                        ->groupBy('client','currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('clients_contracts_det')
                        ->select('client', DB::raw('SUM(totalcost) AS coamount'), 'currname','currid','branch_id')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            ['client', '=', $cid],
                            ['followby', '=', $followby],
                            ['brokerid', '=', $brokername],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy('client','currname','currid','branch_id')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->currname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "LBP";
                    }
                }
            }
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }

    public function changeBillingStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'bid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::table('condet')
                ->where([
                    ['id', '=', $request->get('bid')],
                ])
                ->update(['billclosed' => $request->get('sts')]);
            return response()->json(array('msg' => 'msg'), 200);
        }
    }

    public function changeInsStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'bid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::table('condet')
                ->where([
                    ['id', '=', $request->get('bid')],
                ])
                ->update(['status' => $request->get('sts')]);
            return response()->json(array('msg' => 'msg'), 200);
        }
    }

    public function printcontract($contdet_id)
    {
        abort_if(Gate::denies('print_contract_client'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['contractdetlist'] = DB::table('print_contract_det')
            ->select('*')
            ->where('codetid', '=', $contdet_id)
            ->get();

        $getcontid = DB::table('print_contract_det')
            ->select('clientid', 'contid')
            ->where('codetid','=',$contdet_id)
            ->get();

        $getclientid = DB::table('print_contract_det')
            ->select('clientid', 'contid')
            ->where('codetid','=',$contdet_id)
            ->get();

        $data['getlicense'] = DB::table('client_license_name')
            ->select('linum', 'lidate','liplacename')
            ->where('clid','=',$getclientid[0]->clientid)
            ->get();

        $data['getlicensecontract'] = DB::table('contract_license')
            ->select('person','linum', 'lidate','liplacename')
            ->where('contid','=',$getclientid[0]->contid)
            ->get();


        $data['getpayment'] = DB::table('getcontract_payments')
            ->select('payamount','paydate','paycurr','paytype','payamountforid','fromaccount','payamountfor')
            ->where('contid', '=', $getcontid[0]->contid)
            ->where('fromaccount', '=', '2')
            ->get();


//
//        $paymentforlist = DB::table('payment')
//            ->select('id', 'Description')
//            ->get();
//
//        $paymenttype = DB::table('paymenttype')
//            ->select('id', 'Description')
//            ->get();

//        $paymentstatus = DB::table('paymentstatus')
//            ->select('id', 'Description')
//            ->get();

//
//        $clientslist = DB::table('clients')
//            ->select('cname')
//            ->where('id', $contdet_id)
//            ->get();

//        $clientname = $clientslist[0]->cname;

//        return view('pages.clients.Printout.printcontract', compact('contractlist','clientname','client_id','currlist','paymentforlist','paymenttype'));
        return view('pages.Clients.Printout.printcontract',$data);
    }

    public function printpayments($client_id)
    {
        abort_if(Gate::denies('clients_attach_print'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts')
                ->select('id' , 'client', 'cocode', 'codate','coname','coamount','cocurr','deposit','dcurr')
                ->where('client', '=', $client_id)
                ->orderBy('codate', 'desc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('contract')
                ->select('id', 'client', 'cocode', 'codate','coname','coamount','cocurr','deposit','dcurr')
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

//        $paymentstatus = DB::table('paymentstatus')
//            ->select('id', 'Description')
//            ->get();


        $clientslist = DB::table('clients')
            ->select('cname')
            ->where('id', $client_id)
            ->get();

        $clientname = $clientslist[0]->cname;

        return view('pages.Clients.Printout.clientspayments', compact('contractlist','clientname','client_id','currlist','paymentforlist','paymenttype'));
    }

    public function printreceipt($payment_id)
    {
        abort_if(Gate::denies('payments_print'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['paymentlist'] = DB::table('getclient_payments')
            ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','bankid','bankname','details','fromaccountid','toaccountid','accountname','accounttype','codestr','cname','checkdate','contid','ccode','broker','followby','checkdiscount','discount','dueamount')
            ->where('payid', '=', $payment_id)
            ->get();


        $currdate = Carbon::now()->toFormattedDateString();
        $InvCode = $data['paymentlist'][0]->codestr;

//        $tafqeetInArabic = Tafqeet::inArabic($data['contratinfo'][0]->coamount,'usd');
        $tafqeetInArabic = Numbers::TafqeetMoney($data['paymentlist'][0]->dueamount,$data['paymentlist'][0]->paycurr);

        return view('pages.Clients.Printout.clientsreceipt', $data)->with(compact('InvCode','tafqeetInArabic','currdate'));
    }

    public function getpaymentslist(Request $request){
        $followby = $request->get('followby');
        $brokername = $request->get('brokername');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if($followby == '' && $brokername == ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','bankid','bankname','details','fromaccountid','toaccountid','accountname','accounttype','codestr','checkdate','contid','ccode','broker','followby','checkdiscount','discount','dueamount')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $request->get('cid'))
                ->orderBy('paydate', 'asc')
                ->get();
        }elseif($followby != '' && $brokername == ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','bankid','bankname','details','fromaccountid','toaccountid','accountname','accounttype','codestr','checkdate','contid','ccode','broker','followby','checkdiscount','discount','dueamount')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $request->get('cid'))
                ->where('followby', '=', $followby)
                ->orderBy('paydate', 'asc')
                ->get();
        }elseif($followby == '' && $brokername != ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','bankid','bankname','details','fromaccountid','toaccountid','accountname','accounttype','codestr','checkdate','contid','ccode','broker','followby','checkdiscount','discount','dueamount')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $request->get('cid'))
                ->where('broker', '=', $brokername)
                ->orderBy('paydate', 'asc')
                ->get();
        }elseif($followby != '' && $brokername != ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','bankid','bankname','details','fromaccountid','toaccountid','accountname','accounttype','codestr','checkdate','contid','ccode','broker','followby','checkdiscount','discount','dueamount')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $request->get('cid'))
                ->where('followby', '=', $followby)
                ->where('broker', '=', $brokername)
                ->orderBy('paydate', 'asc')
                ->get();
        }

        $datatables = Datatables::of($paymentlist)
            ->editColumn('id', function ($paylist) {
                return $paylist->payid;
            })
            ->editColumn('payactions', function ($paylist) {
                $buttons = "";
                if (Auth::user()->can('payments_print')) {
                    $buttons .= '<a class="btn btn-primary btn-sm inline" target="_blank" title="'. trans('page-contract.contract.tabs.printpayment') .'" href="'. route('print-receipt', $paylist->payid) .'"><i class="fa fa-print"></i></a> ';
                }
                if (Auth::user()->can('payments_edit')) {
                    $buttons .= '<a href="javascript:;" class="edit-btn-payment btn btn-warning btn-sm inline" data-id="'.$paylist->payid.'" data-paytypeid="'.$paylist->paytypeid.'" data-paytype="'.$paylist->paytype.'" data-paychecknum="'.$paylist->paychecknum.'" data-paycheckdate="'.$paylist->checkdate.'" data-paybankid="'.$paylist->bankid.'" data-paybankname="'.$paylist->bankname.'" data-payfromaccountid="'.$paylist->fromaccountid.'" data-payfromaccount="'.$paylist->accountname.'" data-payfromaccounttype="'.$paylist->accounttype.'" data-paydetails="'.$paylist->details.'" data-payamountforid="'.$paylist->payamountforid.'" data-payamountfor="'.$paylist->payamountfor.'" data-paycurrid="'.$paylist->paycurrid.'" data-paycurr="'.$paylist->paycurr.'" data-paydate="'.$paylist->paydate.'" data-payamount="'.$paylist->payamount.'" data-contid="'.$paylist->contid.'" data-ccode="'.$paylist->ccode.'"  data-broker="'.$paylist->broker.'"  data-followby="'.$paylist->followby.'"  data-checkdiscount="'.$paylist->checkdiscount.'" data-discount="'.$paylist->discount.'" data-dueamount="'.$paylist->dueamount.'" title="'.trans('page-contract.contract.tabs.editpayment').'"><i class="fas fa-edit"></i></a>';
                }
                if (Auth::user()->can('payments_delete')) {
                    $buttons .= '<a href="javascript:;" class="delete-btn-payment btn btn-danger btn-sm inline" title="'. trans('page-contract.contract.tabs.deletepayment') .'" data-id="'.$paylist -> payid.'" data-title="'.$paylist -> payamountfor.'"><i class="fas fa-trash"></i></a>';
                }
                return $buttons;
            })
            ->editColumn('receipt', function ($paylist) {
                return $paylist->codestr;
            })
            ->editColumn('paydate', function ($paylist) {
                return $paylist->paydate;
            })
            ->editColumn('payamount', function ($paylist) {
                return number_format($paylist->dueamount) . ' ' . $paylist->paycurr;
            })
//            ->editColumn('payfor', function ($paylist) {
//                return $paylist->payamountfor;
//            })
//            ->editColumn('paytype', function ($paylist) {
//                return $paylist->paytype;
//            })
//            ->editColumn('accounttype', function ($paylist) {
//                return $paylist->accountname . ' - ' . $paylist->accounttype ;
//            })
            ->rawColumns(['payactions']);

        return $datatables->make(true);
    }

    public function getpayments_usd(Request $request){

        $cid = $request->get('cid');
        $followby = $request->get('followby');
        $brokername = $request->get('brokername');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if($followby == '' && $brokername == ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('paycurrid', '=', "3")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        }elseif($followby != '' && $brokername == ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('followby', '=', $followby)
                ->where('paycurrid', '=', "3")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        }elseif($followby == '' && $brokername != ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('broker', '=', $brokername)
                ->where('paycurrid', '=', "3")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        }elseif($followby != '' && $brokername != ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('followby', '=', $followby)
                ->where('broker', '=', $brokername)
                ->where('paycurrid', '=', "3")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }

    public function getpayments_lbp(Request $request){

        $cid = $request->get('cid');
        $followby = $request->get('followby');
        $brokername = $request->get('brokername');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if($followby == '' && $brokername == ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('paycurrid', '=', "2")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "LBP";
            }
        }elseif($followby != '' && $brokername == ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('followby', '=', $followby)
                ->where('paycurrid', '=', "2")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "LBP";
            }
        }elseif($followby == '' && $brokername != ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('broker', '=', $brokername)
                ->where('paycurrid', '=', "2")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "LBP";
            }
        }elseif($followby != '' && $brokername != ''){
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'),'paycurr','paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('followby', '=', $followby)
                ->where('broker', '=', $brokername)
                ->where('paycurrid', '=', "2")
                ->groupBy('payclientid','paycurr','paycurrid')
                ->get();

            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "LBP";
            }
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }

    public function storepayment(Request $request)
    {
        if ($request->isMethod("POST")) {
            $bIds = Auth::user()->branch_id;

            $recunum = DB::table('settings')
                ->select('recunum')
                ->get();

            $currentyear = now()->year;

            $cyear = substr($currentyear,2);

            $codestr = "R-".$cyear."-".$recunum[0]->recunum;


            $rules = array(
                'paymentdate' => 'required|date',
                'checkdate' => 'required|date',
                'paymenttype' => 'required',
                'checkdiscount' =>'required',
                'amount' =>'required',
                'discount' =>'required',
                'dueamount' =>'required',
                'contid' =>'required',
                'ccode' =>'required',
                'brokerid' =>'required',
                'followbyid' =>'required',
                'curr' =>'required',
                'amountfor' =>'required',
                'fromaccount' =>'required',
                'checknum' =>'required',
                'bank' =>'required',
                'pdetails' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            if($request->get('fromaccount') == 1){
                $taccount = '4';
            }elseif($request->get('fromaccount') == 2){
                $taccount = '3';
            }

            $values_to_insert = [
                'branch' => $bIds,
                'client' => $request->get('person'),
                'paymentdate' => $request->get('paymentdate'),
                'checkdate' => $request->get('checkdate'),
                'paymenttype' => $request->get('paymenttype'),
                'checkdiscount' => $request->get('checkdiscount') ? true : false,
                'amount' => $request->get('amount'),
                'discount' => $request->get('discount'),
                'dueamount' => $request->get('dueamount'),
                'contid' => $request->get('contid'),
                'ccode' => $request->get('ccode'),
                'broker' => $request->get('brokerid'),
                'followby' => $request->get('followbyid'),
                'curr' => $request->get('curr'),
                'amountfor' => $request->get('amountfor'),
                'checknum' => $request->get('checknum'),
                'bank' => $request->get('bank'),
                'details' => $request->get('pdetails'),
                'fromaccount' => $request->get('fromaccount'),
                'toaccount' => $taccount,
                'codenum' => $recunum[0]->recunum,
                'codestr' => $codestr,
                'partner' => '9',
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('clientpayments')->insert($values_to_insert);

            $values_to_update_recunum = [
                'recunum' => $recunum[0]->recunum + 1 ,
            ];

            DB::table('settings')
                ->update($values_to_update_recunum);
        }
        return response()->json($data);
    }

    public function editpayment(Request $request){

        if ($request->isMethod("POST")) {


            $rules = array(
                'paymentdate' => 'required|date',
                'checkdate' => 'required|date',
                'paymenttype' => 'required',
                'checkdiscount' =>'required',
                'amount' =>'required',
                'discount' =>'required',
                'dueamount' =>'required',
                'contid' =>'required',
                'ccode' =>'required',
                'brokerid' =>'required',
                'followbyid' =>'required',
                'curr' =>'required',
                'amountfor' =>'required',
                'fromaccount' =>'required',
                'checknum' =>'required',
                'bank' =>'required',
                'pdetails' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            if($request->get('fromaccount') == 1){
                $taccount = '4';
            }elseif($request->get('fromaccount') == 2){
                $taccount = '3';
            }

            $data =  DB::table('clientpayments')
                ->where('id', $request->get('id'))
                ->update([
                    'paymentdate' => $request->get('paymentdate'),
                    'checkdate' => $request->get('checkdate'),
                    'paymenttype' => $request->get('paymenttype'),
                    'checkdiscount' => $request->get('checkdiscount') ? true : false,
                    'amount' => $request->get('amount'),
                    'discount' => $request->get('discount'),
                    'dueamount' => $request->get('dueamount'),
                    'contid' => $request->get('contid'),
                    'ccode' => $request->get('ccode'),
                    'broker' => $request->get('brokerid'),
                    'followby' => $request->get('followbyid'),
                    'curr' => $request->get('curr'),
                    'amountfor' => $request->get('amountfor'),
                    'checknum' => $request->get('checknum'),
                    'bank' => $request->get('bank'),
                    'details' => $request->get('pdetails'),
                    'fromaccount' => $request->get('fromaccount'),
                    'toaccount' => $taccount,
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

    public function getclientsprintout($id,$pdates)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $id;
        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $sqlstr = '';
        $billoption = "كل الفواتير";

        $condid = 'client';
        $billstatus = '';
        $count = '';

        $filter = '';
        $partname = '';


        $data['clientname'] = DB::table('clients')
            ->select('cname as pname')
            ->where('id', '=', $cid)
            ->get();

        $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        if (Auth::user()->can('all_access')) {
            $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                ->whereBetween('codate', [$from, $to])
                ->where('client', '=', $cid)
                ->orderBy('billclosed', 'asc')
                ->get();
            $count = $data['contractlist']->count();
        } else {
            $bIds = Auth::user()->branch_id;
            $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                ->whereBetween('codate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    ['client', '=', $cid],
                ])
                ->orderBy('billclosed', 'asc')
                ->get();
            $count = $data['contractlist']->count();
        }

        //From here calculate the USD Total Amounts

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('currid', '=', "3")
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec2 = number_format($contractlist[0]->coamount);
                $rec3 = $contractlist[0]->currname;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        } else {
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    [$condid, '=', $cid],
                    ['currid', '=', "3"],
                ])
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec2 = number_format($contractlist[0]->coamount);
                $rec3 = $contractlist[0]->currname;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        }

        //From here calculate the LBP Total Amounts

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('currid', '=', "2")
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec22 = number_format($contractlist[0]->coamount);
                $rec33 = $contractlist[0]->currname;
            }else{
                $rec22 = "0";
                $rec33 = "LBP";
            }
        } else {
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    [$condid, '=', $cid],
                    ['currid', '=', "2"],
                ])
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec22 = number_format($contractlist[0]->coamount);
                $rec33 = $contractlist[0]->currname;
            }else{
                $rec22 = "0";
                $rec33 = "LBP";
            }
        }

        return view('pages.Reports.clients_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','filter','partname','from','to'));
    }

    public function getclientsprintoutoptions($id,$sql,$pdates)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $id;
        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $sqlstr = $sql;
        if($sqlstr == "1"){
            $billoption = "الفواتير المدفوعة";
        }elseif($sqlstr == "0"){
            $billoption = "الفواتير الغير مدفوعة";
        }

        $condid = 'client';
        $billstatus = '';
        $count = '';

        $filter = '';
        $partname = '';

        $data['clientname'] = DB::table('clients')
            ->select('cname as pname')
            ->where('id', '=', $cid)
            ->get();

        $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        if (Auth::user()->can('all_access')) {
            $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                ->whereBetween('codate', [$from, $to])
                ->where('client', '=', $cid)
                ->where('billclosed', '=', $sqlstr)
                ->orderBy('billclosed', 'asc')
                ->get();
            $count = $data['contractlist']->count();
        } else {
            $bIds = Auth::user()->branch_id;
            $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                ->whereBetween('codate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    ['billclosed', '=', $sqlstr],
                    ['client', '=', $cid],
                ])
                ->orderBy('billclosed', 'asc')
                ->get();
            $count = $data['contractlist']->count();
        }

        //From here calculate the USD Total Amounts

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('billclosed', '=', $sqlstr)
                ->where('currid', '=', "3")
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec2 = number_format($contractlist[0]->coamount);
                $rec3 = $contractlist[0]->currname;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        } else {
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    ['billclosed', '=', $sqlstr],
                    [$condid, '=', $cid],
                    ['currid', '=', "3"],
                ])
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec2 = number_format($contractlist[0]->coamount);
                $rec3 = $contractlist[0]->currname;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        }

        //From here calculate the LBP Total Amounts

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('billclosed', '=', $sqlstr)
                ->where('currid', '=', "2")
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec22 = number_format($contractlist[0]->coamount);
                $rec33 = $contractlist[0]->currname;
            }else{
                $rec22 = "0";
                $rec33 = "LBP";
            }
        } else {
            $bIds = Auth::user()->branch_id;
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('codate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    ['billclosed', '=', $sqlstr],
                    [$condid, '=', $cid],
                    ['currid', '=', "2"],
                ])
                ->groupBy($condid,'currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec22 = number_format($contractlist[0]->coamount);
                $rec33 = $contractlist[0]->currname;
            }else{
                $rec22 = "0";
                $rec33 = "LBP";
            }
        }

        return view('pages.Reports.clients_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','filter','partname','from','to'));
    }

    public function getclientspaymentsprintout($id,$pdates){

        $cid = $id;
        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $albp = '';
        $clbp = '';
        $ausd = '';
        $cusd = '';
        $ausd1 = '';
        $albp1 = '';

        $fieldid = 'client';
        $condid = 'client';

        $filter = '';
        $partname = '';

        $data['clientname'] = DB::table('clients')
            ->select('cname as pname')
            ->where('id', '=', $cid)
            ->get();

        $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        $contractlist = DB::table('clients_contracts_det')
            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
            ->whereBetween('codate', [$from, $to])
            ->where($condid, '=', $cid)
            ->where('currid', '=', "2")
            ->groupBy($condid,'currname','currid')
            ->get();
        if(isset($contractlist[0]->coamount)) {
            $albp = number_format($contractlist[0]->coamount);
            $albp1 = $contractlist[0]->coamount;
            $clbp = $contractlist[0]->currname;
        }else{
            $albp = "0";
            $albp1 = "0";
            $clbp = "LBP";
        }

        $contractlist = DB::table('clients_contracts_det')
            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
            ->whereBetween('codate', [$from, $to])
            ->where($condid, '=', $cid)
            ->where('currid', '=', "3")
            ->groupBy($condid,'currname','currid')
            ->get();
        if(isset($contractlist[0]->coamount)) {
            $ausd = number_format($contractlist[0]->coamount);
            $ausd1 = $contractlist[0]->coamount;
            $cusd = $contractlist[0]->currname;
        }else{
            $ausd = "0";
            $ausd1 = "0";
            $cusd = "USD";
        }

        $data['paymentlist'] = DB::table('getclient_payments')
            ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','bankid','bankname','details','fromaccountid','toaccountid','accountname','accounttype','codestr','checkdate','contid','ccode','broker','followby','checkdiscount','discount','dueamount')
            ->whereBetween('paydate', [$from, $to])
            ->where('payclientid', '=', $cid)
            ->orderBy('paydate', 'asc')
            ->get();
        $count = $data['paymentlist']->count();

       //        From here get sum of USD Amounts

        $paymentlist = DB::table('getclient_payments')
            ->select('payclientid',DB::raw('SUM(dueamount) AS coamount'), 'paycurr', 'paycurrid')
            ->whereBetween('paydate', [$from, $to])
            ->where('payclientid', '=', $cid)
            ->where('paycurrid', '=', "3")
            ->groupBy('payclientid','paycurr','paycurrid')
            ->get();
        if(isset($paymentlist[0]->coamount)) {
            $rec2 = number_format($paymentlist[0]->coamount);
            $rec2usd = $paymentlist[0]->coamount;
            $rec3 = $paymentlist[0]->paycurr;
        }else{
            $rec2 = "0";
            $rec2usd = "0";
            $rec3 = "USD";
        }

        //        From here get sum of LBP Amounts

        $paymentlist = DB::table('getclient_payments')
            ->select('payclientid',DB::raw('SUM(dueamount) AS coamount'), 'paycurr', 'paycurrid')
            ->whereBetween('paydate', [$from, $to])
            ->where('payclientid', '=', $cid)
            ->where('paycurrid', '=', "2")
            ->groupBy('payclientid','paycurr','paycurrid')
            ->get();
        if(isset($paymentlist[0]->coamount)) {
            $rec22 = number_format($paymentlist[0]->coamount);
            $rec22lbp = $paymentlist[0]->coamount;
            $rec33 = $paymentlist[0]->paycurr;
        }else{
            $rec22 = "0";
            $rec22lbp = "0";
            $rec33 = "LBP";
        }

        $remainusd = $ausd1 - $rec2usd;
        $remainlbp = $albp1 - $rec22lbp;
        return view('pages.Reports.clients_payments', $data)->with(compact('rec2','rec3','rec22','rec33','count','albp','clbp','ausd','cusd','remainusd','remainlbp','filter','partname','from','to'));
    }

    public function bgetclientsprintout($id,$bid,$type,$pdates)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $id;
        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $sqlstr = '';
        $billoption = "كل الفواتير";

        $condid = 'client';
        $billstatus = '';
        $count = '';

        $fbid = $bid;
        $fbids = explode("_", $fbid);
        $partid = $fbids[0];
        $partname = $fbids[1];

        $filter = $type;


        $data['clientname'] = DB::table('clients')
            ->select('cname as pname')
            ->where('id', '=', $cid)
            ->get();

        $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        if($filter == 1){
            if (Auth::user()->can('all_access')) {
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where('client', '=', $cid)
                    ->where('followby', '=', $partid)
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            } else {
                $bIds = Auth::user()->branch_id;
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['client', '=', $cid],
                        ['followby', '=', $partid],
                    ])
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            }
        }elseif($filter == 2){
            if (Auth::user()->can('all_access')) {
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where('client', '=', $cid)
                    ->where('brokerid', '=', $partid)
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            } else {
                $bIds = Auth::user()->branch_id;
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','platnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['client', '=', $cid],
                        ['brokerid', '=', $partid],
                    ])
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            }
        }


        //From here calculate the USD Total Amounts
        if($filter == 1) {
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('followby', '=', $partid)
                    ->where('currid', '=', "3")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        [$condid, '=', $cid],
                        ['followby', '=', $partid],
                        ['currid', '=', "3"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            }
        }elseif($filter == 2){
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('brokerid', '=', $partid)
                    ->where('currid', '=', "3")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        [$condid, '=', $cid],
                        ['brokerid', '=', $partid],
                        ['currid', '=', "3"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            }
        }
        //From here calculate the LBP Total Amounts
        if($filter == 1) {
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('followby', '=', $partid)
                    ->where('currid', '=', "2")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        [$condid, '=', $cid],
                        ['followby', '=', $partid],
                        ['currid', '=', "2"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            }
        }elseif($filter == 2){
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('brokerid', '=', $partid)
                    ->where('currid', '=', "2")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        [$condid, '=', $cid],
                        ['brokerid', '=', $partid],
                        ['currid', '=', "2"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            }
        }
        return view('pages.Reports.clients_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','filter','partname','from','to'));
    }

    public function bgetclientsprintoutoptions($id,$sql,$bid,$type,$pdates)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $id;
        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $sqlstr = $sql;
        if($sqlstr == "1"){
            $billoption = "الفواتير المدفوعة";
        }elseif($sqlstr == "0"){
            $billoption = "الفواتير الغير مدفوعة";
        }

        $condid = 'client';
        $billstatus = '';
        $count = '';

        $fbid = $bid;
        $fbids = explode("_", $fbid);
        $partid = $fbids[0];
        $partname = $fbids[1];

        $filter = $type;

        $data['clientname'] = DB::table('clients')
            ->select('cname as pname')
            ->where('id', '=', $cid)
            ->get();

        $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        if($filter == 1) {
            if (Auth::user()->can('all_access')) {
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode', 'carname', 'platnumber', 'maidname', 'passport', 'compname', 'sdate', 'edate', 'brokerid', 'followby', 'brokername', 'followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where('client', '=', $cid)
                    ->where('followby', '=', $partid)
                    ->where('billclosed', '=', $sqlstr)
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            } else {
                $bIds = Auth::user()->branch_id;
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode', 'carname', 'platnumber', 'maidname', 'passport', 'compname', 'sdate', 'edate', 'brokerid', 'followby', 'brokername', 'followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['billclosed', '=', $sqlstr],
                        ['client', '=', $cid],
                        ['followby', '=', $partid],
                    ])
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            }
        }elseif($filter == 2){
            if (Auth::user()->can('all_access')) {
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode', 'carname', 'platnumber', 'maidname', 'passport', 'compname', 'sdate', 'edate', 'brokerid', 'followby', 'brokername', 'followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where('client', '=', $cid)
                    ->where('brokerid', '=', $partid)
                    ->where('billclosed', '=', $sqlstr)
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            } else {
                $bIds = Auth::user()->branch_id;
                $data['contractlist'] = DB::table('clients_contracts_det_print_out')
                    ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode', 'carname', 'platnumber', 'maidname', 'passport', 'compname', 'sdate', 'edate', 'brokerid', 'followby', 'brokername', 'followname')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['billclosed', '=', $sqlstr],
                        ['client', '=', $cid],
                        ['brokerid', '=', $partid],
                    ])
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            }
        }
        //From here calculate the USD Total Amounts
        if($filter == 1) {
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('billclosed', '=', $sqlstr)
                    ->where('followby', '=', $partid)
                    ->where('currid', '=', "3")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['billclosed', '=', $sqlstr],
                        ['followby', '=', $partid],
                        [$condid, '=', $cid],
                        ['currid', '=', "3"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            }
        }elseif($filter == 2){
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('billclosed', '=', $sqlstr)
                    ->where('brokerid', '=', $partid)
                    ->where('currid', '=', "3")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['billclosed', '=', $sqlstr],
                        ['brokerid', '=', $partid],
                        [$condid, '=', $cid],
                        ['currid', '=', "3"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec2 = number_format($contractlist[0]->coamount);
                    $rec3 = $contractlist[0]->currname;
                } else {
                    $rec2 = "0";
                    $rec3 = "USD";
                }
            }
        }
        //From here calculate the LBP Total Amounts
        if($filter == 1) {
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('billclosed', '=', $sqlstr)
                    ->where('followby', '=', $partid)
                    ->where('currid', '=', "2")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['billclosed', '=', $sqlstr],
                        ['followby', '=', $partid],
                        [$condid, '=', $cid],
                        ['currid', '=', "2"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            }
        }elseif($filter == 2){
            if (Auth::user()->can('all_access')) {
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $cid)
                    ->where('billclosed', '=', $sqlstr)
                    ->where('brokerid', '=', $partid)
                    ->where('currid', '=', "2")
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            } else {
                $bIds = Auth::user()->branch_id;
                $contractlist = DB::table('clients_contracts_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['billclosed', '=', $sqlstr],
                        ['brokerid', '=', $partid],
                        [$condid, '=', $cid],
                        ['currid', '=', "2"],
                    ])
                    ->groupBy($condid, 'currname', 'currid')
                    ->get();
                if (isset($contractlist[0]->coamount)) {
                    $rec22 = number_format($contractlist[0]->coamount);
                    $rec33 = $contractlist[0]->currname;
                } else {
                    $rec22 = "0";
                    $rec33 = "LBP";
                }
            }
        }
        return view('pages.Reports.clients_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','filter','partname','from','to'));
    }

    public function bgetclientspaymentsprintout($id,$bid,$type,$pdates){

        $cid = $id;
        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $albp = '';
        $clbp = '';
        $ausd = '';
        $cusd = '';
        $ausd1 = '';
        $albp1 = '';

        $fieldid = 'client';
        $condid = 'client';

        $fbid = $bid;
        $fbids = explode("_", $fbid);
        $partid = $fbids[0];
        $partname = $fbids[1];

        $filter = $type;

        $data['clientname'] = DB::table('clients')
            ->select('cname as pname')
            ->where('id', '=', $cid)
            ->get();

        $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        if($filter == 1) {
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('followby', '=', $partid)
                ->where('currid', '=', "2")
                ->groupBy($condid, 'currname', 'currid')
                ->get();
            if (isset($contractlist[0]->coamount)) {
                $albp = number_format($contractlist[0]->coamount);
                $albp1 = $contractlist[0]->coamount;
                $clbp = $contractlist[0]->currname;
            } else {
                $albp = "0";
                $albp1 = "0";
                $clbp = "LBP";
            }
        }elseif($filter == 2){
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('brokerid', '=', $partid)
                ->where('currid', '=', "2")
                ->groupBy($condid, 'currname', 'currid')
                ->get();
            if (isset($contractlist[0]->coamount)) {
                $albp = number_format($contractlist[0]->coamount);
                $albp1 = $contractlist[0]->coamount;
                $clbp = $contractlist[0]->currname;
            } else {
                $albp = "0";
                $albp1 = "0";
                $clbp = "LBP";
            }
        }

        if($filter == 1) {
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('followby', '=', $partid)
                ->where('currid', '=', "3")
                ->groupBy($condid, 'currname', 'currid')
                ->get();
            if (isset($contractlist[0]->coamount)) {
                $ausd = number_format($contractlist[0]->coamount);
                $ausd1 = $contractlist[0]->coamount;
                $cusd = $contractlist[0]->currname;
            } else {
                $ausd = "0";
                $ausd1 = "0";
                $cusd = "USD";
            }
        }elseif($filter == 2) {
            $contractlist = DB::table('clients_contracts_det')
                ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                ->whereBetween('codate', [$from, $to])
                ->where($condid, '=', $cid)
                ->where('brokerid', '=', $partid)
                ->where('currid', '=', "3")
                ->groupBy($condid, 'currname', 'currid')
                ->get();
            if (isset($contractlist[0]->coamount)) {
                $ausd = number_format($contractlist[0]->coamount);
                $ausd1 = $contractlist[0]->coamount;
                $cusd = $contractlist[0]->currname;
            } else {
                $ausd = "0";
                $ausd1 = "0";
                $cusd = "USD";
            }
        }

        if($filter == 1) {
            $data['paymentlist'] = DB::table('getclient_payments')
                ->select('payid', 'paydate', 'payamount', 'paycurr', 'payamountfor', 'paytype', 'payclientid', 'paytypeid', 'payamountforid', 'paycurrid', 'paychecknum', 'bankid', 'bankname', 'details', 'fromaccountid', 'toaccountid', 'accountname', 'accounttype', 'codestr', 'checkdate', 'contid', 'ccode', 'broker', 'followby', 'checkdiscount', 'discount', 'dueamount')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('followby', '=', $partid)
                ->orderBy('paydate', 'asc')
                ->get();
            $count = $data['paymentlist']->count();
        }elseif($filter == 2) {
            $data['paymentlist'] = DB::table('getclient_payments')
                ->select('payid', 'paydate', 'payamount', 'paycurr', 'payamountfor', 'paytype', 'payclientid', 'paytypeid', 'payamountforid', 'paycurrid', 'paychecknum', 'bankid', 'bankname', 'details', 'fromaccountid', 'toaccountid', 'accountname', 'accounttype', 'codestr', 'checkdate', 'contid', 'ccode', 'broker', 'followby', 'checkdiscount', 'discount', 'dueamount')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('broker', '=', $partid)
                ->orderBy('paydate', 'asc')
                ->get();
            $count = $data['paymentlist']->count();
        }

        //        From here get sum of USD Amounts
        if($filter == 1) {
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('followby', '=', $partid)
                ->where('paycurrid', '=', "3")
                ->groupBy('payclientid', 'paycurr', 'paycurrid')
                ->get();
            if (isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec2usd = $paymentlist[0]->coamount;
                $rec3 = $paymentlist[0]->paycurr;
            } else {
                $rec2 = "0";
                $rec2usd = "0";
                $rec3 = "USD";
            }
        }elseif($filter == 2) {
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('broker', '=', $partid)
                ->where('paycurrid', '=', "3")
                ->groupBy('payclientid', 'paycurr', 'paycurrid')
                ->get();
            if (isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec2usd = $paymentlist[0]->coamount;
                $rec3 = $paymentlist[0]->paycurr;
            } else {
                $rec2 = "0";
                $rec2usd = "0";
                $rec3 = "USD";
            }
        }

        //        From here get sum of LBP Amounts
        if($filter == 1) {
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('followby', '=', $partid)
                ->where('paycurrid', '=', "2")
                ->groupBy('payclientid', 'paycurr', 'paycurrid')
                ->get();
            if (isset($paymentlist[0]->coamount)) {
                $rec22 = number_format($paymentlist[0]->coamount);
                $rec22lbp = $paymentlist[0]->coamount;
                $rec33 = $paymentlist[0]->paycurr;
            } else {
                $rec22 = "0";
                $rec22lbp = "0";
                $rec33 = "LBP";
            }
        }elseif($filter == 2) {
            $paymentlist = DB::table('getclient_payments')
                ->select('payclientid', DB::raw('SUM(dueamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where('payclientid', '=', $cid)
                ->where('broker', '=', $partid)
                ->where('paycurrid', '=', "2")
                ->groupBy('payclientid', 'paycurr', 'paycurrid')
                ->get();
            if (isset($paymentlist[0]->coamount)) {
                $rec22 = number_format($paymentlist[0]->coamount);
                $rec22lbp = $paymentlist[0]->coamount;
                $rec33 = $paymentlist[0]->paycurr;
            } else {
                $rec22 = "0";
                $rec22lbp = "0";
                $rec33 = "LBP";
            }
        }

        $remainusd = $ausd1 - $rec2usd;
        $remainlbp = $albp1 - $rec22lbp;
        return view('pages.Reports.clients_payments', $data)->with(compact('rec2','rec3','rec22','rec33','count','albp','clbp','ausd','cusd','remainusd','remainlbp','filter','partname','from','to'));
    }

    public function checkcontpayments(Request $request){

        $getcount = DB::table('clientpayments')
            ->where('contid','=',$request->get('contid'))
            ->get();
        $count = $getcount->count();


        if($count == 0) {
            return response()->json(['flag'=>"0"]);
        }else{
            return response()->json(['flag'=>"1"]);
        }
    }

}
