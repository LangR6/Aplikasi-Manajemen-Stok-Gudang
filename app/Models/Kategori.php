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
        'status',
    ];

    // relasi ke barang
    public function barang()
    {
        // satu kategori dapat memiliki banyak barang,
        return $this->hasMany(Barang::class, 'id_kategori');
    }
}
