<?php

namespace App\Http\Controllers\AController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $bIds = Auth::user()->branch_id;
//        View::share( 'brID', $bIds );
//        $brlist = DB::table('branch')
//            ->select('name')
//            ->where('id','=',$bIds)
//            ->get();


           $brID = Auth::user()->branch_id;

        $data['branches'] = DB::table('branch')
            ->select('name')
            ->where('id','=',$brID)
            ->get();

        if (Auth::user()->can('all_access')) {
            $data['totalacc'] = DB::table('report_accidentinfo')
                ->select(DB::raw('count(accid) as accid'), 'accidenttypename')
                ->groupBy('accidenttypename')
                ->orderby('accid', 'desc')
                ->get();

            $data['totalcomp'] = DB::table('companies')
                ->select(DB::raw('count(id) as id'))
                ->get();

            $data['availablecars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'), 'brname')
                ->where('taken', '=', "0")
                ->groupBy('brname')
                ->orderby('carid', 'desc')
                ->get();

            $data['nclients'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('nclient', '=', '1')
                ->get();

            $data['brokers'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('broker', '=', '1')
                ->get();

            $data['experts'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('expert', '=', '1')
                ->get();

            $data['garages'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('garage', '=', '1')
                ->get();

            $data['employees'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('employee', '=', '1')
                ->get();

            $data['apersons'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('aperson', '=', '1')
                ->get();

            $data['offices'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('office', '=', '1')
                ->get();

            $data['totalcontracts'] = DB::table('report_contractinfo')
                ->select(DB::raw('count(contdetid) as contdetid'), 'insname')
                ->where('status', '=', '0')
                ->groupBy('insname')
                ->orderby('contdetid', 'desc')
                ->get();

            $data['totalbooking'] = DB::table('report_bookinginfo')
                ->select(DB::raw('count(bookid) as bookid'), 'brname')
                ->where('status', '=', "0")
                ->groupBy('brname')
                ->orderby('bookid', 'desc')
                ->get();
        }else {
            $data['totalacc'] = DB::table('report_accidentinfo')
                ->select(DB::raw('count(accid) as accid'), 'accidenttypename')
                ->where('branchid', '=', $brID)
                ->groupBy('accidenttypename')
                ->orderby('accid', 'desc')
                ->get();

            $data['totalcomp'] = DB::table('companies')
                ->select(DB::raw('count(id) as id'))
                ->get();

            $data['availablecars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'), 'brname')
                ->where('taken', '=', "0")
                ->where('branchid', '=', $brID)
                ->groupBy('brname')
                ->orderby('carid', 'desc')
                ->get();

            $data['nclients'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('nclient', '=', '1')
                ->Where('branch','=',$brID)
                ->get();

            $data['brokers'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('broker', '=', '1')
                ->Where('branch','=',$brID)
                ->get();

            $data['experts'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('expert', '=', '1')
                ->Where('branch','=',$brID)
                ->get();

            $data['garages'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('garage', '=', '1')
                ->Where('branch','=',$brID)
                ->get();

            $data['employees'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('employee', '=', '1')
                ->Where('branch','=',$brID)
                ->get();

            $data['apersons'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('aperson', '=', '1')
                ->Where('branch','=',$brID)
                ->get();

            $data['offices'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->where('office', '=', '1')
                ->Where('branch','=',$brID)
                ->get();

            $data['totalcontracts'] = DB::table('report_contractinfo')
                ->select(DB::raw('count(contdetid) as contdetid'), 'insname')
                ->where('status', '=', '0')
                ->where('branchid', '=', $brID)
                ->groupBy('insname')
                ->orderby('contdetid', 'desc')
                ->get();

            $data['totalbooking'] = DB::table('report_bookinginfo')
                ->select(DB::raw('count(bookid) as bookid'), 'brname')
                ->where('status', '=', "0")
                ->groupBy('brname')
                ->orderby('bookid', 'desc')
                ->get();
        }

//            $data['comingcars'] = DB::table('report_comingcarsinfo')
//                ->select('carname','datein','timein','brname')
//                ->where([
//                    ['datein', '=',Carbon::now()->format('Y-m-d')],
//                    ['taken', '=', "1"],
//                ])
//                ->get();

//            $data['topclients'] = DB::table('report_topclients')
//                ->select('codetid','cname','carname','carnumber','carcolor','carmodel')
//                ->orderby('codetid','desc')
//                ->limit(3)
//                ->get();


            $data['ldate'] = Carbon::now()->format('Y-m-d');

        return view('adminpanel.dashboard',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
