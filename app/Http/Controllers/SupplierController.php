<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query()
            ->orderBy('id_supplier', 'desc');

        if ($request->filled('search')) {

            $keyword = trim($request->search);

            $query->where(function ($q) use ($keyword) {
                $q->where('nama_supplier', 'like', "%{$keyword}%")
                    ->orWhere('no_kontak', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('kota', 'like', "%{$keyword}%");
            });
        }

        $suppliers = $query
            ->paginate(10)
            ->withQueryString();

        return view('pages.kelola_supplier', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:100|unique:supplier,nama_supplier,NULL,id_supplier,deleted_at,NULL',
            'kontak'        => ['required', 'regex:/^\d[\d\s\-]{4,}\d$/'],
            'email'         => 'required|email|max:100',
            'kota'          => 'required|string|max:100',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier sudah digunakan.',
            'kontak.required'        => 'Kontak wajib diisi.',
            'kontak.regex'           => 'Kontak minimal 6 angka.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'kota.required'          => 'Kota wajib diisi.',
        ]);

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
        $request->merge([
            '_form_mode' => 'edit',
            'id_supplier' => $id
        ]);
        
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'nama_supplier' => 'required|string|max:100|unique:supplier,nama_supplier,' . $id . ',id_supplier,deleted_at,NULL',
            'kontak'        => ['required', 'regex:/^\d[\d\s\-]{4,}\d$/'],
            'email'         => 'required|email|max:100',
            'kota'          => 'required|string|max:100',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier sudah digunakan.',
            'kontak.required'        => 'Kontak wajib diisi.',
            'kontak.regex'           => 'Kontak minimal 6 angka.',
            'email.required'         => 'Email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'kota.required'          => 'Kota wajib diisi.',
        ]);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'no_kontak'     => $request->kontak,
            'email'         => $request->email,
            'kota'          => $request->kota,
        ]);

        return redirect()
            ->route('kelola_supplier')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $namaSupplier = $supplier->nama_supplier;

        $supplier->delete();

        return redirect()
            ->route('kelola_supplier')
            ->with('success', 'Supplier "' . $namaSupplier . '" berhasil dihapus.');
    }
}
