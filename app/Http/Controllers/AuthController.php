<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ===== TAMPILKAN HALAMAN LOGIN =====
    public function index()
    {
        return view('login');
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

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // Simpan data ke session
            session([
                'nama'     => $user->nama,
                'username' => $user->username,
                'email'    => $user->email,
                'hp'       => $user->hp,
                'role'     => $user->role,
            ]);

            // Redirect ke login dulu agar modal muncul
            return redirect()->route('login')->with('login_success', true);

        }

        // Jika gagal
        return redirect()->route('login')
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
