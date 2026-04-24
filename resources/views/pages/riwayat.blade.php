@extends('layouts.app')

@section('title', 'Riwayat')

@section('content')
    <div class="p-4">
        <div class="bg-white rounded-2xl shadow-lg p-5">

            {{-- FILTER + SEARCH --}}
            <div class="flex flex-col lg:flex-row lg:justify-between lg:gap-6 gap-3 mb-4">

                <!-- KIRI -->
                <div class="flex flex-col leading-tight">
                    <span class="text-sm font-semibold text-gray-600">Filter</span>
                    <span class="text-base font-bold text-gray-700">Periode</span>
                </div>

                <!-- KANAN -->
                <div class="flex flex-col items-end w-full lg:w-[800px]">

                    <!-- FILTER -->
                    <div class="flex items-end gap-2 w-full">

                        <!-- DATE RANGE -->
                        <div class="flex items-end gap-2 flex-1">

                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Dari</label>
                                <input type="date" name="dari" value="{{ request('dari') }}"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg
                                focus:ring-orange-500 focus:border-orange-500 w-full p-2 h-[42px]">
                            </div>

                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Sampai</label>
                                <input type="date" name="sampai" value="{{ request('sampai') }}"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg
                                focus:ring-orange-500 focus:border-orange-500 w-full p-2 h-[42px]">
                            </div>

                        </div>

                        <!-- FILTER BUTTON -->
                        <button onclick="submitFilter()"
                            class="flex items-center gap-2 text-white bg-orange-500 hover:bg-orange-600
                        rounded-lg text-sm px-4 h-[42px]">

                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path
                                    d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                            </svg>

                            Filter
                        </button>

                        <!-- JENIS -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Jenis</label>
                            <select id="filterJenis" onchange="submitFilter()"
                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg
                            focus:ring-orange-500 focus:border-orange-500 w-44 p-2 h-[42px]">
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
                        <a href="{{ route('riwayat.export', request()->query()) }}"
                            class="flex items-center gap-2 text-white bg-green-500 hover:bg-green-600
                        rounded-lg text-sm px-4 h-[42px]">
                            Export Excel
                        </a>

                    </div>

                    <!-- SEARCH -->
                    <div class="relative mt-3 w-full">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>

                        <input type="text" id="searchInput" placeholder="Cari nama barang, kota..."
                            value="{{ request('search') }}" onkeydown="if(event.key==='Enter') submitFilter()"
                            class="w-full pl-10 pr-4 py-2 border rounded-lg
                        focus:ring-2 focus:ring-orange-400 outline-none h-[42px]">
                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="border border-gray-300 rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">

                        {{-- HEADER --}}
                        <thead class="bg-[#205375] text-white uppercase text-xs">
                            <tr>
                                <th class="py-3 px-3 text-left">No</th>
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
                                <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }}">

                                    <td class="py-3 px-3">{{ $i + 1 }}</td>
                                    <td class="py-3 px-3">
                                        {{ date('d/m/Y',strtotime($item->tanggal)) }}
                                    </td>
                                    <td class="py-3 px-3 font-medium">{{ $item->nama_barang }}</td>
                                    <td class="py-3 px-3">{{ $item->jumlah }}</td>
                                    <td class="py-3 px-3">{{ $item->kota }}</td>

                                    <td class="py-3 px-3">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium
                                        {{ $item->transaksi === 'Barang Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $item->transaksi }}
                                        </span>
                                    </td>

                                    <td class="py-3 px-3">
                                        <button onclick="toggleDetail({{ $i }})"
                                            class="px-3 py-1 text-xs border border-gray-300 rounded-md
                                        hover:bg-orange-500 hover:text-white transition">
                                            Detail
                                        </button>
                                    </td>

                                </tr>

                                {{-- DETAIL --}}
                                <tr id="detail-{{ $i }}" class="hidden bg-gray-50">
                                    <td colspan="7" class="p-4">
                                        <div class="bg-white border rounded-xl p-4 grid grid-cols-2 gap-3 text-sm">

                                            <div><span class="text-gray-500">Tanggal:</span>
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</div>
                                            <div><span class="text-gray-500">Kategori:</span> {{ $item->kategori }}</div>
                                            <div><span class="text-gray-500">Jumlah:</span> {{ $item->jumlah }}</div>
                                            <div><span class="text-gray-500">Transaksi:</span> {{ $item->transaksi }}</div>
                                            <div><span class="text-gray-500">Supplier:</span> {{ $item->nama_supplier }}
                                            </div>
                                            <div><span class="text-gray-500">Kontak:</span> {{ $item->kontak }}</div>
                                            <div><span class="text-gray-500">Email:</span> {{ $item->email }}</div>
                                            <div><span class="text-gray-500">Kota:</span> {{ $item->kota }}</div>

                                            <div class="col-span-2">
                                                <span class="text-gray-500">Keterangan:</span> {{ $item->keterangan }}
                                            </div>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-16 text-gray-400">
                                        Tidak ada data riwayat
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
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
            const dari = document.querySelector('input[name="dari"]').value;
            const sampai = document.querySelector('input[name="sampai"]').value;
            const jenis = document.getElementById('filterJenis').value;
            const search = document.getElementById('searchInput').value;

            const params = new URLSearchParams({
                dari,
                sampai,
                jenis,
                search
            });
            window.location.href = '{{ route('riwayat') }}?' + params.toString();
        }
    </script>
@endpush
