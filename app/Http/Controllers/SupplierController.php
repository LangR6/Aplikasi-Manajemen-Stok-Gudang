<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SupplierController extends Controller
{
    public function index()
    {
        $data = collect([
            [
                'id' => 1,
                'nama_supplier' => 'CV Sumber Jaya',
                'kontak' => '0812-3456-7890',
                'email' => 'sumberjaya@email.com',
                'kota' => 'Bandung',
            ],
            [
                'id' => 2,
                'nama_supplier' => 'PT Maju Terus',
                'kontak' => '0813-2222-1111',
                'email' => 'maju@email.com',
                'kota' => 'Jakarta',
            ],
            [
                'id' => 3,
                'nama_supplier' => 'UD Makmur',
                'kontak' => '0821-7788-8899',
                'email' => 'makmur@email.com',
                'kota' => 'Surabaya',
            ],
            [
                'id' => 4,
                'nama_supplier' => 'Future Smile',
                'kontak' => '0821-7788-5566',
                'email' => 'futuresmile@email.com',
                'kota' => 'Yogyakarta',
            ],
            [
                'id' => 5,
                'nama_supplier' => 'Sejahtera bersama dia',
                'kontak' => '0821-5021-8899',
                'email' => 'sejahtera@email.com',
                'kota' => 'Makasar',
            ],
            [
                'id' => 6,
                'nama_supplier' => 'Maju Selalu',
                'kontak' => '0821-7788-8899',
                'email' => 'majuselalu@email.com',
                'kota' => 'Padang',
            ],
            [
                'id' => 7,
                'nama_supplier' => 'Pt Terang Bulan',
                'kontak' => '0821-7788-8899',
                'email' => 'terangbulan@email.com',
                'kota' => 'Tanggerang',
            ],
            [
                'id' => 8,
                'nama_supplier' => 'Pt Cahaya Matahari',
                'kontak' => '0821-7788-8899',
                'email' => 'cahayamatahari@email.com',
                'kota' => 'Bandung',
            ],
            [
                'id' => 9,
                'nama_supplier' => 'Bersinar Terang',
                'kontak' => '0821-7788-8899',
                'email' => 'bersinar@email.com',
                'kota' => 'Pekanbaru',
            ],
            [
                'id' => 10,
                'nama_supplier' => 'Ilmu Padi',
                'kontak' => '0821-7788-8899',
                'email' => 'ilmupadi@email.com',
                'kota' => 'Tanggerang',
            ],
            [
                'id' => 11,
                'nama_supplier' => 'Dua Saudara',
                'kontak' => '0890-5523-7967',
                'email' => 'duasaudara@email.com',
                'kota' => 'Bogor',
            ],
            [
                'id' => 12,
                'nama_supplier' => 'Kelinci Putih',
                'kontak' => '0890-5523-7967',
                'email' => 'kelinciputih@email.com',
                'kota' => 'Bandung',
            ],
            [
                'id' => 13,
                'nama_supplier' => 'Pt Hari Esok',
                'kontak' => '0890-5523-7967',
                'email' => 'hariesok@email.com',
                'kota' => 'Batam',
            ],
        ]);

        $perPage = 10;
        $currentPage = request()->get('page', 1);

        $currentItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $suppliers = new LengthAwarePaginator(
            $currentItems,
            $data->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('pages.kelola_supplier', compact('suppliers'));
    }
}
