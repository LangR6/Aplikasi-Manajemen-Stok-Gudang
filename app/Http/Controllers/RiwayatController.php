<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Nanti diisi query dari database
        // Contoh struktur data dummy untuk frontend:
        $riwayat = collect([
            // ['tanggal' => '2026-05-12', 'jenis' => 'Masuk', 'nama_barang' => 'Semen', 'nama_supplier' => 'CV Sumber Jaya', 'jumlah' => 100],
        ]);

        return view('admin.riwayat', compact('riwayat'));
    }

    public function exportExcel(Request $request)
    {
        // Nanti diisi logic export Excel
    }
}
