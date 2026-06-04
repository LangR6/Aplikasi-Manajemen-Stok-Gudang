<?php

namespace App\Models;

class BarangMasuk extends TransaksiStok
{
    protected $table = 'barang_masuk';

    protected $primaryKey = 'id_barang_masuk';

    protected $fillable = [
        'id_barang',
        'id_supplier',
        'jumlah',
        'tgl_masuk',
        'keterangan',
        'dicatat_oleh',
    ];

    public function catat(array $data): void
    {
        // POLYMORPHISME:
        // mengimplementasikan method catat() dari abstract class TransaksiStok
        // bedanya dengan BarangKeluar, method ini akan MENAMBAH stok barang

        // menyimpan data transaksi barang masuk ke database
        self::create($data);

        // menambah stok barang secara otomatis sesuai jumlah yang diinput
        // pakai kode_barang karena itu primary key tabel barang
        Barang::where('kode_barang', $data['id_barang'])
            ->increment('stok', $data['jumlah']);
    }

    public function barang()
    {
        // foreign key id_barang di tabel barang_masuk
        // merujuk ke kode_barang pada tabel barang
        return $this->belongsTo(
            Barang::class,
            'id_barang',
            'kode_barang'
        );
    }

    public function supplier()
    {
        // withTrashed() supaya supplier yang sudah dihapus tetap bisa dimuat di riwayat
        return $this->belongsTo(
            Supplier::class,
            'id_supplier',
            'id_supplier'
        )->withTrashed();
    }
}
