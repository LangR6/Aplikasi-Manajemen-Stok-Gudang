<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'supplier';

    protected $primaryKey = 'id_supplier';

    protected $fillable = [
        'nama_supplier',
        'no_kontak',
        'email',
        'kota'
    ];

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_supplier', 'id_supplier');
    }
}
