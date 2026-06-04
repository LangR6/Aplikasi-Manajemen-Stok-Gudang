<?php

namespace App\Models;

use Exception;

class BarangKeluar extends TransaksiStok
{
    protected $table = 'barang_keluar';

    protected $primaryKey = 'id_barang_keluar';

    protected $fillable = [
        'id_barang',
        'jumlah',
        'tgl_keluar',
        'tujuan',
        'keterangan',
        'dicatat_oleh',
    ];

    public function catat(array $data): void
    {
        // POLYMORPHISME:
        // mengimplementasikan method catat() dari abstract class TransaksiStok
        // bedanya dengan BarangMasuk, method ini akan MENGURANGI stok barang

        // mencari barang berdasarkan kode_barang
        $barang = Barang::where(
            'kode_barang',
            $data['id_barang']
        )->first();

        // validasi jika barang tidak ditemukan
        if (!$barang) {
            throw new Exception('Barang tidak ditemukan.');
        }

        // validasi agar stok tidak menjadi minus
        if ($barang->stok < $data['jumlah']) {
            throw new Exception('Stok barang tidak mencukupi.');
        }

        // menyimpan data transaksi barang keluar ke database
        self::create($data);

        // mengurangi stok barang secara otomatis
        // pakai kode_barang karena itu primary key tabel barang
        $barang->decrement('stok', $data['jumlah']);
    }

    public function barang()
    {
        // foreign key id_barang di tabel barang_keluar
        // merujuk ke kode_barang pada tabel barang
        return $this->belongsTo(
            Barang::class,
            'id_barang',
            'kode_barang'
        );
    }
}
