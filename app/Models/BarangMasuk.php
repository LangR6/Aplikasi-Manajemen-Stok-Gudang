<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
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

    /**
     * Relasi Many To One ke tabel barang.
     * Setiap transaksi barang masuk terkait dengan satu barang,
     * sedangkan satu barang dapat memiliki banyak transaksi barang masuk.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'kode_barang');
    }

    /**
     * Relasi Many To One ke tabel supplier.
     * Setiap transaksi barang masuk berasal dari satu supplier,
     * sedangkan satu supplier dapat memiliki banyak transaksi barang masuk.
     */
    public function supplier()
    {
        return $this->belongsTo(
            Supplier::class,
            'id_supplier',
            'id_supplier'
            // withTrashed supaya riwayat tetap tampil meski supplier dihapus
        )->withTrashed();
    }
}
