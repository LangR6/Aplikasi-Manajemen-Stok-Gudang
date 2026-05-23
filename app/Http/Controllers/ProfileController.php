<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'email' => 'required|email|max:100',
            'hp' => 'nullable|max:20',
        ]);

        $user = User::find(Auth::id());

        $user->username = $request->nama;
        $user->email = $request->email;
        $user->no_telpon = $request->hp;
        $user->save();

        $request->session()->put('username', $request->nama);
        $request->session()->put('nama', $request->nama);
        $request->session()->put('email', $request->email);
        $request->session()->put('hp', $request->hp);

        return redirect()
            ->route('profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
