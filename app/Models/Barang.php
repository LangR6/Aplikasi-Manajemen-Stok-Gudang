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
        'stok_habis_dibaca_pada'
    ];

    // CREATE - menyimpan data barang baru ke database
    public function tambah(array $data): void
    {
        // menyimpan data barang baru ke dalam database
        self::create($data);
    }

    // READ - mengambil semua data barang beserta kategorinya
    public function tampilSemua(): array
    {
        // mengambil semua barang yang belum dihapus beserta relasi kategorinya
        return self::with('kategori')->get()->toArray();
    }

    // UPDATE - memperbarui data barang berdasarkan kode_barang
    public function edit(string $kodeBarang, array $data): void
    {
        // mencari barang berdasarkan kode_barang, lalu memperbarui datanya
        self::where('kode_barang', $kodeBarang)->update($data);
    }

    // relasi ke kategori
    public function kategori()
    {
        // setiap barang hanya memiliki satu kategori
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // relasi ke transaksi
    public function barangMasuk()
    {
        // satu barang bisa memiliki banyak transaksi masuk
        return $this->hasMany(BarangMasuk::class, 'id_barang', 'kode_barang');
    }

    public function barangKeluar()
    {
        // satu barang bisa memiliki banyak transaksi keluar
        return $this->hasMany(BarangKeluar::class, 'id_barang', 'kode_barang');
    }
}
