<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = [
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
        ];

        return view('admin.kelola_supplier', compact('suppliers'));
    }
}