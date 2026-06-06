<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RiwayatExport
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function download()
    {
        $filters   = $this->filters;
        $adaFilter = !empty($filters['dari']) || !empty($filters['sampai']) || !empty($filters['jenis']) || !empty($filters['search']);

        // ===== AMBIL DATA MASUK =====
        $masuk = BarangMasuk::with(['barang.kategori', 'supplier'])
            ->get()
            ->map(function ($item) {
                return (object)[
                    'tanggal'       => $item->tgl_masuk,
                    'nama_barang'   => $item->barang->nama_barang ?? '-',
                    'jumlah'        => $item->jumlah,
                    'kota'          => $item->supplier->kota ?? '-',
                    'transaksi'     => 'Barang Masuk',
                    'kategori'      => $item->barang->kategori->nama_kategori ?? '-',
                    'nama_supplier' => $item->supplier->nama_supplier ?? '-',
                    'kontak'        => $item->supplier->no_kontak ?? '-',
                    'email'         => $item->supplier->email ?? '-',
                    'keterangan'    => $item->keterangan ?? '-',
                    'dicatat_oleh'  => $item->dicatat_oleh ?? '-',
                    'created_at'    => $item->created_at,
                ];
            });

        // ===== AMBIL DATA KELUAR =====
        $keluar = BarangKeluar::with(['barang.kategori'])
            ->get()
            ->map(function ($item) {
                return (object)[
                    'tanggal'       => $item->tgl_keluar,
                    'nama_barang'   => $item->barang->nama_barang ?? '-',
                    'jumlah'        => $item->jumlah,
                    'kota'          => $item->tujuan ?? '-',
                    'transaksi'     => 'Barang Keluar',
                    'kategori'      => $item->barang->kategori->nama_kategori ?? '-',
                    'nama_supplier' => $item->tujuan ?? '-',
                    'kontak'        => '-',
                    'email'         => '-',
                    'keterangan'    => $item->keterangan ?? '-',
                    'dicatat_oleh'  => $item->dicatat_oleh ?? '-',
                    'created_at'    => $item->created_at,
                ];
            });

        // ===== FILTER =====
        $filterFn = function ($item) use ($filters, $adaFilter) {
            if (!empty($filters['dari']) && Carbon::parse($item->tanggal)->startOfDay() < Carbon::parse($filters['dari'])->startOfDay()) return false;
            if (!empty($filters['sampai']) && Carbon::parse($item->tanggal)->startOfDay() > Carbon::parse($filters['sampai'])->startOfDay()) return false;
            if (!empty($filters['search'])) {
                $search = strtolower($filters['search']);
                if (!str_contains(strtolower($item->nama_barang), $search) && !str_contains(strtolower($item->kota), $search)) return false;
            }
            if (!$adaFilter && Carbon::parse($item->created_at) < Carbon::now()->subMonths(3)->startOfDay()) return false;
            return true;
        };

        $showMasuk  = empty($filters['jenis']) || $filters['jenis'] === 'Barang Masuk';
        $showKeluar = empty($filters['jenis']) || $filters['jenis'] === 'Barang Keluar';

        $dataMasuk  = $showMasuk  ? $masuk->filter($filterFn)->sortByDesc('created_at')->values()  : collect();
        $dataKeluar = $showKeluar ? $keluar->filter($filterFn)->sortByDesc('created_at')->values() : collect();

        // ===== BUAT SPREADSHEET =====
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Riwayat Transaksi');
        $lastCol = 'K';

        // ===== JUDUL UTAMA =====
        $sheet->mergeCells('A1:' . $lastCol . '1');
        $sheet->setCellValue('A1', 'LAPORAN RIWAYAT TRANSAKSI');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '205375']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // ===== SUB JUDUL =====
        $sheet->mergeCells('A2:' . $lastCol . '2');
        $dari   = !empty($filters['dari'])   ? Carbon::parse($filters['dari'])->format('d/m/Y')   : '—';
        $sampai = !empty($filters['sampai']) ? Carbon::parse($filters['sampai'])->format('d/m/Y') : '—';
        $sheet->setCellValue('A2', 'Periode: ' . $dari . ' s/d ' . $sampai . '   |   Dicetak: ' . Carbon::now()->format('d/m/Y H:i'));
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['size' => 9, 'color' => ['rgb' => '555555']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EAF0F6']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $row = 3;

        // =============================================
        // SECTION BARANG MASUK
        // =============================================
        $row = $this->tulisSection(
            $sheet, $row, $dataMasuk,
            'BARANG MASUK', '0E8A5F', 'D1FAE5',
            $lastCol
        );

        // Baris pemisah kosong
        $row++;

        // =============================================
        // SECTION BARANG KELUAR
        // =============================================
        $row = $this->tulisSection(
            $sheet, $row, $dataKeluar,
            'BARANG KELUAR', 'DC2626', 'FEE2E2',
            $lastCol
        );

        // ===== LEBAR KOLOM (ikut section masuk yang lebih lebar) =====
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setWidth(22);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(8);
        $sheet->getColumnDimension('F')->setWidth(22);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(25);
        $sheet->getColumnDimension('K')->setWidth(15);

        // ===== DOWNLOAD =====
        $filename = 'Riwayat_Transaksi_' . Carbon::now()->format('d-m-Y_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function tulisSection($sheet, int $row, $data, string $judul, string $warnaHeader, string $warnaBadge, string $lastCol): int
    {
        $isMasuk = $judul === 'BARANG MASUK';

        $headers = $isMasuk
            ? ['No', 'Tanggal', 'Nama Barang', 'Kategori', 'Jumlah', 'Supplier', 'Kontak', 'Email', 'Kota', 'Keterangan', 'Dicatat Oleh']
            : ['No', 'Tanggal', 'Nama Barang', 'Kategori', 'Jumlah', 'Tujuan', 'Keterangan', 'Dicatat Oleh'];

        $lastColSection = $isMasuk ? 'K' : 'H';

        // ===== JUDUL SECTION =====
        $sheet->mergeCells('A' . $row . ':' . $lastColSection . $row);
        $sheet->setCellValue('A' . $row, $judul);
        $sheet->getStyle('A' . $row)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $warnaHeader]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'indent' => 1],
        ]);
        $sheet->getRowDimension($row)->setRowHeight(24);
        $row++;

        // ===== HEADER KOLOM =====
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $sheet->getStyle($col . $row)->applyFromArray([
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F66B0E']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);
            $col++;
        }
        $sheet->getRowDimension($row)->setRowHeight(22);
        $row++;

        // ===== ISI DATA =====
        if ($data->isEmpty()) {
            $sheet->mergeCells('A' . $row . ':' . $lastColSection . $row);
            $sheet->setCellValue('A' . $row, 'Tidak ada data');
            $sheet->getStyle('A' . $row)->applyFromArray([
                'font'      => ['italic' => true, 'color' => ['rgb' => '9CA3AF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9FAFB']],
                'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
            ]);
            $row++;
        } else {
            foreach ($data as $i => $item) {
                $bgColor = $i % 2 === 0 ? 'FFFFFF' : 'F9FAFB';

                if ($isMasuk) {
                    $sheet->setCellValue('A' . $row, $i + 1);
                    $sheet->setCellValue('B' . $row, Carbon::parse($item->tanggal)->format('d/m/Y'));
                    $sheet->setCellValue('C' . $row, $item->nama_barang);
                    $sheet->setCellValue('D' . $row, $item->kategori);
                    $sheet->setCellValue('E' . $row, $item->jumlah);
                    $sheet->setCellValue('F' . $row, $item->nama_supplier);
                    $sheet->setCellValue('G' . $row, $item->kontak);
                    $sheet->setCellValue('H' . $row, $item->email);
                    $sheet->setCellValue('I' . $row, $item->kota);
                    $sheet->setCellValue('J' . $row, $item->keterangan);
                    $sheet->setCellValue('K' . $row, $item->dicatat_oleh);
                } else {
                    $sheet->setCellValue('A' . $row, $i + 1);
                    $sheet->setCellValue('B' . $row, Carbon::parse($item->tanggal)->format('d/m/Y'));
                    $sheet->setCellValue('C' . $row, $item->nama_barang);
                    $sheet->setCellValue('D' . $row, $item->kategori);
                    $sheet->setCellValue('E' . $row, $item->jumlah);
                    $sheet->setCellValue('F' . $row, $item->kota); // tujuan
                    $sheet->setCellValue('G' . $row, $item->keterangan);
                    $sheet->setCellValue('H' . $row, $item->dicatat_oleh);
                }

                $sheet->getStyle('A' . $row . ':' . $lastColSection . $row)->applyFromArray([
                    'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E5E7EB']]],
                ]);

                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $row++;
            }

            // ===== TOTAL SECTION =====
            $sheet->mergeCells('A' . $row . ':D' . $row);
            $sheet->setCellValue('A' . $row, 'Total ' . $judul . ': ' . count($data));
            $sheet->getStyle('A' . $row . ':' . $lastColSection . $row)->applyFromArray([
                'font'    => ['bold' => true],
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EAF0F6']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);
            $row++;
        }

        return $row;
    }
}
