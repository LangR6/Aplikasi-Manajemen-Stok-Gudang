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
        Supplier::insert([
            [
                'nama_supplier' => 'PT Sumber Jaya',
                'no_kontak' => '081234567890',
                'email' => 'sumberjaya@gmail.com',
                'kota' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Maju Bersama',
                'no_kontak' => '082345678901',
                'email' => 'majubersama@gmail.com',
                'kota' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Cahaya Abadi',
                'no_kontak' => '083456789012',
                'email' => 'cahayaabadi@gmail.com',
                'kota' => 'Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Makmur Sentosa',
                'no_kontak' => '084567890123',
                'email' => 'makmursentosa@gmail.com',
                'kota' => 'Batam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Berkah Rizki',
                'no_kontak' => '085678901234',
                'email' => 'berkahrizki@gmail.com',
                'kota' => 'Medan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Nusantara Logistik',
                'no_kontak' => '081111111111',
                'email' => 'nusantara@gmail.com',
                'kota' => 'Semarang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Sejahtera Abadi',
                'no_kontak' => '082222222222',
                'email' => 'sejahtera@gmail.com',
                'kota' => 'Yogyakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Sinar Terang',
                'no_kontak' => '083333333333',
                'email' => 'sinarterang@gmail.com',
                'kota' => 'Makassar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Harapan Baru',
                'no_kontak' => '084444444444',
                'email' => 'harapanbaru@gmail.com',
                'kota' => 'Palembang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Mitra Utama',
                'no_kontak' => '085555555555',
                'email' => 'mitrautama@gmail.com',
                'kota' => 'Pekanbaru',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Global Mandiri',
                'no_kontak' => '081666666666',
                'email' => 'globalmandiri@gmail.com',
                'kota' => 'Bogor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Anugerah Jaya',
                'no_kontak' => '082777777777',
                'email' => 'anugerahjaya@gmail.com',
                'kota' => 'Depok',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Sentosa Abadi',
                'no_kontak' => '083888888888',
                'email' => 'sentosaabadi@gmail.com',
                'kota' => 'Bekasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Bintang Timur',
                'no_kontak' => '084999999999',
                'email' => 'bintangtimur@gmail.com',
                'kota' => 'Tangerang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Jaya Makmur',
                'no_kontak' => '085111111222',
                'email' => 'jayamakmur@gmail.com',
                'kota' => 'Cirebon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Mitra Sejahtera',
                'no_kontak' => '081222333444',
                'email' => 'mitrasejahtera@gmail.com',
                'kota' => 'Tasikmalaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Prima Logistik',
                'no_kontak' => '082333444555',
                'email' => 'primalogistik@gmail.com',
                'kota' => 'Balikpapan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Karya Nusantara',
                'no_kontak' => '083444555666',
                'email' => 'karyanusantara@gmail.com',
                'kota' => 'Pontianak',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Indo Supplier',
                'no_kontak' => '084555666777',
                'email' => 'indosupplier@gmail.com',
                'kota' => 'Manado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Surya Gemilang',
                'no_kontak' => '085666777888',
                'email' => 'suryagemilang@gmail.com',
                'kota' => 'Samarinda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Mega Utama',
                'no_kontak' => '081777888999',
                'email' => 'megautama@gmail.com',
                'kota' => 'Banjarmasin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Kencana Abadi',
                'no_kontak' => '082888999000',
                'email' => 'kencanaabadi@gmail.com',
                'kota' => 'Malang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Sukses Selalu',
                'no_kontak' => '083999000111',
                'email' => 'suksesselalu@gmail.com',
                'kota' => 'Kediri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'CV Mutiara Jaya',
                'no_kontak' => '084111222333',
                'email' => 'mutiarajaya@gmail.com',
                'kota' => 'Jambi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_supplier' => 'PT Artha Mandiri',
                'no_kontak' => '085222333444',
                'email' => 'arthamandiri@gmail.com',
                'kota' => 'Banda Aceh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
