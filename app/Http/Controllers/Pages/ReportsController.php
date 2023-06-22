<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use Gate;

class ReportsController extends Controller
{
    public function upcomingcars()
    {
        if (Auth::user()->can('all_access')) {

            $data['comingcars'] = DB::table('report_comingcarsinfo')
                ->select('carname','datein','timein','brname')
                ->where([
                    ['datein', '=',Carbon::now()->format('Y-m-d')],
                    ['taken', '=', "1"],
                ])
                ->get();


            $data['ldate'] = Carbon::now()->format('Y-m-d');

        }else{
            $bIds = Auth::user()->branch_id;

            $data['comingcars'] = DB::table('report_comingcarsinfo')
                ->select('carname','datein','timein','brname')
                ->where([
                    ['datein', '=',Carbon::now()->format('Y-m-d')],
                    ['branchid', '=', $bIds],
                    ['taken', '=', "1"],
                ])
                ->groupBy('brname')
                ->get();

            $data['ldate'] =  Carbon::now()->format('Y-m-d');

        }

        return view('pages.Reports.upcomingcars',$data);
    }
    public function availablecars()
    {
        if (Auth::user()->can('all_access')) {

            $data['comingcars'] = DB::table('report_comingcarsinfo')
                ->select('carname','datein','timein','brname')
                ->where([
                    ['datein', '=',Carbon::now()->format('Y-m-d')],
                    ['taken', '=', "1"],
                ])
                ->get();


            $data['ldate'] = Carbon::now()->format('Y-m-d');

        }else{
            $bIds = Auth::user()->branch_id;

            $data['comingcars'] = DB::table('report_comingcarsinfo')
                ->select('carname','datein','timein','brname')
                ->where([
                    ['datein', '=',Carbon::now()->format('Y-m-d')],
                    ['branchid', '=', $bIds],
                    ['taken', '=', "1"],
                ])
                ->groupBy('brname')
                ->get();

            $data['ldate'] =  Carbon::now()->format('Y-m-d');

        }

        return view('pages.Reports.availablecars',$data);
    }
    public function trasactionscars()
    {
        if (Auth::user()->can('all_access')) {

            $data['comingcars'] = DB::table('report_comingcarsinfo')
                ->select('carname','datein','timein','brname')
                ->where([
                    ['datein', '=',Carbon::now()->format('Y-m-d')],
                    ['taken', '=', "1"],
                ])
                ->get();


            $data['ldate'] = Carbon::now()->format('Y-m-d');

        }else{
            $bIds = Auth::user()->branch_id;

            $data['comingcars'] = DB::table('report_comingcarsinfo')
                ->select('carname','datein','timein','brname')
                ->where([
                    ['datein', '=',Carbon::now()->format('Y-m-d')],
                    ['branchid', '=', $bIds],
                    ['taken', '=', "1"],
                ])
                ->groupBy('brname')
                ->get();

            $data['ldate'] =  Carbon::now()->format('Y-m-d');

        }

        return view('pages.Reports.carstransaction',$data);
    }


    public function getupcomingcarslist(Request $request)
    {
        abort_if(Gate::denies('incomingcars_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $clientname = $request->get('clientname');
        $carname = $request->get('carname');
        $brname = $request->get('brname');
        $uptoday = $request->get('uptoday');

        if($uptoday != '' ){
                if (Auth::user()->can('all_access')) {
                    $availablelist = DB::table('report_comingcarsinfo')
                        ->select('contid', 'cname', 'carname', 'carnumber', 'carcolor', 'carmodel', 'cardays', 'dateout', 'timeout', 'datein', 'timein', 'taken', 'brname', 'branchid', 'codate')
                        ->where('cname', 'like', '%' . $clientname . '%')
                        ->where('carname', 'like', '%' . $carname . '%')
                        ->where('brname', 'like', '%' . $brname . '%')
                        ->where('datein', '=', $uptoday)
                        ->where('taken', '=', '1')
                        ->orderBy('datein', 'asc')
                        ->get();
                } else {
                    $bIds = Auth::user()->branch_id;
                    $availablelist = DB::table('report_comingcarsinfo')
                        ->select('contid', 'cname', 'carname', 'carnumber', 'carcolor', 'carmodel', 'cardays', 'dateout', 'timeout', 'datein', 'timein', 'taken', 'brname', 'branchid', 'codate')
                        ->where('branchid', '=', $bIds)
                        ->where('cname', 'like', '%' . $clientname . '%')
                        ->where('carname', 'like', '%' . $carname . '%')
                        ->where('brname', 'like', '%' . $brname . '%')
                        ->where('datein', '=', $uptoday)
                        ->where('taken', '=', '1')
                        ->orderBy('datein', 'asc')
                        ->get();
                }
    }else{
            if (Auth::user()->can('all_access')) {
                $availablelist = DB::table('report_comingcarsinfo')
                    ->select('contid', 'cname', 'carname', 'carnumber', 'carcolor', 'carmodel', 'cardays', 'dateout', 'timeout', 'datein', 'timein', 'taken', 'brname', 'branchid', 'codate')
                    ->where('cname', 'like', '%' . $clientname . '%')
                    ->where('carname', 'like', '%' . $carname . '%')
                    ->where('brname', 'like', '%' . $brname . '%')
                    ->where('taken', '=', '1')
                    ->orderBy('datein', 'asc')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $availablelist = DB::table('report_comingcarsinfo')
                    ->select('contid', 'cname', 'carname', 'carnumber', 'carcolor', 'carmodel', 'cardays', 'dateout', 'timeout', 'datein', 'timein', 'taken', 'brname', 'branchid', 'codate')
                    ->where('branchid', '=', $bIds)
                    ->where('cname', 'like', '%' . $clientname . '%')
                    ->where('carname', 'like', '%' . $carname . '%')
                    ->where('brname', 'like', '%' . $brname . '%')
                    ->where('taken', '=', '1')
                    ->orderBy('datein', 'asc')
                    ->get();
            }
        }

        $datatables = Datatables::of($availablelist)
            ->editColumn('contid', function ($upcomingcars) {
                return $upcomingcars->contid;
            })
            ->editColumn('brname', function ($upcomingcars) {
                return $upcomingcars->brname;
            })
            ->editColumn('contractdate', function ($upcomingcars) {
                return $upcomingcars->codate;
            })
            ->editColumn('clientname', function ($upcomingcars) {
                return $upcomingcars->cname;
            })
            ->editColumn('carname', function ($upcomingcars) {
                return $upcomingcars->carname . ' - ' . $upcomingcars->carnumber . ' , ' . $upcomingcars->carcolor . ' , ' . $upcomingcars->carmodel;
            })
            ->editColumn('cardays', function ($upcomingcars) {
                return $upcomingcars->cardays;
            })
            ->editColumn('takendate', function ($upcomingcars) {
                return $upcomingcars->dateout;
            })
            ->editColumn('takentime', function ($upcomingcars) {
                return $upcomingcars->timeout;
            })
            ->editColumn('returndate', function ($upcomingcars) {
                return $upcomingcars->datein;
            })
            ->editColumn('returntime', function ($upcomingcars) {
                return $upcomingcars->timein;
            });

//        if ($start = $request->get('fromdate')) {
//            $datatables->where('expdate', '>=', $start);
//        }
//
//        if ($end = $request->get('todate')) {
//            $datatables->where('expdate', '<=', $end);
//        }
        return $datatables->make(true);
    }
    public function getavailablecarslist(Request $request)
    {
        abort_if(Gate::denies('incomingcars_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $brname = $request->get('brname');

        if (Auth::user()->can('all_access')) {
            $availablelist = DB::table('getavailablecarslist')
                ->select('carid', 'carname', 'carnumber', 'carcolor', 'caryear','taken', 'brname', 'branchid')
                ->where('brname', 'like', '%' . $brname . '%')
                ->where('taken', '=', '0')
                ->get();
        } else {
            $bIds = Auth::user()->branch_id;
            $availablelist = DB::table('getavailablecarslist')
                ->select('carid', 'carname', 'carnumber', 'carcolor', 'caryear','taken', 'brname', 'branchid')
                ->where('brname', 'like', '%' . $brname . '%')
                ->where('taken', '=', '0')
                ->get();
        }

        $datatables = Datatables::of($availablelist)
            ->editColumn('carid', function ($availablecars) {
                return $availablecars->carid;
            })
            ->editColumn('carname', function ($availablecars) {
                return $availablecars->carname . ' - ' . $availablecars->carnumber . ' , ' . $availablecars->carcolor . ' , ' . $availablecars->caryear;
            })
            ->editColumn('brname', function ($availablecars) {
                return $availablecars->brname;
            });

//        if ($start = $request->get('fromdate')) {
//            $datatables->where('expdate', '>=', $start);
//        }
//
//        if ($end = $request->get('todate')) {
//            $datatables->where('expdate', '<=', $end);
//        }
        return $datatables->make(true);
    }
    public function gettransactionscarslist(Request $request)
    {
        abort_if(Gate::denies('cars_transaction_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $clientname = $request->get('clientname');
        $carname = $request->get('carname');
        $brname = $request->get('brname');

          if (Auth::user()->can('all_access')) {
                $transactioncarslist = DB::table('report_transactioncars')
                    ->select('contid', 'cname', 'carname', 'carnumber', 'carcolor', 'carmodel', 'cardays', 'dateout', 'timeout', 'datein', 'timein', 'taken', 'brname', 'branchid', 'codate')
                    ->where('cname', 'like', '%' . $clientname . '%')
                    ->where('carname', 'like', '%' . $carname . '%')
                    ->where('brname', 'like', '%' . $brname . '%')
                    ->orderBy('datein', 'asc')
                    ->get();
            } else {
                $bIds = Auth::user()->branch_id;
                $transactioncarslist = DB::table('report_transactioncars')
                    ->select('contid', 'cname', 'carname', 'carnumber', 'carcolor', 'carmodel', 'cardays', 'dateout', 'timeout', 'datein', 'timein', 'taken', 'brname', 'branchid', 'codate')
                    ->where('branchid', '=', $bIds)
                    ->where('cname', 'like', '%' . $clientname . '%')
                    ->where('carname', 'like', '%' . $carname . '%')
                    ->where('brname', 'like', '%' . $brname . '%')
                    ->orderBy('datein', 'asc')
                    ->get();
            }


        $datatables = Datatables::of($transactioncarslist)
            ->editColumn('contid', function ($upcomingcars) {
                return $upcomingcars->contid;
            })
            ->editColumn('brname', function ($upcomingcars) {
                return $upcomingcars->brname;
            })
            ->editColumn('contractdate', function ($upcomingcars) {
                return $upcomingcars->codate;
            })
            ->editColumn('clientname', function ($upcomingcars) {
                return $upcomingcars->cname;
            })
            ->editColumn('carname', function ($upcomingcars) {
                return $upcomingcars->carname . ' - ' . $upcomingcars->carnumber . ' , ' . $upcomingcars->carcolor . ' , ' . $upcomingcars->carmodel;
            })
            ->editColumn('cardays', function ($upcomingcars) {
                return $upcomingcars->cardays;
            })
            ->editColumn('takendate', function ($upcomingcars) {
                return $upcomingcars->dateout;
            })
            ->editColumn('takentime', function ($upcomingcars) {
                return $upcomingcars->timeout;
            })
            ->editColumn('returndate', function ($upcomingcars) {
                return $upcomingcars->datein;
            })
            ->editColumn('returntime', function ($upcomingcars) {
                return $upcomingcars->timein;
            });

//        if ($start = $request->get('fromdate')) {
//            $datatables->where('expdate', '>=', $start);
//        }
//
//        if ($end = $request->get('todate')) {
//            $datatables->where('expdate', '<=', $end);
//        }
        return $datatables->make(true);
    }

}
