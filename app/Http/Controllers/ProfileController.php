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
        /** @var User $user */
        $user = Auth::user();

        return view('pages.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $adaPassword = $request->filled('password_lama')
                    || $request->filled('password_baru')
                    || $request->filled('konfirmasi_password');

        $rules = [
            'nama'  => 'required|max:100',
            'email' => 'required|email|max:100',
            'hp'    => 'required|numeric|digits_between:6,20',
        ];

        if ($adaPassword) {
            $rules['password_lama']       = 'required';
            $rules['password_baru']       = 'required|min:6|same:konfirmasi_password';
            $rules['konfirmasi_password'] = 'required';
        }

        $request->validate($rules, [
            'nama.required'                => 'Nama pengguna wajib diisi.',
            'nama.max'                     => 'Nama pengguna maksimal 100 karakter.',
            'email.required'               => 'Email wajib diisi.',
            'email.email'                  => 'Format email tidak valid.',
            'email.max'                    => 'Email maksimal 100 karakter.',
            'hp.required'                  => 'No handphone wajib diisi.',
            'hp.numeric'                   => 'No handphone hanya boleh berisi angka.',
            'hp.digits_between'            => 'No handphone minimal 6 dan maksimal 20 angka.',
            'password_lama.required'       => 'Password lama wajib diisi.',
            'password_baru.required'       => 'Password baru wajib diisi.',
            'password_baru.min'            => 'Password baru minimal 6 karakter.',
            'password_baru.same'           => 'Password baru dan konfirmasi password tidak cocok.',
            'konfirmasi_password.required' => 'Konfirmasi password wajib diisi.',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($adaPassword) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return back()
                    ->withErrors(['password_lama' => 'Password lama yang kamu masukkan salah.'])
                    ->withInput();
            }

            $user->password = Hash::make($request->password_baru);
        }

        $user->username  = $request->nama;
        $user->email     = $request->email;
        $user->no_telpon = $request->hp;

        $user->save();

        session([
            'username' => $user->username,
            'nama'     => $user->username,
            'email'    => $user->email,
            'hp'       => $user->no_telpon,
        ]);

        return redirect()
            ->route('profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
