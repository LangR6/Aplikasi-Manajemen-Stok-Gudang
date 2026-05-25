<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Admin extends User
{
    protected $table = 'users';

    public function kelolaBarang(): void
    {
        // Admin memiliki akses penuh untuk menambah, mengubah, dan menghapus data barang
    }

    public function kelolaSupplier(): void
    {
        // Admin memiliki akses penuh untuk menambah, mengubah, dan menghapus data supplier
    }

    public function kelolaKategori(): void
    {
        // Admin memiliki akses penuh untuk menambah, mengubah, dan menghapus data kategori
    }

    public function catatTransaksi(): void
    {
        // Admin dapat mencatat transaksi barang masuk maupun barang keluar
    }

    public function tandaiDibaca(int $id): void
    {
        DB::table('notifikasi')->where('id', $id)->update(['is_read' => true]);
    }

    public function tampilData(): array
    {
        return [
            'can_edit'   => true,
            'can_delete' => true,
            'data'       => Barang::all()->toArray(),
        ];
    }

    public function updateProfile(array $data): void
    {
        $this->update($data);
    }
}
