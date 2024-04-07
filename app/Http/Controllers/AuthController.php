<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function verify(Request $request)
    {
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ], [
            'email.exists' => 'provided email doesn\'t exists'
        ]);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors());
        $user = User::where(['email' => $request->email])->first();
        if (Auth::attempt($request->only(['email', 'password']))) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withErrors(['msg' => 'invalid credentials']);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login')->with('success', 'logout successfull');
    }

    public function register()
    {
        return view('register');
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->only(['name', 'email', 'password', 'password_confirmation']));
    }
}
