<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
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

    /**
     * Relasi Many To One ke tabel barang.
     * Setiap transaksi barang keluar hanya terkait dengan satu barang,
     * sedangkan satu barang dapat memiliki banyak transaksi barang keluar.
     */
    public function barang()
    {
        return $this->belongsTo(
            Barang::class,
            'id_barang',
            'kode_barang'
        );
    }
}
