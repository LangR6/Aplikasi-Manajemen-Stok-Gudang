@extends('app')

@section('title', 'Dashboard')

@section('content')
@if (session('success'))
<div class="mb-4 rounded-xl border border-green-500 bg-green-50 px-4 py-3 text-green-700">
    {{ session('success') }}
</div>
@endif

<!-- Top Cards -->
<div class="grid grid-cols-2 gap-3 mb-4">
    <!-- Barang Masuk -->
    <div class="cursor-pointer rounded-[22px] p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white"
        onclick="openDaftarBarangMasukModal()">
        <div class="flex items-center justify-between gap-6 h-full">
            <div class="max-w-[80%] -mt-4">
                <h2 class="text-[16px] font-semibold text-gray-900">Barang Masuk</h2>
                <div class="mt-8 text-4xl font-bold leading-none text-gray-900">
                    {{ $totalBarangMasuk }}
                </div>
            </div>

            <!-- Icon Barang Masuk -->
            <div class="shrink-0 opacity-80">
                <div class="flex h-22 w-22 items-center justify-center rounded-[22px] ">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-16 w-16 text-gray-900"
                        fill="none"
                        viewBox="0 0 32 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7.5L12 3l9 4.5M4.5 9.75v6.75L12 21l7.5-4.5V9.75M12 12L3 7.5M12 12l9-4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M28 12h-6m0 0l2-2m-2 2l2 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Barang Keluar -->
    <div class="cursor-pointer rounded-[22px] p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white"
        onclick="openDaftarBarangKeluarModal()">
        <div class="flex items-center justify-between gap-6 h-full">
            <div class="max-w-[80%] -mt-4">
                <h2 class="text-[16px] font-semibold text-gray-900">Barang Keluar</h2>
                <div class="mt-8 mt-8 text-4xl font-bold leading-none text-gray-900">
                    {{ $totalBarangKeluar }}
                </div>
            </div>

            <!-- Icon Barang Keluar -->
            <div class="shrink-0 opacity-80">
                <div class="flex h-22 w-22 items-center justify-center rounded-[22px] text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-14 w-14 text-gray-900"
                        fill="none"
                        viewBox="0 0 28 24"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7.5L12 3l9 4.5M4.5 9.75v6.75L12 21l7.5-4.5V9.75M12 12L3 7.5M12 12l9-4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 12h5m0 0l-2-2m2 2l-2 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Small Cards -->
<div class="grid grid-cols-3 gap-3 mb-4">
    <!-- Total Barang -->
    <a href="{{ route('kelola_barang') }}"
        class="block rounded-[22px] p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white cursor-pointer">

        <div class="flex items-center justify-between gap-6 h-full">
            <div class="max-w-[70%] -mt-4">
                <h2 class="text-[16px] font-semibold text-gray-900">Total Barang</h2>
                <div class="mt-8 text-4xl font-bold leading-none text-gray-900">
                    {{ $totalBarang }}
                </div>
            </div>

            <div class="shrink-0 opacity-80">
                <div class="flex h-22 w-22 items-center justify-center rounded-[22px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5 12 3 3.75 7.5 12 12l8.25-4.5ZM3.75 12 12 16.5 20.25 12M3.75 16.5 12 21l8.25-4.5" />
                    </svg>
                </div>
            </div>
        </div>
    </a>

    <!-- Stok Barang Menipis -->
    <div class="cursor-pointer rounded-[22px] p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white"
        onclick="openStokMenipisModal()">
        <div class="flex items-center justify-between gap-1 h-full">
            <div class="max-w-[70%] -mt-4">
                <h2 class="text-[16px] font-semibold text-amber-900">Stok Barang Menipis</h2>
                <div class="mt-8 text-4xl font-bold leading-none text-amber-600">
                    {{ $stokMenipis }}
                </div>
            </div>

            <div class="shrink-0 opacity-80">
                <div class="flex h-22 w-22 items-center justify-center rounded-[22px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stok Barang Habis -->
    <div class="cursor-pointer rounded-[22px] p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white"
        onclick="openStokHabisModal()">
        <div class="flex items-center justify-between gap-6 h-full">
            <div class="max-w-[70%] -mt-4">
                <h2 class="text-[16px] font-semibold text-rose-900">Stok Barang Habis</h2>
                <div class="mt-8 text-4xl font-bold leading-none text-red-600">
                    {{ $stokHabis }}
                </div>
            </div>

            <div class="shrink-0 opacity-80">
                <div class="flex h-22 w-22 items-center justify-center rounded-[22px]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-13 w-13 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636 5.636 18.364M5.636 5.636l12.728 12.728M7.5 7.5h9v9h-9z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section -->
<div class="grid grid-cols-12 gap-5">
    <!-- Data Supplier -->
    <div class="col-span-6">
        <div
            class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-xl">

            <!-- Header -->
            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4">
                <h2 class="text-[22px] font-semibold text-[#1f2937]">Data Supplier</h2>
            </div>

            <!-- Table -->
            <div class="p-4">
                @if (count($suppliers) > 0)
                <div class="overflow-hidden rounded-2xl border border-gray-100 ">
                    <table class="w-full table-fixed border-collapse">
                        <thead class="bg-[#205375]">
                            <tr>
                                <th class="w-[38%] px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-white">
                                    Nama Supplier
                                </th>
                                <th class="w-[33%] px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-white">
                                    Kontak
                                </th>
                                <th class="w-[25%] px-4 py-3 text-left text-[11px] font-semibold uppercase tracking-wide text-white">
                                    Kota
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($suppliers as $supplier)
                            <tr class="border-b border-gray-100 odd:bg-white even:bg-gray-50/60 hover:bg-orange-50/30 transition-all duration-200">
                                <td class="px-4 py-4 align-middle text-[14px] font-semibold text-gray-800">
                                    {{ $supplier['nama_supplier'] }}
                                </td>

                                <td class="px-4 py-4 align-middle text-[14px] text-gray-700 whitespace-nowrap">
                                    {{ $supplier['kontak'] }}
                                </td>

                                <td class="px-4 py-4 align-middle text-[14px] text-gray-700 whitespace-nowrap">
                                    {{ $supplier['kota'] }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="flex h-[240px] flex-col items-center justify-center rounded-2xl border border-dashed border-gray-200 bg-gray-50 text-center">
                    <p class="text-sm font-medium text-gray-600">Belum ada data supplier</p>
                    <p class="mt-1 text-xs text-gray-400">Data supplier akan muncul di sini</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Cards -->
    <div class="col-span-6 space-y-4">

        <!-- Barang Masuk terbaru -->
        <div class="rounded-[24px] border border-gray-200 bg-white shadow-sm hover:shadow-xl transition-all">

            <div class="border-b border-gray-200 px-5 py-4">
                <h2 class="text-[20px] font-semibold text-gray-900">Barang Masuk Terbaru</h2>
            </div>

            <div class="flex items-center justify-between px-5 py-5">

                <div class="space-y-2 text-[15px] text-gray-800">

                    <div class="grid grid-cols-[100px_10px_auto]">
                        <span>Nama</span>
                        <span>:</span>
                        <span class="font-medium">{{ $barangMasukTerbaru['nama_barang'] }}</span>
                    </div>

                    <div class="grid grid-cols-[100px_10px_auto]">
                        <span>Kategori</span>
                        <span>:</span>
                        <span>{{ $barangMasukTerbaru['kategori'] }}</span>
                    </div>

                    <div class="grid grid-cols-[100px_10px_auto]">
                        <span>Tanggal</span>
                        <span>:</span>
                        <span>{{ $barangMasukTerbaru['tanggal'] }}</span>
                    </div>

                </div>

                <button onclick="openBarangMasukModal()"
                    class="rounded-xl bg-orange-500 px-5 py-2 text-sm font-medium text-white hover:bg-orange-600 transition">
                    Lihat
                </button>
            </div>
        </div>

        <!-- Barang Keluar terbaru -->
        <div class="rounded-[24px] border border-gray-200 bg-white shadow-sm hover:shadow-xl transition-all">

            <div class="border-b border-gray-200 px-5 py-4">
                <h2 class="text-[20px] font-semibold text-gray-900">Barang Keluar Terbaru</h2>
            </div>

            <div class="flex items-center justify-between px-5 py-5">

                <div class="space-y-2 text-[15px] text-gray-800">

                    <div class="grid grid-cols-[100px_10px_auto]">
                        <span>Nama</span>
                        <span>:</span>
                        <span class="font-medium">{{ $barangKeluarTerbaru['nama_barang'] }}</span>
                    </div>

                    <div class="grid grid-cols-[100px_10px_auto]">
                        <span>Kategori</span>
                        <span>:</span>
                        <span>{{ $barangKeluarTerbaru['kategori'] }}</span>
                    </div>

                    <div class="grid grid-cols-[100px_10px_auto]">
                        <span>Tanggal</span>
                        <span>:</span>
                        <span>{{ $barangKeluarTerbaru['tanggal'] }}</span>
                    </div>

                </div>

                <button onclick="openBarangKeluarModal()"
                    class="rounded-xl bg-orange-500 px-5 py-2 text-sm font-medium text-white hover:bg-orange-600 transition">
                    Lihat
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Modal Daftar Barang Masuk -->
<div id="daftarBarangMasukModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 px-4 backdrop-blur-[1px]">
    <div class="w-full max-w-[720px] overflow-hidden rounded-2xl bg-white shadow-xl">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-green-600 px-4 py-3">
            <h3 class="text-[20px] font-semibold text-white">Daftar Barang Masuk</h3>
            <button type="button" onclick="closeDaftarBarangMasukModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="max-h-[420px] space-y-4 overflow-y-auto p-4">
            @forelse($daftarBarangMasuk as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1 text-[16px] leading-7 text-[#444]">
                        <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                        <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                        <div><span class="font-medium">Jumlah :</span> {{ $barang['jumlah'] }}</div>
                        <div><span class="font-medium">Tanggal :</span> {{ $barang['tanggal'] }}</div>
                        <div><span class="font-medium">Supplier :</span> {{ $barang['supplier'] }}</div>
                    </div>
                </div>
            </div>
            @empty
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-center text-gray-500">
                Tidak ada data barang masuk
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Daftar Barang Keluar -->
<div id="daftarBarangKeluarModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 px-4 backdrop-blur-[1px]">

    <div class="w-full max-w-[720px] overflow-hidden rounded-2xl bg-white shadow-xl">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-red-500 px-4 py-3">
            <h3 class="text-[20px] font-semibold text-white">Daftar Barang Keluar</h3>

            <button type="button" onclick="closeDaftarBarangKeluarModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="max-h-[420px] space-y-4 overflow-y-auto p-4">
            @forelse($daftarBarangKeluar as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="space-y-1 text-[16px] leading-7 text-[#444]">
                    <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                    <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                    <div><span class="font-medium">Jumlah :</span> {{ $barang['jumlah'] }}</div>
                    <div><span class="font-medium">Tanggal :</span> {{ $barang['tanggal'] }}</div>
                    <div><span class="font-medium">Tujuan :</span> {{ $barang['tujuan'] }}</div>
                    <div><span class="font-medium">Keterangan :</span> {{ $barang['catatan'] }}</div>
                </div>

            </div>
            @empty
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-center text-gray-500">
                Tidak ada data barang keluar
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Barang Masuk Terbaru -->
<div id="barangMasukModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 px-4 backdrop-blur-[1px]">

    <div class="w-full max-w-[700px] overflow-hidden rounded-2xl bg-white shadow-xl">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-orange-500 px-4 py-3">
            <h3 class="text-[20px] font-semibold text-white">
                Detail Barang Masuk
            </h3>

            <button onclick="closeBarangMasukModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-4 space-y-4">

            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="space-y-2 text-[16px] text-[#444] leading-7">
                    <div><span class="font-medium">Nama Barang :</span> {{ $barangMasukTerbaru['nama_barang'] }}</div>
                    <div><span class="font-medium">Kategori :</span> {{ $barangMasukTerbaru['kategori'] }}</div>
                    <div><span class="font-medium">Jumlah :</span> {{ $barangMasukTerbaru['jumlah'] }}</div>
                    <div><span class="font-medium">Tanggal :</span> {{ $barangMasukTerbaru['tanggal'] }}</div>
                    <div><span class="font-medium">Supplier :</span> {{ $barangMasukTerbaru['supplier'] }}</div>
                    <div><span class="font-medium">Kontak :</span> {{ $barangMasukTerbaru['kontak'] }}</div>
                    <div><span class="font-medium">Keterangan :</span> {{ $barangMasukTerbaru['catatan'] }}</div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Modal Barang Keluar Terbaru -->
<div id="barangKeluarModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 px-4 backdrop-blur-[1px]">

    <div class="w-full max-w-[700px] overflow-hidden rounded-2xl bg-white shadow-xl">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-red-500 px-4 py-3">
            <h3 class="text-[20px] font-semibold text-white">
                Detail Barang Keluar
            </h3>

            <button onclick="closeBarangKeluarModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-4 space-y-4">

            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <div class="space-y-2 text-[16px] leading-7 text-[#444]">
                    <div><span class="font-medium">Nama Barang :</span> {{ $barangKeluarTerbaru['nama_barang'] }}</div>
                    <div><span class="font-medium">Kategori :</span> {{ $barangKeluarTerbaru['kategori'] }}</div>
                    <div><span class="font-medium">Jumlah :</span> {{ $barangKeluarTerbaru['jumlah'] }}</div>
                    <div><span class="font-medium">Tanggal :</span> {{ $barangKeluarTerbaru['tanggal'] }}</div>
                    <div><span class="font-medium">Tujuan :</span> {{ $barangKeluarTerbaru['tujuan'] }}</div>
                    <div><span class="font-medium">Supplier :</span> {{ $barangKeluarTerbaru['supplier'] }}</div>
                    <div><span class="font-medium">Kontak :</span> {{ $barangKeluarTerbaru['kontak'] }}</div>
                    <div><span class="font-medium">Keterangan :</span> {{ $barangKeluarTerbaru['catatan'] }}</div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Stok Barang Menipis -->
<div id="stokMenipisModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 px-4 backdrop-blur-[1px]">
    <div class="w-full max-w-[720px] overflow-hidden rounded-2xl bg-white shadow-xl">
        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-orange-500 px-4 py-3">
            <h3 class="text-[20px] font-semibold text-white">Daftar Stok Barang Menipis</h3>
            <button type="button" onclick="closeStokMenipisModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Tutup modal</span>
            </button>
        </div>

        <!-- Body -->
        <div class="max-h-[420px] space-y-4 overflow-y-auto p-4">
            @forelse($daftarStokMenipis as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1 text-[16px] leading-7 text-[#444]">
                        <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                        <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                        <div><span class="font-medium">Sisa Stok :</span> {{ $barang['stok'] }}</div>
                    </div>

                    <button type="button"
                        class="rounded-lg px-4 py-2 text-[15px] font-medium text-white transition-all duration-300
                            {{ $barang['status_baca'] ? 'bg-gray-400 hover:bg-gray-500' : 'bg-orange-500 hover:bg-orange-600' }}">
                        {{ $barang['status_baca'] ? 'Sudah Dibaca' : 'Tandai Dibaca' }}
                    </button>
                </div>
            </div>
            @empty
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-center text-gray-500">
                Tidak ada barang dengan stok menipis
            </div>
            @endforelse
        </div>
    </div>
</div>


<!-- Modal Stok Barang Habis -->
<div id="stokHabisModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/20 px-4 backdrop-blur-[1px]">

    <div class="w-full max-w-[720px] overflow-hidden rounded-2xl bg-white shadow-xl">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-red-500 px-4 py-3">
            <h3 class="text-[20px] font-semibold text-white">
                Daftar Stok Barang Habis
            </h3>

            <button type="button" onclick="closeStokHabisModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="max-h-[420px] space-y-4 overflow-y-auto p-4">
            @forelse($daftarStokHabis as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                <div class="flex items-center justify-between gap-4">

                    <!-- Info -->
                    <div class="space-y-1 text-[16px] leading-7 text-[#444]">
                        <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                        <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                        <div><span class="font-medium">Sisa Stok :</span> {{ $barang['stok'] }}</div>
                    </div>

                    <!-- Button -->
                    <button type="button"
                        class="rounded-lg px-4 py-2 text-[15px] font-medium text-white transition-all duration-300
                            {{ $barang['status_baca'] 
                                ? 'bg-gray-400 hover:bg-gray-500' 
                                : 'bg-red-500 hover:bg-red-600' }}">

                        {{ $barang['status_baca'] ? 'Sudah Dibaca' : 'Tandai Dibaca' }}
                    </button>

                </div>
            </div>
            @empty
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 text-center text-gray-500">
                Tidak ada barang dengan stok habis
            </div>
            @endforelse
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function lockBodyScroll() {
        const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.classList.add('overflow-hidden');
        document.body.style.paddingRight = scrollBarWidth + 'px';
    }

    function unlockBodyScroll() {
        document.body.classList.remove('overflow-hidden');
        document.body.style.paddingRight = '';
    }

    function openBarangMasukModal() {
        const modal = document.getElementById('barangMasukModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lockBodyScroll();
        }
    }

    function closeBarangMasukModal() {
        const modal = document.getElementById('barangMasukModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            unlockBodyScroll();
        }
    }

    function openBarangKeluarModal() {
        const modal = document.getElementById('barangKeluarModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lockBodyScroll();
        }
    }

    function closeBarangKeluarModal() {
        const modal = document.getElementById('barangKeluarModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            unlockBodyScroll();
        }
    }

    function openStokMenipisModal() {
        const modal = document.getElementById('stokMenipisModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lockBodyScroll();
        }
    }

    function closeStokMenipisModal() {
        const modal = document.getElementById('stokMenipisModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            unlockBodyScroll();
        }
    }

    function openStokHabisModal() {
        const modal = document.getElementById('stokHabisModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lockBodyScroll();
        }
    }

    function closeStokHabisModal() {
        const modal = document.getElementById('stokHabisModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            unlockBodyScroll();
        }
    }

    function openDaftarBarangMasukModal() {
        const modal = document.getElementById('daftarBarangMasukModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lockBodyScroll();
        }
    }

    function closeDaftarBarangMasukModal() {
        const modal = document.getElementById('daftarBarangMasukModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            unlockBodyScroll();
        }
    }

    function openDaftarBarangKeluarModal() {
        const modal = document.getElementById('daftarBarangKeluarModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lockBodyScroll();
        }
    }

    function closeDaftarBarangKeluarModal() {
        const modal = document.getElementById('daftarBarangKeluarModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            unlockBodyScroll();
        }
    }
</script>
@endpush