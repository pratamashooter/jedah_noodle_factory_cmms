<?php

namespace App\Http\Controllers;

use Session;
use Auth;
use Illuminate\Http\Request;

class AuthenticationManagement extends Controller
{

    // Open View Login
    public function Login()
    {
    	return view('login');
    }

    // Verify Login
    public function VerifyLogin(Request $request)
    {
    	if(Auth::attempt($request->only('username', 'password'))){
    		return redirect('/dashboard');
    	}
    	Session::flash('false','Username or password is incorrect');
    	return redirect('/login');
    }

    // Logout
    public function Logout()
    {
    	Auth::logout();
    	return redirect('/login');
    }

}
