@extends('layouts.app')

@section('title', 'Riwayat')

@section('content')
    <div class="p-4">
        <div class="bg-white rounded-2xl shadow-lg p-5">

            {{-- FILTER --}}
            <div class="flex flex-wrap items-center gap-3 mb-4">

                <span class="text-sm text-gray-500">Filter Periode</span>

                <input type="month" name="dari" value="{{ request('dari') }}"
                    class="text-sm border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">

                <span class="text-gray-400">—</span>

                <input type="month" name="sampai" value="{{ request('sampai') }}"
                    class="text-sm border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">

                <select id="filterJenis" onchange="submitFilter()"
                    class="text-sm border rounded-lg px-3 py-2 focus:ring-2 focus:ring-orange-400 outline-none">
                    <option value="">Semua Transaksi</option>
                    <option value="Barang Masuk" {{ request('jenis') == 'Barang Masuk' ? 'selected' : '' }}>Barang Masuk
                    </option>
                    <option value="Barang Keluar" {{ request('jenis') == 'Barang Keluar' ? 'selected' : '' }}>Barang Keluar
                    </option>
                </select>

                <button onclick="submitFilter()"
                    class="px-4 py-2 text-sm bg-orange-500 text-white rounded-lg
                hover:bg-orange-600 transition shadow">
                    Filter
                </button>

                {{-- EXPORT --}}
                <a href="{{ route('riwayat.export', request()->query()) }}"
                    class="ml-auto px-4 py-2 text-sm bg-green-500 text-white rounded-lg
                hover:bg-green-600 transition shadow">
                    Export Excel
                </a>
            </div>

            {{-- SEARCH --}}
            <div class="relative mb-5">

                <!-- ICON -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35" />
                </svg>

                <!-- INPUT -->
                <input type="text" id="searchSupplier" placeholder="Cari supplier..." value="{{ request('supplier') }}"
                    onkeydown="if(event.key==='Enter') submitFilter()"
                    class="w-full pl-10 pr-4 py-2 border rounded-lg
        focus:ring-2 focus:ring-orange-400 outline-none
        transition-all duration-200">

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm">

                    <thead>
                        <tr class="bg-gray-50 text-gray-600">
                            <th class="py-3 px-3 text-left">No</th>
                            <th class="py-3 px-3 text-left">Tanggal</th>
                            <th class="py-3 px-3 text-left">Nama Barang</th>
                            <th class="py-3 px-3 text-left">Jumlah</th>
                            <th class="py-3 px-3 text-left">Transaksi</th>
                            <th class="py-3 px-3 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($riwayat as $i => $item)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-3">{{ $i + 1 }}</td>
                                <td class="py-3 px-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td class="py-3 px-3 font-medium">{{ $item->nama_barang }}</td>
                                <td class="py-3 px-3">{{ $item->jumlah }}</td>

                                <td class="py-3 px-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $item->transaksi === 'Barang Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $item->transaksi }}
                                    </span>
                                </td>

                                <td class="py-3 px-3">
                                    <button onclick="toggleDetail({{ $i }})"
                                        class="px-3 py-1 text-xs bg-gray-100 rounded-lg
                                    hover:bg-orange-500 hover:text-white transition">
                                        Detail
                                    </button>
                                </td>
                            </tr>

                            {{-- DETAIL --}}
                            <tr id="detail-{{ $i }}" class="hidden">
                                <td colspan="6" class="p-4 bg-gray-50">
                                    <div class="bg-white rounded-xl shadow p-4 grid grid-cols-2 gap-3 text-sm">

                                        <div><span class="text-gray-500">Tanggal:</span>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</div>
                                        <div><span class="text-gray-500">Kategori:</span> {{ $item->kategori }}</div>
                                        <div><span class="text-gray-500">Jumlah:</span> {{ $item->jumlah }}</div>
                                        <div><span class="text-gray-500">Transaksi:</span> {{ $item->transaksi }}</div>
                                        <div><span class="text-gray-500">Supplier:</span> {{ $item->nama_supplier }}</div>
                                        <div><span class="text-gray-500">Kontak:</span> {{ $item->kontak }}</div>
                                        <div><span class="text-gray-500">Email:</span> {{ $item->email }}</div>
                                        <div><span class="text-gray-500">Kota:</span> {{ $item->kota }}</div>
                                        <div class="col-span-2"><span class="text-gray-500">Keterangan:</span>
                                            {{ $item->keterangan }}</div>

                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-400 py-16">
                                    Tidak ada data riwayat
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
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
            const supplier = document.getElementById('searchSupplier').value;

            const params = new URLSearchParams({
                dari,
                sampai,
                jenis,
                supplier
            });
            window.location.href = '{{ route('riwayat') }}?' + params.toString();
        }
    </script>
@endpush
