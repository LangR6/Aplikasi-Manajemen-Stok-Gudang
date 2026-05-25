app/Models/Barang.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'foto_barang',
        'stok',
        'id_kategori'
    ];

    protected $dates = ['deleted_at'];

    public function tambah(array $data): void
    {
        // menyimpan data barang baru ke dalam database
        self::create($data);
    }

    public function edit(int $id, array $data): void
    {
        // mencari barang berdasarkan id, lalu memperbarui datanya
        self::where('id', $id)->update($data);
    }

    public function hapus(int $id): void
    {
        // menghapus barang secara soft delete
        // data tidak benar-benar terhapus, hanya kolom deleted_at yang diisi
        self::where('id', $id)->delete();
    }

    public function kategori()
    {
        // setiap barang hanya memiliki satu kategori
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function barangMasuk()
    {
        // satu barang bisa memiliki banyak transaksi masuk
        return $this->hasMany(BarangMasuk::class, 'id_barang');
    }

    public function barangKeluar()
    {
        // satu barang bisa memiliki banyak transaksi keluar
        return $this->hasMany(BarangKeluar::class, 'id_barang');
    }
}
