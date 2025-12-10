<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // FORM REGISTER
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat!');
    }

    // FORM LOGIN
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN (DIUBAH INI)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Login ke guard 'web' dulu untuk cek user
        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            
            // Logout dari guard 'web'
            Auth::guard('web')->logout();
            
            // Login ke guard sesuai role
            if ($user->role === 'admin') {
                Auth::guard('admin')->login($user);
                $request->session()->regenerate();
                return redirect()->route('kelas.index'); // Admin ke kelas
            } 
            elseif ($user->role === 'siswa') {
                Auth::guard('siswa')->login($user);
                $request->session()->regenerate();
                return redirect()->route('siswa.kelas'); // Siswa ke kelas mereka
            }
            else {
                return back()->withErrors(['username' => 'Role tidak dikenali!']);
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ]);
    }

    // LOGOUT (DIUBAH INI)
    public function logout(Request $request)
    {
        // Logout dari semua guard
        Auth::guard('admin')->logout();
        Auth::guard('siswa')->logout();
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}