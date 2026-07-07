<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $seninIni = Carbon::now()->startOfWeek(Carbon::MONDAY)->startOfDay();

        $totalBarangMasuk  = BarangMasuk::where('tgl_masuk', '>=', $seninIni)->count();
        $totalBarangKeluar = BarangKeluar::where('tgl_keluar', '>=', $seninIni)->count();
        $totalBarang       = Barang::count();

        $stokMenipis = Barang::where('stok', '>', 0)
            ->where('stok', '<=', 5)
            ->count();

        $stokHabis = Barang::where('stok', 0)
            ->whereHas('barangMasuk')
            ->count();

        $daftarStokMenipis = Barang::with('kategori')
            ->where('stok', '>', 0)
            ->where('stok', '<=', 5)
            ->orderByRaw("
        CASE
            WHEN stok_menipis_dibaca_pada IS NULL
                 OR DATE(stok_menipis_dibaca_pada) < CURDATE()
            THEN 0
            ELSE 1
        END
    ")
            ->get()
            ->map(fn($b) => [
                'kode'        => $b->kode_barang,
                'nama_barang' => $b->nama_barang,
                'kategori'    => $b->kategori?->nama_kategori ?? '-',
                'stok'        => $b->stok,
                'status_baca' => $b->stok_menipis_dibaca_pada
                    ? Carbon::parse($b->stok_menipis_dibaca_pada)->isToday()
                    : false,
            ]);

        $daftarStokHabis = Barang::with(['kategori', 'barangMasuk'])
            ->where('stok', 0)
            ->whereHas('barangMasuk')
            ->orderByRaw("
        CASE
            WHEN stok_habis_dibaca_pada IS NULL
                 OR DATE(stok_habis_dibaca_pada) < CURDATE()
            THEN 0
            ELSE 1
        END ASC
    ")
            ->get()
            ->map(fn($b) => [
                'kode'        => $b->kode_barang,
                'nama_barang' => $b->nama_barang,
                'kategori'    => $b->kategori?->nama_kategori ?? '-',
                'stok'        => $b->stok,
                'status_baca' => $b->stok_habis_dibaca_pada
                    ? Carbon::parse($b->stok_habis_dibaca_pada)->isToday()
                    : false,
            ]);

        $suppliers = Supplier::whereNull('deleted_at')
            ->orderByDesc('id_supplier')
            ->limit(5)
            ->get()
            ->map(fn($s) => [
                'nama_supplier' => $s->nama_supplier,
                'kontak'        => $s->no_kontak,
                'email'         => $s->email ?? '-',
                'kota'          => $s->kota,
            ])
            ->toArray();

        $masuk = BarangMasuk::with(['barang.kategori', 'supplier'])
            ->orderByDesc('tgl_masuk')
            ->orderByDesc('id_barang_masuk')
            ->first();

        $barangMasukTerbaru = $masuk ? [
            'nama_barang' => $masuk->barang?->nama_barang ?? '-',
            'kategori'    => $masuk->barang?->kategori?->nama_kategori ?? '-',
            'jumlah'      => $masuk->jumlah,
            'supplier'    => $masuk->supplier?->nama_supplier ?? '-',
            'kontak'      => $masuk->supplier?->no_kontak ?? '-',
            'tanggal'     => Carbon::parse($masuk->tgl_masuk)->translatedFormat('d F Y'),
            'catatan'     => $masuk->keterangan ?? '-',
        ] : [
            'nama_barang' => '-',
            'kategori' => '-',
            'jumlah' => 0,
            'supplier' => '-',
            'kontak' => '-',
            'tanggal' => '-',
            'catatan' => '-',
        ];

        $keluar = BarangKeluar::with(['barang.kategori'])
            ->orderByDesc('tgl_keluar')
            ->orderByDesc('id_barang_keluar')
            ->first();

        $barangKeluarTerbaru = $keluar ? [
            'nama_barang' => $keluar->barang?->nama_barang ?? '-',
            'kategori'    => $keluar->barang?->kategori?->nama_kategori ?? '-',
            'jumlah'      => $keluar->jumlah,
            'tujuan'      => $keluar->tujuan ?? '-',
            'supplier'    => '-',
            'kontak'      => '-',
            'tanggal'     => Carbon::parse($keluar->tgl_keluar)->translatedFormat('d F Y'),
            'catatan'     => $keluar->keterangan ?? '-',
        ] : [
            'nama_barang' => '-',
            'kategori' => '-',
            'jumlah' => 0,
            'tujuan' => '-',
            'supplier' => '-',
            'kontak' => '-',
            'tanggal' => '-',
            'catatan' => '-',
        ];

        $daftarBarangMasuk = BarangMasuk::with(['barang.kategori', 'supplier'])
            ->where('tgl_masuk', '>=', $seninIni)
            ->latest('tgl_masuk')->get()
            ->map(fn($m) => [
                'nama_barang' => $m->barang?->nama_barang ?? '-',
                'kategori'    => $m->barang?->kategori?->nama_kategori ?? '-',
                'jumlah'      => $m->jumlah,
                'tanggal'     => Carbon::parse($m->tgl_masuk)->translatedFormat('d F Y'),
                'supplier'    => $m->supplier?->nama_supplier ?? '-',
            ])->toArray();

        $daftarBarangKeluar = BarangKeluar::with(['barang.kategori'])
            ->where('tgl_keluar', '>=', $seninIni)
            ->latest('tgl_keluar')->get()
            ->map(fn($k) => [
                'nama_barang' => $k->barang?->nama_barang ?? '-',
                'kategori'    => $k->barang?->kategori?->nama_kategori ?? '-',
                'jumlah'      => $k->jumlah,
                'tanggal'     => Carbon::parse($k->tgl_keluar)->translatedFormat('d F Y'),
                'tujuan'      => $k->tujuan ?? '-',
                'catatan'     => $k->keterangan ?? '-',
            ])->toArray();

        // mengecek apakah ada stok menipis yang belum dibaca — untuk auto-open modal
        $adaStokMenipis = Barang::where('stok', '>', 0)->where('stok', '<=', 5)
            ->where(function ($q) {
                $q->whereNull('stok_menipis_dibaca_pada')
                    ->orWhereDate('stok_menipis_dibaca_pada', '<', today());
            })->exists();

        $showStokMenipisModal = false;

        $isAdminOrManajer = in_array(session('role'), ['admin', 'manajer']);

        // Muncul Notifikasi
        if ($isAdminOrManajer && session('show_stok_menipis') && $stokMenipis > 0) {
            $showStokMenipisModal = true;
            session()->forget('show_stok_menipis');
        }

        return view('pages.dashboard', compact(
            'suppliers',
            'barangMasukTerbaru',
            'barangKeluarTerbaru',
            'totalBarangMasuk',
            'totalBarangKeluar',
            'totalBarang',
            'stokMenipis',
            'stokHabis',
            'daftarStokMenipis',
            'daftarStokHabis',
            'daftarBarangMasuk',
            'daftarBarangKeluar',
            'showStokMenipisModal'
        ));
    }

    public function tandaiBaca(Request $request)
    {
        if (session('role') !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $kode  = $request->input('kode_barang');
        $tipe  = $request->input('tipe');
        $kolom = $tipe === 'menipis' ? 'stok_menipis_dibaca_pada' : 'stok_habis_dibaca_pada';

        Barang::where('kode_barang', $kode)->update([$kolom => today()->toDateString()]);

        return response()->json(['success' => true]);
    }
}
