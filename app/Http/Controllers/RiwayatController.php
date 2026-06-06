<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // ===== AMBIL DATA BARANG MASUK =====
        $masuk = BarangMasuk::with(['barang.kategori', 'supplier'])
            ->get()
            ->map(function ($item) {
                return (object)[
                    'tanggal'      => $item->tgl_masuk,
                    'nama_barang'  => $item->barang->nama_barang ?? '-',
                    'jumlah'       => $item->jumlah,
                    'kota'         => $item->supplier->kota ?? '-',
                    'transaksi'    => 'Barang Masuk',
                    'kategori'     => $item->barang->kategori->nama_kategori ?? '-',
                    'nama_supplier'=> $item->supplier->nama_supplier ?? '-',
                    'kontak'       => $item->supplier->no_kontak ?? '-',
                    'email'        => $item->supplier->email ?? '-',
                    'keterangan'   => $item->keterangan ?? '-',
                    'dicatat_oleh' => $item->dicatat_oleh ?? '-',
                    'created_at'   => $item->created_at,
                ];
            });

        // ===== AMBIL DATA BARANG KELUAR =====
        $keluar = BarangKeluar::with(['barang.kategori'])
            ->get()
            ->map(function ($item) {
                return (object)[
                    'tanggal'      => $item->tgl_keluar,
                    'nama_barang'  => $item->barang->nama_barang ?? '-',
                    'jumlah'       => $item->jumlah,
                    'kota'         => $item->tujuan ?? '-',
                    'transaksi'    => 'Barang Keluar',
                    'kategori'     => $item->barang->kategori->nama_kategori ?? '-',
                    'nama_supplier'=> '-',
                    'kontak'       => '-',
                    'email'        => '-',
                    'keterangan'   => $item->keterangan ?? '-',
                    'dicatat_oleh' => $item->dicatat_oleh ?? '-',
                    'created_at'   => $item->created_at,
                ];
            });

        // ===== GABUNGKAN & URUTKAN TERBARU =====
        $riwayat = $masuk->merge($keluar)
            ->sortByDesc('created_at')
            ->values();

        // ===== DEFAULT: 3 BULAN TERAKHIR (jika tidak ada filter aktif) =====
        $adaFilter = $request->dari || $request->sampai || $request->jenis || $request->search;

        if (!$adaFilter) {
            $tiga_bulan_lalu = Carbon::now()->subMonths(3)->startOfDay();
            $riwayat = $riwayat->filter(function ($item) use ($tiga_bulan_lalu) {
                return Carbon::parse($item->created_at) >= $tiga_bulan_lalu;
            })->values();
        }

        // ===== FILTER =====
        $riwayat = $riwayat->filter(function ($item) use ($request) {

            if ($request->dari && Carbon::parse($item->tanggal)->startOfDay() < Carbon::parse($request->dari)->startOfDay()) {
                return false;
            }

            if ($request->sampai && Carbon::parse($item->tanggal)->startOfDay() > Carbon::parse($request->sampai)->startOfDay()) {
                return false;
            }

            if ($request->jenis && $item->transaksi !== $request->jenis) {
                return false;
            }

            if ($request->search) {
                $search = strtolower($request->search);
                if (
                    !str_contains(strtolower($item->nama_barang), $search) &&
                    !str_contains(strtolower($item->kota), $search)
                ) {
                    return false;
                }
            }

            return true;
        })->values();

        // ===== PAGINATION =====
        $perPage = 10;
        $page    = $request->get('page', 1);

        $items = $riwayat->slice(($page - 1) * $perPage, $perPage)->values();

        $riwayat = new LengthAwarePaginator(
            $items,
            $riwayat->count(),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('pages.riwayat', compact('riwayat'));
    }

    public function exportExcel(Request $request)
    {
        $filters = [
            'dari'   => $request->dari,
            'sampai' => $request->sampai,
            'jenis'  => $request->jenis,
            'search' => $request->search,
        ];

        (new \App\Exports\RiwayatExport($filters))->download();
    }
}
