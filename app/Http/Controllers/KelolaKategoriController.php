<?php

namespace App\Http\Controllers;

class KelolaKategoriController extends Controller
{
    public function getData()
    {
        $dataKategori = [
            ['id' => 1, 'nama_kategori' => 'Tas',   'status' => 1],
            ['id' => 2, 'nama_kategori' => 'Elektronik', 'status' => 0],
            ['id' => 3, 'nama_kategori' => 'Aksesoris',  'status' => 0],
            ['id' => 4, 'nama_kategori' => 'Dompet',     'status' => 0],
            ['id' => 5, 'nama_kategori' => 'Celana',     'status' => 0],
            ['id' => 6, 'nama_kategori' => 'Sepatu',     'status' => 0],
            ['id' => 7, 'nama_kategori' => 'Tas',     'status' => 1],
            ['id' => 8, 'nama_kategori' => 'Baju',     'status' => 1],
            ['id' => 9, 'nama_kategori' => 'Atasan',     'status' => 0],
            ['id' => 10, 'nama_kategori' => 'Atasan',     'status' => 0],
            ['id' => 11, 'nama_kategori' => 'Atasan',     'status' => 0],
            ['id' => 12, 'nama_kategori' => 'Atasan',     'status' => 0],
            ['id' => 13, 'nama_kategori' => 'Atasan',     'status' => 1],
            ['id' => 14, 'nama_kategori' => 'Atasan',     'status' => 1],
            ['id' => 15, 'nama_kategori' => 'Atasan',     'status' => 0],
            ['id' => 16, 'nama_kategori' => 'Atasan',     'status' => 0],

        ];

        return $dataKategori;
    }

    public function index()
    {
        $data = $this->getData();

        return view('pages.kelola_kategori', compact('data'));
    }
}