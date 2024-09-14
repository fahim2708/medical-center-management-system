<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function create(LoginRequest $request)
    {
        if (!auth()->attempt($request->only('username', 'password'), $request->remember)) {
            return  back()->with('status', 'Invalid Credentials');
        }
        // return redirect()->route('home'); //redirect to fixed page which is mentioned
        return redirect()->intended('/'); 
    }
}
