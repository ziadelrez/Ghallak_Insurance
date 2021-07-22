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

class BookingController extends Controller
{
    //    Booking Section
    public function index()
    {
        abort_if(Gate::denies('booking_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Auth::user()->can('all_access')) {
            $carslist = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $carslist = DB::table('getcarslist')
                ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename')
                ->where([
                    ['branchid', '=', $bIds],
                ])
                ->get();
        }

        $branchlist = DB::table('branch')
            ->select('id', 'name')
            ->get();


        return view('pages.Booking.booking', compact('carslist','branchlist'));
    }

    public function getbookinglist(Request $request)
    {
        abort_if(Gate::denies('booking_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');
        $from = $request->get('fromdate');
        $to = $request->get('todate');

        if (Auth::user()->can('all_access')) {
            $bookinglist = DB::table('getbooking')
                ->select('id' , 'carid', 'pname', 'mobile','fromdate','todate','ndays','branchid','brname','carname','carnumber','carcolor','carmodel','status')
                ->whereBetween('fromdate', [$from, $to])
                ->orderBy('fromdate', 'desc')
                ->get();
        }else{
            $bIds = Auth::user()->branch_id;
            $bookinglist = DB::table('getbooking')
                ->select('id' , 'carid', 'pname', 'mobile','fromdate','todate','ndays','branchid','brname','carname','carnumber','carcolor','carmodel','status')
                ->where('branchid', '=', $bIds)
                ->whereBetween('fromdate', [$from, $to])
                ->orderBy('fromdate', 'desc')
                ->get();
        }

        $datatables = Datatables::of($bookinglist)
            ->editColumn('id', function ($booked) {
                return $booked->id;
            })
            ->editColumn('pname', function ($booked) {
                return $booked->pname;
            })
            ->editColumn('fromdate', function ($booked) {
                return $booked->fromdate;
            })
            ->editColumn('todate', function ($booked) {
                return $booked->todate;
            })
            ->editColumn('carname', function ($booked) {
                return $booked->carname . ' - ' . $booked->carnumber . ' , ' . $booked->carcolor . ' , ' . $booked->carmodel;
            })
            ->editColumn('bookingstatus', function ($booked) {
                $statusbuttons = "";
                if ($booked->status) {
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$booked -> id.'" data-to="0" class="btn btn-sts btn-xs btn-outline-success">'. trans('booking.Bookings.done') .'</a>';
                    }
                else{
                    $statusbuttons .= '<a href="javascript:;" data-id="'.$booked -> id.'" data-to="1" class="btn btn-sts btn-xs btn-outline-danger">'. trans('booking.Bookings.notdone') .'</a>';
                }
                return $statusbuttons;
            })
            ->editColumn('bookingaction', function ($booked) {
                $buttons = "";
                if (Auth::user()->can('booking_edit')) {
                    $buttons .= '<button class="edit-btn btn btn-warning btn-sm" title="'. trans('expenses.Expenses.edit') .'" data-id="'.$booked -> id.'" data-fromdate="'.$booked -> fromdate.'" data-todate="'.$booked -> todate.'" data-carid="'.$booked -> carid.'" data-carname="'.$booked -> carname.'" data-carnumber="'.$booked -> carnumber.'" data-carcolor="'.$booked -> carcolor.'" data-carmodel="'.$booked -> carmodel.'" data-pname="'.$booked -> pname.'" data-mobile="'.$booked -> mobile.'" data-ndays="'.$booked -> ndays.'" data-branch="'.$booked -> brname.'" data-branchid="'.$booked -> branchid.'"><i class="fa fa-edit"></i></button> ';
                }
                if (Auth::user()->can('booking_delete')) {
                    $buttons .= '<button class="delete-btn btn btn-danger btn-sm" title="'. trans('expenses.Expenses.delete') .'" data-id="'.$booked -> id.'" data-title="'.$booked -> carname.'"><i class="fas fa-trash"></i></button>';
                }
                return $buttons;
            })->rawColumns(['bookingstatus','bookingaction']);

//        if ($start = $request->get('fromdate')) {
//            $datatables->where('expdate', '>=', $start);
//        }
//
//        if ($end = $request->get('todate')) {
//            $datatables->where('expdate', '<=', $end);
//        }

        return $datatables->make(true);

    }

    public function storebooking(Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'fromdate' => 'required|date',
                'todate' => 'required|date',
                'car' => 'required',
                'pname' =>'required',
                'mobile' =>'required',
                'ndays' =>'required',
                'branch' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $values_to_insert = [
                'fromdate' => $request->get('fromdate'),
                'todate' => $request->get('todate'),
                'car' => $request->get('car'),
                'pname' => $request->get('pname'),
                'mobile' => $request->get('mobile'),
                'ndays' => $request->get('ndays'),
                'branch' => $request->get('branch'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];
            $data = DB::table('booking')->insert($values_to_insert);
        }
        return response()->json($data);
    }

    public function editbooking(Request $request){

        if ($request->isMethod("POST")) {

            $rules = array(
                'fromdate' => 'required|date',
                'todate' => 'required|date',
                'car' => 'required',
                'pname' =>'required',
                'mobile' =>'required',
                'ndays' =>'required',
                'branch' =>'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return \Illuminate\Support\Facades\Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $data =  DB::table('booking')
                ->where('id', $request->get('id'))
                ->update([
                    'fromdate' => $request->get('fromdate'),
                    'todate' => $request->get('todate'),
                    'car' => $request->get('car'),
                    'pname' => $request->get('pname'),
                    'mobile' => $request->get('mobile'),
                    'ndays' => $request->get('ndays'),
                    'branch' => $request->get('branch'),
                    'updated_by'=> Auth::user()->id,
                    'updated_at' => date('Y-m-d'),
                ]);

            return response()->json($data);
        }
    }

    public function deletebooking(Request $request){

        DB::table('booking')
            ->where('id','=', $request->get('id'))
            ->delete();

        return response()->json();
//        return $request->get('id');
    }

    public function changeBookingStatus(Request $request)
    {
        if ($request->isMethod("POST")) {

            $validator = Validator::make($request->all(), [
                'bid' => 'required|numeric',
                'sts' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()->all()]);
            }

            DB::table('booking')
                ->where([
                    ['id', '=', $request->get('bid')],
                ])
                ->update(['status' => $request->get('sts')]);
            return response()->json(array('msg' => 'msg'), 200);
        }
    }

}
