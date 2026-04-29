<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'hp'    => 'required|string|max:20',
        ]);

        session()->put('nama', $request->nama);
        session()->put('email', $request->email);
        session()->put('hp', $request->hp);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}