@extends('admin.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="space-y-4">

        <!-- SEARCH & BUTTON TAMBAH -->
        <div class="flex items-center gap-3 bg-white p-2 rounded-xl border border-gray-200 shadow">

            <!-- SEARCH -->
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="searchInput" placeholder="Cari kategori..."
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
            </div>

            <!-- TOMBOL TAMBAH -->
            <button type="button" data-modal-target="modalKategori" data-modal-toggle="modalKategori"
                onclick="setModalKategori('tambah')"
                class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
                Tambah Kategori
            </button>
        </div>

        <!-- TABLE -->
        <div class="bg-white p-3 border border-gray-200 rounded-xl shadow space-y-2">

            <!-- Info jumlah data -->
            <p id="dataInfo" class="text-xs text-gray-500 px-1">Menampilkan 1-2 dari 2 data</p>

            <!-- Tabel -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-600 uppercase bg-orange-50 border-b border-orange-100">
                        <tr>
                            <th scope="col" class="px-4 py-3.5 w-14 text-center">No</th>
                            <th scope="col" class="px-4 py-3.5">Nama Kategori</th>
                            <th scope="col" class="px-4 py-3.5 w-40 text-left">Status</th>
                            <th scope="col" class="px-4 py-3.5 w-40 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-100 hover:bg-gray-50" data-search="bawahan">
                            <td class="px-4 py-3.5 font-medium text-gray-800 text-center">1</td>
                            <td class="px-4 py-3.5 font-medium text-gray-800">Bawahan</td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-flex items-center bg-green-100 text-green-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 rounded-full bg-green-500"></span>
                                    Aktif
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" data-modal-target="modalKategori"
                                        data-modal-toggle="modalKategori" onclick="setModalKategori('edit')"
                                        class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Edit
                                    </button>
                                    <button type="button" data-modal-target="modalHapus" data-modal-toggle="modalHapus"
                                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-100 hover:bg-gray-50" data-search="elektronik">
                            <td class="px-4 py-3.5 font-medium text-gray-800 text-center">2</td>
                            <td class="px-4 py-3.5 font-medium text-gray-800">Elektronik</td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-flex items-center bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 rounded-full bg-gray-400"></span>
                                    Nonaktif
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" data-modal-target="modalKategori"
                                        data-modal-toggle="modalKategori" onclick="setModalKategori('edit')"
                                        class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Edit
                                    </button>
                                    <button type="button" data-modal-target="modalHapus" data-modal-toggle="modalHapus"
                                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-100 hover:bg-gray-50" data-search="aksesoris">
                            <td class="px-4 py-3.5 font-medium text-gray-800 text-center">3</td>
                            <td class="px-4 py-3.5 font-medium text-gray-800">Aksesoris</td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-flex items-center bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 rounded-full bg-gray-400"></span>
                                    Nonaktif
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" data-modal-target="modalKategori"
                                        data-modal-toggle="modalKategori" onclick="setModalKategori('edit')"
                                        class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Edit
                                    </button>
                                    <button type="button" data-modal-target="modalHapus" data-modal-toggle="modalHapus"
                                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-100 hover:bg-gray-50" data-search="atasan">
                            <td class="px-4 py-3.5 font-medium text-gray-800 text-center">4</td>
                            <td class="px-4 py-3.5 font-medium text-gray-800">Atasan</td>
                            <td class="px-4 py-3.5">
                                <span
                                    class="inline-flex items-center bg-gray-100 text-gray-600 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    <span class="w-2 h-2 me-1 rounded-full bg-gray-400"></span>
                                    Nonaktif
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" data-modal-target="modalKategori"
                                        data-modal-toggle="modalKategori" onclick="setModalKategori('edit')"
                                        class="text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Edit
                                    </button>
                                    <button type="button" data-modal-target="modalHapus" data-modal-toggle="modalHapus"
                                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Empty state (muncul jika tidak ada hasil) -->
                <div id="emptyState" class="hidden py-10 text-center">
                    <svg class="mx-auto mb-3 w-10 h-10 text-gray-300" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <p class="text-sm text-gray-400">Kategori tidak ditemukan.</p>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('modals')
    <!-- MODAL TAMBAH / EDIT KATEGORI -->
    <div id="modalKategori" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden">

                <!-- Header -->
                <div id="modalKategoriHeader"
                    class="flex items-center justify-between px-6 py-5 bg-orange-500 border-b border-orange-100">
                    <h3 id="modalKategoriTitle" class="text-lg font-semibold text-white">Tambah Kategori</h3>
                    <button type="button" data-modal-hide="modalKategori"
                        class="text-white/70 bg-transparent hover:text-white rounded-lg w-8 h-8 inline-flex justify-center items-center transition">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-6 py-6 space-y-5">

                    <!-- Nama Kategori -->
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                            Nama Kategori
                        </label>
                        <input type="text" id="namaKategori" placeholder="Masukkan nama kategori"
                            class="bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 placeholder-gray-300" />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                            Status
                        </label>
                        <label class="inline-flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div
                                class="relative w-12 h-6 bg-gray-200 rounded-full peer peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 peer-checked:bg-yellow-500 after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-gray-300 after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white">
                            </div>
                            <span class="text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                    </div>

                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                    <button type="button" data-modal-hide="modalKategori"
                        class="py-2.5 px-6 text-sm font-medium text-gray-700 bg-white rounded-xl border border-gray-200 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-100 transition">
                        Batal
                    </button>
                    <button type="button"
                        class="py-2.5 px-6 text-sm font-semibold text-white bg-yellow-500 hover:bg-yellow-600 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-300 transition">
                        Simpan
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL KONFIRMASI HAPUS -->
    <div id="modalHapus" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden">

                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-5 bg-red-500 border-b border-red-100">
                    <h3 class="text-lg font-semibold text-white">Konfirmasi Hapus</h3>
                    <button type="button" data-modal-hide="modalHapus"
                        class="text-white/70 bg-transparent hover:text-white rounded-lg w-8 h-8 inline-flex justify-center items-center transition">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup Modal</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-5 text-center">
                    <svg class="mx-auto mb-4 text-red-400 w-12 h-12" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p class="text-sm text-gray-600">
                        Apakah kamu yakin ingin menghapus kategori ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>

                <!-- Footer -->
                <div class="flex items-center justify-end gap-2 p-5 border-t border-gray-200 rounded-b">
                    <button type="button" data-modal-hide="modalHapus"
                        class="py-2.5 px-5 text-sm font-medium text-gray-700 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        Batal
                    </button>
                    <button type="button"
                        class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Ya, Hapus
                    </button>
                </div>

            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        // ── SEARCH ──
        document.getElementById('searchInput').addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('tbody tr[data-search]');
            const emptyState = document.getElementById('emptyState');
            let visible = 0;

            rows.forEach(row => {
                const match = row.dataset.search.includes(keyword);
                row.classList.toggle('hidden', !match);
                if (match) visible++;
            });

            // Tampilkan empty state jika tidak ada hasil
            emptyState.classList.toggle('hidden', visible > 0);

            // Update info jumlah data
            const total = rows.length;
            const info = document.getElementById('dataInfo');
            info.textContent = keyword ?
                `Menampilkan ${visible} dari ${total} data` :
                `Menampilkan 1-${total} dari ${total} data`;
        });

        // ── MODAL KATEGORI ──
        function setModalKategori(mode) {
            const title = document.getElementById('modalKategoriTitle');
            const header = document.getElementById('modalKategoriHeader');

            const isTambah = mode === 'tambah';

            title.textContent = isTambah ? 'Tambah Kategori' : 'Edit Kategori';

            header.classList.toggle('bg-orange-500', isTambah);
            header.classList.toggle('border-orange-100', isTambah);
            header.classList.toggle('bg-yellow-300', !isTambah);
            header.classList.toggle('border-yellow-100', !isTambah);
        }
    </script>
@endpush
