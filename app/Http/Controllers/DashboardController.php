<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $suppliers = [
            [
                'nama_supplier' => 'CV Sumber Jaya',
                'kontak' => '0812-3456-7890',
                'email' => 'sumberjaya@email.com',
                'kota' => 'Bandung',
            ],
            [
                'nama_supplier' => 'PT Maju Terus',
                'kontak' => '0813-2222-1111',
                'email' => 'maju@email.com',
                'kota' => 'Jakarta',
            ],
            [
                'nama_supplier' => 'UD Makmur',
                'kontak' => '0821-7788-8899',
                'email' => 'makmur@email.com',
                'kota' => 'Surabaya',
            ],
        ];

        $barangMasukTerbaru = [
            'supplier' => 'CV Sumber Jaya',
            'kontak' => '0812-3456-7890',
            'tanggal' => '12 Mei 2026',
        ];

        $barangKeluarTerbaru = [
            'supplier' => 'PT Maju Terus',
            'kontak' => '0813-2222-1111',
            'tanggal' => '11 Mei 2026',
        ];

        return view('admin.dashboard', compact(
            'suppliers',
            'barangMasukTerbaru',
            'barangKeluarTerbaru'
        ));
    }
}