<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class ExpensesController extends Controller
{
    //    Expenses Section
    public function index()
    {
        abort_if(Gate::denies('expenses_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

       $bankslist = DB::table('banks')
            ->select('id', 'Description')
            ->get();

        $currlist = DB::table('currency')
            ->select('id', 'currname_eng')
            ->get();

        $branchlist = DB::table('branch')
            ->select('id', 'name')
            ->get();

        if (Auth::user()->can('all_access')) {
            $branchlist = DB::table('branch')
                ->select('id', 'name')
                ->get();
        }else {
            $bIds = Auth::user()->branch_id;
            $branchlist = DB::table('branch')
                ->select('id', 'name')
                ->where('id','=',$bIds)
                ->get();
        }

        $exptypelist = DB::table('exptype')
            ->select('id', 'Description')
            ->get();

        $paymenttype = DB::table('paymenttype')
            ->select('id', 'Description')
            ->get();

        return view('pages.Expenses.expenses', compact('currlist','branchlist','exptypelist','paymenttype','bankslist'));
    }

    public function getexplist(Request $request)
    {
        abort_if(Gate::denies('expenses_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if (Auth::user()->can('all_access')) {
            $exptlist = DB::table('getexpenses')
                ->select('payid' , 'paydate', 'exptypeid', 'payamount','paycurrid','paycurr','branchid','brname','exptype','paytypeid','paytype','paychecknum','bankid','bankname','checkdate')
                ->whereBetween('paydate', [$from, $to])
                ->where('partner', '=', '10')
                ->orderBy('paydate', 'desc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $exptlist = DB::table('getexpenses')
                ->select('payid' , 'paydate', 'exptypeid', 'payamount','paycurrid','paycurr','branchid','brname','exptype','paytypeid','paytype','paychecknum','bankid','bankname','checkdate')
                ->where('branchid', '=', $bIds)
                ->whereBetween('paydate', [$from, $to])
                ->where('partner', '=', '10')
                ->orderBy('paydate', 'desc')
                ->get();
        }

        $datatables = Datatables::of($exptlist)
            ->editColumn('expid', function ($exp) {
                return $exp->payid;
            })
            ->editColumn('expdate', function ($exp) {
                return $exp->paydate;
            })
            ->editColumn('exptype', function ($exp) {
                return $exp->exptype;
            })
            ->editColumn('amount', function ($exp) {
                return number_format($exp->payamount);
            })
            ->editColumn('curr', function ($exp) {
                return $exp->paycurr;
            })
            ->editColumn('brname', function ($exp) {
                return $exp->brname;
            })
            ->editColumn('expaction', function ($exp) {
                $buttons = "";
                if (Auth::user()->can('expenses_edit')) {
                    $buttons .= '<button class="edit-btn btn btn-warning btn-sm" title="'. trans('expenses.Expenses.edit') .'" data-id="'.$exp -> payid.'" data-expdate="'.$exp -> paydate.'" data-exptype="'.$exp -> exptype.'" data-exptypeid="'.$exp -> exptypeid.'" data-expamount="'.$exp -> payamount.'" data-expcurr="'.$exp -> paycurr.'" data-expcurrid="'.$exp -> paycurrid.'" data-expbranch="'.$exp -> brname.'" data-expbranchid="'.$exp -> branchid.'" data-paytypeid="'.$exp -> paytypeid.'" data-paytype="'.$exp -> paytype.'" data-checknum="'.$exp -> paychecknum.'" data-checkdate="'.$exp -> checkdate.'" data-bankid="'.$exp -> bankid.'" data-bankname="'.$exp -> bankname.'"><i class="fa fa-edit"></i></button> ';
                }
                if (Auth::user()->can('expenses_delete')) {
                    $buttons .= '<button class="delete-btn btn btn-danger btn-sm" title="'. trans('expenses.Expenses.delete') .'" data-id="'.$exp -> payid.'" data-title="'.$exp -> exptype.'"><i class="fas fa-trash"></i></button>';
                }
                return $buttons;
            })->rawColumns(['expaction']);

//        if ($start = $request->get('fromdate')) {
//            $datatables->where('expdate', '>=', $start);
//        }
//
//        if ($end = $request->get('todate')) {
//            $datatables->where('expdate', '<=', $end);
//        }

        return $datatables->make(true);

    }

    public function storeexp(Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'expdate' => 'required|date',
                'checkdate' => 'required|date',
                'exptype' => 'required',
                'amount' =>'required',
                'curr' =>'required',
                'bank' =>'required',
                'branch' =>'required',
                'paymenttype' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'paymentdate' => $request->get('expdate'),
                'checkdate' => $request->get('checkdate'),
                'exptype' => $request->get('exptype'),
                'amount' => $request->get('amount'),
                'curr' => $request->get('curr'),
                'branch' => $request->get('branch'),
                'paymenttype' => $request->get('paymenttype'),
                'checknum' => $request->get('checknum'),
                'bank' => $request->get('bank'),
                'partner' => '10',
                'fromaccount' => '20',
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('clientpayments')->insert($values_to_insert);
        }
        return response()->json($data);
    }

    public function editexp(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'expdate' => 'required|date',
                'checkdate' => 'required|date',
                'exptype' => 'required',
                'amount' =>'required',
                'curr' =>'required',
                'bank' =>'required',
                'branch' =>'required',
                'paymenttype' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('clientpayments')
                ->where('id', $request->get('id'))
                ->update([
                    'paymentdate' => $request->get('expdate'),
                    'checkdate' => $request->get('checkdate'),
                    'exptype' => $request->get('exptype'),
                    'amount' => $request->get('amount'),
                    'curr' => $request->get('curr'),
                    'branch' => $request->get('branch'),
                    'paymenttype' => $request->get('paymenttype'),
                    'checknum' => $request->get('checknum'),
                    'bank' => $request->get('bank'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            return response()->json($data);
        }
    }

    public function deleteexp(Request $request){

        DB::table('clientpayments')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }

    public function addNewValueexp(Request $request)
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
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('exptype')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }elseif($tbid == "10") {
                $values_to_insert = [
                    'Description' => $request->get('description'),
                ];
                $id = DB::table('banks')->insertGetId($values_to_insert);
                return response()->json(['id' => $id, 'success' => 'Record is successfully added']);
            }
        }
    }

    public function getexpenses_usd(Request $request){

        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if (Auth::user()->can('all_access')) {
            $exptlist = DB::table('getexpenses')
                ->select('payid' ,DB::raw('SUM(payamount) AS coamount'),'paycurrid','paycurr')
                ->whereBetween('paydate', [$from, $to])
                ->where('partner', '=', '10')
                ->where('paycurrid', '=', '3')
                ->groupBy('paycurr','paycurrid')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $exptlist = DB::table('getexpenses')
                ->select('payid' ,DB::raw('SUM(payamount) AS coamount'),'paycurrid','paycurr')
                ->where('branchid', '=', $bIds)
                ->whereBetween('paydate', [$from, $to])
                ->where('partner', '=', '10')
                ->where('paycurrid', '=', '3')
                ->groupBy('paycurr','paycurrid')
                ->get();
        }

        if(isset($exptlist[0]->coamount)) {
            $rec2 = number_format($exptlist[0]->coamount);
            $rec3 = $exptlist[0]->paycurr;
        }else{
            $rec2 = "0";
            $rec3 = "USD";
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }

    public function getexpenses_lbp(Request $request){

        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if (Auth::user()->can('all_access')) {
            $exptlist = DB::table('getexpenses')
                ->select('payid' ,DB::raw('SUM(payamount) AS coamount'),'paycurrid','paycurr')
                ->whereBetween('paydate', [$from, $to])
                ->where('partner', '=', '10')
                ->where('paycurrid', '=', '2')
                ->groupBy('paycurr','paycurrid')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $exptlist = DB::table('getexpenses')
                ->select('payid' ,DB::raw('SUM(payamount) AS coamount'),'paycurrid','paycurr')
                ->where('branchid', '=', $bIds)
                ->whereBetween('paydate', [$from, $to])
                ->where('partner', '=', '10')
                ->where('paycurrid', '=', '2')
                ->groupBy('paycurr','paycurrid')
                ->get();
        }

        if(isset($exptlist[0]->coamount)) {
            $rec2 = number_format($exptlist[0]->coamount);
            $rec3 = $exptlist[0]->paycurr;
        }else{
            $rec2 = "0";
            $rec3 = "LBP";
        }

        return response()->json(['ramount'=> $rec2,'rcurr' => $rec3]);
    }
}
