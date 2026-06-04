<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class TransaksiStok extends Model
{
    protected $fillable = [
        'id_barang',
        'jumlah',
        'tanggal',
        'keterangan'
    ];

    public function catat(array $data): void
    {
        // abstract method - wajib diimplementasikan oleh subclass
        // BarangMasuk akan menambah stok, BarangKeluar akan mengurangi stok
    }

    public function tampilRiwayat(): array
    {
        // mengambil semua riwayat transaksi beserta data barangnya
        // diurutkan dari transaksi terbaru
        return self::with('barang')
            ->orderBy('tanggal', 'desc')
            ->get()
            ->toArray();
    }

    public function validasi(array $data): bool
    {
        // memastikan id_barang dan jumlah tidak kosong sebelum transaksi diproses
        if (empty($data['id_barang']) || empty($data['jumlah'])) {
            return false;
        }
        return true;
    }

    public function barang()
    {
        // setiap transaksi hanya terhubung ke satu barang
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
