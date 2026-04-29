<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        ]);

        $admin = [
            'username' => 'admin',
            'password' => 'admin',
        ];

        $manager = [
            'username' => 'manager',
            'password' => 'manager',
        ];

        // ADMIN
        if ($request->username == $admin['username'] && $request->password == $admin['password']) {
            session()->put('role', 'admin');
            session()->put('nama', ucfirst($request->username));
            session()->put('email', 'admin@gmail.com');
            session()->put('hp', '081234567890');

            return redirect()
                ->route('dashboard')
                ->with('show_stok_menipis_modal', true);
        }

        // MANAGER
        elseif ($request->username == $manager['username'] && $request->password == $manager['password']) {
            session()->put('role', 'manager');
            session()->put('nama', ucfirst($request->username));
            session()->put('email', 'manager@gmail.com');
            session()->put('hp', '089876543210');

            return redirect()->route('dashboard');
        }

        // ERROR LOGIN
        return back()->with('error', 'Username atau password salah');
    }
}
