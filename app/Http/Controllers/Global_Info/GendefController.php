<?php

namespace App\Http\Controllers\Global_Info;

use App\Http\Controllers\Controller;
use App\Http\Requests\GDRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\http\Requests;



class GendefController extends Controller
{

    public function index()
    {
//        $list = Carscolors::get();
//        $list = DB::select('select * from carcolors where userid = ? ', [Auth::user()->id]);
        $listgendef = DB::table('gendef')
            ->select('id', 'name','tb','status')
           // ->where('active', '=', 1)
            ->get();

        return view('global_info.gendef',compact('listgendef'));
    }


    public function getgdvalues($tbid)
    {
             $tbnameenc = DB::table('gendef')
                ->select('tb','name')
                ->where('id',$tbid)
                ->get();
                $tb = $tbnameenc[0]->tb;
            $gdlist = DB::table($tb)
            ->select('id', 'Description')
            ->orderBy('Description', 'desc')
//            ->where('userid', '=', Auth::user()->id)
            ->get();
//        Session::put('title',  $gdlist[1]->Description);
        $titlegd = $tbnameenc[0]->name;
       // return $titlegd;
        return view('global_info.gdvalueslist',compact('gdlist','titlegd','tbid'));
    }


    public function store($gdid, Request $request)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'title' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }


            $tbnameenc = DB::table('gendef')
                ->select('tb', 'name')
                ->where('id', $gdid)
                ->get();
            $tb = $tbnameenc[0]->tb;

            //        DB::table($tb)->insert([
            //            'Description' => $request->get('title'),
            //        ]);

            $values_to_insert = [
                'Description' => $request->get('title'),
            ];

            $id = DB::table($tb)->insertGetId($values_to_insert);

            $descname = DB::table($tb)
                ->select('id','Description')
                ->where('id', $id)
                ->get();
            $dname = $descname[0]->Description;

            return response()->json(['id'=> $id ,'title'=> $dname]);
        }
    }


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $id
     * @return void
     */
    public function edit($id)
    {

    }


    public function update(Request $request, $gdid)
    {
        if ($request->isMethod("POST")) {

            $rules = array(
                'title' => 'required',
            );


            $validator = Validator::make($request->all(),$rules);

            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->getMessageBag()->toarray()));
            }

            $tbnameenc = DB::table('gendef')
                ->select('tb', 'name')
                ->where('id', $gdid)
                ->get();
            $tb = $tbnameenc[0]->tb;

            DB::table($tb)
                ->where('id', $request->get('id'))
                ->update(['Description' => $request->get('title')]);

            $descname = DB::table($tb)
                ->select('Description')
                ->where('id', $request->get('id'))
                ->get();
            $dname = $descname[0]->Description;

            return response()->json(['id' => $request->get('id'), 'title' => $dname]);

        }
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function deleteitemgd(Request $request, $gdid){
        $tbnameenc = DB::table('gendef')
            ->select('tb', 'name')
            ->where('id', $gdid)
            ->get();
        $tb = $tbnameenc[0]->tb;
        switch ($tb) {
            case "reg":
                $getcount = DB::table('clients')
                    ->where('creg','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "exptype":
                $getcount = DB::table('expenses')
                    ->where('exptype','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "PaymentType":
                $getcount = DB::table('clientpayments')
                    ->where('paymenttype','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "ctype":
                $getcount = DB::table('clients')
                    ->where('cctype','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "religion":
                $getcount = DB::table('clients')
                    ->where('relig','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "cartype":
                $getcount = DB::table('cars')
                    ->where('cartype','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "carcolors":
                $getcount = DB::table('cars')
                    ->where('carcolor','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "passplace":
                $getcount = DB::table('clients')
                    ->where('passplace','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();

                $getcount = DB::table('linum')
                    ->where('place','=',$request->get('id'))
                    ->get();
                $count1 = $getcount->count();

                if($count == 0 && $count1 == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }

                break;
            case "natio":
                $getcount = DB::table('clients')
                    ->where('natio','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "place":
                $getcount = DB::table('clients')
                    ->where('place','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "spareparts":

                break;
            case "payment":
                $getcount = DB::table('clientpayments')
                    ->where('amountfor','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "branch_location":
                $getcount = DB::table('branch')
                    ->where('location','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "carsspecs":
                $getcount = DB::table('cars_specs')
                    ->where('carspecs_id','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "carsenginetype":
                $getcount = DB::table('cars')
                    ->where('enginetype','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "carstransmission":
                $getcount = DB::table('cars')
                    ->where('transmission','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
            case "location":
                $getcount = DB::table('contprocedures')
                    ->where('location','=',$request->get('id'))
                    ->get();
                $count = $getcount->count();
                if($count == 0) {
                    DB::table($tb)
                        ->where('id','=', $request->get('id'))
                        ->delete();
                    return response()->json(['flag'=>"0"]);
                }else{
                    return response()->json(['flag'=>"1"]);
                }
                break;
        }
//
//
//        return response()->json();
//        return $request->get('id');
    }


}
