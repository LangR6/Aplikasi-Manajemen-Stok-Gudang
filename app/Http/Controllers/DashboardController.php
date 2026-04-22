<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

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
            [
                'nama_supplier' => 'UD Makmur',
                'kontak' => '0821-7788-8899',
                'email' => 'makmur@email.com',
                'kota' => 'Surabaya',
            ],
            [
                'nama_supplier' => 'UD Makmur',
                'kontak' => '0821-7788-8899',
                'email' => 'makmur@email.com',
                'kota' => 'Surabaya',
            ],
            
        ];

        $barangMasukTerbaru = [
            'nama_barang'   => 'Hoodie',
            'kategori'      => 'Pakaian',
            'jumlah'        => 50,
            'supplier'      => 'CV Sumber Jaya',
            'kontak'        => '0812-3456-7890',
            'tanggal'       => '12 Mei 2026',
            'catatan'       => 'Barang diterima dalam kondisi baik.',
        ];

        $barangKeluarTerbaru = [
            'nama_barang'   => 'Hoodie',
            'kategori'      => 'Pakaian',
            'jumlah'        => 15,
            'tujuan'        => 'Cabang Jakarta',
            'supplier'      => 'PT Maju Terus',
            'kontak'        => '0813-2222-1111',
            'tanggal'       => '11 Mei 2026',
            'catatan'       => 'Pengiriman untuk restok toko cabang.',
        ];

        $daftarStokMenipis = [
            [
                'nama_barang' => 'Celana Jeans',
                'kategori' => 'Pakaian',
                'stok' => 8,
                'status_baca' => false,
            ],
            [
                'nama_barang' => 'Jaket Denim',
                'kategori' => 'Pakaian',
                'stok' => 5,
                'status_baca' => false,
            ],
            [
                'nama_barang' => 'Sweater Polos',
                'kategori' => 'Pakaian',
                'stok' => 7,
                'status_baca' => true,
            ],
            [
                'nama_barang' => 'Kaos Polkadot',
                'kategori' => 'Pakaian',
                'stok' => 3,
                'status_baca' => true,
            ],
            [
                'nama_barang' => 'Kemeja Slimfit ',
                'kategori' => 'Pakaian',
                'stok' => 1,
                'status_baca' => true,
            ],
        ];

        $daftarStokHabis = [
            [
                'nama_barang' => 'Kemeja Flanel',
                'kategori' => 'Pakaian',
                'stok' => 0,
                'status_baca' => false,
            ],
            [
                'nama_barang' => 'Kaos Oversize',
                'kategori' => 'Pakaian',
                'stok' => 0,
                'status_baca' => true,
            ],
            [
                'nama_barang' => 'Hoodie Zipper',
                'kategori' => 'Pakaian',
                'stok' => 0,
                'status_baca' => false,
            ],
            [
                'nama_barang' => 'Blouse Bunga',
                'kategori' => 'Pakaian',
                'stok' => 0,
                'status_baca' => false,
            ],
            [
                'nama_barang' => 'Hodie Crop',
                'kategori' => 'Pakaian',
                'stok' => 0,
                'status_baca' => false,
            ],
        ];

        $daftarBarangMasuk = [
            [
                'nama_barang' => 'Hoodie',
                'kategori' => 'Pakaian',
                'jumlah' => 50,
                'tanggal' => '12 Mei 2026',
                'supplier' => 'CV Sumber Jaya',
            ],
            [
                'nama_barang' => 'Kaos Oversize',
                'kategori' => 'Pakaian',
                'jumlah' => 30,
                'tanggal' => '10 Mei 2026',
                'supplier' => 'PT Maju Terus',
            ],
            [
                'nama_barang' => 'Jaket Denim',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '08 Mei 2026',
                'supplier' => 'UD Makmur',
            ],
            [
                'nama_barang' => 'Jaket Denim',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '08 Mei 2026',
                'supplier' => 'UD Makmur',
            ],
            [
                'nama_barang' => 'Jaket Denim',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '08 Mei 2026',
                'supplier' => 'UD Makmur',
            ],
            [
                'nama_barang' => 'Jaket Denim',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '08 Mei 2026',
                'supplier' => 'UD Makmur',
            ],
        ];

        $daftarBarangKeluar = [
            [
                'nama_barang' => 'Topi',
                'kategori' => 'Aksesoris',
                'jumlah' => 10,
                'tanggal' => '12 Mei 2026',
                'tujuan' => 'Toko Cabang A',
                'catatan' => 'Pengiriman rutin',
            ],
            [
                'nama_barang' => 'Kaos Polos',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '11 Mei 2026',
                'tujuan' => 'Toko Cabang B',
                'catatan' => '-',
            ],
            [
                'nama_barang' => 'Kaos Polos',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '11 Mei 2026',
                'tujuan' => 'Toko Cabang B',
                'catatan' => '-',
            ],
            [
                'nama_barang' => 'Kaos Polos',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '11 Mei 2026',
                'tujuan' => 'Toko Cabang B',
                'catatan' => '-',
            ],
            [
                'nama_barang' => 'Kaos Polos',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '11 Mei 2026',
                'tujuan' => 'Toko Cabang B',
                'catatan' => '-',
            ],
             [
                'nama_barang' => 'Kaos Polos',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '11 Mei 2026',
                'tujuan' => 'Toko Cabang B',
                'catatan' => '-',
            ],
            [
                'nama_barang' => 'Kaos Polos',
                'kategori' => 'Pakaian',
                'jumlah' => 20,
                'tanggal' => '11 Mei 2026',
                'tujuan' => 'Toko Cabang B',
                'catatan' => '-',
            ],
        ];

        $totalBarangMasuk = 55;
        $totalBarangKeluar = 30;
        $totalBarang = 120;
        $stokMenipis = 8;
        $stokHabis = 3;

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
            'daftarBarangKeluar'
        ));
    }
}
