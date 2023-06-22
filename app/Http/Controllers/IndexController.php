<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {

        $data['ptype'] = DB::table('planstype')
            ->select('id', 'Description')
            ->get();

        $data['inslist'] = DB::table('insname_type')
            ->select('insid', 'insname','instype','details')
            ->get();

        $data['complist'] = DB::table('companies')
            ->select('id', 'compname')
            ->get();

        return view('index',$data);
    }

    public function insurancellist(){
        return view('insurancellist');
    }
    public function getcarcollections()
    {
        $data['carslist'] = DB::table('getcarslist')
            ->select('carid', 'carname','carnumber','cartype','cartypeid','caryear','carcolor','enginetype','trasnmission','passenger','bags','doors','img_filename','carrate','curr')
            ->where('carstop','=',"0")
            ->orderBy('carid', 'desc')
            ->get();
        $data['carscount'] = DB::table('getcarslist')
            ->select('carid', 'carname','carnumber','cartype','caryear','carcolor','img_filename','carrate','curr')
//               ->where('branchid','=',$brID)
            ->count();

        $data['carstype'] = DB::table('cartype')
            ->select('id', 'Description')
            ->get();

        return view('cars-collections',$data);
    }

    public function contactus()
    {
        return view('contactus');
    }

    public function aboutus()
    {
        return view('aboutus');
    }

    public function branches()
    {
        return view('branches');
    }

}
