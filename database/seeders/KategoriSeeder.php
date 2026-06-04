<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Atasan',      'status' => 'aktif'],
            ['nama_kategori' => 'Bawahan',     'status' => 'aktif'],
            ['nama_kategori' => 'Outer',       'status' => 'aktif'],
            ['nama_kategori' => 'Sepatu',      'status' => 'nonaktif'],
            ['nama_kategori' => 'Aksesoris',   'status' => 'nonaktif'],
            ['nama_kategori' => 'Tas',         'status' => 'nonaktif'],
            ['nama_kategori' => 'Dress',       'status' => 'aktif'],
            ['nama_kategori' => 'Rok',         'status' => 'aktif'],
            ['nama_kategori' => 'Jaket',       'status' => 'aktif'],
            ['nama_kategori' => 'Kemeja',      'status' => 'aktif'],
            ['nama_kategori' => 'Kaos',        'status' => 'aktif'],
            ['nama_kategori' => 'Celana Jeans','status' => 'aktif'],
            ['nama_kategori' => 'Sandal',      'status' => 'nonaktif'],
            ['nama_kategori' => 'Topi',        'status' => 'aktif'],
            ['nama_kategori' => 'Hijab',       'status' => 'aktif'],
            ['nama_kategori' => 'Sweater',     'status' => 'aktif'],
            ['nama_kategori' => 'Blazer',      'status' => 'nonaktif'],
            ['nama_kategori' => 'Dompet',      'status' => 'aktif'],
            ['nama_kategori' => 'Jam Tangan',  'status' => 'aktif'],
            ['nama_kategori' => 'Kacamata',    'status' => 'nonaktif'],
        ];

        foreach ($kategori as $item) {
            Kategori::create($item);
        }
    }
}