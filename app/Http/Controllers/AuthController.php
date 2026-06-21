<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ===== TAMPILKAN HALAMAN LOGIN =====
    public function index()
    {
        return view('pages.login');
    }

    // ===== PROSES LOGIN =====
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Nama pengguna wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ===== SIMPAN SESSION =====
            session([
                'nama'     => Auth::user()->username, //Pakai username karena tidak ada kolom nama
                'username' => Auth::user()->username,
                'email'    => Auth::user()->email,
                'hp'       => Auth::user()->no_telpon,
                'role'     => Auth::user()->role,
            ]);

            // ===== FLAG STOK MENIPIS UNTUK ADMIN =====
            if (Auth::user()->role === 'admin') {
                session(['show_stok_menipis' => true]);
            }

            return redirect()->route('login')->with('login_success', true);
        }

        return back()
            ->with('error', 'Username atau password salah!')
            ->withInput($request->only('username'));
    }

    // ===== LOGOUT =====
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
