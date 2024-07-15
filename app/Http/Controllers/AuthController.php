<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('member_id', 'password');
    
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/');
        }
    
        return back()->withErrors([
            'member_id' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'member_id' => 'required|unique:members',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            'phone' => 'required',
        ]);
        $data['password'] = bcrypt($data['password']);
        Member::create($data);
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
