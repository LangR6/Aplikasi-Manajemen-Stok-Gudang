app/Models/Kategori.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'status'
    ];

    protected $dates = ['deleted_at'];

    public function tambah(array $data): void
    {
        // menyimpan data kategori baru ke dalam database
        self::create($data);
    }

    public function edit(int $id, array $data): void
    {
        // mencari kategori berdasarkan id, lalu memperbarui datanya
        self::where('id', $id)->update($data);
    }

    public function hapus(int $id): void
    {
        // menghapus kategori secara soft delete
        // data tidak benar-benar terhapus, hanya kolom deleted_at yang diisi
        self::where('id', $id)->delete();
    }

    public function barang()
    {
        // satu kategori bisa memiliki banyak barang
        return $this->hasMany(Barang::class, 'id_kategori');
    }
}
