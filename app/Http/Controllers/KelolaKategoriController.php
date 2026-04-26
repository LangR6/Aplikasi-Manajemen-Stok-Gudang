<?php

namespace App\Http\Controllers;

class KelolaKategoriController extends Controller
{
    public function getData()
    {
        $dataKategori = [
            ['id' => 1,  'nama_kategori' => 'Aksesoris',    'status' => 1],
            ['id' => 2,  'nama_kategori' => 'Atasan',       'status' => 1],
            ['id' => 3,  'nama_kategori' => 'Bawahan',      'status' => 1],
            ['id' => 4,  'nama_kategori' => 'Sepatu',       'status' => 1],
            ['id' => 5,  'nama_kategori' => 'Tas',          'status' => 1],
            ['id' => 6,  'nama_kategori' => 'Outerwear',    'status' => 1],
            ['id' => 7,  'nama_kategori' => 'Pakaian Formal', 'status' => 1],
            ['id' => 8,  'nama_kategori' => 'Pakaian Santai', 'status' => 1],
            ['id' => 9,  'nama_kategori' => 'Olahraga',     'status' => 1],
            ['id' => 10, 'nama_kategori' => 'Elektronik',   'status' => 0],
            ['id' => 11, 'nama_kategori' => 'Perhiasan',    'status' => 0],
            ['id' => 12, 'nama_kategori' => 'Travel',       'status' => 0],
            ['id' => 13, 'nama_kategori' => 'Vintage',      'status' => 0],
            ['id' => 14, 'nama_kategori' => 'Musiman',      'status' => 0],
            ['id' => 15, 'nama_kategori' => 'Anak-anak',    'status' => 1],
            ['id' => 16, 'nama_kategori' => 'Wanita',       'status' => 1],
            ['id' => 17, 'nama_kategori' => 'Pria',         'status' => 1],
            ['id' => 18, 'nama_kategori' => 'Unisex',       'status' => 1],
            ['id' => 19, 'nama_kategori' => 'Limited Edition', 'status' => 0],
            ['id' => 20, 'nama_kategori' => 'Diskon',       'status' => 0],
        ];

        return $dataKategori;
    }

    public function index()
    {
        $data = $this->getData();

        return view('pages.kelola_kategori', compact('data'));
    }
}
