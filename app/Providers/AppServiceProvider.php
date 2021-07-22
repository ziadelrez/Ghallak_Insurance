<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
//     * @return void
     */
    public function boot()
    {
        view::composer('*', function ($view)
        {
            if(isset(Auth::user()->branch_id)) {
                $bIds = Auth::user()->branch_id;
                $brlist = DB::table('branch')
                    ->select('name','id')
                    ->where('id', '=', $bIds)
                    ->get();

                $branchname = $brlist[0]->name;
                $branchids = $brlist[0]->id;

                View::share(['branchname'=> $branchname,'branchsid'=> $branchids]);
            }
        });
    }
}
