<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Model\User;

use Auth;


class LoginController extends Controller
{
    public function checkLogin()
    {
        if (Auth::check()) {
            return redirect('admin/dashboard');
        }else{
            return redirect('admin/login');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            'remember' => 'nullable'
        ]);

        $remember = $request->remember ? true : false;

        if (Auth::attempt([
	        'username' => $request->username,
	        'password' => $request->password], $remember)
	    ){
	    	return redirect('admin/dashboard');
	    }

        return redirect('admin/login')->with('error', 'The username or password is incorrect');
    }

    public function logout(Request $request)
    {
        if(Auth::check()){
	        Auth::logout();

	        $request->session()->invalidate();
	    }

	    return  redirect('admin/login');
    }
}
