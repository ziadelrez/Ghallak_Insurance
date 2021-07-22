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

         $setcurr = DB::table('Settings')
            ->select('curr')
            ->get();

        $currlist = DB::table('currency')
            ->select('id', 'currname_ara')
            ->where('id','=',$setcurr[0]->curr)
            ->get();

        $branchlist = DB::table('branch')
            ->select('id', 'name')
            ->get();

        $exptypelist = DB::table('exptype')
            ->select('id', 'Description')
            ->get();

        return view('pages.Expenses.expenses', compact('currlist','branchlist','exptypelist'));
    }

    public function getexplist(Request $request)
    {
        abort_if(Gate::denies('expenses_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if (Auth::user()->can('all_access')) {
            $exptlist = DB::table('getexpenses')
                ->select('expid' , 'expdate', 'exptypeid', 'amount','currid','curr','branchid','brname','exptype')
                ->whereBetween('expdate', [$from, $to])
                ->orderBy('expdate', 'asc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $exptlist = DB::table('getexpenses')
                ->select('expid' , 'expdate', 'exptypeid', 'amount','currid','curr','branchid','brname','exptype')
                ->where('branchid', '=', $bIds)
                ->whereBetween('expdate', [$from, $to])
                ->orderBy('expdate', 'asc')
                ->get();
        }

        $datatables = Datatables::of($exptlist)
            ->editColumn('expid', function ($exp) {
                return $exp->expid;
            })
            ->editColumn('expdate', function ($exp) {
                return $exp->expdate;
            })
            ->editColumn('exptype', function ($exp) {
                return $exp->exptype;
            })
            ->editColumn('amount', function ($exp) {
                return $exp->amount;
            })
            ->editColumn('curr', function ($exp) {
                return $exp->curr;
            })
            ->editColumn('brname', function ($exp) {
                return $exp->brname;
            })
            ->editColumn('expaction', function ($exp) {
                $buttons = "";
                if (Auth::user()->can('expenses_edit')) {
                    $buttons .= '<button class="edit-btn btn btn-warning btn-sm" title="'. trans('expenses.Expenses.edit') .'" data-id="'.$exp -> expid.'" data-expdate="'.$exp -> expdate.'" data-exptype="'.$exp -> exptype.'" data-exptypeid="'.$exp -> exptypeid.'" data-expamount="'.$exp -> amount.'" data-expcurr="'.$exp -> curr.'" data-expcurrid="'.$exp -> currid.'" data-expbranch="'.$exp -> brname.'" data-expbranchid="'.$exp -> branchid.'"><i class="fa fa-edit"></i></button> ';
                }
                if (Auth::user()->can('expenses_delete')) {
                    $buttons .= '<button class="delete-btn btn btn-danger btn-sm" title="'. trans('expenses.Expenses.delete') .'" data-id="'.$exp -> expid.'" data-title="'.$exp -> exptype.'"><i class="fas fa-trash"></i></button>';
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
                'exptype' => 'required',
                'amount' =>'required',
                'curr' =>'required',
                'branch' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'expdate' => $request->get('expdate'),
                'exptype' => $request->get('exptype'),
                'amount' => $request->get('amount'),
                'curr' => $request->get('curr'),
                'branch' => $request->get('branch'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('expenses')->insert($values_to_insert);
        }
        return response()->json($data);
    }

    public function editexp(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'expdate' => 'required|date',
                'exptype' => 'required',
                'amount' =>'required',
                'curr' =>'required',
                'branch' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('expenses')
                ->where('id', $request->get('id'))
                ->update([
                    'expdate' => $request->get('expdate'),
                    'exptype' => $request->get('exptype'),
                    'amount' => $request->get('amount'),
                    'curr' => $request->get('curr'),
                    'branch' => $request->get('branch'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            return response()->json($data);
        }
    }

    public function deleteexp(Request $request){

        DB::table('expenses')
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
            }
        }
    }
}
