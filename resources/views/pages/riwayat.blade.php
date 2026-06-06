@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div>
<div class="p-0.5">

    {{-- FILTER + SEARCH --}}
<div class="flex flex-col lg:flex-row lg:justify-between lg:gap-6 gap-3 mb-4">

    <!-- KIRI -->
    <div class="flex flex-col leading-tight">
        <span class="text-sm font-semibold text-gray-600">Filter</span>
        <span class="text-base font-bold text-gray-700">Periode</span>
    </div>

    <!-- KANAN -->
    <div class="flex flex-col w-full lg:w-[900px] gap-2">

        <!-- FILTER ROW -->
        <div class="flex flex-wrap items-end gap-3 w-full">

            <!-- DATE RANGE -->
            <div class="flex flex-row gap-2 flex-1 min-w-0">
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Dari</label>
                    <input type="date" id="inputDari" name="dari"
                        value="{{ request('dari') }}"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg
                        focus:ring-orange-500 focus:border-orange-500 w-full p-2 h-[42px]">
                </div>
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Sampai</label>
                    <input type="date" id="inputSampai" name="sampai"
                        value="{{ request('sampai') }}"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg
                        focus:ring-orange-500 focus:border-orange-500 w-full p-2 h-[42px]">
                </div>
            </div>

            <!-- TOMBOL FILTER -->
            <div class="w-full sm:w-auto sm:mt-[21px]">
                <button onclick="submitFilter()"
                    class="flex items-center justify-center gap-2 text-white bg-orange-500 hover:bg-orange-600
                    rounded-lg text-sm px-8 h-[42px] w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                    </svg>
                    Filter
                </button>
            </div>

            <!-- JENIS TRANSAKSI -->
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-medium text-gray-500 mb-1">Jenis Transaksi</label>
                <select id="filterJenis" onchange="submitFilter()"
                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg
                    focus:ring-orange-500 focus:border-orange-500 w-full sm:w-48 p-2 h-[42px]">
                    <option value="">Semua Transaksi</option>
                    <option value="Barang Masuk" {{ request('jenis') == 'Barang Masuk' ? 'selected' : '' }}>
                        Barang Masuk
                    </option>
                    <option value="Barang Keluar" {{ request('jenis') == 'Barang Keluar' ? 'selected' : '' }}>
                        Barang Keluar
                    </option>
                </select>
            </div>

            <!-- EXPORT -->
            <div class="w-full sm:w-auto sm:mt-[21px]">
                <a id="exportBtn" href="{{ route('riwayat.export', request()->query()) }}"
                    class="flex items-center justify-center gap-2 text-white bg-green-500 hover:bg-green-600
                    rounded-lg text-sm px-6 h-[42px] w-full sm:w-auto">
                    Export Excel
                </a>
            </div>

        </div>

        <!-- SEARCH -->
        <div class="relative w-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="11" cy="11" r="8" />
                <path d="M21 21l-4.35-4.35" />
            </svg>
            <input id="searchInput" type="text"
                value="{{ request('search') }}"
                onkeydown="if(event.key==='Enter') submitFilter()"
                placeholder="Cari nama barang/kota..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
        </div>

    </div>
</div>
    </div>

    {{-- INFO 3 BULAN TERAKHIR --}}
    @if(!request('dari') && !request('sampai') && !request('jenis') && !request('search'))
    <div class="flex items-center gap-2 mb-3 px-3 py-2 rounded-lg bg-blue-50 border border-blue-100 text-xs text-blue-600 w-fit">
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/>
        </svg>
        Menampilkan aktivitas <span class="font-semibold mx-1">3 bulan terakhir</span>. Gunakan filter untuk melihat data lebih lama.
    </div>
    @endif

    {{-- ACTIVE FILTER BADGES --}}
    @if(request('dari') || request('sampai') || request('jenis') || request('search'))
    <div class="flex flex-wrap gap-2 mb-3">

        @if(request('dari') || request('sampai'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700 border border-orange-200">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            {{ request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') : '...' }}
            –
            {{ request('sampai') ? \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') : '...' }}
            <a href="{{ route('riwayat', array_merge(request()->except(['dari','sampai','page']))) }}"
                class="ml-1 text-orange-500 hover:text-orange-700 font-bold">×</a>
        </span>
        @endif

        @if(request('jenis'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
            {{ request('jenis') == 'Barang Masuk' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
            {{ request('jenis') }}
            <a href="{{ route('riwayat', array_merge(request()->except(['jenis','page']))) }}"
                class="ml-1 font-bold hover:opacity-70">×</a>
        </span>
        @endif

        @if(request('search'))
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            "{{ request('search') }}"
            <a href="{{ route('riwayat', array_merge(request()->except(['search','page']))) }}"
                class="ml-1 text-gray-500 hover:text-gray-700 font-bold">×</a>
        </span>
        @endif

        <a href="{{ route('riwayat') }}"
            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-gray-500 hover:text-red-500 underline underline-offset-2 transition">
            Reset semua
        </a>

    </div>
    @endif

    {{-- TABLE --}}
    <div class="border border-gray-300 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[700px] text-sm">

                {{-- HEADER --}}
                <thead class="bg-[#205375] text-white uppercase text-xs">
                    <tr>
                        <th class="py-3 px-6 text-left">No</th>
                        <th class="py-3 px-3 text-left">Tanggal</th>
                        <th class="py-3 px-3 text-left">Nama Barang</th>
                        <th class="py-3 px-3 text-left">Jumlah</th>
                        <th class="py-3 px-3 text-left">Kota</th>
                        <th class="py-3 px-3 text-left">Transaksi</th>
                        <th class="py-3 px-3 text-left">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody>
                    @forelse ($riwayat as $i => $item)
                        <tr class="{{ $loop->even ? 'bg-gray-50/60' : '' }}">
                            <td class="py-3 px-6 font-medium">
                                {{ ($riwayat->currentPage() - 1) * $riwayat->perPage() + $i + 1 }}
                            </td>
                            <td class="py-3 px-3">{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                            <td class="py-3 px-3 font-medium">{{ $item->nama_barang }}</td>
                            <td class="py-3 px-3">{{ $item->jumlah }}</td>
                            <td class="py-3 px-3 font-medium">{{ $item->kota }}</td>

                            <td class="py-3 px-3">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $item->transaksi === 'Barang Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $item->transaksi }}
                                </span>
                            </td>

                            <td class="py-3 px-3">
                                <button onclick="toggleDetail({{ $i }})"
                                    class="px-3 py-1 text-sm font-medium border border-orange-200 rounded-md bg-orange-100 text-orange-800
                                    hover:bg-orange-500 hover:text-white transition">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        {{-- DETAIL --}}
                        <tr id="detail-{{ $i }}" class="hidden bg-gray-50">
                            <td colspan="7" class="p-4">
                                <div class="bg-white border rounded-xl p-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                    <div><span class="text-gray-500">Tanggal:</span> {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</div>
                                    <div><span class="text-gray-500">Kategori:</span> {{ $item->kategori }}</div>
                                    <div><span class="text-gray-500">Jumlah:</span> {{ $item->jumlah }}</div>
                                    <div><span class="text-gray-500">Transaksi:</span> {{ $item->transaksi }}</div>
                                    <div><span class="text-gray-500">Supplier:</span> {{ $item->nama_supplier }}</div>
                                    <div><span class="text-gray-500">Kontak:</span> {{ $item->kontak }}</div>
                                    <div><span class="text-gray-500">Email:</span> {{ $item->email }}</div>
                                    <div><span class="text-gray-500">{{ $item->transaksi === 'Barang Keluar' ? 'Tujuan' : 'Kota' }}:</span> {{ $item->kota }}</div>
                                    <div><span class="text-gray-500">Keterangan:</span> {{ $item->keterangan }}</div>
                                    <div>
                                        <span class="text-gray-500">Dicatat Oleh:</span>
                                        <span class="inline-flex items-center gap-1.5 ml-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            {{ $item->dicatat_oleh }}
                                        </span>
                                    </div>
                                </div>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="py-12 text-center">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200
                                        flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.8" />
                                            <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="1.8" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Tidak ada riwayat ditemukan</p>
                                    <p class="text-sm text-gray-400">Coba ubah filter atau rentang tanggal</p>
                                    <a href="{{ route('riwayat') }}"
                                        class="inline-flex items-center gap-1.5 mt-4 bg-[#F66B0E] hover:bg-orange-600
                                        text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                        Tampilkan Semua
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER PAGINATION --}}
        <div class="px-3 py-2 flex flex-col sm:flex-row items-center justify-between gap-2 text-sm border-t border-gray-200">

            <span class="text-gray-400">
                @if($riwayat->total() > 0)
                    Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }}
                    dari {{ $riwayat->total() }} riwayat
                @else
                    Tidak ada data
                @endif
            </span>

            @if($riwayat->lastPage() > 1)
            <div class="flex items-center gap-1">

                {{-- PREV --}}
                @if ($riwayat->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center text-gray-300 border border-gray-200 rounded-md">‹</span>
                @else
                    <a href="{{ $riwayat->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                        class="w-8 h-8 flex items-center justify-center text-gray-500
                        border border-gray-300 rounded-md hover:border-orange-500 hover:text-orange-500 transition">‹</a>
                @endif

                {{-- NUMBER --}}
                @for ($p = 1; $p <= $riwayat->lastPage(); $p++)
                    <a href="{{ $riwayat->url($p) }}&{{ http_build_query(request()->except('page')) }}"
                        class="w-8 h-8 flex items-center justify-center rounded-md border transition
                        {{ $riwayat->currentPage() == $p
                            ? 'bg-orange-500 text-white border-orange-500'
                            : 'text-gray-500 border-gray-300 hover:border-orange-500 hover:text-orange-500' }}">
                        {{ $p }}
                    </a>
                @endfor

                {{-- NEXT --}}
                @if ($riwayat->hasMorePages())
                    <a href="{{ $riwayat->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                        class="w-8 h-8 flex items-center justify-center text-gray-500
                        border border-gray-300 rounded-md hover:border-orange-500 hover:text-orange-500 transition">›</a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center text-gray-300 border border-gray-200 rounded-md">›</span>
                @endif

            </div>
            @endif

        </div>
    </div>

</div>
</div>
@endsection

@push('scripts')
<script>
    function toggleDetail(i) {
        const rows = document.querySelectorAll('[id^="detail-"]');
        rows.forEach(r => {
            if (r.id !== 'detail-' + i) r.classList.add('hidden');
        });
        document.getElementById('detail-' + i).classList.toggle('hidden');
    }

    function submitFilter() {
        const dari   = document.getElementById('inputDari').value;
        const sampai = document.getElementById('inputSampai').value;
        const jenis  = document.getElementById('filterJenis').value;
        const search = document.getElementById('searchInput').value;

        const params = new URLSearchParams();
        if (dari)   params.set('dari',   dari);
        if (sampai) params.set('sampai', sampai);
        if (jenis)  params.set('jenis',  jenis);
        if (search) params.set('search', search);

        window.location.href = '{{ route('riwayat') }}?' + params.toString();
    }

    function updateExportHref() {
        const dari   = document.getElementById('inputDari').value;
        const sampai = document.getElementById('inputSampai').value;
        const jenis  = document.getElementById('filterJenis').value;
        const search = document.getElementById('searchInput').value;

        const params = new URLSearchParams();
        if (dari)   params.set('dari',   dari);
        if (sampai) params.set('sampai', sampai);
        if (jenis)  params.set('jenis',  jenis);
        if (search) params.set('search', search);

        document.getElementById('exportBtn').href =
            '{{ route('riwayat.export') }}?' + params.toString();
    }

    document.getElementById('inputDari').addEventListener('change', updateExportHref);
    document.getElementById('inputSampai').addEventListener('change', updateExportHref);
    document.getElementById('filterJenis').addEventListener('change', updateExportHref);
    document.getElementById('searchInput').addEventListener('input', updateExportHref);
</script>
@endpush
