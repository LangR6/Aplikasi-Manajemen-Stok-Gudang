<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            'password_lama' => 'nullable',
            'password_baru' => 'nullable|min:6|same:konfirmasi_password',
            'konfirmasi_password' => 'nullable',
        ]);

        $user = Auth::user();

        // Update profile
        $user->username = $request->nama;
        $user->email = $request->email;
        $user->no_telpon = $request->hp;

        // Jika ingin mengganti password
        if ($request->password_baru) {

            // Cek password lama
            if (!Hash::check($request->password_lama, $user->password)) {

                return redirect()
                    ->route('profile')
                    ->with('error', 'Password lama salah');
            }

            // Simpan password baru
            $user->password = Hash::make($request->password_baru);
        }

        $user->save();

        // Update session
        session([
            'username' => $user->username,
            'nama' => $user->username,
            'email' => $user->email,
            'hp' => $user->no_telpon,
        ]);

        return redirect()
            ->route('profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
