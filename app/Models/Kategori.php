<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'status'
    ];
    protected $dates = ['deleted_at'];

    // CREATE - menyimpan data kategori baru ke database
    public function tambah(array $data): void
    {
        self::create($data);
    }

    // UPDATE - memperbarui data kategori berdasarkan id
    public function edit(int $id, array $data): void
    {
        self::where('id_kategori', $id)->update($data);
    }

    // DELETE - soft delete kategori berdasarkan id
    public function hapus(int $id): void
    {
        self::where('id_kategori', $id)->delete();
    }

    // relasi ke barang
    public function barang()
    {
        // satu kategori bisa memiliki banyak barang
        return $this->hasMany(Barang::class, 'id_kategori');
    }
}