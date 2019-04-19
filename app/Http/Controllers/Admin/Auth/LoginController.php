<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends AdminController
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

    public function showLoginForm()
    {
        return view('admin.auth.showloginform');
    }

    public function redirectTo()
    {	
        if(auth()->user()->isAdmin()){
            return route('admin.dashboard');
        }else{
            return route('home');
        }
        
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

    
    

   
}
