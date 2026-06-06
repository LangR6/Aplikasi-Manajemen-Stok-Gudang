<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KelolaKategoriController extends Controller
{
    // READ - menampilkan semua kategori dengan filter dan pagination
    public function index(Request $request)
    {
        // ambil semua kategori, urutkan dari yang terbaru
        $query = Kategori::orderBy('created_at', 'desc');

        // filter berdasarkan keyword pencarian nama kategori
        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        // filter berdasarkan status aktif atau nonaktif
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        // ambil 10 data per halaman
        $data = $query->paginate(10)->withQueryString()->through(function ($item) {
            return [
                'id_kategori'   => $item->id_kategori,
                'nama_kategori' => $item->nama_kategori,
                'status'        => $item->status === 'aktif' ? true : false,
            ];
        });

        return view('pages.kelola_kategori', compact('data'));
    }

    // CREATE - menyimpan kategori baru
    public function store(Request $request)
    {
        // hanya admin yang boleh menambah kategori
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        $request->validate([
            'nama_kategori' => 'required|string|min:2|max:100|unique:kategori,nama_kategori,NULL,id_kategori,deleted_at,NULL',
            'status'        => 'required|in:aktif,nonaktif',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.min'      => 'Nama kategori minimal 2 karakter.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        $data = $request->only(['nama_kategori', 'status']);

        // ubah menjadi Title Case sebelum disimpan
        $data['nama_kategori'] = ucwords(strtolower($data['nama_kategori']));

        $model = new Kategori();
        $model->tambah($data);

        return redirect()->back()
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // UPDATE - memperbarui data kategori
    public function update(Request $request, int $id)
    {
        // hanya admin yang boleh mengubah kategori
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // kondisi bisnis - pastikan kategori yang akan diubah ada di database
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return redirect()->back()
                ->with('error', 'Kategori tidak ditemukan.');
        }

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        $request->validate([
            'nama_kategori' => 'required|string|min:2|max:100|unique:kategori,nama_kategori,' . $id . ',id_kategori,deleted_at,NULL',
            'status'        => 'required|in:aktif,nonaktif',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.min'      => 'Nama kategori minimal 2 karakter.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan.',
        ]);

        $data = $request->only(['nama_kategori', 'status']);

        // ubah menjadi Title Case sebelum disimpan
        $data['nama_kategori'] = ucwords(strtolower($data['nama_kategori']));

        $model = new Kategori();
        $model->edit($id, $data);

        return redirect()->back()
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    // DELETE - soft delete kategori
    public function destroy(int $id)
    {
        // hanya admin yang boleh menghapus kategori
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // pastikan kategori yang akan dihapus ada di database
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return redirect()->back()
                ->with('error', 'Kategori tidak ditemukan.');
        }

        // cek barang dengan stok tersedia atau menipis (stok > 0)
        // jika ada, kategori tidak boleh dihapus karena masih aktif digunakan
        $barangAktif = \App\Models\Barang::where('id_kategori', $id)
            ->where('stok', '>', 0)
            ->count();

        if ($barangAktif > 0) {
            return redirect()->back()
                ->with('error', "Tidak dapat dihapus.\nKategori masih digunakan oleh barang.");
        }

        // cek barang dengan stok 0 tapi sudah pernah ada transaksi masuk (status habis)
        // jika ada, kategori tidak boleh dihapus karena masih memiliki riwayat transaksi
        $barangHabis = \App\Models\Barang::where('id_kategori', $id)
            ->where('stok', 0)
            ->whereHas('barangMasuk')
            ->count();

        if ($barangHabis > 0) {
            return redirect()->back()
                ->with('error', "Tidak dapat dihapus.\nKategori memiliki riwayat transaksi.");
        }

        // cek barang baru yaitu stok 0 dan belum pernah ada transaksi masuk sama sekali
        // jika ada, kategori tidak dihapus melainkan dinonaktifkan saja
        $barangBaru = \App\Models\Barang::where('id_kategori', $id)
            ->where('stok', 0)
            ->whereDoesntHave('barangMasuk')
            ->count();

        if ($barangBaru > 0) {
            // nonaktifkan kategori karena masih memiliki barang baru yang belum bertransaksi
            $model = new Kategori();
            $model->edit($id, ['status' => 'nonaktif', 'nama_kategori' => $kategori->nama_kategori]);

            return redirect()->back()
                ->with('success', 'Kategori "' . $kategori->nama_kategori . '" dinonaktifkan karena masih memiliki ' . $barangBaru . ' barang baru yang belum pernah bertransaksi.');
        }

        // tidak ada barang sama sekali, aman untuk dihapus secara soft delete
        $model = new Kategori();
        $model->hapus($id);

        return redirect()->back()
            ->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }
}
