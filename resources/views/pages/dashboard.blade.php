@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if (session('success'))
<div class="mb-4 rounded-xl border border-green-500 bg-green-50 px-4 py-3 text-green-700">
    {{ session('success') }}
</div>
@endif

<!-- Top Cards: Barang Masuk & Barang Keluar -->
<div class="grid grid-cols-2 gap-3 px-3 sm:px-0 mb-4 sm:gap-4 sm:mb-5">

    <!-- Barang Masuk -->
    <div class="cursor-pointer rounded-[18px] sm:rounded-[22px] p-4 sm:p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white active:scale-[0.98]"
        onclick="openDaftarBarangMasukModal()">
        <div class="flex items-center justify-between gap-2 sm:gap-6 h-full">
            <div class="min-w-0 -mt-3 sm:-mt-4">
                <h2 class="text-[13px] sm:text-[16px] font-semibold text-green-900 leading-tight">Barang Masuk</h2>
                <div class="mt-5 sm:mt-8 text-3xl sm:text-4xl font-bold leading-none text-green-800">
                    {{ $totalBarangMasuk }}
                </div>
            </div>
            <!-- Icon Barang Masuk -->
            <div class="shrink-0 opacity-80">
                <div class="flex h-14 w-14 sm:h-22 sm:w-22 items-center justify-center rounded-[16px] sm:rounded-[22px]">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10 sm:h-16 sm:w-16 text-green-700"
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
    <div class="cursor-pointer rounded-[18px] sm:rounded-[22px] p-4 sm:p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white active:scale-[0.98]"
        onclick="openDaftarBarangKeluarModal()">
        <div class="flex items-center justify-between gap-2 sm:gap-6 h-full">
            <div class="min-w-0 -mt-3 sm:-mt-4">
                <h2 class="text-[13px] sm:text-[16px] font-semibold text-red-800 leading-tight">Barang Keluar</h2>
                <div class="mt-5 sm:mt-8 text-3xl sm:text-4xl font-bold leading-none text-red-800">
                    {{ $totalBarangKeluar }}
                </div>
            </div>
            <!-- Icon Barang Keluar -->
            <div class="shrink-0 opacity-80">
                <div class="flex h-14 w-14 sm:h-22 sm:w-22 items-center justify-center rounded-[16px] sm:rounded-[22px] text-red-900">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-9 w-9 sm:h-14 sm:w-14 text-red-800"
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

<!-- Small Cards: Total Barang, Stok Menipis, Stok Habis -->
<div class="grid grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3 mb-4 px-3 sm:px-0">

    <!-- Total Barang -->
    <a href="{{ route('kelola_barang') }}"
        class="flex sm:block rounded-[18px] sm:rounded-[22px] p-3 sm:p-6 min-h-[90px] sm:min-h-0 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white cursor-pointer active:scale-[0.98]">
        <div class="flex w-full flex-col justify-between sm:flex-row sm:items-center sm:justify-between sm:gap-6">
            <div class="flex h-full flex-col sm:block sm:h-auto sm:-mt-4">
                <h2 class="text-[11px] sm:text-[16px] font-semibold text-sky-900 leading-tight">Total Barang</h2>
                <div class="mt-auto sm:mt-8 flex items-center gap-2">
                    <div class="text-2xl sm:text-4xl font-bold leading-none text-sky-900">
                        {{ $totalBarang }}
                    </div>
                    <!-- Icon mobile kecil -->
                    <div class="flex sm:hidden opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5 12 3 3.75 7.5 12 12l8.25-4.5ZM3.75 12 12 16.5 20.25 12M3.75 16.5 12 21l8.25-4.5" />
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Icon desktop -->
            <div class="hidden sm:flex shrink-0 opacity-80 h-22 w-22 items-center justify-center rounded-[22px]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-sky-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5 12 3 3.75 7.5 12 12l8.25-4.5ZM3.75 12 12 16.5 20.25 12M3.75 16.5 12 21l8.25-4.5" />
                </svg>
            </div>
        </div>
    </a>

    <!-- Stok Barang Menipis -->
    <div class="flex sm:block cursor-pointer rounded-[18px] sm:rounded-[22px] p-3 sm:p-6 min-h-[90px] sm:min-h-0 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white active:scale-[0.98]"
        onclick="openStokMenipisModal()">
        <div class="flex w-full flex-col justify-between sm:flex-row sm:items-center sm:justify-between sm:gap-1">
            <div class="flex h-full flex-col sm:block sm:h-auto sm:-mt-4">
                <h2 class="text-[11px] sm:text-[16px] font-semibold text-amber-600 leading-tight">Stok Menipis</h2>
                <div class="mt-auto sm:mt-8 flex items-center gap-2">
                    <div class="text-2xl sm:text-4xl font-bold leading-none text-amber-600">
                        {{ $stokMenipis }}
                    </div>
                    <!-- Icon mobile kecil  -->
                    <div class="flex sm:hidden opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-amber-600 stroke-amber-600"
                            fill="none" viewBox="0 0 24 24" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Icon desktop -->
            <div class="hidden sm:flex shrink-0 h-22 w-22 items-center justify-center rounded-[22px]">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-10 w-10 text-amber-600 stroke-amber-600"
                    fill="none" viewBox="0 0 24 24" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Stok Barang Habis -->
    <div class="flex sm:block cursor-pointer rounded-[18px] sm:rounded-[22px] p-3 sm:p-6 min-h-[90px] sm:min-h-0 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl bg-white active:scale-[0.98]"
        onclick="openStokHabisModal()">
        <div class="flex w-full flex-col justify-between sm:flex-row sm:items-center sm:justify-between sm:gap-6">
            <div class="flex h-full flex-col sm:block sm:h-auto sm:-mt-4">
                <h2 class="text-[11px] sm:text-[16px] font-semibold text-red-600 leading-tight">Stok Habis</h2>
                <div class="mt-auto sm:mt-8 flex items-center gap-2">
                    <div class="text-2xl sm:text-4xl font-bold leading-none text-red-600">
                        {{ $stokHabis }}
                    </div>
                    <!-- Icon mobile kecil -->
                    <div class="flex sm:hidden opacity-80">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-red-600 stroke-red-600"
                            fill="none" viewBox="0 0 24 24" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18.364 5.636 5.636 18.364M5.636 5.636l12.728 12.728M7.5 7.5h9v9h-9z" />
                        </svg>
                    </div>
                </div>
            </div>
            <!-- Icon desktop -->
            <div class="hidden sm:flex shrink-0 h-22 w-22 items-center justify-center rounded-[22px]">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-13 w-13 text-red-600 stroke-red-600"
                    fill="none" viewBox="0 0 24 24" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18.364 5.636 5.636 18.364M5.636 5.636l12.728 12.728M7.5 7.5h9v9h-9z" />
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-5 px-3 sm:px-0">

    <!-- Data Supplier -->
    <div class="col-span-12 lg:col-span-6">
        <div class="overflow-hidden rounded-[20px] sm:rounded-[24px] border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-xl">

            <!-- Header -->
            <div class="flex items-center justify-between border-b border-gray-200 px-4 sm:px-5 py-3 sm:py-4">
                <h2 class="text-[18px] sm:text-[22px] font-semibold text-[#1f2937]">Data Supplier</h2>
            </div>

            <!-- Table -->
            <div class="p-3 sm:p-4">
                @if (count($suppliers) > 0)

                {{-- Desktop: tabel biasa --}}
                <div class="hidden sm:block overflow-hidden rounded-2xl border border-gray-100">
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

                {{-- Mobile: card list supplier --}}
                <div class="sm:hidden divide-y divide-gray-100 overflow-hidden rounded-2xl border border-gray-100">
                    @foreach ($suppliers as $supplier)
                    <div class="mobile-card px-4 py-3 {{ $loop->even ? '' : 'bg-gray-50/60' }}">
                        {{-- Baris atas: nomor + nama --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span
                                    class="mobile-num shrink-0 w-6 h-6 rounded-full bg-[#205375] text-white
                                     text-xs font-semibold flex items-center justify-center">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="text-sm font-semibold text-gray-800 truncate">
                                    {{ $supplier['nama_supplier'] }}
                                </span>
                            </div>
                        </div>

                        {{-- Detail info --}}
                        <div class="mt-2 ml-8.5 space-y-1 pl-1">
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>{{ $supplier['kontak'] }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="break-all">{{ $supplier['email'] ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5 shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $supplier['kota'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @else
                <div class="flex h-[160px] sm:h-[240px] flex-col items-center justify-center rounded-2xl border border-dashed border-gray-200 bg-gray-50 text-center">
                    <p class="text-sm font-medium text-gray-600">Belum ada data supplier</p>
                    <p class="mt-1 text-xs text-gray-400">Data supplier akan muncul di sini</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Cards -->
    <div class="col-span-12 lg:col-span-6 space-y-3 sm:space-y-4">

        <!-- Barang Masuk terbaru -->
        <div class="rounded-[20px] sm:rounded-[24px] border border-gray-200 bg-white shadow-sm hover:shadow-xl transition-all">

            <div class="border-b border-gray-200 px-4 sm:px-5 py-3 sm:py-4">
                <h2 class="text-[16px] sm:text-[20px] font-semibold text-gray-900">Barang Masuk Terbaru</h2>
            </div>

            <div class="flex items-center justify-between px-4 sm:px-5 py-4 sm:py-5 gap-3">
                <div class="space-y-1.5 sm:space-y-2 text-[13px] sm:text-[15px] text-gray-800 min-w-0 flex-1">
                    <div class="grid grid-cols-[80px_8px_auto] sm:grid-cols-[100px_10px_auto] items-start">
                        <span class="text-gray-500">Nama</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium truncate">{{ $barangMasukTerbaru['nama_barang'] }}</span>
                    </div>
                    <div class="grid grid-cols-[80px_8px_auto] sm:grid-cols-[100px_10px_auto] items-start">
                        <span class="text-gray-500">Jumlah</span>
                        <span class="text-gray-400">:</span>
                        <span class="truncate">{{ $barangMasukTerbaru['jumlah'] }}</span>
                    </div>
                    <div class="grid grid-cols-[80px_8px_auto] sm:grid-cols-[100px_10px_auto] items-start">
                        <span class="text-gray-500">Tanggal</span>
                        <span class="text-gray-400">:</span>
                        <span>{{ $barangMasukTerbaru['tanggal'] }}</span>
                    </div>
                </div>
                <button onclick="openBarangMasukModal()"
                    class="shrink-0 rounded-xl bg-orange-500 px-4 sm:px-5 py-2 text-[13px] sm:text-sm font-medium text-white hover:bg-orange-600 active:bg-orange-700 transition">
                    Lihat
                </button>
            </div>
        </div>

        <!-- Barang Keluar terbaru -->
        <div class="rounded-[20px] sm:rounded-[24px] border border-gray-200 bg-white shadow-sm hover:shadow-xl transition-all">

            <div class="border-b border-gray-200 px-4 sm:px-5 py-3 sm:py-4">
                <h2 class="text-[16px] sm:text-[20px] font-semibold text-gray-900">Barang Keluar Terbaru</h2>
            </div>

            <div class="flex items-center justify-between px-4 sm:px-5 py-4 sm:py-5 gap-3">
                <div class="space-y-1.5 sm:space-y-2 text-[13px] sm:text-[15px] text-gray-800 min-w-0 flex-1">
                    <div class="grid grid-cols-[80px_8px_auto] sm:grid-cols-[100px_10px_auto] items-start">
                        <span class="text-gray-500">Nama</span>
                        <span class="text-gray-400">:</span>
                        <span class="font-medium truncate">{{ $barangKeluarTerbaru['nama_barang'] }}</span>
                    </div>
                    <div class="grid grid-cols-[80px_8px_auto] sm:grid-cols-[100px_10px_auto] items-start">
                        <span class="text-gray-500">Jumlah</span>
                        <span class="text-gray-400">:</span>
                        <span class="truncate">{{ $barangKeluarTerbaru['jumlah'] }}</span>
                    </div>
                    <div class="grid grid-cols-[80px_8px_auto] sm:grid-cols-[100px_10px_auto] items-start">
                        <span class="text-gray-500">Tanggal</span>
                        <span class="text-gray-400">:</span>
                        <span>{{ $barangKeluarTerbaru['tanggal'] }}</span>
                    </div>
                </div>
                <button onclick="openBarangKeluarModal()"
                    class="shrink-0 rounded-xl bg-orange-500 px-4 sm:px-5 py-2 text-[13px] sm:text-sm font-medium text-white hover:bg-orange-600 active:bg-orange-700 transition">
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
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center px-3 sm:px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
    <div class="modal-box relative w-full max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-xl transform scale-95 opacity-0 transition-all duration-200">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-green-600 px-4 py-3">
            <h3 class="text-[17px] sm:text-[20px] font-semibold text-white">Daftar Barang Masuk</h3>
            <button type="button" onclick="closeDaftarBarangMasukModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="max-h-[70vh] sm:max-h-[420px] space-y-3 sm:space-y-4 overflow-y-auto p-3 sm:p-4">
            @forelse($daftarBarangMasuk as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 sm:p-4">
                <div class="flex items-center justify-between gap-4">
                    <div class="space-y-1 text-[14px] sm:text-[16px] leading-6 sm:leading-7 text-[#444]">
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
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center px-3 sm:px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>

    <div class="modal-box relative w-full max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-xl transform scale-95 opacity-0 transition-all duration-200">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-red-500 px-4 py-3">
            <h3 class="text-[17px] sm:text-[20px] font-semibold text-white">Daftar Barang Keluar</h3>

            <button type="button" onclick="closeDaftarBarangKeluarModal()"
                class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/10 hover:text-white">
                <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="max-h-[70vh] sm:max-h-[420px] space-y-3 sm:space-y-4 overflow-y-auto p-3 sm:p-4">
            @forelse($daftarBarangKeluar as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 sm:p-4">

                <div class="space-y-1 text-[14px] sm:text-[16px] leading-6 sm:leading-7 text-[#444]">
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

<!-- Modal Barang Masuk Terbaru (Detail) -->
<div id="barangMasukModal"
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center px-3 sm:px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>

    <div class="modal-box relative w-full max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-xl transform scale-95 opacity-0 transition-all duration-200">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-orange-500 px-4 py-3">
            <h3 class="text-[17px] sm:text-[20px] font-semibold text-white">
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
        <div class="p-3 sm:p-4 space-y-3 sm:space-y-4">

            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 sm:p-4">

                <div class="space-y-1 text-[14px] sm:text-[16px] text-[#444] leading-6 sm:leading-7">
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

<!-- Modal Barang Keluar Terbaru (Detail) -->
<div id="barangKeluarModal"
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center px-3 sm:px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>

    <div class="modal-box relative w-full max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-xl transform scale-95 opacity-0 transition-all duration-200">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-red-500 px-4 py-3">
            <h3 class="text-[17px] sm:text-[20px] font-semibold text-white">
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
        <div class="p-3 sm:p-4 space-y-3 sm:space-y-4">
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 sm:p-4">
                <div class="space-y-1 text-[14px] sm:text-[16px] leading-6 sm:leading-7 text-[#444]">
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
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center px-3 sm:px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
    <div class="modal-box relative w-full max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-xl transform scale-95 opacity-0 transition-all duration-200">
        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-orange-500 px-4 py-3">
            <h3 class="text-[17px] sm:text-[20px] font-semibold text-white">Daftar Stok Barang Menipis</h3>
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
        <div class="max-h-[70vh] sm:max-h-[420px] space-y-3 sm:space-y-4 overflow-y-auto p-3 sm:p-4">
            @forelse($daftarStokMenipis as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 sm:p-4">
                <div class="flex items-center justify-between gap-3 sm:gap-4">
                    <div class="space-y-1 text-[14px] sm:text-[16px] leading-6 sm:leading-7 text-[#444]">
                        <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                        <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                        <div><span class="font-medium">Sisa Stok :</span> {{ $barang['stok'] }}</div>
                    </div>

                    <!-- Button tandai dibaca -->
                    @if (session('role') === 'admin')
                    <button type="button"
                        data-kode="{{ $barang['kode'] }}"
                        data-tipe="menipis"
                        onclick="tandaiBaca(this)"
                        {{ $barang['status_baca'] ? 'disabled' : '' }}
                        class="shrink-0 rounded-lg px-3 sm:px-4 py-2 text-[13px] sm:text-[15px] font-medium text-white transition-all duration-300
        {{ $barang['status_baca'] ? 'bg-gray-400 cursor-not-allowed' : 'bg-orange-500 hover:bg-orange-600' }}">
                        {{ $barang['status_baca'] ? 'Sudah Dibaca' : 'Tandai Dibaca' }}
                    </button>
                    @endif

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
    class="modal-overlay fixed inset-0 z-50 hidden items-center justify-center px-3 sm:px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>

    <div class="modal-box relative w-full max-w-[520px] overflow-hidden rounded-2xl bg-white shadow-xl transform scale-95 opacity-0 transition-all duration-200">

        <!-- Header -->
        <div class="flex items-center justify-between rounded-t-2xl bg-red-500 px-4 py-3">
            <h3 class="text-[17px] sm:text-[20px] font-semibold text-white">
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
        <div class="max-h-[70vh] sm:max-h-[420px] space-y-3 sm:space-y-4 overflow-y-auto p-3 sm:p-4">
            @forelse($daftarStokHabis as $barang)
            <div class="rounded-xl border border-gray-200 bg-gray-50 p-3 sm:p-4">

                <div class="flex items-center justify-between gap-3 sm:gap-4">

                    <!-- Info -->
                    <div class="space-y-1 text-[14px] sm:text-[16px] leading-6 sm:leading-7 text-[#444]">
                        <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                        <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                        <div><span class="font-medium">Sisa Stok :</span> {{ $barang['stok'] }}</div>
                    </div>

                    <!-- Button tandai dibaca-->
                    @if (session('role') === 'admin')
                    <button type="button"
                        data-kode="{{ $barang['kode'] }}"
                        data-tipe="habis"
                        onclick="tandaiBaca(this)"
                        {{ $barang['status_baca'] ? 'disabled' : '' }}
                        class="shrink-0 rounded-lg px-3 sm:px-4 py-2 text-[13px] sm:text-[15px] font-medium text-white transition-all duration-300
        {{ $barang['status_baca'] ? 'bg-gray-400 cursor-not-allowed' : 'bg-red-500 hover:bg-red-600' }}">
                        {{ $barang['status_baca'] ? 'Sudah Dibaca' : 'Tandai Dibaca' }}
                    </button>
                    @endif

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

@push('styles')
<style>
    .modal-overlay.is-open .modal-backdrop {
        background: rgba(0, 0, 0, .35) !important;
        backdrop-filter: blur(2px) !important;
        -webkit-backdrop-filter: blur(2px) !important;
    }

    .modal-overlay.is-open .modal-box {
        transform: scale(1) !important;
        opacity: 1 !important;
    }
</style>
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

    function openModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Paksa browser membaca state awal dulu, supaya transition jalan.
        void modal.offsetWidth;

        modal.classList.add('is-open');
        lockBodyScroll();
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        modal.classList.remove('is-open');

        setTimeout(function() {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 200);

        unlockBodyScroll();
    }

    function openBarangMasukModal() {
        openModal('barangMasukModal');
    }

    function closeBarangMasukModal() {
        closeModal('barangMasukModal');
    }

    function openBarangKeluarModal() {
        openModal('barangKeluarModal');
    }

    function closeBarangKeluarModal() {
        closeModal('barangKeluarModal');
    }

    function openStokMenipisModal() {
        openModal('stokMenipisModal');
    }

    function closeStokMenipisModal() {
        closeModal('stokMenipisModal');
    }

    function openStokHabisModal() {
        openModal('stokHabisModal');
    }

    function closeStokHabisModal() {
        closeModal('stokHabisModal');
    }

    function openDaftarBarangMasukModal() {
        openModal('daftarBarangMasukModal');
    }

    function closeDaftarBarangMasukModal() {
        closeModal('daftarBarangMasukModal');
    }

    function openDaftarBarangKeluarModal() {
        openModal('daftarBarangKeluarModal');
    }

    function closeDaftarBarangKeluarModal() {
        closeModal('daftarBarangKeluarModal');
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-overlay').forEach(function(modal) {
            const backdrop = modal.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    closeModal(modal.id);
                });
            }
        });
    });

    function tandaiBaca(btn) {
        if (btn.disabled) return;

        fetch('{{ route("dashboard.tandaiBaca") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                kode_barang: btn.dataset.kode,
                tipe: btn.dataset.tipe,
            }),
        }).then(() => {
            btn.textContent = 'Sudah Dibaca';
            btn.disabled = true;
            btn.classList.remove('bg-orange-500', 'bg-red-500', 'hover:bg-orange-600', 'hover:bg-red-600');
            btn.classList.add('bg-gray-400', 'cursor-not-allowed');
        });
    }
</script>

@if ($showStokMenipisModal)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        openStokMenipisModal();
    });
</script>
@endif

@endpush