<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarsRequest;
use App\Http\Requests\UpdateCarsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\Datatables\Datatables;

class SettingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('settings_access'), \Symfony\Component\HttpFoundation\Response::HTTP_FORBIDDEN, '403 Forbidden');

        $checkexist = DB::table('settings')
            ->select('id')
            ->get();

        $total_row = $checkexist->count();
        if($total_row > 0) {
            $data['settingsDB'] = DB::table('settings')
                ->select('id','img_filename','curr','billnum','recunum','accnum','reminder','smsrenew','smspayment')
                ->get();

            $data['setid'] = $data['settingsDB'][0]->id;

            $data['currlist'] = DB::table('currency')
                ->select('id', 'currname_ara')
                ->get();

            $data['status']="settings.update";

            $data['chkexist']="1";
        }else{

            $data['setid'] = "";

            $data['currlist'] = DB::table('currency')
                ->select('id', 'currname_ara')
                ->get();

            $data['status']="settings.store";

            $data['chkexist']="0";
        }
        return view('pages.Settings.settings', $data);
    }

    public function store(Request $request)
    {
        if ($request->isMethod("POST")) {

            $values_to_insert = [
                'curr'=> $request->get('curr'),
                'billnum'=> $request->get('billnum'),
                'recunum'=> $request->get('recunum'),
                'accnum'=> $request->get('accnum'),
                'reminder'=> $request->get('reminder'),
                'smsrenew'=> $request->get('smsrenewdetails'),
                'smspayment'=> $request->get('smspaymentdetails'),
                'created_by'=> Auth::user()->id,
                'created_at' => date('Y-m-d'),
            ];

            $setid = DB::table('settings')->insertGetId($values_to_insert);

            $counter = 1;
            $path_info = pathinfo($request->file('photo')->getClientOriginalName());
            $file_name = $path_info["filename"];
            $extension = $path_info["extension"];


            while (file_exists(public_path() . '/files/images/company/'. $file_name . '.' . $extension)) {
                $file_name = $path_info["filename"] . '_' . $counter;
                $counter++;
            }
            if ($request->file('photo')->isValid()) {
                $request->file('photo')->move('files/images/company/', $file_name . '.' . $extension);

                DB::table('settings')
                    ->where('id', $setid)
                    ->update([
                        'img_filename' => $file_name . '.' . $extension,
                        'img_extention' => $extension,
                    ]);
            }
        }
        return redirect()->route('adminpanel.dashboard.index');
    }

    public function update(Request $request)
    {
        if ($request->isMethod("POST")) {

            $values_to_update = [
                'curr'=> $request->get('curr'),
                'billnum'=> $request->get('billnum'),
                'recunum'=> $request->get('recunum'),
                'accnum'=> $request->get('accnum'),
                'reminder'=> $request->get('reminder'),
                'smsrenew'=> $request->get('smsrenewdetails'),
                'smspayment'=> $request->get('smspaymentdetails'),
                'updated_by'=> Auth::user()->id,
                'updated_at' => date('Y-m-d'),
            ];

            DB::table('settings')
                ->where('id', '=', $request->get('statusid'))
                ->update($values_to_update);

            if($request->hasFile('photo')) {
                $counter = 1;
                $path_info = pathinfo($request->file('photo')->getClientOriginalName());
                $file_name = $path_info["filename"];
                $extension = $path_info["extension"];


                while (file_exists(public_path() . '/files/images/company/'. $file_name . '.' . $extension)) {
                    $file_name = $path_info["filename"] . '_' . $counter;
                    $counter++;
                }
                if ($request->file('photo')->isValid()) {
                    $request->file('photo')->move('files/images/company/', $file_name . '.' . $extension);

                    DB::table('settings')
                        ->where('id', $request->get('statusid'))
                        ->update([
                            'img_filename' => $file_name . '.' . $extension,
                            'img_extention' => $extension,
                        ]);
                }
            }

        }
        return redirect()->route('adminpanel.dashboard.index');
    }
}
