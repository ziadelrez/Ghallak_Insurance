<?php

namespace App\Http\Controllers\Pages;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Alkoumi\LaravelArabicTafqeet\Tafqeet;

class PaymentsController extends Controller
{
    public function indexpayments()
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');


        $data['currlist'] = DB::table('currency')
            ->select('id', 'currname_eng')
            ->get();


        $data['paymentforlist'] = DB::table('payment')
            ->select('id', 'Description')
            ->get();

        $data['bankslist'] = DB::table('banks')
            ->select('id', 'Description')
            ->get();

       $data['paymenttype'] = DB::table('paymenttype')
            ->select('id', 'Description')
            ->get();

        $data['partnerslist'] = DB::table('partners')
            ->select('id', 'partner')
            ->whereIn('id',array(1,2,3,4,5,6,7))
            ->get();


        return view('pages.Contracts.ppayments', $data);

    }

    public function getpartnersname(Request $request){

        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tb = $request->get('idpartners');
        switch ($tb) {
            case "1":
                if (Auth::user()->can('all_access')) {
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('office', '=', '1')
                        ->get();
                }else {
                  $bIds = Auth::user()->branch_id;
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('office', '=', '1')
                        ->Where('branch', '=', $bIds)
                        ->get();
                 }

                $data['accountype'] = DB::table('transtype')
                    ->select('id as tid', 'transtype','type')
                    ->whereIn('id',array(4,3,22,21))
                    ->orderby('id','desc')
                    ->get();

                return response()->json($data);
                break;
            case "2":
                $data['alist'] = DB::table('companies')
                    ->select('id', 'compname AS defname')
                    ->get();

                $data['accountype'] = DB::table('transtype')
                    ->select('id as tid', 'transtype','type')
                    ->whereIn('id',array(6,5))
                    ->orderby('id','desc')
                    ->get();
                return response()->json($data);
                break;
            case "3":
                if (Auth::user()->can('all_access')) {
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('broker', '=', '1')
                        ->get();
                }else {
                    $bIds = Auth::user()->branch_id;
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('broker', '=', '1')
                        ->Where('branch', '=', $bIds)
                        ->get();
                }

                $data['accountype'] = DB::table('transtype')
                    ->select('id as tid', 'transtype','type')
                    ->whereIn('id',array(8,7))
                    ->orderby('id','desc')
                    ->get();

                return response()->json($data);
                break;
            case "4":
                if (Auth::user()->can('all_access')) {
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('garage', '=', '1')
                        ->get();
                }else {
                    $bIds = Auth::user()->branch_id;
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('garage', '=', '1')
                        ->Where('branch', '=', $bIds)
                        ->get();
                }

                $data['accountype'] = DB::table('transtype')
                    ->select('id as tid', 'transtype','type')
                    ->whereIn('id',array(10,9))
                    ->orderby('id','desc')
                    ->get();
                return response()->json($data);
                break;
            case "5":
                if (Auth::user()->can('all_access')) {
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('expert', '=', '1')
                        ->get();
                }else {
                    $bIds = Auth::user()->branch_id;
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('expert', '=', '1')
                        ->Where('branch', '=', $bIds)
                        ->get();
                }

                $data['accountype'] = DB::table('transtype')
                    ->select('id as tid', 'transtype','type')
                    ->whereIn('id',array(12,11))
                    ->orderby('id','desc')
                    ->get();
                return response()->json($data);
                break;
            case "6":
                $data['alist'] = DB::table('hospitals')
                    ->select('id', 'Description AS defname')
                    ->where('id','>','1')
                    ->get();

                $data['accountype'] = DB::table('transtype')
                    ->select('id as tid', 'transtype','type')
                    ->whereIn('id',array(14,13))
                    ->orderby('id','desc')
                    ->get();
                return response()->json($data);
                break;
            case "7":
                if (Auth::user()->can('all_access')) {
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('aperson', '=', '1')
                        ->get();
                }else {
                    $bIds = Auth::user()->branch_id;
                    $data['alist'] = DB::table('clients')
                        ->select('id', 'cname AS defname')
                        ->Where('aperson', '=', '1')
                        ->Where('branch', '=', $bIds)
                        ->get();
                }

                $data['accountype'] = DB::table('transtype')
                    ->select('id as tid', 'transtype','type')
                    ->whereIn('id',array(16,15))
                    ->orderby('id','desc')
                    ->get();
                return response()->json($data);
                break;
        }
    }

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

    public function getpartnerslist(Request $request)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $request->get('cid');
        $tbid = $request->get('tbid');
        $sqlstr = $request->get('sqlstr');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

       $condid = '';
       $billstatus = '';

        switch ($tbid) {
            case "1":
                $condid = 'officeid';
                $billstatus = 'billoffice';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }

                $datatables = Datatables::of($contractlist)
                    ->editColumn('id', function ($inscontlist) {
                        return $inscontlist->id;
                    })
                    ->editColumn('billid', function ($inscontlist) {
                        return $inscontlist->billoffice;
                    })
                    ->editColumn('billstatus', function ($inscontlist) {
                        $statusbuttons = "";
                        if ($inscontlist->billoffice) {
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                        }
                        else{
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                        }
                        return $statusbuttons;
                    })
                    ->editColumn('ccode', function ($inscontlist) {
                        $statusbuttons = "";
                        $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> ccode.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> ccode .'</a>';
                        return $statusbuttons;
                    })
                    ->editColumn('insname', function ($inscontlist) {
                        return $inscontlist->insname;
                    })
                    ->editColumn('totalcost', function ($inscontlist) {
                        return number_format($inscontlist->officeshare);
                    })
                    ->editColumn('currname', function ($inscontlist) {
                        return $inscontlist->currname;
                    })
                    ->editColumn('insaction', function ($inscontlist) {
                        $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/contract-details/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.displaycontract') .'"><i class="fa fa-eye"></i></a> ';
                        return $buttons;
                    })->rawColumns(['billstatus','ccode','insaction']);

                return $datatables->make(true);

                break;
            case "2":
                $condid = 'companyid';
                $billstatus = 'billcompanies';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }

                $datatables = Datatables::of($contractlist)
                    ->editColumn('id', function ($inscontlist) {
                        return $inscontlist->id;
                    })
                    ->editColumn('billid', function ($inscontlist) {
                        return $inscontlist->billcompanies;
                    })
                    ->editColumn('billstatus', function ($inscontlist) {
                        $statusbuttons = "";
                        if ($inscontlist->billcompanies) {
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                        }
                        else{
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                        }
                        return $statusbuttons;
                    })
                    ->editColumn('ccode', function ($inscontlist) {
                        $statusbuttons = "";
                        $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> ccode.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> ccode .'</a>';
                        return $statusbuttons;
                    })
                    ->editColumn('insname', function ($inscontlist) {
                        return $inscontlist->insname;
                    })
                    ->editColumn('totalcost', function ($inscontlist) {
                        return number_format($inscontlist->netcost);
                    })
                    ->editColumn('currname', function ($inscontlist) {
                        return $inscontlist->currname;
                    })
                    ->editColumn('insaction', function ($inscontlist) {
                        $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/contract-details/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.displaycontract') .'"><i class="fa fa-eye"></i></a> ';
                        return $buttons;
                    })->rawColumns(['billstatus','ccode','insaction']);

                return $datatables->make(true);

                break;
            case "3":
                $condid = 'brokerid';
                $billstatus = 'billbrokers';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }

                $datatables = Datatables::of($contractlist)
                    ->editColumn('id', function ($inscontlist) {
                        return $inscontlist->id;
                    })
                    ->editColumn('billid', function ($inscontlist) {
                        return $inscontlist->billbrokers;
                    })
                    ->editColumn('billstatus', function ($inscontlist) {
                        $statusbuttons = "";
                        if ($inscontlist->billbrokers) {
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                        }
                        else{
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                        }
                        return $statusbuttons;
                    })
                    ->editColumn('ccode', function ($inscontlist) {
                        $statusbuttons = "";
                        $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> ccode.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> ccode .'</a>';
                        return $statusbuttons;
                    })
                    ->editColumn('insname', function ($inscontlist) {
                        return $inscontlist->insname;
                    })
                    ->editColumn('totalcost', function ($inscontlist) {
                        return number_format($inscontlist->brokershare);
                    })
                    ->editColumn('currname', function ($inscontlist) {
                        return $inscontlist->currname;
                    })
                    ->editColumn('insaction', function ($inscontlist) {
                        $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/contract-details/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.displaycontract') .'"><i class="fa fa-eye"></i></a> ';
                        return $buttons;
                    })->rawColumns(['billstatus','ccode','insaction']);

                return $datatables->make(true);

                break;
            case "4":
                $condid = 'garage';
                $billstatus = 'billgarage';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }

                $datatables = Datatables::of($contractlist)
                    ->editColumn('id', function ($inscontlist) {
                        return $inscontlist->id;
                    })
                    ->editColumn('billid', function ($inscontlist) {
                        return $inscontlist->billgarage;
                    })
                    ->editColumn('billstatus', function ($inscontlist) {
                        $statusbuttons = "";
                        if ($inscontlist->billgarage) {
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                        }
                        else{
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                        }
                        return $statusbuttons;
                    })
                    ->editColumn('ccode', function ($inscontlist) {
                        $statusbuttons = "";
                        $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> codestr.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> codestr .'</a>';
                        return $statusbuttons;
                    })
                    ->editColumn('insname', function ($inscontlist) {
                        return $inscontlist->accidenttypename;
                    })
                    ->editColumn('totalcost', function ($inscontlist) {
                        return number_format($inscontlist->gcost);
                    })
                    ->editColumn('currname', function ($inscontlist) {
                        return $inscontlist->gcurrname;
                    })
                    ->editColumn('insaction', function ($inscontlist) {
                        $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/accident/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.displaycontract') .'"><i class="fa fa-eye"></i></a> ';
                        return $buttons;
                    })->rawColumns(['billstatus','ccode','insaction']);

                return $datatables->make(true);

                break;
            case "5":
                $condid = 'expert';
                $billstatus = 'billexpert';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }

                $datatables = Datatables::of($contractlist)
                    ->editColumn('id', function ($inscontlist) {
                        return $inscontlist->id;
                    })
                    ->editColumn('billid', function ($inscontlist) {
                        return $inscontlist->billexpert;
                    })
                    ->editColumn('billstatus', function ($inscontlist) {
                        $statusbuttons = "";
                        if ($inscontlist->billexpert) {
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                        }
                        else{
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                        }
                        return $statusbuttons;
                    })
                    ->editColumn('ccode', function ($inscontlist) {
                        $statusbuttons = "";
                        $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> codestr.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> codestr .'</a>';
                        return $statusbuttons;
                    })
                    ->editColumn('insname', function ($inscontlist) {
                        return $inscontlist->accidenttypename;
                    })
                    ->editColumn('totalcost', function ($inscontlist) {
                        return number_format($inscontlist->ecost);
                    })
                    ->editColumn('currname', function ($inscontlist) {
                        return $inscontlist->ecurrname;
                    })
                    ->editColumn('insaction', function ($inscontlist) {
                        $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/accident/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.displaycontract') .'"><i class="fa fa-eye"></i></a> ';
                        return $buttons;
                    })->rawColumns(['billstatus','ccode','insaction']);

                return $datatables->make(true);

                break;
            case "6":
                $condid = 'hospital';
                $billstatus = 'billhospital';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }

                $datatables = Datatables::of($contractlist)
                    ->editColumn('id', function ($inscontlist) {
                        return $inscontlist->id;
                    })
                    ->editColumn('billid', function ($inscontlist) {
                        return $inscontlist->billhospital;
                    })
                    ->editColumn('billstatus', function ($inscontlist) {
                        $statusbuttons = "";
                        if ($inscontlist->billhospital) {
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                        }
                        else{
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                        }
                        return $statusbuttons;
                    })
                    ->editColumn('ccode', function ($inscontlist) {
                        $statusbuttons = "";
                        $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> codestr.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> codestr .'</a>';
                        return $statusbuttons;
                    })
                    ->editColumn('insname', function ($inscontlist) {
                        return $inscontlist->accidenttypename;
                    })
                    ->editColumn('totalcost', function ($inscontlist) {
                        return number_format($inscontlist->hcost);
                    })
                    ->editColumn('currname', function ($inscontlist) {
                        return $inscontlist->hcurrname;
                    })
                    ->editColumn('insaction', function ($inscontlist) {
                        $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/accident/edit/' . $inscontlist->id) . '" title="'. trans('page-contract.contract.titles.pdisplaycontract') .'"><i class="fa fa-eye"></i></a> ';
                        return $buttons;
                    })->rawColumns(['billstatus','ccode','insaction']);

                return $datatables->make(true);

                break;
            case "7":
                $condid = 'apersonid';
                $billstatus = 'closed';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }

                $datatables = Datatables::of($contractlist)
                    ->editColumn('id', function ($inscontlist) {
                        return $inscontlist->id;
                    })
                    ->editColumn('billid', function ($inscontlist) {
                        return $inscontlist->closed;
                    })
                    ->editColumn('billstatus', function ($inscontlist) {
                        $statusbuttons = "";
                        if ($inscontlist->closed) {
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-sts btn-sm btn-outline-success btn-block">'. trans('page-contract.contract.titles.closed') .'</a>';
                        }
                        else{
                            $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="1" class="btn btn-sts btn-sm btn-outline-danger btn-block">'. trans('page-contract.contract.titles.notclosed') .'</a>';
                        }
                        return $statusbuttons;
                    })
                    ->editColumn('ccode', function ($inscontlist) {
                        $statusbuttons = "";
                        $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> codestr.'" data-to="0" class="btn btn-code btn-sm btn-primary">'. $inscontlist -> codestr .'</a>';
                        return $statusbuttons;
                    })
                    ->editColumn('insname', function ($inscontlist) {
                        return $inscontlist->accidenttypename;
                    })
                    ->editColumn('totalcost', function ($inscontlist) {
                        return number_format($inscontlist->accost);
                    })
                    ->editColumn('currname', function ($inscontlist) {
                        return $inscontlist->currname;
                    })
                    ->editColumn('insaction', function ($inscontlist) {
                        $buttons = '<a target="_blank" class="btn btn-info btn-sm" href="' . url('/accident-list') . '" title="'. trans('page-contract.contract.titles.pdisplaycontract') .'"><i class="fa fa-eye"></i></a> ';
                        return $buttons;
                    })->rawColumns(['billstatus','ccode','insaction']);

                return $datatables->make(true);

                break;
        }
    }

    public function getpartnerslist_usd(Request $request)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $request->get('cid');
        $tbid = $request->get('tbid');
        $sqlstr = $request->get('sqlstr');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        $condid = '';
        $billstatus = '';

        switch ($tbid) {
            case "1":
                $condid = 'officeid';
                $billstatus = 'billoffice';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                }
                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "2":
                $condid = 'companyid';
                $billstatus = 'billcompanies';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                }
                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "3":
                $condid = 'brokerid';
                $billstatus = 'billbrokers';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                }

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "4":
                $condid = 'garage';
                $billstatus = 'billgarage';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('gcurr', '=', "3")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('gcurr', '=', "3")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "5":
                $condid = 'expert';
                $billstatus = 'billexpert';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('ecurr', '=', "3")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "3"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where($condid, '=', $cid)
                            ->where('ecurr', '=', "3")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "3"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }
                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "6":
                $condid = 'hospital';
                $billstatus = 'billhospital';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                             ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('hcurr', '=', "3")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                             ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                             ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where($condid, '=', $cid)
                            ->where('hcurr', '=', "3")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                             ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                           $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "7":
                $condid = 'apersonid';
                $billstatus = 'closed';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('acccurr', '=', "3")
                            ->groupBy($condid,'currname','acccurr')
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
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['acccurr', '=', "3"],
                            ])
                            ->groupBy($condid,'currname','acccurr')
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
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where($condid, '=', $cid)
                            ->where('acccurr', '=', "3")
                            ->groupBy($condid,'currname','acccurr')
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
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['acccurr', '=', "3"],
                            ])
                            ->groupBy($condid,'currname','acccurr')
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

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
        }
    }

    public function getpartnerslist_lbp(Request $request)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $request->get('cid');
        $tbid = $request->get('tbid');
        $sqlstr = $request->get('sqlstr');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        $condid = '';
        $billstatus = '';

        switch ($tbid) {
            case "1":
                $condid = 'officeid';
                $billstatus = 'billoffice';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['currid', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['currid', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','currid')
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
                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "2":
                $condid = 'companyid';
                $billstatus = 'billcompanies';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['currid', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['currid', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','currid')
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
                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "3":
                $condid = 'brokerid';
                $billstatus = 'billbrokers';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['currid', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['currid', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','currid')
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

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "4":
                $condid = 'garage';
                $billstatus = 'billgarage';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('gcurr', '=', "2")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('gcurr', '=', "2")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurr','gcurrname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    }
                }

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "5":
                $condid = 'expert';
                $billstatus = 'billexpert';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('ecurr', '=', "2")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "2"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where($condid, '=', $cid)
                            ->where('ecurr', '=', "2")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurr','ecurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "2"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    }
                }
                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "6":
                $condid = 'hospital';
                $billstatus = 'billhospital';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('hcurr', '=', "2")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where($condid, '=', $cid)
                            ->where('hcurr', '=', "2")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurr','hcurrname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "LBP";
                        }
                    }
                }

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
            case "7":
                $condid = 'apersonid';
                $billstatus = 'closed';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('acccurr', '=', "2")
                            ->groupBy($condid,'currname','acccurr')
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
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['acccurr', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','acccurr')
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
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where($condid, '=', $cid)
                            ->where('acccurr', '=', "2")
                            ->groupBy($condid,'currname','acccurr')
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
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select($condid,DB::raw('SUM(accost) AS coamount'), 'acccurr','currname')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['acccurr', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','acccurr')
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

                return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);

                break;
        }
    }

    public function changePartnersBillingStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'bid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            $tb = $request->get('tbid');
            switch ($tb) {
                case "1":
                    DB::table('condet')
                        ->where([
                            ['id', '=', $request->get('bid')],
                        ])
                        ->update(['billoffice' => $request->get('sts')]);
                    return response()->json(array('msg' => 'msg'), 200);
                    break;
                case "2":
                    DB::table('condet')
                        ->where([
                            ['id', '=', $request->get('bid')],
                        ])
                        ->update(['billcompanies' => $request->get('sts')]);
                    return response()->json(array('msg' => 'msg'), 200);
                    break;
                case "3":
                    DB::table('condet')
                        ->where([
                            ['id', '=', $request->get('bid')],
                        ])
                        ->update(['billbrokers' => $request->get('sts')]);
                    return response()->json(array('msg' => 'msg'), 200);
                    break;
                case "4":
                    DB::table('accident')
                        ->where([
                            ['id', '=', $request->get('bid')],
                        ])
                        ->update(['billgarage' => $request->get('sts')]);
                    return response()->json(array('msg' => 'msg'), 200);
                    break;
                case "5":
                    DB::table('accident')
                        ->where([
                            ['id', '=', $request->get('bid')],
                        ])
                        ->update(['billexpert' => $request->get('sts')]);
                    return response()->json(array('msg' => 'msg'), 200);
                    break;
                case "6":
                    DB::table('accident')
                        ->where([
                            ['id', '=', $request->get('bid')],
                        ])
                        ->update(['billhospital' => $request->get('sts')]);
                    return response()->json(array('msg' => 'msg'), 200);
                    break;
                case "7":
                    DB::table('accidentdet')
                        ->where([
                            ['id', '=', $request->get('bid')],
                        ])
                        ->update(['closed' => $request->get('sts')]);
                    return response()->json(array('msg' => 'msg'), 200);
                    break;
            }

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

    public function getprintpaymentslist(Request $request){
        $output = '';
        $rflagpayment = '';
        $output1 = '';
        $paymentlist = DB::table('getclient_payments')
            ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','fromaccount','transtype')
            ->where('payclientid', '=', $request->get('clientid'))
            ->where('fromaccount', '=', '2')
            ->orderBy('paydate', 'desc')
            ->get();

        $total_row = $paymentlist->count();
        if($total_row > 0) {
            $rflagpayment = "1";
            foreach ($paymentlist as $row) {
                if ($row->payamountforid == "1") {
                    $trow1 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->paydate. '</td>';
                    $trow2 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->payamount.' ' .$row->paycurr. '</td>';
                    $trow3 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->payamountfor. '</td>';
                    $trow4 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->paytype. '</td>';
                }else{
                    $trow1 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->paydate. '</td>';
                    $trow2 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->payamount.' ' .$row->paycurr. '</td>';
                    $trow3 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->payamountfor. '</td>';
                    $trow4 = '<td class="text-center " style="vertical-align: middle" width="150px">' . $row->paytype. '</td>';
                }
                $output1 .=' <tr class="paymentsrows'.$row->payid.'">
                            <td style="display:none;" >'.$row->payid.'</td>
                            '.$trow1.'
                            '.$trow2.'
                            '.$trow3.'
                            '.$trow4.'
                            <td class="text-center" style="display:none;">'.$row->payamount.'</td>
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

    public function printreceipt($payment_id)
    {
        abort_if(Gate::denies('payments_print'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data['paymentlist'] = DB::table('getclient_payments')
            ->select('payid','paydate','payamount','paycurr','payamountfor','paytype','payclientid','paytypeid','payamountforid','paycurrid','paychecknum','bankid','bankname','details','fromaccountid','toaccountid','accountname','accounttype','codestr','cname')
            ->where('payid', '=', $payment_id)
            ->get();


        $currdate = Carbon::now()->toFormattedDateString();
        $InvCode = $data['paymentlist'][0]->codestr;

//        $tafqeetInArabic = Tafqeet::inArabic($data['contratinfo'][0]->coamount,'usd');
        $tafqeetInArabic = Numbers::TafqeetMoney($data['paymentlist'][0]->payamount,$data['paymentlist'][0]->paycurr);

        return view('pages.Clients.Printout.clientsreceipt', $data)->with(compact('InvCode','tafqeetInArabic','currdate'));
    }

    public function getpaymentslist(Request $request){

        $partnerid = $request->get('cid');
        $tb = $request->get('tbid');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        switch ($tb) {
            case "1":
                $fieldid = 'officeid';
                break;
            case "2":
                $fieldid = 'compid';
                break;
            case "3":
                $fieldid = 'brokerid';
                break;
            case "4":
                $fieldid = 'garageid';
                break;
            case "5":
                $fieldid = 'expertid';
                break;
            case "6":
                $fieldid = 'hospid';
                break;
            case "7":
                $fieldid = 'apersonid';
                break;
        }
        if($partnerid != '') {
            $paymentlist = DB::table('getpartners_payments')
                ->select('payid', 'paydate', 'payamount', 'paycurr', 'payamountfor', 'paytype', 'payclientid', 'paytypeid', 'payamountforid', 'paycurrid', 'paychecknum', 'bankid', 'bankname', 'details', 'fromaccountid', 'toaccountid', 'accountname', 'accounttype', 'codestr','checkdate','contid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', $partnerid)
                ->orderBy('paydate', 'asc')
                ->get();
        }else{
            $paymentlist = DB::table('getpartners_payments')
                ->select('payid', 'paydate', 'payamount', 'paycurr', 'payamountfor', 'paytype', 'payclientid', 'paytypeid', 'payamountforid', 'paycurrid', 'paychecknum', 'bankid', 'bankname', 'details', 'fromaccountid', 'toaccountid', 'accountname', 'accounttype', 'codestr','checkdate','contid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', 'partnerid')
                ->orderBy('paydate', 'asc')
                ->get();
        }

        $datatables = Datatables::of($paymentlist)
            ->editColumn('id', function ($paylist) {
                return $paylist->payid;
            })
            ->editColumn('payactions', function ($paylist) {
                $buttons = "";
//                if (Auth::user()->can('payments_print')) {
//                    $buttons .= '<a class="btn btn-primary btn-sm inline" target="_blank" title="'. trans('page-contract.contract.tabs.printpayment') .'" href="'. route('print-receipt', $paylist->payid) .'"><i class="fa fa-print"></i></a> ';
//                }
                if (Auth::user()->can('payments_edit')) {
                    $buttons .= '<a href="javascript:;" class="edit-btn-payment btn btn-warning btn-sm inline" data-id="'.$paylist->payid.'" data-paytypeid="'.$paylist->paytypeid.'" data-paytype="'.$paylist->paytype.'" data-paychecknum="'.$paylist->paychecknum.'" data-paycheckdate="'.$paylist->checkdate.'" data-paybankid="'.$paylist->bankid.'" data-paybankname="'.$paylist->bankname.'" data-payfromaccountid="'.$paylist->fromaccountid.'" data-payfromaccount="'.$paylist->accountname.'" data-payfromaccounttype="'.$paylist->accounttype.'" data-paydetails="'.$paylist->details.'" data-payamountforid="'.$paylist->payamountforid.'" data-payamountfor="'.$paylist->payamountfor.'" data-paycurrid="'.$paylist->paycurrid.'" data-paycurr="'.$paylist->paycurr.'" data-paydate="'.$paylist->paydate.'" data-payamount="'.$paylist->payamount.'" data-contid="'.$paylist->contid.'" title="'.trans('page-contract.contract.tabs.editpayment').'"><i class="fas fa-edit"></i></a>';
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
                return $paylist->payamount . ' ' . $paylist->paycurr;
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

    public function getpaymentslist_usd(Request $request){

        $partnerid = $request->get('cid');
        $tb = $request->get('tbid');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        switch ($tb) {
            case "1":
                $fieldid = 'officeid';
                break;
            case "2":
                $fieldid = 'compid';
                break;
            case "3":
                $fieldid = 'brokerid';
                break;
            case "4":
                $fieldid = 'garageid';
                break;
            case "5":
                $fieldid = 'expertid';
                break;
            case "6":
                $fieldid = 'hospid';
                break;
            case "7":
                $fieldid = 'apersonid';
                break;
        }
        if($partnerid != '') {
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', $partnerid)
                ->where('paycurrid', '=', "3")
                ->groupBy($fieldid,'paycurr','paycurrid')
                ->get();
            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "USD";
            }
        }else{
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', 'partnerid')
                ->where('paycurrid', '=', "3")
                ->groupBy($fieldid,'paycurr','paycurrid')
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

    public function getpaymentslist_lbp(Request $request){

        $partnerid = $request->get('cid');
        $tb = $request->get('tbid');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        switch ($tb) {
            case "1":
                $fieldid = 'officeid';
                break;
            case "2":
                $fieldid = 'compid';
                break;
            case "3":
                $fieldid = 'brokerid';
                break;
            case "4":
                $fieldid = 'garageid';
                break;
            case "5":
                $fieldid = 'expertid';
                break;
            case "6":
                $fieldid = 'hospid';
                break;
            case "7":
                $fieldid = 'apersonid';
                break;
        }
        if($partnerid != '') {
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', $partnerid)
                ->where('paycurrid', '=', "2")
                ->groupBy($fieldid,'paycurr','paycurrid')
                ->get();
            if(isset($paymentlist[0]->coamount)) {
                $rec2 = number_format($paymentlist[0]->coamount);
                $rec3 = $paymentlist[0]->paycurr;
            }else{
                $rec2 = "0";
                $rec3 = "LBP";
            }
        }else{
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', 'partnerid')
                ->where('paycurrid', '=', "2")
                ->groupBy($fieldid,'paycurr','paycurrid')
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
                'amount' =>'required',
//                'contid' =>'required',
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
            $tb = $request->get('tbid');
            switch ($tb) {
                case "1":
                  $fieldid = 'officeid';
                  $partnerid = '1';
                    break;
                case "2":
                    $fieldid = 'compid';
                    $partnerid = '2';
                    break;
                case "3":
                    $fieldid = 'brokerid';
                    $partnerid = '3';
                    break;
                case "4":
                    $fieldid = 'garageid';
                    $partnerid = '4';
                    break;
                case "5":
                    $fieldid = 'expertid';
                    $partnerid = '5';
                    break;
                case "6":
                    $fieldid = 'hospid';
                    $partnerid = '6';
                    break;
                case "7":
                    $fieldid = 'apersonid';
                    $partnerid = '7';
                    break;
            }

            $values_to_insert = [
                'branch' => $bIds,
                $fieldid => $request->get('person'),
                'paymentdate' => $request->get('paymentdate'),
                'paymenttype' => $request->get('paymenttype'),
                'amount' => $request->get('amount'),
//                'contid' => $request->get('contid'),
                'curr' => $request->get('curr'),
                'amountfor' => $request->get('amountfor'),
                'checknum' => $request->get('checknum'),
                'checkdate' => $request->get('checkdate'),
                'bank' => $request->get('bank'),
                'details' => $request->get('pdetails'),
                'fromaccount' => $request->get('fromaccount'),
                'codenum' => $recunum[0]->recunum,
                'codestr' => $codestr,
                'partner' => $partnerid,
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
                'amount' =>'required',
//                'contid' =>'required',
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


            $data =  DB::table('clientpayments')
                ->where('id', $request->get('id'))
                ->update([
                    'paymentdate' => $request->get('paymentdate'),
                    'paymenttype' => $request->get('paymenttype'),
                    'amount' => $request->get('amount'),
//                    'contid' => $request->get('contid'),
                    'curr' => $request->get('curr'),
                    'amountfor' => $request->get('amountfor'),
                    'checknum' => $request->get('checknum'),
                    'checkdate' => $request->get('checkdate'),
                    'bank' => $request->get('bank'),
                    'details' => $request->get('pdetails'),
                    'fromaccount' => $request->get('fromaccount'),
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

    public function gettransactioncashierlist(Request $request)
    {
        abort_if(Gate::denies('cashier_transaction_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $from = $request->get('fromdate');
        $to = $request->get('todate');
        $partner = $request->get('partnerid');

        if($partner != '') {
            if (Auth::user()->can('all_access')) {
                $exptlist = DB::table('getoffice_transactions')
                    ->select('payid', 'payclientid', 'exptypeid', 'cname', 'payamount', 'payamountfor', 'paycurrid', 'paycurr', 'branchid', 'brname', 'exptype', 'paytypeid', 'paytype', 'paychecknum', 'accountname', 'accounttype', 'hospname', 'bankname', 'officename', 'brokername', 'garagename', 'expertname', 'apersonname', 'compname', 'partner','details','paydate')
                    ->whereBetween('paydate', [$from, $to])
                    ->where('partner','=',$partner)
                    ->orderBy('paydate', 'desc')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $exptlist = DB::table('getoffice_transactions')
                    ->select('payid', 'payclientid', 'exptypeid', 'cname', 'payamount', 'payamountfor', 'paycurrid', 'paycurr', 'branchid', 'brname', 'exptype', 'paytypeid', 'paytype', 'paychecknum', 'accountname', 'accounttype', 'hospname', 'bankname', 'officename', 'brokername', 'garagename', 'expertname', 'apersonname', 'compname', 'partner','details','paydate')
                    ->where('branchid', '=', $bIds)
                    ->where('partner','=',$partner)
                    ->whereBetween('paydate', [$from, $to])
                    ->orderBy('paydate', 'desc')
                    ->get();
            }
        }else{
            if (Auth::user()->can('all_access')) {
                $exptlist = DB::table('getoffice_transactions')
                    ->select('payid', 'payclientid', 'exptypeid', 'cname', 'payamount', 'payamountfor', 'paycurrid', 'paycurr', 'branchid', 'brname', 'exptype', 'paytypeid', 'paytype', 'paychecknum', 'accountname', 'accounttype', 'hospname', 'bankname', 'officename', 'brokername', 'garagename', 'expertname', 'apersonname', 'compname', 'partner','details','paydate')
                    ->whereBetween('paydate', [$from, $to])
                    ->orderBy('paydate', 'desc')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $exptlist = DB::table('getoffice_transactions')
                    ->select('payid', 'payclientid', 'exptypeid', 'cname', 'payamount', 'payamountfor', 'paycurrid', 'paycurr', 'branchid', 'brname', 'exptype', 'paytypeid', 'paytype', 'paychecknum', 'accountname', 'accounttype', 'hospname', 'bankname', 'officename', 'brokername', 'garagename', 'expertname', 'apersonname', 'compname', 'partner','details','paydate')
                    ->where('branchid', '=', $bIds)
                    ->whereBetween('paydate', [$from, $to])
                    ->orderBy('paydate', 'desc')
                    ->get();
            }
        }

        $datatables = Datatables::of($exptlist)
            ->editColumn('trid', function ($exp) {
                return $exp->payid;
            })
            ->editColumn('trbranch', function ($exp) {
                return $exp->brname;
            })
            ->editColumn('trdate', function ($exp) {
                return $exp->paydate;
            })
            ->editColumn('trname', function ($exp) {
                return $exp->accountname;
            })
            ->editColumn('trclient', function ($exp) {
                switch ($exp->partner) {
                    case "1":
                        return $exp->officename;
                        break;
                    case "2":
                        return $exp->compname;
                        break;
                    case "3":
                        return $exp->brokername;
                        break;
                    case "4":
                        return $exp->garagename;
                        break;
                    case "5":
                        return $exp->expertname;
                        break;
                    case "6":
                        return $exp->hospname;
                        break;
                    case "7":
                        return $exp->apersonname;
                        break;
                    case "9":
                        return $exp->cname;
                        break;
                    case "10":
                        return $exp->exptype;
                        break;
                }
            })
            ->editColumn('tramountin', function ($exp) {
                switch ($exp->accounttype) {
                    case "IN":
                        return number_format($exp->payamount);
                        break;
                    case "OUT":
                        return "0";
                        break;
                }
            })
            ->editColumn('tramountout', function ($exp) {
                switch ($exp->accounttype) {
                    case "IN":
                        return "0";
                        break;
                    case "OUT":
                        return number_format($exp->payamount);
                        break;
                }
            })
            ->editColumn('trcurr', function ($exp) {
                return $exp->paycurr;
            })
            ->editColumn('trtype', function ($exp) {
                return $exp->paytype;
            })
            ->editColumn('trcheck', function ($exp) {
                return $exp->paychecknum;
            })
            ->editColumn('trbank', function ($exp) {
                return $exp->bankname;
            })
            ->editColumn('trdetails', function ($exp) {
                return $exp->details;
            });

        return $datatables->make(true);

    }

    public function transactionscahier()
    {
        abort_if(Gate::denies('cashier_transaction_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data['partnerslist'] = DB::table('partners')
            ->select('id', 'partner')
            ->where('active','=','1')
            ->get();
        return view('pages.Reports.cashier',$data);
    }

    public function getcashier_usd(Request $request){

        $from = $request->get('fromdate');
        $to = $request->get('todate');
        $partner = $request->get('partnerid');

        if($partner != '') {
            if (Auth::user()->can('all_access')) {
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->whereBetween('paydate', [$from, $to])
                    ->where('partner','=',$partner)
                    ->where('paycurrid', '=', "3")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->where('branchid', '=', $bIds)
                    ->where('partner','=',$partner)
                    ->whereBetween('paydate', [$from, $to])
                    ->where('paycurrid', '=', "3")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            }
        }else{
            if (Auth::user()->can('all_access')) {
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->whereBetween('paydate', [$from, $to])
                    ->where('paycurrid', '=', "3")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->where('branchid', '=', $bIds)
                    ->whereBetween('paydate', [$from, $to])
                    ->where('paycurrid', '=', "3")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            }
        }
        $recout = '0';
        $recin = '0';
        $rec = 'USD';
        foreach ($exptlist as $key=>$exp) {
            switch ($exp->accounttype) {
                case "IN":
                    if(isset($exp->coamount)) {
                        $recin = number_format($exp->coamount);
                        $rec3 = $exp->paycurr;
                    }else{
                        $recin = "0";
                        $rec3 = "USD";
                    }
                    break;
                case "OUT":
                    if(isset($exp->coamount)) {
                        $recout = number_format($exp->coamount);
                        $rec3 = $exp->paycurr;
                    }else{
                        $recout = "0";
                        $rec3 = "USD";
                    }
                    break;
            }
        }

        return response()->json(['ramountin'=> $recin,'ramountout'=> $recout,'rcurr' => $rec3]);
    }

    public function getcashier_lbp(Request $request){

        $from = $request->get('fromdate');
        $to = $request->get('todate');
        $partner = $request->get('partnerid');

        if($partner != '') {
            if (Auth::user()->can('all_access')) {
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->whereBetween('paydate', [$from, $to])
                    ->where('partner','=',$partner)
                    ->where('paycurrid', '=', "2")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->where('branchid', '=', $bIds)
                    ->where('partner','=',$partner)
                    ->whereBetween('paydate', [$from, $to])
                    ->where('paycurrid', '=', "2")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            }
        }else{
            if (Auth::user()->can('all_access')) {
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->whereBetween('paydate', [$from, $to])
                    ->where('paycurrid', '=', "2")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $exptlist = DB::table('getoffice_transactions')
                    ->select('partner',DB::raw('SUM(payamount) AS coamount'), 'paycurrid', 'paycurr','accounttype')
                    ->where('branchid', '=', $bIds)
                    ->whereBetween('paydate', [$from, $to])
                    ->where('paycurrid', '=', "2")
                    ->groupBy('paycurr','paycurrid','accounttype')
                    ->get();
            }
        }
        $recout = '0';
        $recin = '0';
        $rec3 = 'LBP';
        foreach ($exptlist as $key=>$exp) {
            switch ($exp->accounttype) {
                case "IN":
                    if(isset($exp->coamount)) {
                        $recin = number_format($exp->coamount);
                        $rec3 = $exp->paycurr;
                    }else{
                        $recin = "0";
                        $rec3 = "LBP";
                    }
                    break;
                case "OUT":
                    if(isset($exp->coamount)) {
                        $recout = number_format($exp->coamount);
                        $rec3 = $exp->paycurr;
                    }else{
                        $recout = "0";
                        $rec3 = "LBP";
                    }
                    break;
            }
        }

        return response()->json(['ramountin'=> $recin,'ramountout'=> $recout,'rcurr' => $rec3]);
    }

    public function getpartnersprintout($id,$pid,$pdates)
{
    abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

    $cid = $id;
    $tbid = $pid;
    $sqlstr = '';
    $fdate = $pdates;
    $fdates = explode("_", $fdate);
    $from = $fdates[0];
    $to = $fdates[1];
    $billoption = "كل الفواتير";

    $condid = '';
    $billstatus = '';
    $count = '';

    switch ($tbid) {
        case "1":
            $condid = 'officeid';
            $billstatus = 'billoffice';

            $data['partnername'] = DB::table('clients')
                ->select('cname as pname')
                ->where('id', '=', $cid)
                ->get();

            $data['partnertype'] = DB::table('partners')
                ->select('partner as ptype')
                ->where('id', '=', '1')
                ->get();

            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }

            // from here calcalute the USD Dollars Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
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
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
            }

            // from here calculate the LBP Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
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
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
            }

            return view('pages.Reports.partners_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));

            break;
        case "2":
            $condid = 'companyid';
            $billstatus = 'billcompanies';

            $data['partnername'] = DB::table('companies')
                ->select('compname as pname')
                ->where('id', '=', $cid)
                ->get();

            $data['partnertype'] = DB::table('partners')
                ->select('partner as ptype')
                ->where('id', '=', '2')
                ->get();

            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }

            // from here calcalute the USD Dollars Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
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
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
            }

            // from here calculate the LBP Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
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
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
            }

            return view('pages.Reports.partners_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));


            break;
        case "3":
            $condid = 'brokerid';
            $billstatus = 'billbrokers';

            $data['partnername'] = DB::table('clients')
                ->select('cname as pname')
                ->where('id', '=', $cid)
                ->get();

            $data['partnertype'] = DB::table('partners')
                ->select('partner as ptype')
                ->where('id', '=', '3')
                ->get();


            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('partners_actions_det_print_out')
                        ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }

            // from here calcalute the USD Dollars Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
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
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
            }

            // from here calcalute the USD Dollars Sum for broker clients
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('currid', '=', "3")
                        ->groupBy($condid,'currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2broker = number_format($contractlist[0]->coamount);
                        $rec3broker = $contractlist[0]->currname;
                    }else{
                        $rec2broker = "0";
                        $rec3broker = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['currid', '=', "3"],
                        ])
                        ->groupBy($condid,'currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2broker = number_format($contractlist[0]->coamount);
                        $rec3broker = $contractlist[0]->currname;
                    }else{
                        $rec2broker = "0";
                        $rec3broker = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('currid', '=', "3")
                        ->groupBy($condid,'currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2broker = number_format($contractlist[0]->coamount);
                        $rec3broker = $contractlist[0]->currname;
                    }else{
                        $rec2broker = "0";
                        $rec3broker = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('partners_actions_det')
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
                        $rec2broker = number_format($contractlist[0]->coamount);
                        $rec3broker = $contractlist[0]->currname;
                    }else{
                        $rec2broker = "0";
                        $rec3broker = "USD";
                    }
                }
            }


            // from here calculate the LBP Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
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
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
            }

            // from here calculate the LBP Sum for broker clients
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('currid', '=', "2")
                        ->groupBy($condid,'currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22broker = number_format($contractlist[0]->coamount);
                        $rec33broker = $contractlist[0]->currname;
                    }else{
                        $rec22broker = "0";
                        $rec33broker = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['currid', '=', "2"],
                        ])
                        ->groupBy($condid,'currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22broker = number_format($contractlist[0]->coamount);
                        $rec33broker = $contractlist[0]->currname;
                    }else{
                        $rec22broker = "0";
                        $rec33broker = "LBP";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('partners_actions_det')
                        ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                        ->whereBetween('codate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('currid', '=', "2")
                        ->groupBy($condid,'currname','currid')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22broker = number_format($contractlist[0]->coamount);
                        $rec33broker = $contractlist[0]->currname;
                    }else{
                        $rec22broker = "0";
                        $rec33broker = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('partners_actions_det')
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
                        $rec22broker = number_format($contractlist[0]->coamount);
                        $rec33broker = $contractlist[0]->currname;
                    }else{
                        $rec22broker = "0";
                        $rec33broker = "LBP";
                    }
                }
            }

            return view('pages.Reports.partners_statements_brokers', $data)->with(compact('rec2','rec3','rec22','rec33','rec2broker','rec3broker','rec22broker','rec33broker','billoption','count','billstatus','from','to'));

            break;
        case "4":
            $condid = 'garage';
            $billstatus = 'billgarage';

            $data['partnername'] = DB::table('clients')
                ->select('cname as pname')
                ->where('id', '=', $cid)
                ->get();

            $data['partnertype'] = DB::table('partners')
                ->select('partner as ptype')
                ->where('id', '=', '4')
                ->get();

            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }

            // from here calcalute the USD Dollars Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('gcurr', '=', "3")
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->gcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['gcurr', '=', "3"],
                        ])
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->gcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('gcurr', '=', "3")
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->gcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                            ['gcurr', '=', "3"],
                        ])
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->gcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }

            // from here calculate the LBP Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('gcurr', '=', "2")
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->gcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['gcurr', '=', "2"],
                        ])
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->gcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                }
                }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('gcurr', '=', "2")
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->gcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                            ['gcurr', '=', "2"],
                        ])
                        ->groupBy($condid,'gcurrname','gcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->gcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                }
            }
            return view('pages.Reports.partners_statements_accidents', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));
            break;
        case "5":
            $condid = 'expert';
            $billstatus = 'billexpert';

            $data['partnername'] = DB::table('clients')
                ->select('cname as pname')
                ->where('id', '=', $cid)
                ->get();

            $data['partnertype'] = DB::table('partners')
                ->select('partner as ptype')
                ->where('id', '=', '5')
                ->get();

            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }

            // from here calcalute the USD Dollars Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('ecurr', '=', "3")
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->ecurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['ecurr', '=', "3"],
                        ])
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->ecurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('ecurr', '=', "3")
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->ecurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                            ['ecurr', '=', "3"],
                        ])
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->ecurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }

            // from here calculate the LBP Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('ecurr', '=', "2")
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->ecurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['ecurr', '=', "2"],
                        ])
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->ecurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('ecurr', '=', "2")
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->ecurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                            ['ecurr', '=', "2"],
                        ])
                        ->groupBy($condid,'ecurrname','ecurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->ecurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                }
            }
            return view('pages.Reports.partners_statements_accidents_experts', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));
            break;
        case "6":
            $condid = 'hospital';
            $billstatus = 'billhospital';

            $data['partnername'] = DB::table('hospitals')
                ->select('Description as pname')
                ->where('id', '=', $cid)
                ->get();

            $data['partnertype'] = DB::table('partners')
                ->select('partner as ptype')
                ->where('id', '=', '6')
                ->get();

            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $data['contractlist'] = DB::table('getaccidents')
                        ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy($billstatus, 'asc')
                        ->get();
                    $count = $data['contractlist']->count();
                }
            }

            // from here calcalute the USD Dollars Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('hcurr', '=', "3")
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->hcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['hcurr', '=', "3"],
                        ])
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->hcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('hcurr', '=', "3")
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->hcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                            ['hcurr', '=', "3"],
                        ])
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec2 = number_format($contractlist[0]->coamount);
                        $rec3 = $contractlist[0]->hcurrname;
                    }else{
                        $rec2 = "0";
                        $rec3 = "USD";
                    }
                }
            }

            // from here calculate the LBP Sum
            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->where('hcurr', '=', "2")
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->hcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                            ['hcurr', '=', "2"],
                        ])
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->hcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where($condid, '=', $cid)
                        ->where('hcurr', '=', "2")
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->hcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidents')
                        ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                        ->whereBetween('accdate', [$from, $to])
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                            ['hcurr', '=', "2"],
                        ])
                        ->groupBy($condid,'hcurrname','hcurr')
                        ->get();
                    if(isset($contractlist[0]->coamount)) {
                        $rec22 = number_format($contractlist[0]->coamount);
                        $rec33 = $contractlist[0]->hcurrname;
                    }else{
                        $rec22 = "0";
                        $rec33 = "LBP";
                    }
                }
            }
            return view('pages.Reports.partners_statements_accidents_hospitals', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));
            break;
        case "7":
            $condid = 'apersonid';
            $billstatus = 'closed';

            if($sqlstr != '') {
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidentsaperson')
                        ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                        ->where($condid, '=', $cid)
                        ->where($billstatus, '=', $sqlstr)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidentsaperson')
                        ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$billstatus, '=', $sqlstr],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy('billclosed', 'asc')
                        ->get();
                }
            }else{
                if (Auth::user()->can('all_access')) {
                    $contractlist = DB::table('getaccidentsaperson')
                        ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                        ->where($condid, '=', $cid)
                        ->orderBy($billstatus, 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $contractlist = DB::table('getaccidentsaperson')
                        ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                        ->where([
                            ['branch_id', '=', $bIds],
                            [$condid, '=', $cid],
                        ])
                        ->orderBy($billstatus, 'asc')
                        ->get();
                }
            }



            break;
    }
}

    public function getpartnersprintoutoptions($id,$pid,$sql,$pdates)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cid = $id;
        $tbid = $pid;
        $sqlstr = $sql;
        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];

        if($sqlstr == "1"){
           $billoption = "الفواتير المدفوعة";
        }elseif($sqlstr == "0"){
            $billoption = "الفواتير الغير مدفوعة";
        }

        $condid = '';
        $billstatus = '';
        $count = '';

        switch ($tbid) {
            case "1":
                $condid = 'officeid';
                $billstatus = 'billoffice';

                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $cid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '1')
                    ->get();

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }

                // from here calcalute the USD Dollars Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                }

                // from here calculate the LBP Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
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
                }

                return view('pages.Reports.partners_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));

                break;
            case "2":
                $condid = 'companyid';
                $billstatus = 'billcompanies';

                $data['partnername'] = DB::table('companies')
                    ->select('compname as pname')
                    ->where('id', '=', $cid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '2')
                    ->get();

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }

                // from here calcalute the USD Dollars Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                }

                // from here calculate the LBP Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
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
                }

                return view('pages.Reports.partners_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));


                break;
            case "3":
                $condid = 'brokerid';
                $billstatus = 'billbrokers';

                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $cid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '3')
                    ->get();


                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('partners_actions_det_print_out')
                            ->select('id', 'client', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','companyid','billcompanies','officeid','billoffice','brokerid','billbrokers','officeshare','brokershare','netcost','carname','platnumber','maidname','passport','compname','coname','sdate','edate')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }

                // from here calcalute the USD Dollars Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                }


                // from here calcalute the USD Dollars Sum for broker clients
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('currid', '=', "3")
                            ->groupBy($condid,'currname','currid')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2broker = number_format($contractlist[0]->coamount);
                            $rec3broker = $contractlist[0]->currname;
                        }else{
                            $rec2broker = "0";
                            $rec3broker = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['currid', '=', "3"],
                            ])
                            ->groupBy($condid,'currname','currid')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2broker = number_format($contractlist[0]->coamount);
                            $rec3broker = $contractlist[0]->currname;
                        }else{
                            $rec2broker = "0";
                            $rec3broker = "USD";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('currid', '=', "3")
                            ->groupBy($condid,'currname','currid')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2broker = number_format($contractlist[0]->coamount);
                            $rec3broker = $contractlist[0]->currname;
                        }else{
                            $rec2broker = "0";
                            $rec3broker = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
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
                            $rec2broker = number_format($contractlist[0]->coamount);
                            $rec3broker = $contractlist[0]->currname;
                        }else{
                            $rec2broker = "0";
                            $rec3broker = "USD";
                        }
                    }
                }


                // from here calculate the LBP Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
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
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
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
                }

                // from here calculate the LBP Sum for broker clients
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22broker = number_format($contractlist[0]->coamount);
                            $rec33broker = $contractlist[0]->currname;
                        }else{
                            $rec22broker = "0";
                            $rec33broker = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['currid', '=', "2"],
                            ])
                            ->groupBy($condid,'currname','currid')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22broker = number_format($contractlist[0]->coamount);
                            $rec33broker = $contractlist[0]->currname;
                        }else{
                            $rec22broker = "0";
                            $rec33broker = "LBP";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('partners_actions_det')
                            ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                            ->whereBetween('codate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('currid', '=', "2")
                            ->groupBy($condid,'currname','currid')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22broker = number_format($contractlist[0]->coamount);
                            $rec33broker = $contractlist[0]->currname;
                        }else{
                            $rec22broker = "0";
                            $rec33broker = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('partners_actions_det')
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
                            $rec22broker = number_format($contractlist[0]->coamount);
                            $rec33broker = $contractlist[0]->currname;
                        }else{
                            $rec22broker = "0";
                            $rec33broker = "LBP";
                        }
                    }
                }

                return view('pages.Reports.partners_statements_brokers', $data)->with(compact('rec2','rec3','rec22','rec33','rec2broker','rec3broker','rec22broker','rec33broker','billoption','count','billstatus','from','to'));

                break;
            case "4":
                $condid = 'garage';
                $billstatus = 'billgarage';

                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $cid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '4')
                    ->get();

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }

                // from here calcalute the USD Dollars Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('gcurr', '=', "3")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('gcurr', '=', "3")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->gcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }

                // from here calculate the LBP Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('gcurr', '=', "2")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->gcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->gcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('gcurr', '=', "2")
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->gcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['gcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'gcurrname','gcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->gcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    }
                }

                return view('pages.Reports.partners_statements_accidents', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));
                break;
            case "5":
                $condid = 'expert';
                $billstatus = 'billexpert';

                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $cid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '5')
                    ->get();

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }

                // from here calcalute the USD Dollars Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('ecurr', '=', "3")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "3"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('ecurr', '=', "3")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "3"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->ecurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }

                // from here calculate the LBP Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('ecurr', '=', "2")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->ecurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "2"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->ecurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('ecurr', '=', "2")
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->ecurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['ecurr', '=', "2"],
                            ])
                            ->groupBy($condid,'ecurrname','ecurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->ecurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    }
                }
                return view('pages.Reports.partners_statements_accidents_experts', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));
                break;
            case "6":
                $condid = 'hospital';
                $billstatus = 'billhospital';

                $data['partnername'] = DB::table('hospitals')
                    ->select('Description as pname')
                    ->where('id', '=', $cid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '6')
                    ->get();

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $data['contractlist'] = DB::table('getaccidents')
                            ->select('id', 'accdate', 'accidenttypename', 'regname', 'garage', 'gcost', 'gcurr','gcurrname','compacccode','codestr','carname','carnumber','expert','ecost','ecurrname','hospital','hospitalname','hcost','hcurrname','details','totalcost','currname','billclosed','billgarage','billexpert','billhospital','garagename','expertname','clientcarname','cname','ccode','insname')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                        $count = $data['contractlist']->count();
                    }
                }

                // from here calcalute the USD Dollars Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('hcurr', '=', "3")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('hcurr', '=', "3")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "3"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec2 = number_format($contractlist[0]->coamount);
                            $rec3 = $contractlist[0]->hcurrname;
                        }else{
                            $rec2 = "0";
                            $rec3 = "USD";
                        }
                    }
                }

                // from here calculate the LBP Sum
                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->where('hcurr', '=', "2")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->hcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->hcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where($condid, '=', $cid)
                            ->where('hcurr', '=', "2")
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->hcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidents')
                            ->select($condid,DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                            ->whereBetween('accdate', [$from, $to])
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                                ['hcurr', '=', "2"],
                            ])
                            ->groupBy($condid,'hcurrname','hcurr')
                            ->get();
                        if(isset($contractlist[0]->coamount)) {
                            $rec22 = number_format($contractlist[0]->coamount);
                            $rec33 = $contractlist[0]->hcurrname;
                        }else{
                            $rec22 = "0";
                            $rec33 = "LBP";
                        }
                    }
                }
                return view('pages.Reports.partners_statements_accidents_hospitals', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','from','to'));
                break;
            case "7":
                $condid = 'apersonid';
                $billstatus = 'closed';

                if($sqlstr != '') {
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where($condid, '=', $cid)
                            ->where($billstatus, '=', $sqlstr)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$billstatus, '=', $sqlstr],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy('billclosed', 'asc')
                            ->get();
                    }
                }else{
                    if (Auth::user()->can('all_access')) {
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where($condid, '=', $cid)
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    } else {
                        $bIds = Auth::user()->branch_id;
                        $contractlist = DB::table('getaccidentsaperson')
                            ->select('id', 'accdate', 'accidenttypename', 'accidentid', 'apersonid', 'apersonname', 'accost','currname','closed','codestr','adetails')
                            ->where([
                                ['branch_id', '=', $bIds],
                                [$condid, '=', $cid],
                            ])
                            ->orderBy($billstatus, 'asc')
                            ->get();
                    }
                }



                break;
        }
    }

    public function getpartnerspaymentsprintout($id,$pid,$pdates){

        $partnerid = $id;
        $tb = $pid;
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
        $albpbroker = '';
        $clbpbroker = '';
        $ausdbroker = '';
        $cusdbroker = '';
        $ausd1broker = '';
        $albp1broker = '';

        $fromwhere = '0';
        switch ($tb) {
            case "1":
                $fieldid = 'officeid';
                $condid = 'officeid';
                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $partnerid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '1')
                    ->get();

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
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

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(officeshare) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
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
                $fromwhere = '0';
                break;
            case "2":
                $fieldid = 'compid';
                $condid = 'companyid';
                $data['partnername'] = DB::table('companies')
                    ->select('compname as pname')
                    ->where('id', '=', $partnerid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '2')
                    ->get();

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
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

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(netcost) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
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
                $fromwhere = '0';
                break;
            case "3":
                $fieldid = 'brokerid';
                $condid = 'brokerid';
                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $partnerid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '3')
                    ->get();

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
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

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('currid', '=', "2")
                    ->groupBy($condid,'currname','currid')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $albpbroker = number_format($contractlist[0]->coamount);
                    $albp1broker = $contractlist[0]->coamount;
                    $clbpbroker = $contractlist[0]->currname;
                }else{
                    $albpbroker = "0";
                    $albp1broker = "0";
                    $clbpbroker = "LBP";
                }

//                Get Total in USD

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(brokershare) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
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

                $contractlist = DB::table('partners_actions_det')
                    ->select($condid, DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                    ->whereBetween('codate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('currid', '=', "3")
                    ->groupBy($condid,'currname','currid')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $ausdbroker = number_format($contractlist[0]->coamount);
                    $ausd1broker = $contractlist[0]->coamount;
                    $cusdbroker = $contractlist[0]->currname;
                }else{
                    $ausdbroker = "0";
                    $ausd1broker = "0";
                    $cusdbroker = "USD";
                }
                $fromwhere = '1';
                break;
            case "4":
                $fieldid = 'garageid';
                $condid = 'garage';
                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $partnerid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '4')
                    ->get();

                $contractlist = DB::table('getaccidents')
                    ->select($condid, DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                    ->whereBetween('accdate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('gcurr', '=', "2")
                    ->groupBy($condid,'gcurrname','gcurr')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $albp = number_format($contractlist[0]->coamount);
                    $albp1 = $contractlist[0]->coamount;
                    $clbp = $contractlist[0]->gcurrname;
                }else{
                    $albp = "0";
                    $albp1 = "0";
                    $clbp = "LBP";
                }

                $contractlist = DB::table('getaccidents')
                    ->select($condid, DB::raw('SUM(gcost) AS coamount'), 'gcurrname','gcurr')
                    ->whereBetween('accdate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('gcurr', '=', "3")
                    ->groupBy($condid,'gcurrname','gcurr')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $ausd = number_format($contractlist[0]->coamount);
                    $ausd1 = $contractlist[0]->coamount;
                    $cusd = $contractlist[0]->gcurrname;
                }else{
                    $ausd = "0";
                    $ausd1 = "0";
                    $cusd = "USD";
                }
                $fromwhere = '0';
                break;
            case "5":
                $fieldid = 'expertid';
                $condid = 'expert';

                $data['partnername'] = DB::table('clients')
                    ->select('cname as pname')
                    ->where('id', '=', $partnerid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '5')
                    ->get();

                $contractlist = DB::table('getaccidents')
                    ->select($condid, DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                    ->whereBetween('accdate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('ecurr', '=', "2")
                    ->groupBy($condid,'ecurrname','ecurr')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $albp = number_format($contractlist[0]->coamount);
                    $albp1 = $contractlist[0]->coamount;
                    $clbp = $contractlist[0]->ecurrname;
                }else{
                    $albp = "0";
                    $albp1 = "0";
                    $clbp = "LBP";
                }

                $contractlist = DB::table('getaccidents')
                    ->select($condid, DB::raw('SUM(ecost) AS coamount'), 'ecurrname','ecurr')
                    ->whereBetween('accdate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('ecurr', '=', "3")
                    ->groupBy($condid,'ecurrname','ecurr')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $ausd = number_format($contractlist[0]->coamount);
                    $ausd1 = $contractlist[0]->coamount;
                    $cusd = $contractlist[0]->ecurrname;
                }else{
                    $ausd = "0";
                    $ausd1 = "0";
                    $cusd = "USD";
                }
                $fromwhere = '0';
                break;
            case "6":
                $fieldid = 'hospid';
                $condid = 'hospital';

                $data['partnername'] = DB::table('hospitals')
                    ->select('Description as pname')
                    ->where('id', '=', $partnerid)
                    ->get();

                $data['partnertype'] = DB::table('partners')
                    ->select('partner as ptype')
                    ->where('id', '=', '6')
                    ->get();

                $contractlist = DB::table('getaccidents')
                    ->select($condid, DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                    ->whereBetween('accdate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('hcurr', '=', "2")
                    ->groupBy($condid,'hcurrname','hcurr')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $albp = number_format($contractlist[0]->coamount);
                    $albp1 = $contractlist[0]->coamount;
                    $clbp = $contractlist[0]->hcurrname;
                }else{
                    $albp = "0";
                    $albp1 = "0";
                    $clbp = "LBP";
                }

                $contractlist = DB::table('getaccidents')
                    ->select($condid, DB::raw('SUM(hcost) AS coamount'), 'hcurrname','hcurr')
                    ->whereBetween('accdate', [$from, $to])
                    ->where($condid, '=', $partnerid)
                    ->where('hcurr', '=', "3")
                    ->groupBy($condid,'hcurrname','hcurr')
                    ->get();
                if(isset($contractlist[0]->coamount)) {
                    $ausd = number_format($contractlist[0]->coamount);
                    $ausd1 = $contractlist[0]->coamount;
                    $cusd = $contractlist[0]->hcurrname;
                }else{
                    $ausd = "0";
                    $ausd1 = "0";
                    $cusd = "USD";
                }
                $fromwhere = '0';
                break;
            case "7":
                $fieldid = 'apersonid';
                $fromwhere = '0';
                break;
        }

        if($partnerid != '') {
            $data['paymentlist'] = DB::table('getpartners_payments')
                ->select('payid', 'paydate', 'payamount', 'paycurr', 'payamountfor', 'paytype', 'payclientid', 'paytypeid', 'payamountforid', 'paycurrid', 'paychecknum', 'bankid', 'bankname', 'details', 'fromaccountid', 'toaccountid', 'accountname', 'accounttype', 'codestr','checkdate')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', $partnerid)
                ->orderBy('paydate', 'desc')
                ->get();
            $count = $data['paymentlist']->count();
        }else{
            $data['paymentlist'] = DB::table('getpartners_payments')
                ->select('payid', 'paydate', 'payamount', 'paycurr', 'payamountfor', 'paytype', 'payclientid', 'paytypeid', 'payamountforid', 'paycurrid', 'paychecknum', 'bankid', 'bankname', 'details', 'fromaccountid', 'toaccountid', 'accountname', 'accounttype', 'codestr','checkdate')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', 'partnerid')
                ->orderBy('paydate', 'desc')
                ->get();
            $count = $data['paymentlist']->count();
        }

//        From here get sum of USD Amounts

        if($partnerid != '') {
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', $partnerid)
                ->where('paycurrid', '=', "3")
                ->groupBy($fieldid,'paycurr','paycurrid')
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
        }else{
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', 'partnerid')
                ->where('paycurrid', '=', "3")
                ->groupBy($fieldid,'paycurr','paycurrid')
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
        }

        //        From here get sum of LBP Amounts

        if($partnerid != '') {
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', $partnerid)
                ->where('paycurrid', '=', "2")
                ->groupBy($fieldid,'paycurr','paycurrid')
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
        }else{
            $paymentlist = DB::table('getpartners_payments')
                ->select($fieldid,DB::raw('SUM(payamount) AS coamount'), 'paycurr', 'paycurrid')
                ->whereBetween('paydate', [$from, $to])
                ->where($fieldid, '=', 'partnerid')
                ->where('paycurrid', '=', "2")
                ->groupBy($fieldid,'paycurr','paycurrid')
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
        }
            if($fromwhere == '1'){
                $remainusd = ($ausd1broker - $ausd1) - $rec2usd;
                $remainlbp = ($albp1broker - $albp1) - $rec22lbp;
                $totalbrokerusd = number_format($ausd1broker - $ausd1);
                $totalbrokerlbp = number_format($albp1broker - $albp1);
            }else{
                $remainusd = $ausd1 - $rec2usd;
                $remainlbp = $albp1  - $rec22lbp;
                $totalbrokerusd = '0';
                $totalbrokerlbp = '0';
            }

        return view('pages.Reports.partners_payments', $data)->with(compact('totalbrokerusd','totalbrokerlbp','rec2','rec3','rec22','rec33','count','albp','clbp','ausd','cusd','albpbroker','clbpbroker','ausdbroker','cusdbroker','remainusd','remainlbp','from','to','fromwhere'));
    }
}
