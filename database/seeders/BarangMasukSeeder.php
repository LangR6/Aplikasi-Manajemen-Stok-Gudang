<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\User;
use App\Models\BarangMasuk;

class BarangMasukSeeder extends Seeder
{
    public function run(): void
    {
        $barangList   = Barang::all();
        $supplierList = Supplier::all();
        $userList = User::where('role', 'admin')->pluck('username');

        if ($barangList->isEmpty() || $supplierList->isEmpty()) {
            $this->command->warn('Barang atau Supplier masih kosong. Seed dulu sebelum jalanin BarangMasukSeeder.');
            return;
        }

        $keteranganList = [
            'Barang Lengkap',
            'Kondisi baik',
            'Sesuai pesanan',
            'Ada sedikit kerusakan pada kemasan',
            null,
        ];

        for ($i = 0; $i < 40; $i++) {
            $tanggal = Carbon::now()->subDays(rand(0, 180));

            BarangMasuk::create([
                'id_barang'    => $barangList->random()->kode_barang,
                'id_supplier'  => $supplierList->random()->id_supplier,
                'jumlah'       => rand(5, 100),
                'tgl_masuk'    => $tanggal->format('Y-m-d'),
                'keterangan'   => $keteranganList[array_rand($keteranganList)],
                'dicatat_oleh' => $userList->isNotEmpty() ? $userList->random() : 'admin1',
                'created_at'   => $tanggal,
                'updated_at'   => $tanggal,
            ]);
        }
    }
}
