app/Models/BarangMasuk.php
<?php
namespace App\Models;

class BarangMasuk extends TransaksiStok
{
    protected $table = 'barang_masuk';

    protected $fillable = [
        'id_barang',
        'id_supplier',
        'jumlah',
        'tgl_masuk',
        'keterangan'
    ];

    public function catat(array $data): void
    {
        // POLYMORPHISME: mengimplementasikan catat() dari abstract class TransaksiStok
        // bedanya dengan BarangKeluar, method ini akan MENAMBAH stok barang

        // menyimpan data transaksi barang masuk ke database
        self::create($data);

        // menambah stok barang secara otomatis sesuai jumlah yang diinput
        Barang::where('id', $data['id_barang'])
            ->increment('stok', $data['jumlah']);
    }

    public function supplier()
    {
        // setiap transaksi barang masuk terhubung ke satu supplier
        return $this->belongsTo(Supplier::class, 'id_supplier');
    }
}
