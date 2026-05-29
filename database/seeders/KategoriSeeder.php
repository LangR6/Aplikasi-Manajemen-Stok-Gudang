<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'Atasan',     'status' => 'aktif'],
            ['nama_kategori' => 'Bawahan',    'status' => 'aktif'],
            ['nama_kategori' => 'Outer',      'status' => 'aktif'],
            ['nama_kategori' => 'Sepatu',     'status' => 'nonaktif'],
            ['nama_kategori' => 'Aksesoris',  'status' => 'nonaktif'],
            ['nama_kategori' => 'Tas',        'status' => 'nonaktif'],
        ];

        foreach ($kategori as $item) {
            // menyimpan setiap data kategori ke dalam database
            Kategori::create($item);
        }
    }
}