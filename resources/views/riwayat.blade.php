@extends('app')

@section('title', 'Riwayat')

@section('content')
    <div class="p-4">
        <div class="bg-white rounded-lg border shadow p-4">

            <!-- FILTER -->
            <div class="flex items-center gap-3 mb-4 flex-wrap">
                <span class="text-sm font-medium text-gray-700 whitespace-nowrap">Filter Periode</span>

                <!-- Bulan Awal -->
                <div class="flex items-center gap-1 border rounded px-2 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <select class="text-sm text-gray-500 outline-none bg-transparent pr-1">
                        <option value="">Bulan...</option>
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>

                <span class="text-gray-400">—</span>

                <!-- Bulan Akhir -->
                <div class="flex items-center gap-1 border rounded px-2 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <select class="text-sm text-gray-500 outline-none bg-transparent pr-1">
                        <option value="">Bulan...</option>
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>

                <!-- Tombol Filter -->
                <button class="flex items-center gap-1 border rounded px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z" />
                    </svg>
                    Filter
                </button>

                <!-- Tombol Export Excel -->
                <button class="flex items-center gap-1 border rounded px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 transition ml-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </button>
            </div>

            <!-- TABEL -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b text-gray-700">
                            <th class="py-2 pr-4 font-medium">Tanggal</th>
                            <th class="py-2 pr-4 font-medium">Jenis</th>
                            <th class="py-2 pr-4 font-medium">Nama Barang</th>
                            <th class="py-2 pr-4 font-medium">Nama Supplier</th>
                            <th class="py-2 font-medium">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DATA KOSONG --}}
                        <tr>
                            <td colspan="5" class="text-center text-gray-400 py-16 text-sm">
                                Tidak ada data riwayat.
                            </td>
                        </tr>

                        {{-- CONTOH DATA (hapus kalau sudah pakai data dari controller) --}}
                        {{--
                        @foreach ($riwayat as $item)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-2 pr-4">{{ $item->tanggal }}</td>
                            <td class="py-2 pr-4">
                                <span class="px-2 py-0.5 rounded text-xs font-medium
                                    {{ $item->jenis === 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item->jenis }}
                                </span>
                            </td>
                            <td class="py-2 pr-4">{{ $item->nama_barang }}</td>
                            <td class="py-2 pr-4">{{ $item->nama_supplier }}</td>
                            <td class="py-2">{{ $item->jumlah }}</td>
                        </tr>
                        @endforeach
                        --}}
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
