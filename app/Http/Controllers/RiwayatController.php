<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $riwayat = collect([
            (object)[
                'tanggal' => now(),
                'nama_barang' => 'Celana Denim',
                'jumlah' => 5,
                'kota' => 'Batam',
                'transaksi' => 'Barang Masuk',
                'kategori' => 'Bawahan',
                'nama_supplier' => 'PT Denim Maju',
                'kontak' => '081234567890',
                'email' => 'supplier1@mail.com',
                'keterangan' => 'Barang baru masuk dari supplier utama'
            ],
            (object)[
                'tanggal' => now()->subDays(1),
                'nama_barang' => 'Kemeja Boxy',
                'jumlah' => 12,
                'kota' => 'Jakarta',
                'transaksi' => 'Barang Keluar',
                'kategori' => 'Atasan',
                'nama_supplier' => 'CV Kemeja Jaya',
                'kontak' => '082233445566',
                'email' => 'supplier2@mail.com',
                'keterangan' => 'Dikirim ke cabang Jakarta'
            ],
            (object)[
                'tanggal' => now()->subDays(2),
                'nama_barang' => 'Sepatu Zex',
                'jumlah' => 7,
                'kota' => 'Surabaya',
                'transaksi' => 'Barang Masuk',
                'kategori' => 'Sepatu',
                'nama_supplier' => 'PT Kulit Sepatu',
                'kontak' => '083344556677',
                'email' => 'supplier3@mail.com',
                'keterangan' => 'Restock gudang utama'
            ],
            (object)[
                'tanggal' => now()->subDays(3),
                'nama_barang' => 'Cincin  Kalcer',
                'jumlah' => 3,
                'kota' => 'Medan',
                'transaksi' => 'Barang Keluar',
                'kategori' => 'Aksesoris',
                'nama_supplier' => 'PT Kalcer Indo',
                'kontak' => '084455667788',
                'email' => 'supplier4@mail.com',
                'keterangan' => 'Pengiriman ke client Medan'
            ],
        ]);


        $riwayat = $riwayat->filter(function ($item) use ($request) {

            // 🔎 FILTER DARI
            if ($request->dari) {
                if ($item->tanggal < Carbon::parse($request->dari)) {
                    return false;
                }
            }

            // 🔎 FILTER SAMPAI
            if ($request->sampai) {
                if ($item->tanggal > Carbon::parse($request->sampai)->endOfDay()) {
                    return false;
                }
            }

            // 🔎 FILTER JENIS
            if ($request->jenis) {
                if ($item->transaksi !== $request->jenis) {
                    return false;
                }
            }

            // 🔎 SEARCH (nama barang & kota)
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
        return view('pages.riwayat', compact('riwayat'));
    }

    public function exportExcel(Request $request)
    {
        // dummy dulu (biar gak error kalau diklik)
        return back()->with('success', 'Export Excel dummy berhasil (belum real)');
    }
}
