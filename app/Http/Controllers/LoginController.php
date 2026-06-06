<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('pages.login');
    }

    public function loginAction(Request $request)
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

            $request->session()->put('role', Auth::user()->role);
            $request->session()->put('username', Auth::user()->username);
            $request->session()->put('nama', Auth::user()->username);
            $request->session()->put('email', Auth::user()->email);
            $request->session()->put('hp', Auth::user()->no_telpon);

            if (Auth::user()->role === 'admin') {
                session(['show_stok_menipis' => true]);
            }

            return redirect()->route('login')->with('login_success', true);
        }

        return back()->with('error', 'Username atau password salah');
    }
}
