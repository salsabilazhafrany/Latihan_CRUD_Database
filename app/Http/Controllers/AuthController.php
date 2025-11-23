<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek data ke Database (Tabel Users)
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Simpan nama user ke session agar dashboard lama tetap jalan
            session(['user' => Auth::user()->name]); 
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau Password salah!');
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return view('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}