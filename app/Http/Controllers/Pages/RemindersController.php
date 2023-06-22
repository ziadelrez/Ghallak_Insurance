<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\DataTables;

class RemindersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sms_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sett = DB::table('settings')
            ->select('reminder','smsrenew','smspayment')
            ->get();

        $brokerslist = DB::table('clients')
            ->select('id', 'cname')
            ->where('broker', '=', '1')
            ->where('cname', '<>', 'NONE')
            ->orderBy('cname')
            ->get();

        $followlist = DB::table('followperson')
            ->select('id', 'Description')
            ->where('Description', '<>', 'NONE')
            ->orderBy('Description')
            ->get();

        $settdays = $sett[0]->reminder;
        $settsmsrenew = $sett[0]->smsrenew;
        $settsmspayment = $sett[0]->smspayment;

        return view('pages.Reminders.reminders',compact('settsmsrenew','settsmspayment','brokerslist','followlist'));

    }

    public function remindersresults(Request $request)
    {
        abort_if(Gate::denies('sms_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sqlstr = $request->get('sqlstr');
        $sqlstrstatus = $request->get('sqlstrstatus');
        $msgtype = $request->get('msgtype');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        $sett = DB::table('settings')
            ->select('reminder','smsrenew','smspayment')
            ->get();

        $settdays = $sett[0]->reminder;
        $settsmsrenew = $sett[0]->smsrenew;
        $settsmspayment = $sett[0]->smspayment;

        if (Auth::user()->can('all_access')) {
            if ($sqlstr != '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'cmob', 'carnumber','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('billclosed', '=', $sqlstr)
                    ->where('days', '<', $settdays)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('billclosed', '=', $sqlstr)
                    ->where('days', '<', $settdays)
                    ->where('status', '=', $sqlstrstatus)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('status', '=', $sqlstrstatus)
                    ->where('days', '<', $settdays)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('days', '<', $settdays)
                    ->get();
            }
        }else {
            $bIds = Auth::user()->branch_id;
            if ($sqlstr != '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'cmob', 'carnumber','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('branchid', '=', $bIds)
                    ->where('billclosed', '=', $sqlstr)
                    ->where('days', '<', $settdays)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('billclosed', '=', $sqlstr)
                    ->where('days', '<', $settdays)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid', '=', $bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('status', '=', $sqlstrstatus)
                    ->where('days', '<', $settdays)
                    ->where('branchid', '=', $bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->whereBetween('edate', [$from, $to])
                    ->where('days', '<', $settdays)
                    ->where('branchid', '=', $bIds)
                    ->get();
            }
        }

        $datatables = Datatables::of($contractdetlist)
            ->editColumn('id', function ($inscontlist) {
                return $inscontlist->id;
            })
            ->editColumn('status', function ($inscontlist) {
                return $inscontlist->status;
            })
            ->editColumn('sendaction', function ($inscontlist) {
                $checkfirstcode = substr($inscontlist->cmob, 0, 1);
                if($checkfirstcode === "0"){
                    $phone = substr($inscontlist->cmob, 1);
                }else{
                    $phone = $inscontlist->cmob;
                }
                $checksecondcode = substr($phone, 0, 1);

                if($checksecondcode === "6"){
                    $cmobile =  "-";
                }elseif ($phone == ''){
                    $cmobile = "-";
                }else{
                    $cmobile = "961".$phone;
                }

                $statusbuttons = "";
                $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-to="0" class="btn btn-send btn-sm btn-outline-success btn-block" onclick="send(event,'.$cmobile.')">'. trans('reminders.tables.sendaction') .'</a>';
                return $statusbuttons;
            })
            ->editColumn('ccode', function ($inscontlist) {
                return $inscontlist->ccode;
            })
            ->editColumn('cname', function ($inscontlist) {
                return $inscontlist->coname;
            })
            ->editColumn('cmob', function ($inscontlist) {
                $checkfirstcode = substr($inscontlist->cmob, 0, 1);
                if($checkfirstcode === "0"){
                    $phone = substr($inscontlist->cmob, 1);
                }else{
                    $phone = $inscontlist->cmob;
                }
                $checksecondcode = substr($phone, 0, 1);

                if($checksecondcode === "6"){
                    return "-";
                }elseif ($phone == ''){
                    return "-";
                }else{
                    return "961".$phone;
                }
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
                return $inscontlist->totalcost;
            })
            ->editColumn('currname', function ($inscontlist) {
                return $inscontlist->currname;
            })
            ->rawColumns(['sendaction']);

        return $datatables->make(true);
    }

    public function allremindersresults(Request $request)
    {
        abort_if(Gate::denies('sms_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sqlstr = $request->get('sqlstr');
        $sqlstrstatus = $request->get('sqlstrstatus');
        $msgtype = $request->get('msgtype');

        $sett = DB::table('settings')
            ->select('reminder','smsrenew','smspayment')
            ->get();

        $settdays = $sett[0]->reminder;
        $settsmsrenew = $sett[0]->smsrenew;
        $settsmspayment = $sett[0]->smspayment;

        if (Auth::user()->can('all_access')) {
            if ($sqlstr != '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'cmob', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->where('status', '=', $sqlstrstatus)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->get();
            }
        }else {
            $bIds = Auth::user()->branch_id;
            if ($sqlstr != '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'cmob', 'carnumber','maidid','maidname','passport','stopcont')
                    ->where('branchid', '=', $bIds)
                    ->where('billclosed', '=', $sqlstr)
                    ->get();
            } elseif ($sqlstr != '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->where('billclosed', '=', $sqlstr)
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid', '=', $bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus != '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->where('status', '=', $sqlstrstatus)
                    ->where('branchid', '=', $bIds)
                    ->get();
            } elseif ($sqlstr == '' && $sqlstrstatus == '') {
                $contractdetlist = DB::table('reminders_results')
                    ->select('id', 'coname', 'compname', 'insname', 'sdate', 'edate', 'days', 'totalcost', 'currname', 'status', 'carname', 'netcost', 'billclosed', 'ccode', 'carnumber', 'cmob','maidid','maidname','passport','stopcont')
                    ->where('branchid', '=', $bIds)
                    ->get();
            }
        }

        $datatables = Datatables::of($contractdetlist)
            ->editColumn('id', function ($inscontlist) {
                return $inscontlist->id;
            })
            ->editColumn('status', function ($inscontlist) {
                return $inscontlist->status;
            })
            ->editColumn('sendaction', function ($inscontlist) {
                $checkfirstcode = substr($inscontlist->cmob, 0, 1);
                if($checkfirstcode === "0"){
                    $phone = substr($inscontlist->cmob, 1);
                }else{
                    $phone = $inscontlist->cmob;
                }
                $checksecondcode = substr($phone, 0, 1);

                if($checksecondcode === "6"){
                    $cmobile =  "-";
                }elseif ($phone == ''){
                    $cmobile = "-";
                }else{
                    $cmobile = "961".$phone;
                }

                $statusbuttons = "";
                $person="'".$inscontlist -> coname."'";
                $statusbuttons .= '<a href="javascript:;" data-id="'.$inscontlist -> id.'" data-name="'.$inscontlist -> coname.'" data-to="0" class="btn btn-send btn-sm btn-outline-success btn-block" onclick="sendwelcome(event,'.$cmobile.','.$person.')">'. trans('reminders.tables.sendaction1') .'</a>';
                return $statusbuttons;
            })
            ->editColumn('ccode', function ($inscontlist) {
                return $inscontlist->ccode;
            })
            ->editColumn('cname', function ($inscontlist) {
                return $inscontlist->coname;
            })
            ->editColumn('cmob', function ($inscontlist) {
                $checkfirstcode = substr($inscontlist->cmob, 0, 1);
                if($checkfirstcode === "0"){
                    $phone = substr($inscontlist->cmob, 1);
                }else{
                    $phone = $inscontlist->cmob;
                }
                $checksecondcode = substr($phone, 0, 1);

                if($checksecondcode === "6"){
                    return "-";
                }elseif ($phone == ''){
                    return "-";
                }else{
                    return "961".$phone;
                }
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
                return $inscontlist->totalcost;
            })
            ->editColumn('currname', function ($inscontlist) {
                return $inscontlist->currname;
            })
            ->rawColumns(['sendaction']);

        return $datatables->make(true);
    }

    public function getremindersprintout($pdates)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');


        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $sqlstr = '';
        $billoption = "كل الفواتير";

        $condid = 'edate';
        $billstatus = '';
        $count = '';

        $filter = '';
        $partname = '';


               $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        if (Auth::user()->can('all_access')) {
            $data['contractlist'] = DB::table('reminders_results')
                ->select('id', 'client','coname', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','carnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                ->whereBetween('edate', [$from, $to])
                ->orderBy('billclosed', 'asc')
                ->get();
            $count = $data['contractlist']->count();
        } else {
            $bIds = Auth::user()->branch_id;
            $data['contractlist'] = DB::table('reminders_results')
                ->select('id', 'client','coname', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','carnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                ->whereBetween('edate', [$from, $to])
                ->where('branch_id', '=', $bIds)
                ->orderBy('billclosed', 'asc')
                ->get();
            $count = $data['contractlist']->count();
        }

        //From here calculate the USD Total Amounts

        if (Auth::user()->can('all_access')) {
            $contractlist = DB::table('reminders_results')
                ->select( DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('edate', [$from, $to])
                ->where('currid', '=', "3")
                ->groupBy('currname','currid')
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
            $contractlist = DB::table('reminders_results')
                ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('edate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    ['currid', '=', "3"],
                ])
                ->groupBy('currname','currid')
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
            $contractlist = DB::table('reminders_results')
                ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('edate', [$from, $to])
                ->where('currid', '=', "2")
                ->groupBy('currname','currid')
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
            $contractlist = DB::table('reminders_results')
                ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname','currid')
                ->whereBetween('edate', [$from, $to])
                ->where([
                    ['branch_id', '=', $bIds],
                    ['currid', '=', "2"],
                ])
                ->groupBy('currname','currid')
                ->get();
            if(isset($contractlist[0]->coamount)) {
                $rec22 = number_format($contractlist[0]->coamount);
                $rec33 = $contractlist[0]->currname;
            }else{
                $rec22 = "0";
                $rec33 = "LBP";
            }
        }

        return view('pages.Reports.reminders_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','filter','partname','from','to'));
    }

    public function bgetremindersprintout($bid,$type,$pdates)
    {
        abort_if(Gate::denies('payments_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');


        $fdate = $pdates;
        $fdates = explode("_", $fdate);
        $from = $fdates[0];
        $to = $fdates[1];
        $sqlstr = '';
        $billoption = "كل الفواتير";

        $condid = 'edate';
        $billstatus = '';
        $count = '';

        $fbid = $bid;
        $fbids = explode("_", $fbid);
        $partid = $fbids[0];
        $partname = $fbids[1];

        $filter = $type;


        $data['partnertype'] = DB::table('partners')
            ->select('partner as ptype')
            ->where('id', '=', '9')
            ->get();

        if($filter == 1){
            if (Auth::user()->can('all_access')) {
                $data['contractlist'] = DB::table('reminders_results')
                    ->select('id', 'client','coname', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','carnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('edate', [$from, $to])
                    ->where('followby', '=', $partid)
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            } else {
                $bIds = Auth::user()->branch_id;
                $data['contractlist'] = DB::table('reminders_results')
                    ->select('id', 'client','coname', 'codate', 'insname', 'totalcost', 'currname', 'billclosed', 'ccode','carname','carnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('edate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['followby', '=', $partid],
                    ])
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            }
        }elseif($filter == 2){
            if (Auth::user()->can('all_access')) {
                $data['contractlist'] = DB::table('reminders_results')
                    ->select('id', 'client','coname', 'codate', 'insname','brokershare', 'totalcost', 'currname', 'billclosed', 'ccode','carname','carnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('edate', [$from, $to])
                    ->where('brokerid', '=', $partid)
                    ->orderBy('billclosed', 'asc')
                    ->get();
                $count = $data['contractlist']->count();
            } else {
                $bIds = Auth::user()->branch_id;
                $data['contractlist'] = DB::table('reminders_results')
                    ->select('id', 'client','coname', 'codate', 'insname','brokershare', 'totalcost', 'currname', 'billclosed', 'ccode','carname','carnumber','maidname','passport','compname','sdate','edate','brokerid','followby','brokername','followname')
                    ->whereBetween('edate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where('followby', '=', $partid)
                    ->where('currid', '=', "3")
                    ->groupBy('currname', 'currid')
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['followby', '=', $partid],
                        ['currid', '=', "3"],
                    ])
                    ->groupBy('currname', 'currid')
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where('brokerid', '=', $partid)
                    ->where('currid', '=', "3")
                    ->groupBy('currname', 'currid')
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['brokerid', '=', $partid],
                        ['currid', '=', "3"],
                    ])
                    ->groupBy('currname', 'currid')
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where('followby', '=', $partid)
                    ->where('currid', '=', "2")
                    ->groupBy('currname', 'currid')
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['followby', '=', $partid],
                        ['currid', '=', "2"],
                    ])
                    ->groupBy('currname', 'currid')
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where('brokerid', '=', $partid)
                    ->where('currid', '=', "2")
                    ->groupBy('currname', 'currid')
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
                $contractlist = DB::table('reminders_results')
                    ->select(DB::raw('SUM(totalcost) AS coamount'), 'currname', 'currid')
                    ->whereBetween('edate', [$from, $to])
                    ->where([
                        ['branch_id', '=', $bIds],
                        ['brokerid', '=', $partid],
                        ['currid', '=', "2"],
                    ])
                    ->groupBy('currname', 'currid')
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
        return view('pages.Reports.reminders_statements', $data)->with(compact('rec2','rec3','rec22','rec33','billoption','count','billstatus','filter','partname','from','to'));
    }
}
