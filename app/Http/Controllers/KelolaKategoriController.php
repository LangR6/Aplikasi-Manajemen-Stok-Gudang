<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KelolaKategoriController extends Controller
{
    public function index(Request $request)
{
    // mengambil semua data kategori, diurutkan dari yang terbaru
    $data = Kategori::orderBy('created_at', 'desc')->get()->map(function ($item) {
        return [
            'id_kategori'   => $item->id_kategori,
            'nama_kategori' => $item->nama_kategori,
            'status'        => $item->status === 'aktif' ? true : false,
        ];
    });

    return view('pages.kelola_kategori', compact('data'));
}

    public function store(Request $request)
    {
        // hanya admin yang boleh menambah kategori
        if (session('role') !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        // validasi input sebelum menyimpan data kategori baru
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $model = new Kategori();
        $model->tambah($request->only(['nama_kategori', 'status']));

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        // hanya admin yang boleh mengubah kategori
        if (session('role') !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        // validasi input sebelum memperbarui data kategori
        $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $id . ',id_kategori',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $model = new Kategori();
        $model->edit($id, $request->only(['nama_kategori', 'status']));

        return redirect()->back()->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(int $id)
    {
        // hanya admin yang boleh menghapus kategori
        if (session('role') !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        }

        // mengecek apakah kategori masih digunakan oleh barang
        $kategori = Kategori::withCount('barang')->find($id);

        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        if ($kategori->barang_count > 0) {
            // menolak penghapusan jika kategori masih digunakan oleh barang
            return redirect()->back()->with('error',
                'Kategori tidak bisa dihapus karena masih digunakan oleh ' .
                $kategori->barang_count . ' barang.');
        }

        $model = new Kategori();
        $model->hapus($id);

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}