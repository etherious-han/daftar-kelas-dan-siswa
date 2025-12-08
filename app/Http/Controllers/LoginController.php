<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'Username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('Username', 'password'))) {
            return redirect()->route('dashboard')->with('success', 'Berhasil login!');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
