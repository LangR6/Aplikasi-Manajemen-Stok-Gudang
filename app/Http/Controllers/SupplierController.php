<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // ===========================
        // DATA SUPPLIER
        // ===========================
        $suppliers = collect(
            Supplier::orderBy('id_supplier', 'desc')->get()
        );

        // ===========================
        // FILTER PENCARIAN
        // ===========================
        if ($request->filled('search')) {

            $search = strtolower(trim($request->search));

            $suppliers = $suppliers
                ->filter(function ($item) use ($search) {
                    return str_contains(strtolower($item->nama_supplier), $search) ||
                        str_contains(strtolower($item->no_kontak), $search) ||
                        str_contains(strtolower($item->email), $search) ||
                        str_contains(strtolower($item->kota), $search);
                })
                ->values();
        }

        // ===========================
        // PAGINATION
        // ===========================
        $perPage = 10;
        $page = $request->get('page', 1);

        $items = $suppliers
            ->slice(($page - 1) * $perPage, $perPage)
            ->values();

        $suppliers = new LengthAwarePaginator(
            $items,
            $suppliers->count(),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('pages.kelola_supplier', compact('suppliers'));
    }

    // ===========================
    // TAMBAH SUPPLIER
    // ===========================
    public function store(Request $request)
    {
        // Hanya admin yang boleh menambah supplier
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $request->validate([
            'nama_supplier' => 'required|string|max:100|unique:supplier,nama_supplier,NULL,id_supplier,deleted_at,NULL',
            'kontak'        => [
                'required',
                function ($attribute, $value, $fail) {
                    $digitOnly = preg_replace('/[\s\-]/', '', $value);

                    if (!preg_match('/^\d+$/', $digitOnly)) {
                        $fail('Kontak harus berupa angka.');
                        return;
                    }

                    if (strlen($digitOnly) < 6) {
                        $fail('Kontak minimal 6 angka.');
                    }
                },
            ],
            'email'         => 'required|email|max:100',
            'kota'          => 'required|string|max:100',
        ], [
            'nama_supplier.required' => 'Nama supplier wajib diisi.',
            'nama_supplier.unique'   => 'Nama supplier sudah digunakan.',
            'kontak.required'        => 'Kontak wajib diisi.',
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

    // ===========================
    // UPDATE SUPPLIER
    // ===========================
    public function update(Request $request, $id)
    {
        // Hanya admin yang boleh mengubah supplier
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $request->merge([
            '_form_mode'  => 'edit',
            'id_supplier' => $id,
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

    // ===========================
    // HAPUS SUPPLIER
    // ===========================
    public function destroy($id)
    {
        // Hanya admin yang boleh menghapus supplier
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        $supplier = Supplier::findOrFail($id);

        $namaSupplier = $supplier->nama_supplier;

        $supplier->delete();

        return redirect()
            ->route('kelola_supplier')
            ->with('success', 'Supplier "' . $namaSupplier . '" berhasil dihapus.');
    }
}
