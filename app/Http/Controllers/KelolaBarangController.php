<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Kategori;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaBarangController extends Controller
{
    // READ - menampilkan semua barang dengan filter dan pagination
    public function index(Request $request)
    {
        $query = Barang::with('kategori');

        // filter berdasarkan keyword pencarian nama barang
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        // filter berdasarkan kategori yang dipilih
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // filter berdasarkan status stok
        if ($request->filled('status')) {
            if ($request->status === 'Habis') {
                // barang dengan stok 0
                $query->where('stok', 0);
            } elseif ($request->status === 'Menipis') {
                // barang dengan stok lebih dari 0 tapi kurang dari atau sama dengan 5
                $query->where('stok', '>', 0)->where('stok', '<=', 5);
            } elseif ($request->status === 'Tersedia') {
                // barang dengan stok lebih dari 5
                $query->where('stok', '>', 5);
            }
        }

        // urutkan berdasarkan status stok, lalu nama barang
        $query->orderByRaw("CASE
            WHEN stok = 0 THEN 2
            WHEN stok <= 5 THEN 1
            ELSE 0
        END")->orderBy('nama_barang');

        // ambil 25 data per halaman dan pertahankan parameter filter di url
        $data = $query->paginate(25)->withQueryString();

        // transform data menjadi array yang dibutuhkan oleh view
        $data = $data->through(function ($item) {
            return [
                'kode'        => $item->kode_barang,
                'nama'        => $item->nama_barang,
                'stok'        => $item->stok,
                'id_kategori' => $item->id_kategori,
                'kategori'    => $item->kategori?->nama_kategori ?? '-',
                'foto_url'    => $item->foto_barang
                    ? asset('storage/' . $item->foto_barang)
                    : null,
            ];
        });

        // mengambil kategori yang aktif saja untuk dropdown filter dan modal tambah
        $kategori = Kategori::where('status', 'aktif')
            ->orderBy('nama_kategori')
            ->get(['id_kategori', 'nama_kategori']);

        // mengambil semua supplier untuk dropdown barang masuk
        $supplier = Supplier::orderBy('nama_supplier')
            ->get(['id_supplier', 'nama_supplier']);

        // mengambil semua user yang role-nya admin untuk dropdown dicatat oleh
        $adminList = User::where('role', 'admin')
            ->orderBy('username')
            ->get(['id', 'username']);

        return view(
            'pages.kelola_barang',
            compact('data', 'kategori', 'supplier', 'adminList')
        );
    }

    // CREATE - menyimpan data barang baru ke database
    public function store(Request $request)
    {
        // hanya admin yang boleh menambah barang
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique'   => 'Kode barang sudah digunakan.',
            'kode_barang.max'      => 'Kode barang maksimal 50 karakter.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.max'      => 'Nama barang maksimal 100 karakter.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists'   => 'Kategori tidak ditemukan.',
            'foto_barang.image'    => 'File harus berupa gambar.',
            'foto_barang.mimes'    => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto_barang.max'      => 'Ukuran foto maksimal 2 MB.',
        ]);

        $data = $request->only(['kode_barang', 'nama_barang', 'id_kategori']);

        // ubah nama barang menjadi title case sebelum disimpan
        $data['nama_barang'] = ucwords(strtolower($data['nama_barang']));

        // stok awal selalu 0 saat barang baru ditambahkan
        $data['stok'] = 0;

        // simpan foto sebagai path file di storage bukan binary
        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = $request
                ->file('foto_barang')
                ->store('barang', 'public');
        }

        $model = new Barang();
        $model->tambah($data);

        return redirect()->back()
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    // UPDATE - memperbarui data barang berdasarkan kode_barang
    public function update(Request $request, string $kodeBarang)
    {
        // hanya admin yang boleh mengubah data barang
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // kondisi bisnis - pastikan barang yang akan diubah ada di database
        $barang = Barang::find($kodeBarang);
        if (!$barang) {
            return redirect()->back()
                ->with('error', 'Barang tidak ditemukan.');
        }

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        // unique mengabaikan kode_barang yang sedang diedit
        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barang,kode_barang,' .
                $kodeBarang . ',kode_barang',
            'nama_barang' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'kode_barang.required' => 'Kode barang wajib diisi.',
            'kode_barang.unique'   => 'Kode barang sudah digunakan.',
            'kode_barang.max'      => 'Kode barang maksimal 50 karakter.',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'nama_barang.max'      => 'Nama barang maksimal 100 karakter.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists'   => 'Kategori tidak ditemukan.',
            'foto_barang.image'    => 'File harus berupa gambar.',
            'foto_barang.mimes'    => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'foto_barang.max'      => 'Ukuran foto maksimal 2 MB.',
        ]);

        $data = $request->only(['kode_barang', 'nama_barang', 'id_kategori']);

        // ubah nama barang menjadi title case sebelum disimpan
        $data['nama_barang'] = ucwords(strtolower($data['nama_barang']));

        // simpan foto baru jika ada yang diupload
        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = $request
                ->file('foto_barang')
                ->store('barang', 'public');
        }

        $model = new Barang();
        $model->edit($kodeBarang, $data);

        return redirect()->back()
            ->with('success', 'Barang berhasil diperbarui.');
    }

    // CREATE - mencatat transaksi barang masuk dan menambah stok otomatis
    public function masuk(Request $request)
    {
        // hanya admin yang boleh mencatat barang masuk
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // simpan info barang ke session sebelum validasi
        // supaya saat redirect back blade bisa buka modal yang benar
        session([
            '_last_modal'    => 'masuk',
            '_last_kode'     => $request->kode_barang_transaksi,
            '_last_nama'     => $request->nama_display,
            '_last_kategori' => $request->kategori_display,
        ]);

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        // before_or_equal:today mencegah tanggal melebihi hari ini
        $request->validate([
            'kode_barang_transaksi' => 'required|exists:barang,kode_barang',
            'jumlah'                => 'required|integer|min:1',
            'tanggal'               => 'required|date|before_or_equal:today',
            'id_supplier'           => 'required|exists:supplier,id_supplier',
            'dicatat_oleh'          => 'required|string',
            'keterangan'            => 'nullable|string|max:255',
        ], [
            'jumlah.required'                  => 'Jumlah wajib diisi.',
            'jumlah.integer'                   => 'Jumlah harus berupa angka.',
            'jumlah.min'                       => 'Jumlah minimal 1.',
            'tanggal.required'                 => 'Tanggal wajib diisi.',
            'tanggal.before_or_equal'          => 'Tanggal tidak boleh melebihi hari ini.',
            'id_supplier.required'             => 'Supplier wajib dipilih.',
            'id_supplier.exists'               => 'Supplier tidak ditemukan.',
            'dicatat_oleh.required'            => 'Admin wajib dipilih.',
            'keterangan.max'                   => 'Keterangan maksimal 255 karakter.',
        ]);

        // kondisi bisnis - pastikan barang yang akan dicatat ada di database
        $barang = Barang::find($request->kode_barang_transaksi);
        if (!$barang) {
            return redirect()->back()
                ->with('error', 'Barang tidak ditemukan.');
        }

        // memanggil method catat() dari model BarangMasuk
        // stok barang akan bertambah otomatis sesuai jumlah yang diinput
        $model = new BarangMasuk();
        $model->catat([
            'id_barang'    => $request->kode_barang_transaksi,
            'jumlah'       => $request->jumlah,
            'tgl_masuk'    => $request->tanggal,
            'id_supplier'  => $request->id_supplier,
            'keterangan'   => $request->keterangan,
            'dicatat_oleh' => $request->dicatat_oleh,
        ]);

        // bersihkan session setelah berhasil
        session()->forget(['_last_modal', '_last_kode', '_last_nama', '_last_kategori']);

        return redirect()->back()
            ->with('success', 'Barang masuk berhasil dicatat.');
    }

    // CREATE - mencatat transaksi barang keluar dan mengurangi stok otomatis
    public function keluar(Request $request)
    {
        // hanya admin yang boleh mencatat barang keluar
        if (session('role') !== 'admin') {
            return redirect()->back()
                ->with('error', 'Anda tidak memiliki akses.');
        }

        // simpan info barang ke session sebelum validasi
        // supaya saat redirect back blade bisa buka modal yang benar
        session([
            '_last_modal'    => 'keluar',
            '_last_kode'     => $request->kode_barang_transaksi,
            '_last_nama'     => $request->nama_display,
            '_last_kategori' => $request->kategori_display,
        ]);

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        // before_or_equal:today mencegah tanggal melebihi hari ini
        $request->validate([
            'kode_barang_transaksi' => 'required|exists:barang,kode_barang',
            'jumlah'                => 'required|integer|min:1',
            'tanggal'               => 'required|date|before_or_equal:today',
            'tujuan'                => 'required|string|max:100',
            'dicatat_oleh'          => 'required|string',
            'keterangan'            => 'nullable|string|max:255',
        ], [
            'jumlah.required'         => 'Jumlah wajib diisi.',
            'jumlah.integer'          => 'Jumlah harus berupa angka.',
            'jumlah.min'              => 'Jumlah minimal 1.',
            'tanggal.required'        => 'Tanggal wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
            'tujuan.required'         => 'Tujuan wajib diisi.',
            'tujuan.max'              => 'Tujuan maksimal 100 karakter.',
            'dicatat_oleh.required'   => 'Admin wajib dipilih.',
            'keterangan.max'          => 'Keterangan maksimal 255 karakter.',
        ]);

        // kondisi bisnis - pastikan barang yang akan dicatat ada di database
        $barang = Barang::find($request->kode_barang_transaksi);
        if (!$barang) {
            return redirect()->back()
                ->with('error', 'Barang tidak ditemukan.');
        }

        // kondisi bisnis - pastikan stok mencukupi sebelum transaksi diproses
        if ($barang->stok < $request->jumlah) {
            return redirect()->back()
                ->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $barang->stok . '.');
        }

        // memanggil method catat() dari model BarangKeluar
        // stok barang akan berkurang otomatis sesuai jumlah yang diinput
        $model = new BarangKeluar();
        $model->catat([
            'id_barang'    => $request->kode_barang_transaksi,
            'jumlah'       => $request->jumlah,
            'tgl_keluar'   => $request->tanggal,
            'tujuan'       => $request->tujuan,
            'keterangan'   => $request->keterangan,
            'dicatat_oleh' => $request->dicatat_oleh,
        ]);

        // bersihkan session setelah berhasil
        session()->forget(['_last_modal', '_last_kode', '_last_nama', '_last_kategori']);

        return redirect()->back()
            ->with('success', 'Barang keluar berhasil dicatat.');
    }
}