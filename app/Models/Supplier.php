<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = 'supplier';

    // PRIMARY KEY DATABASE
    protected $primaryKey = 'id_supplier';

    protected $fillable = [
        'nama_supplier',
        'no_kontak',
        'email',
        'kota',
        'dicatat_oleh'
    ];

    protected $dates = ['deleted_at'];

    public function tambah(array $data): void
    {
        self::create($data);
    }

    public function edit(int $id, array $data): void
    {
        self::where('id_supplier', $id)->update($data);
    }

    public function hapus(int $id): void
    {
        self::where('id_supplier', $id)->delete();
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'id_supplier');
    }
}
