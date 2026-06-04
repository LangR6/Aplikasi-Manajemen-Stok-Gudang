<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'kode_barang';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'foto_barang',
        'stok',
        'id_kategori'
    ];

    // CREATE - menyimpan data barang baru ke database
    public function tambah(array $data): void
    {
        // menyimpan data barang baru ke dalam database
        self::create($data);
    }

    // UPDATE - memperbarui data barang berdasarkan kode_barang
    public function edit(string $kodeBarang, array $data): void
    {
        // mencari barang berdasarkan kode_barang, lalu memperbarui datanya
        self::where('kode_barang', $kodeBarang)->update($data);
    }

    // DELETE - soft delete barang berdasarkan kode_barang
    public function hapus(string $kodeBarang): void
    {
        // menghapus barang secara soft delete
        // data tidak benar-benar terhapus, hanya kolom deleted_at yang diisi
        self::where('kode_barang', $kodeBarang)->delete();
    }

    // relasi ke kategori
    public function kategori()
    {
        // setiap barang hanya memiliki satu kategori
        // withTrashed() supaya kategori yang sudah dihapus tetap bisa dimuat
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori')->withTrashed();
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