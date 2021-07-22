<?php

namespace App\Http\Controllers\Global_Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\GDRequest;
use App\Models\Global_Info\Carscolors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CarscolorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
//        $list = Carscolors::get();
        $list = DB::select('select * from carcolors where userid = ? ', [Auth::user()->id]);
//        $list = DB::table('carcolors')
//            ->select('id', 'Description')
//            ->where('userid', '=', Auth::user()->id)
//            ->get();

        return view('global_info.carscolorslist',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GDRequest $request)
    {
        Carscolors::create([
            'Description' => $request -> carcolor,
        ]);

        return view('/carscolors-list');
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
