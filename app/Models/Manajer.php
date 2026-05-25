<?php

namespace App\Models;

class Manajer extends User
{
    protected $table = 'users';

    public function lihatLaporan(): void
    {
        // Manager dapat melihat laporan stok barang dan riwayat transaksi
    }

    public function eksporLaporan(): void
    {
        // Manager dapat mengekspor laporan stok barang ke format Excel
    }

    public function tampilData(): array
    {
        return [
            'can_edit'   => false,
            'can_delete' => false,
            'data'       => Barang::all()->toArray(),
        ];
    }

    public function updateProfile(array $data): void
    {
        $this->update($data);
    }
}
