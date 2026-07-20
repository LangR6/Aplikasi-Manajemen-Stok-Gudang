<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'nama_supplier' => 'PT Sumber Jaya',
                'no_kontak' => '081234567890',
                'email' => 'sumberjaya@gmail.com',
                'kota' => 'Bandung',
            ],
            [
                'nama_supplier' => 'CV Maju Bersama',
                'no_kontak' => '082345678901',
                'email' => 'majubersama@gmail.com',
                'kota' => 'Jakarta',
            ],
            [
                'nama_supplier' => 'PT Cahaya Abadi',
                'no_kontak' => '083456789012',
                'email' => 'cahayaabadi@gmail.com',
                'kota' => 'Surabaya',
            ],
            [
                'nama_supplier' => 'CV Makmur Sentosa',
                'no_kontak' => '084567890123',
                'email' => 'makmursentosa@gmail.com',
                'kota' => 'Batam',
            ],
            [
                'nama_supplier' => 'PT Berkah Rizki',
                'no_kontak' => '085678901234',
                'email' => 'berkahrizki@gmail.com',
                'kota' => 'Medan',
            ],
            [
                'nama_supplier' => 'PT Nusantara Logistik',
                'no_kontak' => '081111111111',
                'email' => 'nusantara@gmail.com',
                'kota' => 'Semarang',
            ],
            [
                'nama_supplier' => 'CV Sejahtera Abadi',
                'no_kontak' => '082222222222',
                'email' => 'sejahtera@gmail.com',
                'kota' => 'Yogyakarta',
            ],
            [
                'nama_supplier' => 'PT Sinar Terang',
                'no_kontak' => '083333333333',
                'email' => 'sinarterang@gmail.com',
                'kota' => 'Makassar',
            ],
            [
                'nama_supplier' => 'CV Harapan Baru',
                'no_kontak' => '084444444444',
                'email' => 'harapanbaru@gmail.com',
                'kota' => 'Palembang',
            ],
            [
                'nama_supplier' => 'PT Mitra Utama',
                'no_kontak' => '085555555555',
                'email' => 'mitrautama@gmail.com',
                'kota' => 'Pekanbaru',
            ],
            [
                'nama_supplier' => 'PT Global Mandiri',
                'no_kontak' => '081666666666',
                'email' => 'globalmandiri@gmail.com',
                'kota' => 'Bogor',
            ],
            [
                'nama_supplier' => 'CV Anugerah Jaya',
                'no_kontak' => '082777777777',
                'email' => 'anugerahjaya@gmail.com',
                'kota' => 'Depok',
            ],
            [
                'nama_supplier' => 'PT Sentosa Abadi',
                'no_kontak' => '083888888888',
                'email' => 'sentosaabadi@gmail.com',
                'kota' => 'Bekasi',
            ],
            [
                'nama_supplier' => 'CV Bintang Timur',
                'no_kontak' => '084999999999',
                'email' => 'bintangtimur@gmail.com',
                'kota' => 'Tangerang',
            ],
            [
                'nama_supplier' => 'PT Jaya Makmur',
                'no_kontak' => '085111111222',
                'email' => 'jayamakmur@gmail.com',
                'kota' => 'Cirebon',
            ],
            [
                'nama_supplier' => 'CV Mitra Sejahtera',
                'no_kontak' => '081222333444',
                'email' => 'mitrasejahtera@gmail.com',
                'kota' => 'Tasikmalaya',
            ],
            [
                'nama_supplier' => 'PT Prima Logistik',
                'no_kontak' => '082333444555',
                'email' => 'primalogistik@gmail.com',
                'kota' => 'Balikpapan',
            ],
            [
                'nama_supplier' => 'CV Karya Nusantara',
                'no_kontak' => '083444555666',
                'email' => 'karyanusantara@gmail.com',
                'kota' => 'Pontianak',
            ],
            [
                'nama_supplier' => 'PT Indo Supplier',
                'no_kontak' => '084555666777',
                'email' => 'indosupplier@gmail.com',
                'kota' => 'Manado',
            ],
            [
                'nama_supplier' => 'CV Surya Gemilang',
                'no_kontak' => '085666777888',
                'email' => 'suryagemilang@gmail.com',
                'kota' => 'Samarinda',
            ],
            [
                'nama_supplier' => 'PT Mega Utama',
                'no_kontak' => '081777888999',
                'email' => 'megautama@gmail.com',
                'kota' => 'Banjarmasin',
            ],
            [
                'nama_supplier' => 'CV Kencana Abadi',
                'no_kontak' => '082888999000',
                'email' => 'kencanaabadi@gmail.com',
                'kota' => 'Malang',
            ],
            [
                'nama_supplier' => 'PT Sukses Selalu',
                'no_kontak' => '083999000111',
                'email' => 'suksesselalu@gmail.com',
                'kota' => 'Kediri',
            ],
            [
                'nama_supplier' => 'CV Mutiara Jaya',
                'no_kontak' => '084111222333',
                'email' => 'mutiarajaya@gmail.com',
                'kota' => 'Jambi',
            ],
            [
                'nama_supplier' => 'PT Artha Mandiri',
                'no_kontak' => '085222333444',
                'email' => 'arthamandiri@gmail.com',
                'kota' => 'Banda Aceh',
            ],
        ];

        foreach ($suppliers as $item) {
            Supplier::firstOrCreate(
                ['nama_supplier' => $item['nama_supplier']],
                [
                    'no_kontak' => $item['no_kontak'],
                    'email' => $item['email'],
                    'kota' => $item['kota'],
                ]
            );
        }
    }
}
