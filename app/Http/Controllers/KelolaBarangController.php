<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;

class KelolaBarangController extends Controller
{
    // READ - menampilkan semua barang dengan filter dan pagination
    public function index(Request $request)
    {
        // eager load kategori dan riwayat transaksi masuk & keluar
        $query = Barang::with(['kategori', 'barangMasuk', 'barangKeluar']);

        // filter berdasarkan keyword pencarian nama barang atau kode barang
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        // filter berdasarkan kategori yang dipilih
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // filter berdasarkan status stok
        if ($request->filled('status')) {
            if ($request->status === 'Baru') {
                // barang baru = stok 0 dan belum pernah ada transaksi masuk
                $query->where('stok', 0)
                    ->whereDoesntHave('barangMasuk');
            } elseif ($request->status === 'Tersedia') {
                // barang dengan stok lebih dari 5
                $query->where('stok', '>', 5);
            } elseif ($request->status === 'Menipis') {
                // barang dengan stok lebih dari 0 tapi kurang dari atau sama dengan 5
                $query->where('stok', '>', 0)->where('stok', '<=', 5);
            } elseif ($request->status === 'Habis') {
                // barang habis = stok 0 tapi sudah pernah ada transaksi masuk
                $query->where('stok', 0)
                    ->whereHas('barangMasuk');
            }
        }

        // urutkan: Baru → Tersedia → Menipis → Habis
        $query->orderByRaw("CASE
            WHEN stok = 0 AND NOT EXISTS (
                SELECT 1 FROM barang_masuk WHERE barang_masuk.id_barang = barang.kode_barang
            ) THEN 0
            WHEN stok > 5 THEN 1
            WHEN stok > 0 AND stok <= 5 THEN 2
            ELSE 3
        END")->orderBy('nama_barang');

        // ambil 25 data per halaman dan pertahankan parameter filter di url
        $data = $query->paginate(25)->withQueryString()->through(function ($item) {
            // tentukan status berdasarkan stok dan riwayat transaksi
            $isBaru = $item->stok === 0 && $item->barangMasuk->isEmpty();

            // kode barang terkunci (tidak bisa diedit) jika sudah punya riwayat transaksi
            $punyaTransaksi = $item->barangMasuk->isNotEmpty() || $item->barangKeluar->isNotEmpty();

            return [
                'kode'            => $item->kode_barang,
                'nama'            => $item->nama_barang,
                'stok'            => $item->stok,
                'is_baru'         => $isBaru,
                'id_kategori'     => $item->id_kategori,
                'kategori'        => $item->kategori?->nama_kategori ?? '-',
                'punya_transaksi' => $punyaTransaksi,
                // decode binary foto menjadi base64 untuk ditampilkan di img tag
                'foto_url'        => $item->foto_barang
                    ? 'data:image/jpeg;base64,' . base64_encode($item->foto_barang)
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

        return view(
            'pages.kelola_barang',
            compact('data', 'kategori', 'supplier')
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

        $data = [
            'kode_barang' => $request->kode_barang,
            // ubah nama barang menjadi title case sebelum disimpan
            'nama_barang' => ucwords(strtolower($request->nama_barang)),
            'id_kategori' => $request->id_kategori,
            // stok awal selalu 0 saat barang baru ditambahkan
            'stok'        => 0,
        ];

        // simpan foto sebagai binary ke database
        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = file_get_contents(
                $request->file('foto_barang')->getRealPath()
            );
        }

        Barang::create($data);

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

        // kondisi bisnis - kode barang tidak boleh diubah jika sudah memiliki riwayat transaksi
        $punyaTransaksi = $barang->barangMasuk()->exists() || $barang->barangKeluar()->exists();
        if ($punyaTransaksi) {
            // paksa kode_barang tetap sama walaupun ada nilai lain yang dikirim dari form
            $request->merge(['kode_barang' => $kodeBarang]);
        }

        // Mengetahui bahwa proses yang dilakukan adalah edit data barang
        // _punya_transaksi dikirim juga agar modal tetap mengunci field kode saat error validasi
        $request->merge([
            '_edit_kode'      => $kodeBarang,
            '_punya_transaksi' => $punyaTransaksi,
        ]);

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
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

        $data = [
            'kode_barang' => $request->kode_barang,
            // ubah nama barang menjadi title case sebelum disimpan
            'nama_barang' => ucwords(strtolower($request->nama_barang)),
            'id_kategori' => $request->id_kategori,
        ];

        // simpan foto baru sebagai binary jika ada yang diupload
        if ($request->hasFile('foto_barang')) {
            $data['foto_barang'] = file_get_contents(
                $request->file('foto_barang')->getRealPath()
            );
        }

        $barang->update($data);

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

        // ambil stok barang saat ini untuk ditampilkan kembali jika validasi gagal
        $stokSaatIni = Barang::find($request->kode_barang_transaksi)?->stok ?? 0;

        // simpan info barang ke session sebelum validasi
        session([
            '_last_modal'    => 'masuk',
            '_last_kode'     => $request->kode_barang_transaksi,
            '_last_nama'     => $request->nama_display,
            '_last_kategori' => $request->kategori_display,
            '_last_stok'     => $stokSaatIni,
        ]);

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        $request->validate([
            'kode_barang_transaksi' => 'required|exists:barang,kode_barang',
            'jumlah'                => 'required|integer|min:1',
            'tanggal'               => 'required|date|before_or_equal:today',
            'id_supplier'           => 'required|exists:supplier,id_supplier',
            'keterangan'            => 'nullable|string|max:255',
        ], [
            'jumlah.required'         => 'Jumlah wajib diisi.',
            'jumlah.min'              => 'Jumlah minimal 1.',
            'tanggal.required'        => 'Tanggal wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
            'id_supplier.required'    => 'Supplier wajib dipilih.',
            'id_supplier.exists'      => 'Supplier tidak ditemukan.',
            'keterangan.max'          => 'Keterangan maksimal 255 karakter.',
        ]);

        // kondisi bisnis - pastikan barang yang akan dicatat ada di database
        $barang = Barang::find($request->kode_barang_transaksi);
        if (!$barang) {
            return redirect()->back()
                ->with('error', 'Barang tidak ditemukan.');
        }

        // simpan transaksi masuk
        // stok barang akan bertambah otomatis sesuai jumlah yang diinput
        BarangMasuk::create([
            'id_barang'    => $request->kode_barang_transaksi,
            'jumlah'       => $request->jumlah,
            'tgl_masuk'    => $request->tanggal,
            'id_supplier'  => $request->id_supplier,
            'keterangan'   => $request->keterangan,
            // dicatat_oleh diisi otomatis dari session admin yang sedang login
            'dicatat_oleh' => session('username'),
        ]);

        // tambah stok
        $barang->increment('stok', $request->jumlah);
        $barang->refresh();

        // reset notifikasi stok sesuai kondisi terbaru
        if ($barang->stok > 5) {
            $barang->update([
                'stok_menipis_dibaca_pada' => null,
                'stok_habis_dibaca_pada'   => null,
            ]);
        } elseif ($barang->stok > 0) {
            $barang->update(['stok_habis_dibaca_pada' => null]);
        }

        session()->forget(['_last_modal', '_last_kode', '_last_nama', '_last_kategori', '_last_stok']);

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

        // ambil stok barang saat ini untuk ditampilkan kembali jika validasi gagal
        $stokSaatIni = Barang::find($request->kode_barang_transaksi)?->stok ?? 0;

        // simpan info barang ke session sebelum validasi
        session([
            '_last_modal'    => 'keluar',
            '_last_kode'     => $request->kode_barang_transaksi,
            '_last_nama'     => $request->nama_display,
            '_last_kategori' => $request->kategori_display,
            '_last_stok'     => $stokSaatIni,
        ]);

        // validasi input - jika gagal Laravel otomatis redirect back dengan error
        $request->validate([
            'kode_barang_transaksi' => 'required|exists:barang,kode_barang',
            'jumlah'                => 'required|integer|min:1',
            'tanggal'               => 'required|date|before_or_equal:today',
            'tujuan'                => 'required|string|max:100',
            'keterangan'            => 'nullable|string|max:255',
        ], [
            'jumlah.required'         => 'Jumlah wajib diisi.',
            'jumlah.min'              => 'Jumlah minimal 1.',
            'tanggal.required'        => 'Tanggal wajib diisi.',
            'tanggal.before_or_equal' => 'Tanggal tidak boleh melebihi hari ini.',
            'tujuan.required'         => 'Tujuan wajib diisi.',
            'tujuan.max'              => 'Tujuan maksimal 100 karakter.',
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
                ->withErrors([
                    'jumlah' => 'Stok tidak mencukupi. Stok tersedia: ' . $barang->stok
                ])
                ->withInput();
        }

        // simpan transaksi keluar
        // stok barang akan berkurang otomatis sesuai jumlah yang diinput
        BarangKeluar::create([
            'id_barang'    => $request->kode_barang_transaksi,
            'jumlah'       => $request->jumlah,
            'tgl_keluar'   => $request->tanggal,
            'tujuan'       => $request->tujuan,
            'keterangan'   => $request->keterangan,
            // dicatat_oleh diisi otomatis dari session admin yang sedang login
            'dicatat_oleh' => session('username'),
        ]);

        // kurangi stok
        $barang->decrement('stok', $request->jumlah);

        session()->forget(['_last_modal', '_last_kode', '_last_nama', '_last_kategori', '_last_stok']);

        return redirect()->back()
            ->with('success', 'Barang keluar berhasil dicatat.');
    }
}
