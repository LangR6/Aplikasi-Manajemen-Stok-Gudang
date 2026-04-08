@extends('app')

@section('title', 'Dashboard')

@section('content')
    @if (session('success'))
        <div class="mb-4 rounded-xl border border-green-500 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Top Cards -->
    <div class="grid grid-cols-2 gap-5 mb-6">
        <div
            class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-[155px] p-6">
            <h2 class="panel-title">Barang Masuk</h2>
            <div class="mt-6 text-[40px] font-semibold text-[#222]">
                {{ $totalBarangMasuk }}
            </div>
        </div>
        <div
            class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-[155px] p-6">
            <h2 class="panel-title">Barang Keluar</h2>
            <div class="mt-6 text-[40px] font-semibold text-[#222]">
                {{ $totalBarangKeluar }}
            </div>
        </div>
    </div>

    <!-- Small Cards -->
    <div class="grid grid-cols-3 gap-5 mb-6">
        <div
            class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-[150px] p-6">
            <h2 class="text-[20px] font-medium">Total Barang</h2>
            <div class="mt-6 text-[30px] font-semibold">
                {{ $totalBarang }}
            </div>
        </div>
        <div class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-[150px] p-6 cursor-pointer"
            onclick="openStokMenipisModal()">
            <h2 class="text-[20px] font-medium">Stok Barang Menipis</h2>
            <div class="mt-6 text-[30px] font-semibold text-yellow-600">
                {{ $stokMenipis }}
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-[150px] p-6 cursor-pointer"
            onclick="openStokHabisModal()">
            <h2 class="text-[20px] font-medium">Stok Barang Habis</h2>
            <div class="mt-6 text-[30px] font-semibold text-red-600">
                {{ $stokHabis }}
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-12 gap-5">
        <!-- Data Supplier -->
        <div class="col-span-6">
            <div
                class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 min-h-[390px] overflow-hidden">
                <div class="px-4 py-3 border-b-2 border-[#9a9a9a]">
                    <h2 class="text-[22px] font-semibold text-[#222]">Data Supplier</h2>
                </div>

                <div class="px-4 pt-4">
                    @if (count($suppliers) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full table-fixed border-collapse">
                                <thead>
                                    <tr class="border-b-2 border-[#9a9a9a] text-left">
                                        <th class="pb-3 text-[18px] font-medium text-[#333] w-[28%]">Nama Supplier</th>
                                        <th class="pb-3 text-[18px] font-medium text-[#333] w-[22%]">Kontak</th>
                                        <th class="pb-3 text-[18px] font-medium text-[#333] w-[30%]">Email</th>
                                        <th class="pb-3 text-[18px] font-medium text-[#333] w-[20%]">Kota</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr class="border-b">
                                            <td class="py-4 pr-4 text-[15px] text-[#222] align-top break-words">
                                                {{ $supplier['nama_supplier'] }}
                                            </td>
                                            <td class="py-4 pr-4 text-[15px] text-[#222] align-top break-words">
                                                {{ $supplier['kontak'] }}
                                            </td>
                                            <td class="py-4 pr-4 text-[15px] text-[#222] align-top break-words">
                                                {{ $supplier['email'] }}
                                            </td>
                                            <td class="py-4 text-[15px] text-[#222] align-top break-words">
                                                {{ $supplier['kota'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="h-[230px] flex items-center justify-center text-gray-400">
                            Belum ada data supplier
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Cards -->
        <div class="col-span-6 space-y-4">
            <div
                class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="px-4 py-3 border-b-2 border-[#9a9a9a]">
                    <h2 class="text-[22px] font-semibold text-[#222]">Barang Masuk Terbaru</h2>
                </div>

                <div class="p-4">
                    <div
                        class="bg-gray-50 border border-gray-200 rounded-[20px] p-5 flex items-center justify-between min-h-[120px] transition-all duration-300 hover:shadow-md">
                        <div class="text-[18px] text-[#444] leading-8">
                            <div>Supplier : {{ $barangMasukTerbaru['supplier'] }}</div>
                            <div>Kontak : {{ $barangMasukTerbaru['kontak'] }}</div>
                            <div>Tanggal : {{ $barangMasukTerbaru['tanggal'] }}</div>
                        </div>

                        <button type="button" onclick="openBarangMasukModal()"
                            class="bg-orange-500 text-white rounded-[14px] px-6 py-2.5 text-[16px] font-medium hover:bg-orange-600 hover:shadow-md transition-all duration-300">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>

            <div
                class="bg-white border border-gray-200 rounded-[24px] shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                <div class="px-4 py-3 border-b-2 border-[#9a9a9a]">
                    <h2 class="text-[22px] font-semibold text-[#222]">Barang Keluar Terbaru</h2>
                </div>

                <div class="p-4">
                    <div
                        class="bg-gray-50 border border-gray-200 rounded-[20px] p-5 flex items-center justify-between min-h-[120px] transition-all duration-300 hover:shadow-md">
                        <div class="text-[18px] text-[#444] leading-8">
                            <div>Supplier : {{ $barangKeluarTerbaru['supplier'] }}</div>
                            <div>Kontak : {{ $barangKeluarTerbaru['kontak'] }}</div>
                            <div>Tanggal : {{ $barangKeluarTerbaru['tanggal'] }}</div>
                        </div>

                        <button type="button" onclick="openBarangKeluarModal()"
                            class="bg-orange-500 text-white rounded-[14px] px-6 py-2.5 text-[16px] font-medium hover:bg-orange-600 hover:shadow-md transition-all duration-300">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <!-- Modal Detail Barang Masuk -->
    <div id="barangMasukModal"
        class="fixed inset-0 hidden items-center justify-center bg-black/20 backdrop-blur-[1px] z-50">
        <div class="w-full max-w-[620px] bg-white rounded-2xl border-2 border-[#b0b0b0] shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b-2 thin-line">
                <h3 class="text-[20px] font-semibold text-[#222]">Informasi Barang Masuk</h3>
                <button type="button" onclick="closeBarangMasukModal()"
                    class="text-[24px] text-[#333] leading-none">&times;</button>
            </div>

            <div class="p-4">
                <div class="mb-3">
                    <label class="block text-[13px] font-medium mb-1">Nama Barang</label>
                    <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                        {{ $barangMasukTerbaru['nama_barang'] }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-[13px] font-medium mb-1">Kategori</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangMasukTerbaru['kategori'] }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium mb-1">Jumlah</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangMasukTerbaru['jumlah'] }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-[13px] font-medium mb-1">Nama Supplier</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangMasukTerbaru['supplier'] }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium mb-1">Tanggal Masuk</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangMasukTerbaru['tanggal'] }}
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-[13px] font-medium mb-1">Catatan</label>
                    <div class="w-full min-h-[80px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                        {{ $barangMasukTerbaru['catatan'] }}
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="button" onclick="closeBarangMasukModal()"
                        class="w-[180px] h-[46px] border-2 border-[#8f8f8f] rounded-xl font-medium hover:bg-gray-100">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Barang Keluar -->
    <div id="barangKeluarModal"
        class="fixed inset-0 hidden items-center justify-center bg-black/20 backdrop-blur-[1px] z-50">
        <div class="w-full max-w-[620px] bg-white rounded-2xl border-2 border-[#b0b0b0] shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b-2 thin-line">
                <h3 class="text-[20px] font-semibold text-[#222]">Informasi Barang Keluar</h3>
                <button type="button" onclick="closeBarangKeluarModal()"
                    class="text-[24px] text-[#333] leading-none">&times;</button>
            </div>

            <div class="p-4">
                <div class="mb-3">
                    <label class="block text-[13px] font-medium mb-1">Nama Barang</label>
                    <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                        {{ $barangKeluarTerbaru['nama_barang'] }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-[13px] font-medium mb-1">Kategori</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangKeluarTerbaru['kategori'] }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium mb-1">Jumlah</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangKeluarTerbaru['jumlah'] }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div>
                        <label class="block text-[13px] font-medium mb-1">Tujuan</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangKeluarTerbaru['tujuan'] }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium mb-1">Tanggal Keluar</label>
                        <div class="w-full min-h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                            {{ $barangKeluarTerbaru['tanggal'] }}
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-[13px] font-medium mb-1">Catatan</label>
                    <div class="w-full min-h-[80px] border-2 border-[#8f8f8f] rounded-xl px-4 py-3 bg-white">
                        {{ $barangKeluarTerbaru['catatan'] }}
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="button" onclick="closeBarangKeluarModal()"
                        class="w-[180px] h-[46px] border-2 border-[#8f8f8f] rounded-xl font-medium hover:bg-gray-100">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Stok Barang Menipis -->
    <div id="stokMenipisModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
        <div class="w-full max-w-[720px] bg-white rounded-2xl border-2 border-[#b0b0b0] shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b-2 thin-line">
                <h3 class="text-[20px] font-semibold text-[#222]">Daftar Stok Barang Menipis</h3>
                <button type="button" onclick="closeStokMenipisModal()"
                    class="text-[24px] text-[#333] leading-none">&times;</button>
            </div>

            <div class="p-4 space-y-3 max-h-[420px] overflow-y-auto">
                @forelse($daftarStokMenipis as $barang)
                    <div class="outline-box p-4 flex items-center justify-between gap-4">
                        <div class="text-[16px] text-[#444] leading-7">
                            <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                            <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                            <div><span class="font-medium">Sisa Stok :</span> {{ $barang['stok'] }}</div>
                        </div>

                        <button type="button"
                            class="border-2 border-[#8f8f8f] rounded-xl px-4 py-2 text-[15px] font-medium hover:bg-gray-100 {{ $barang['status_baca'] ? 'bg-gray-100 text-gray-500' : '' }}">
                            {{ $barang['status_baca'] ? 'Sudah Dibaca' : 'Tandai Dibaca' }}
                        </button>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-8">
                        Tidak ada barang dengan stok menipis
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Stok Barang Habis -->
    <div id="stokHabisModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
        <div class="w-full max-w-[720px] bg-white rounded-2xl border-2 border-[#b0b0b0] shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b-2 thin-line">
                <h3 class="text-[20px] font-semibold text-[#222]">Daftar Stok Barang Habis</h3>
                <button type="button" onclick="closeStokHabisModal()"
                    class="text-[24px] text-[#333] leading-none">&times;</button>
            </div>

            <div class="p-4 space-y-3 max-h-[420px] overflow-y-auto">
                @forelse($daftarStokHabis as $barang)
                    <div class="outline-box p-4 flex items-center justify-between gap-4">
                        <div class="text-[16px] text-[#444] leading-7">
                            <div><span class="font-medium">Nama Barang :</span> {{ $barang['nama_barang'] }}</div>
                            <div><span class="font-medium">Kategori :</span> {{ $barang['kategori'] }}</div>
                            <div><span class="font-medium">Sisa Stok :</span> {{ $barang['stok'] }}</div>
                        </div>

                        <button type="button"
                            class="border-2 border-[#8f8f8f] rounded-xl px-4 py-2 text-[15px] font-medium hover:bg-gray-100 {{ $barang['status_baca'] ? 'bg-gray-100 text-gray-500' : '' }}">
                            {{ $barang['status_baca'] ? 'Sudah Dibaca' : 'Tandai Dibaca' }}
                        </button>
                    </div>
                @empty
                    <div class="text-center text-gray-400 py-8">
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
            document.body.classList.add('overflow-hidden');
        }

        function unlockBodyScroll() {
            document.body.classList.remove('overflow-hidden');
        }

        function openBarangMasukModal() {
            const modal = document.getElementById('barangMasukModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeBarangMasukModal() {
            const modal = document.getElementById('barangMasukModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        function openBarangKeluarModal() {
            const modal = document.getElementById('barangKeluarModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeBarangKeluarModal() {
            const modal = document.getElementById('barangKeluarModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        function openStokMenipisModal() {
            const modal = document.getElementById('stokMenipisModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeStokMenipisModal() {
            const modal = document.getElementById('stokMenipisModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        function openStokHabisModal() {
            const modal = document.getElementById('stokHabisModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeStokHabisModal() {
            const modal = document.getElementById('stokHabisModal');
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }
    </script>
@endpush
