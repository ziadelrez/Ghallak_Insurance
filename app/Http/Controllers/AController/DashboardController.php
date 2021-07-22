<?php

namespace App\Http\Controllers\AController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

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

        if (Auth::user()->can('all_access')) {
//           $brID = Auth::user()->branch_id;
            $data['totalcars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'),'brname')
                ->groupBy('brname')
                ->orderby('carid','desc')
                ->get();

            $data['takencars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'),'brname')
                ->where('taken','=',"1")
                ->groupBy('brname')
                ->orderby('carid','desc')
                ->get();

            $data['availablecars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'),'brname')
                ->where('taken','=',"0")
                ->groupBy('brname')
                ->orderby('carid','desc')
                ->get();

            $data['totalclients'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->get();

            $data['totalcontracts'] = DB::table('report_contractinfo')
                ->select(DB::raw('count(contid) as contid'),'brname')
                ->groupBy('brname')
                ->orderby('contid','desc')
                ->get();

            $data['totalbooking'] = DB::table('report_bookinginfo')
                ->select(DB::raw('count(bookid) as bookid'),'brname')
                ->where('status','=',"0")
                ->groupBy('brname')
                ->orderby('bookid','desc')
                ->get();

            $data['comingcars'] = DB::table('report_comingcarsinfo')
                ->select('carname','datein','timein','brname')
                ->where([
                    ['datein', '=',Carbon::now()->format('Y-m-d')],
                    ['taken', '=', "1"],
                ])
                ->get();

            $data['topclients'] = DB::table('report_topclients')
                ->select('codetid','cname','carname','carnumber','carcolor','carmodel')
                ->orderby('codetid','desc')
                ->limit(3)
                ->get();


            $data['ldate'] = Carbon::now()->format('Y-m-d');

        }else{
            $bIds = Auth::user()->branch_id;
            $data['totalcars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'),'brname')
                ->where('branchid','=',$bIds)
                ->groupBy('brname')
                ->get();

            $data['takencars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'),'brname')
                ->where([
                    ['branchid', '=', $bIds],
                    ['taken', '=', "1"],
                ])
                ->groupBy('brname')
                ->get();

            $data['availablecars'] = DB::table('report_carsinfo')
                ->select(DB::raw('count(carid) as carid'),'brname')
                ->where([
                    ['branchid', '=', $bIds],
                    ['taken', '=', "0"],
                ])
                ->groupBy('brname')
                ->get();

            $data['totalclients'] = DB::table('clients')
                ->select(DB::raw('count(id) as id'))
                ->get();

            $data['totalcontracts'] = DB::table('report_contractinfo')
                ->select(DB::raw('count(contid) as contid'),'brname')
                ->where('branchid','=',$bIds)
                ->groupBy('brname')
                ->get();

            $data['totalbooking'] = DB::table('report_bookinginfo')
                ->select(DB::raw('count(bookid) as bookid'),'brname')
                ->where('branchid','=',$bIds)
                ->groupBy('brname')
                ->get();


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
