app/Models/Supplier.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate
\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'supplier';

    protected $fillable = [
        'nama_supplier',
        'no_kontak',
        'email',
        'kota'
    ];

    protected $dates = ['deleted_at'];

    public function tambah(array $data): void
    {
        // menyimpan data supplier baru ke dalam database
        self::create($data);
    }

    public function edit(int $id, array $data): void
    {
        // mencari supplier berdasarkan id, lalu memperbarui datanya
        self::where('id', $id)->update($data);
    }

    public function hapus(int $id): void
    {
        // menghapus supplier secara soft delete
        // data tidak benar-benar terhapus, hanya kolom deleted_at yang diisi
        self::where('id', $id)->delete();
    }

    public function barangMasuk()
    {
        // satu supplier bisa memiliki banyak transaksi barang masuk
        return $this->hasMany(BarangMasuk::class, 'id_supplier');
    }
}
