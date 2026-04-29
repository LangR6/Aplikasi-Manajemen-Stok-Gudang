<?php

namespace App\Http\Controllers;

class KelolaBarangController extends Controller
{

    private function getAllBarang(): array
    {
        return [
            ['kode' => 'BRG-001', 'nama' => 'Topi Bucket',    'stok' => 12, 'kategori' => 'Aksesoris', 'foto' => 'foto1.jpg'],
            ['kode' => 'BRG-002', 'nama' => 'Topi Snapback',  'stok' => 10, 'kategori' => 'Aksesoris', 'foto' => 'foto2.jpg'],
            ['kode' => 'BRG-003', 'nama' => 'Kaos Polos',     'stok' => 20, 'kategori' => 'Atasan',    'foto' => 'foto3.jpg'],
            ['kode' => 'BRG-004', 'nama' => 'Kaos Stripe',    'stok' => 9,  'kategori' => 'Atasan',    'foto' => 'foto4.jpg'],
            ['kode' => 'BRG-005', 'nama' => 'Sweater Hoodie', 'stok' => 5,  'kategori' => 'Atasan',    'foto' => 'foto5.jpg'],
            ['kode' => 'BRG-006', 'nama' => 'Kemeja Flannel', 'stok' => 4,  'kategori' => 'Atasan',    'foto' => 'foto6.jpg'],
            ['kode' => 'BRG-007', 'nama' => 'Celana Jogger',  'stok' => 3,  'kategori' => 'Bawahan',   'foto' => 'foto7.jpg'],
            ['kode' => 'BRG-008', 'nama' => 'Celana Jeans',   'stok' => 2,  'kategori' => 'Bawahan',   'foto' => 'foto8.jpg'],
            ['kode' => 'BRG-009', 'nama' => 'Rok Mini',       'stok' => 1,  'kategori' => 'Bawahan',   'foto' => 'foto9.jpg'],
            ['kode' => 'BRG-010', 'nama' => 'Celana Chino',   'stok' => 0,  'kategori' => 'Bawahan',   'foto' => 'foto10.jpg'],
            ['kode' => 'BRG-011', 'nama' => 'Sneakers Putih', 'stok' => 0,  'kategori' => 'Sepatu',    'foto' => 'foto11.jpg'],
            ['kode' => 'BRG-012', 'nama' => 'Loafers Hitam',  'stok' => 0,  'kategori' => 'Sepatu',    'foto' => 'foto12.jpg'],
            ['kode' => 'BRG-013', 'nama' => 'Sandal Slides',  'stok' => 0,  'kategori' => 'Sepatu',    'foto' => 'foto13.jpg'],
            ['kode' => 'BRG-014', 'nama' => 'Tas Selempang',  'stok' => 0,  'kategori' => 'Tas',       'foto' => 'foto14.jpg'],
            ['kode' => 'BRG-015', 'nama' => 'Tas Ransel',     'stok' => 0,  'kategori' => 'Tas',       'foto' => 'foto15.jpg'],
            ['kode' => 'BRG-016', 'nama' => 'Clutch Bag',     'stok' => 0,  'kategori' => 'Tas',       'foto' => 'foto16.jpg'],
            ['kode' => 'BRG-017', 'nama' => 'Ikat Pinggang',  'stok' => 11, 'kategori' => 'Aksesoris', 'foto' => 'foto17.jpg'],
            ['kode' => 'BRG-018', 'nama' => 'Kacamata Hitam', 'stok' => 3,  'kategori' => 'Aksesoris', 'foto' => 'foto18.jpg'],
            ['kode' => 'BRG-019', 'nama' => 'Jam Tangan',     'stok' => 7,  'kategori' => 'Aksesoris', 'foto' => 'foto19.jpg'],
            ['kode' => 'BRG-020', 'nama' => 'Cardigan',       'stok' => 6,  'kategori' => 'Atasan',    'foto' => 'foto20.jpg'],
            ['kode' => 'BRG-021', 'nama' => 'Blazer',         'stok' => 4,  'kategori' => 'Atasan',    'foto' => 'foto21.jpg'],
            ['kode' => 'BRG-022', 'nama' => 'Celana Pendek',  'stok' => 8,  'kategori' => 'Bawahan',   'foto' => 'foto22.jpg'],
            ['kode' => 'BRG-023', 'nama' => 'Sepatu Boots',   'stok' => 2,  'kategori' => 'Sepatu',    'foto' => 'foto23.jpg'],
            ['kode' => 'BRG-024', 'nama' => 'Tas Travel',     'stok' => 1,  'kategori' => 'Tas',       'foto' => 'foto24.jpg'],
            ['kode' => 'BRG-025', 'nama' => 'Dompet Kulit',   'stok' => 9,  'kategori' => 'Aksesoris', 'foto' => 'foto25.jpg'],
            ['kode' => 'BRG-026', 'nama' => 'Topi Fedora',      'stok' => 6,  'kategori' => 'Aksesoris', 'foto' => 'foto26.jpg'],
            ['kode' => 'BRG-027', 'nama' => 'Gelang Kulit',     'stok' => 13, 'kategori' => 'Aksesoris', 'foto' => 'foto27.jpg'],
            ['kode' => 'BRG-028', 'nama' => 'Kalung Pria',      'stok' => 2,  'kategori' => 'Aksesoris', 'foto' => 'foto28.jpg'],
            ['kode' => 'BRG-029', 'nama' => 'Kaos Oversize',    'stok' => 15, 'kategori' => 'Atasan',    'foto' => 'foto29.jpg'],
            ['kode' => 'BRG-030', 'nama' => 'Kemeja Denim',     'stok' => 7,  'kategori' => 'Atasan',    'foto' => 'foto30.jpg'],
            ['kode' => 'BRG-031', 'nama' => 'Jaket Parka',      'stok' => 3,  'kategori' => 'Atasan',    'foto' => 'foto31.jpg'],
            ['kode' => 'BRG-032', 'nama' => 'Celana Cargo',     'stok' => 5,  'kategori' => 'Bawahan',   'foto' => 'foto32.jpg'],
            ['kode' => 'BRG-033', 'nama' => 'Celana Formal',    'stok' => 9,  'kategori' => 'Bawahan',   'foto' => 'foto33.jpg'],
            ['kode' => 'BRG-034', 'nama' => 'Rok Panjang',      'stok' => 4,  'kategori' => 'Bawahan',   'foto' => 'foto34.jpg'],
            ['kode' => 'BRG-035', 'nama' => 'Sepatu Running',   'stok' => 6,  'kategori' => 'Sepatu',    'foto' => 'foto35.jpg'],
        ];
    }

    private function getKategoriList(): array
    {
        return ['Aksesoris', 'Atasan', 'Bawahan', 'Sepatu', 'Tas'];
    }

    private function getSupplierList(): array
    {
        return [
            'Toko Grosir Batam',
            'Distributor Fashion',
            'PT Sneaker Indo Jaya',
            'Reseller Partner',
            'Konveksi Lokal',
            'PT Fashion Nusantara',
            'Supplier Aksesoris Korea',
            'UD Mode Fashion',
        ];
    }

    public function index()
    {
        $data = array_map(function ($item) {
            $item['foto_url'] = $item['foto']
                ? asset('images/' . $item['foto'])
                : null;
            return $item;
        }, $this->getAllBarang());

        $kategori = $this->getKategoriList();
        $supplier = $this->getSupplierList();

        return view('pages.kelola_barang', compact('data', 'kategori', 'supplier'));
    }
}
