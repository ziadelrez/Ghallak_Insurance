<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo(){
//        if(Auth::user()->types->role == 'المشرف العام')
//        {
//          return 'dashboard';
//        }
//        elseif(Auth::user()->types->role == 'المدير')
//        {
//            return 'dashboard';
//        }
//        elseif(Auth::user()->types->role == 'مستخدم عادي')
//        {
//            return 'home';
//        }
//
//
//        if(Auth::user()->status == '0')
//        {
//            return view('errors.504');
//        }
//        else
//        {
//            return 'dashboard';
//        }


//        return 'dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function validateLogin(Request $request)
    {
        $this->validate($request,[
            'g-recaptcha-response' => 'required|captcha'
        ]);

    }

    protected function authenticated(Request $request)
    {
        if(!Auth::user()->status) {
            return view('errors.504');
        }elseif(Auth::user()->status)
        {
//            $bruser_id = Auth::user()->branch_id;
//            return redirect('/dashboard',compact('branch_id'));
//            $userId = Auth::id();


            return redirect()->route('adminpanel.dashboard.index');

        }

//        $role = Auth::user()->role->role_name;
//        switch($role) {
//            case 'admin':
//                return redirect('/admin');
//                break;
//            case 'user':
//                return redirect('/dashboard');
//                break;
//            default:
//                return redirect('/login');
//                break;
//        }
    }
}
