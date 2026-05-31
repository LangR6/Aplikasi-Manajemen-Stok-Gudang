<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::whereNull('deleted_at')
            ->orderBy('id_supplier', 'desc')
            ->get();

        return view('pages.kelola_supplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'kontak' => 'required',
            'email' => 'required|email',
            'kota' => 'required',
        ]);

        // simpan ke database
        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'no_kontak'     => $request->kontak,
            'email'         => $request->email,
            'kota'          => $request->kota,
        ]);

        return redirect()
            ->route('kelola_supplier')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'kontak' => 'required',
            'email' => 'required|email',
            'kota' => 'required',
        ]);

        Supplier::where('id_supplier', $id)->update([
            'nama_supplier' => $request->nama_supplier,
            'no_kontak' => $request->kontak,
            'email' => $request->email,
            'kota' => $request->kota,
        ]);

        return redirect()
            ->route('kelola_supplier')
            ->with('success', 'Supplier berhasil diperbarui.');
    }
    public function destroy($id)
    {
        Supplier::where('id_supplier', $id)->delete();

        return redirect()
            ->route('kelola_supplier')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
