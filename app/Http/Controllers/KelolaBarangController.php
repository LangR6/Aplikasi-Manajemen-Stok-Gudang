<?php

namespace App\Http\Controllers;

class KelolaBarangController extends Controller
{

    private function getAllBarang(): array
    {
        return [
            ['kode' => 'BRG-001', 'nama' => 'Topi Bucket',    'stok' => 12, 'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-002', 'nama' => 'Topi Snapback',  'stok' => 10, 'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-003', 'nama' => 'Kaos Polos',     'stok' => 20, 'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-004', 'nama' => 'Kaos Stripe',    'stok' => 9,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-005', 'nama' => 'Sweater Hoodie', 'stok' => 5,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-006', 'nama' => 'Kemeja Flannel', 'stok' => 4,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-007', 'nama' => 'Celana Jogger',  'stok' => 3,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-008', 'nama' => 'Celana Jeans',   'stok' => 2,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-009', 'nama' => 'Rok Mini',       'stok' => 1,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-010', 'nama' => 'Celana Chino',   'stok' => 0,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-011', 'nama' => 'Sneakers Putih', 'stok' => 0,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-012', 'nama' => 'Loafers Hitam',  'stok' => 0,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-013', 'nama' => 'Sandal Slides',  'stok' => 0,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-014', 'nama' => 'Tas Selempang',  'stok' => 0,  'kategori' => 'Tas',       'foto' => null],
            ['kode' => 'BRG-015', 'nama' => 'Tas Ransel',     'stok' => 0,  'kategori' => 'Tas',       'foto' => null],
            ['kode' => 'BRG-016', 'nama' => 'Clutch Bag',     'stok' => 0,  'kategori' => 'Tas',       'foto' => null],
            ['kode' => 'BRG-017', 'nama' => 'Ikat Pinggang',  'stok' => 11, 'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-018', 'nama' => 'Kacamata Hitam', 'stok' => 3,  'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-019', 'nama' => 'Jam Tangan',     'stok' => 7,  'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-020', 'nama' => 'Cardigan',       'stok' => 6,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-021', 'nama' => 'Blazer',         'stok' => 4,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-022', 'nama' => 'Celana Pendek',  'stok' => 8,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-023', 'nama' => 'Sepatu Boots',   'stok' => 2,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-024', 'nama' => 'Tas Travel',     'stok' => 1,  'kategori' => 'Tas',       'foto' => null],
            ['kode' => 'BRG-025', 'nama' => 'Dompet Kulit',   'stok' => 9,  'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-026', 'nama' => 'Topi Fedora',      'stok' => 6,  'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-027', 'nama' => 'Gelang Kulit',     'stok' => 13, 'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-028', 'nama' => 'Kalung Pria',      'stok' => 2,  'kategori' => 'Aksesoris', 'foto' => null],
            ['kode' => 'BRG-029', 'nama' => 'Kaos Oversize',    'stok' => 15, 'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-030', 'nama' => 'Kemeja Denim',     'stok' => 7,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-031', 'nama' => 'Jaket Parka',      'stok' => 3,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-032', 'nama' => 'Celana Cargo',     'stok' => 5,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-033', 'nama' => 'Celana Formal',    'stok' => 9,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-034', 'nama' => 'Rok Panjang',      'stok' => 4,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-035', 'nama' => 'Sepatu Running',   'stok' => 6,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-036', 'nama' => 'Sepatu Formal',    'stok' => 2,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-037', 'nama' => 'Sandal Gunung',    'stok' => 1,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-038', 'nama' => 'Tas Laptop',       'stok' => 8,  'kategori' => 'Tas',       'foto' => null],
            ['kode' => 'BRG-039', 'nama' => 'Tas Pinggang',     'stok' => 5,  'kategori' => 'Tas',       'foto' => null],
            ['kode' => 'BRG-040', 'nama' => 'Tas Tote Bag',     'stok' => 11, 'kategori' => 'Tas',       'foto' => null],
            ['kode' => 'BRG-041', 'nama' => 'Kaos Vintage',     'stok' => 0,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-042', 'nama' => 'Jaket Kulit',      'stok' => 1,  'kategori' => 'Atasan',    'foto' => null],
            ['kode' => 'BRG-043', 'nama' => 'Celana Slim Fit',  'stok' => 2,  'kategori' => 'Bawahan',   'foto' => null],
            ['kode' => 'BRG-044', 'nama' => 'Sepatu Slip On',   'stok' => 0,  'kategori' => 'Sepatu',    'foto' => null],
            ['kode' => 'BRG-045', 'nama' => 'Tas Kanvas',       'stok' => 3,  'kategori' => 'Tas',       'foto' => null],
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
        $data      = $this->getAllBarang();
        $kategori  = $this->getKategoriList();
        $supplier  = $this->getSupplierList();

        return view('pages.kelola_barang', compact('data', 'kategori', 'supplier'));
    }
}
