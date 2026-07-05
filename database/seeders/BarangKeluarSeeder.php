<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\Barang;
use App\Models\User;
use App\Models\BarangKeluar;

class BarangKeluarSeeder extends Seeder
{
    public function run(): void
    {
        $barangList = Barang::all();
        $userList = User::where('role', 'admin')->pluck('username');

        if ($barangList->isEmpty()) {
            $this->command->warn('Barang masih kosong. Seed dulu sebelum jalanin BarangKeluarSeeder.');
            return;
        }

        $tujuanList = [
            'Yogyakarta',
            'Bandung',
            'Surabaya',
            'Semarang',
            'Jakarta',
            'Medan',
            'Makassar',
        ];

        $keteranganList = [
            'Barang Lengkap',
            'Dikirim sesuai jadwal',
            'Pengiriman dipercepat',
            null,
        ];

        for ($i = 0; $i < 40; $i++) {
            $tanggal = Carbon::now()->subDays(rand(0, 180));

            BarangKeluar::create([
                'id_barang'    => $barangList->random()->kode_barang,
                'jumlah'       => rand(1, 50),
                'tgl_keluar'   => $tanggal->format('Y-m-d'),
                'tujuan'       => $tujuanList[array_rand($tujuanList)],
                'keterangan'   => $keteranganList[array_rand($keteranganList)],
                'dicatat_oleh' => $userList->isNotEmpty() ? $userList->random() : 'admin1',
                'created_at'   => $tanggal,
                'updated_at'   => $tanggal,
            ]);
        }
    }
}
