<?php
namespace App\Models;

class BarangKeluar extends TransaksiStok
{
    protected $table = 'barang_keluar';

    protected $fillable = [
        'id_barang',
        'jumlah',
        'tgl_keluar',
        'tujuan',
        'keterangan'
    ];

    public function catat(array $data): void
    {
        // POLYMORPHISME: mengimplementasikan catat() dari abstract class TransaksiStok
        // bedanya dengan BarangMasuk, method ini akan MENGURANGI stok barang

        // mencari data barang berdasarkan id
        $barang = Barang::find($data['id_barang']);

        // mengecek apakah stok barang mencukupi sebelum transaksi diproses
        if ($barang && $barang->stok >= $data['jumlah']) {

            // menyimpan data transaksi barang keluar ke database
            self::create($data);

            // mengurangi stok barang secara otomatis sesuai jumlah yang diinput
            $barang->decrement('stok', $data['jumlah']);
        }
    }
}
