<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table      = 'barang';
    protected $primaryKey = 'kode_barang';
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'foto_barang',
        'stok',
        'id_kategori',
        'stok_menipis_dibaca_pada',
        'stok_habis_dibaca_pada',
    ];

    // relasi ke kategori
    public function kategori()
    {
        // setiap barang hanya memiliki satu kategori
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // relasi ke transaksi masuk
    public function barangMasuk()
    {
        // satu barang bisa memiliki banyak transaksi masuk
        return $this->hasMany(BarangMasuk::class, 'id_barang', 'kode_barang');
    }

    // relasi ke transaksi keluar
    public function barangKeluar()
    {
        // satu barang bisa memiliki banyak transaksi keluar
        return $this->hasMany(BarangKeluar::class, 'id_barang', 'kode_barang');
    }
}
