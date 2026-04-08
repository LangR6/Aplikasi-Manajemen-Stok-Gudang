@extends('app')

@section('title', 'Kelola Barang')

@section('content')
    <div class="space-y-6">

        <!-- SEARCH & FILTER -->
        <div class="flex items-center justify-between gap-3">

            <div class="flex items-center gap-3 flex-1">

                <!-- SEARCH -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari barang..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
                </div>

                <!-- FILTER STATUS -->
                <select id="filterStatus"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5">
                    <option value="">Semua Status</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Menipis">Menipis</option>
                    <option value="Habis">Habis</option>
                </select>

                <!-- FILTER KATEGORI -->
                <select id="filterKategori"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5">
                    <option value="">Semua Kategori</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Atasan">Atasan</option>
                    <option value="Bawahan">Bawahan</option>
                    <option value="Sepatu">Sepatu</option>
                    <option value="Tas">Tas</option>
                </select>

            </div>

            <!-- TOMBOL TAMBAH -->
            <button type="button" onclick="openModal('tambah', null)"
                class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center gap-2 ms-4">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 1v16M1 9h16" />
                </svg>
                Tambah Barang
            </button>
        </div>

        <!-- GRID BARANG -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

            @foreach ([['nama' => 'Topi', 'stok' => 8, 'kategori' => 'Aksesoris'], ['nama' => 'Topi', 'stok' => 8, 'kategori' => 'Aksesoris'], ['nama' => 'Topi', 'stok' => 8, 'kategori' => 'Aksesoris'], ['nama' => 'Topi', 'stok' => 8, 'kategori' => 'Aksesoris'], ['nama' => 'Topi', 'stok' => 8, 'kategori' => 'Aksesoris'], ['nama' => 'Sweater', 'stok' => 5, 'kategori' => 'Atasan'], ['nama' => 'Sweater', 'stok' => 5, 'kategori' => 'Atasan'], ['nama' => 'Sweater', 'stok' => 5, 'kategori' => 'Atasan'], ['nama' => 'Sweater', 'stok' => 5, 'kategori' => 'Atasan'], ['nama' => 'Sweater', 'stok' => 5, 'kategori' => 'Atasan'], ['nama' => 'Celana', 'stok' => 0, 'kategori' => 'Bawahan'], ['nama' => 'Celana', 'stok' => 0, 'kategori' => 'Bawahan'], ['nama' => 'Celana', 'stok' => 0, 'kategori' => 'Bawahan'], ['nama' => 'Celana', 'stok' => 0, 'kategori' => 'Bawahan'], ['nama' => 'Celana', 'stok' => 0, 'kategori' => 'Bawahan']] as $barang)
                <div class="card-barang relative bg-white rounded-xl shadow-sm hover:shadow-lg transition p-4 flex flex-col items-center border"
                    data-nama="{{ $barang['nama'] }}" data-kategori="{{ $barang['kategori'] }}"
                    data-stok="{{ $barang['stok'] }}">

                    <!-- MENU AKSI -->
                    <div class="absolute top-2 right-2">
                        <button onclick="toggleMenu(this)" class="text-gray-400 hover:text-gray-700 text-lg">
                            ⋮
                        </button>
                        <div class="hidden absolute right-0 mt-2 w-28 bg-white border rounded-lg shadow-md z-10 menu-aksi">
                            <button onclick="openEditModal('{{ $barang['nama'] }}', '{{ $barang['kategori'] }}')"
                                class="w-full text-left px-3 py-2 hover:bg-gray-100 text-sm">✏️ Edit</button>
                            <button class="w-full text-left px-3 py-2 hover:bg-gray-100 text-sm text-red-500">🗑
                                Hapus</button>
                        </div>
                    </div>

                    <!-- GAMBAR -->
                    <div class="w-36 h-36 bg-gray-100 rounded-lg flex items-center justify-center mb-4">
                        <span class="text-gray-400 text-sm">gambar</span>
                    </div>

                    <!-- NAMA -->
                    <h3 class="font-semibold text-gray-700 text-center">{{ $barang['nama'] }}</h3>
                    <!-- KATEGORI -->
                    <h3 class=" text-gray-500 text-center text-xs">Kategori: {{ $barang['kategori'] }}</h3>

                    <!-- BADGE STOK -->
                    <p
                        class="text-sm mb-4 {{ $barang['stok'] == 0 ? 'text-red-500 font-bold' : ($barang['stok'] <= 5 ? 'text-yellow-500 font-semibold' : 'text-green-500 font-semibold') }}">
                        Stok : {{ $barang['stok'] }}
                        @if ($barang['stok'] == 0)
                            <span class="ml-1 text-xs bg-red-100 text-red-500 px-1 rounded">Habis</span>
                        @elseif ($barang['stok'] <= 5)
                            <span class="ml-1 text-xs bg-yellow-100 text-yellow-500 px-1 rounded">Menipis</span>
                        @elseif ($barang['stok'] >= 5)
                            <span class="ml-1 text-xs bg-green-100 text-green-500 px-1 rounded">Tersedia</span>
                        @endif
                    </p>

                    <!-- TOMBOL MASUK / KELUAR -->
                    <div class="flex gap-3">
                        <button onclick="openModal('keluar', '{{ $barang['nama'] }}', '{{ $barang['kategori'] }}')"
                            title="Barang Keluar"
                            class="w-10 h-10 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600 transition text-xl font-bold">
                            −
                        </button>
                        <button onclick="openModal('masuk', '{{ $barang['nama'] }}', '{{ $barang['kategori'] }}')"
                            title="Barang Masuk"
                            class="w-10 h-10 bg-green-500 text-white rounded-lg flex items-center justify-center hover:bg-green-600 transition text-xl font-bold">
                            +
                        </button>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
@endsection


@push('modals')
    {{-- MODAL UTAMA: TAMBAH / MASUK / KELUAR --}}
    <div id="modalCatatBarang" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">

            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow-xl">

                <!-- Modal Header -->
                <div id="modalHeader" class="flex items-center justify-between p-4 md:p-5 rounded-t-2xl bg-orange-500">
                    <h3 id="modalTitle" class="text-lg font-semibold text-white">
                        Catat Barang
                    </h3>
                    <button type="button" onclick="closeModal()"
                        class="text-white/70 bg-transparent hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4 md:p-5 space-y-4">

                    {{-- SECTION: TAMBAH BARANG BARU --}}
                    <div id="sectionTambah" class="hidden space-y-4">

                        <!-- Upload Gambar -->
                        <div id="imageUploadArea" onclick="document.getElementById('imageInput').click()"
                            class="w-full h-36 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-orange-400 hover:bg-orange-50 transition relative overflow-hidden">
                            <img id="imagePreview" src="" alt=""
                                class="hidden absolute inset-0 w-full h-full object-cover rounded-xl">
                            <div id="imageUploadPlaceholder"
                                class="flex flex-col items-center gap-1 text-gray-400 transition">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <span class="text-sm font-medium">Upload Foto Barang</span>
                                <span class="text-xs text-gray-300">PNG, JPG hingga 2MB</span>
                            </div>
                            <input id="imageInput" type="file" accept="image/*" class="hidden"
                                onchange="previewImage(event)">
                        </div>

                        <!-- Kode & Nama Barang -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                                    Kode Barang
                                </label>
                                <input id="modalKodeBarang" type="text" placeholder="Contoh: BRG-001"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                                    Nama Barang
                                </label>
                                <input id="modalNamaBarangTambah" type="text" placeholder="Contoh: Kaos Polos"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Kategori
                            </label>
                            <select id="modalKategoriTambah"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5">
                                <option value="">— Pilih Kategori —</option>
                                <option value="Atasan">Atasan</option>
                                <option value="Bawahan">Bawahan</option>
                                <option value="Aksesoris">Aksesoris</option>
                            </select>
                        </div>

                    </div>

                    {{-- SECTION: BARANG MASUK / KELUAR --}}
                    <div id="sectionTransaksi" class="hidden space-y-4">

                        <!-- Baris 1: Nama Barang & Kategori -->
                        <div class="grid grid-cols-2 gap-3 -mt-3">
                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">Nama
                                    Barang</label>
                                <input id="modalNamaBarang" type="text" placeholder="Nama Barang" readonly
                                    class="bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" />
                            </div>
                            <div>
                                <label
                                    class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</label>
                                <select id="modalKategori" disabled
                                    class="bg-gray-100 border border-gray-200 text-gray-500 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Atasan">Atasan</option>
                                    <option value="Bawahan">Bawahan</option>
                                    <option value="Aksesoris">Aksesoris</option>
                                </select>
                            </div>
                        </div>

                        <!-- Baris 2: Jumlah & Tanggal -->
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label
                                    class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">Jumlah</label>
                                <input id="modalJumlah" type="number" placeholder="Jumlah" min="1"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" />
                            </div>
                            <div>
                                <label
                                    class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">Tanggal</label>
                                <input id="modalTanggal" type="date"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" />
                            </div>
                        </div>

                        <!-- Baris 3: Supplier (hanya Barang Masuk) -->
                        <div id="fieldSupplier" class="hidden">
                            <label class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Supplier
                            </label>

                            <!-- Wrapper relative hanya untuk button & dropdown -->
                            <div class="relative">
                                <button type="button" id="supplierBtn" onclick="toggleSupplierDropdown()"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 flex justify-between items-center hover:border-green-500 focus:outline-none focus:ring-1 focus:ring-green-500">
                                    <span id="supplierLabel" class="text-gray-400">Pilih Supplier</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <input type="hidden" id="modalSupplier" value="" />

                                <div id="supplierDropdown"
                                    class="hidden absolute w-full left-0 mt-1 border border-gray-200 rounded-lg shadow-lg bg-white z-20">
                                    <div class="p-2 border-b">
                                        <input type="text" id="supplierSearch" placeholder="Cari supplier..."
                                            oninput="filterSupplier()"
                                            class="w-full text-sm border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-1 focus:ring-green-500" />
                                    </div>
                                    <ul id="supplierList" class="max-h-40 overflow-y-auto text-sm text-gray-700">
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="Toko Grosir Batam" onclick="selectSupplier(this)">Toko Grosir
                                            Batam</li>
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="Distributor Fashion" onclick="selectSupplier(this)">Distributor
                                            Fashion</li>
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="PT Sneaker Indo Jaya" onclick="selectSupplier(this)">PT Sneaker
                                            Indo Jaya</li>
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="Reseller Partner" onclick="selectSupplier(this)">Reseller Partner
                                        </li>
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="Konveksi Lokal" onclick="selectSupplier(this)">Konveksi Lokal</li>
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="PT Fashion Nusantara" onclick="selectSupplier(this)">PT Fashion
                                            Nusantara</li>
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="Supplier Aksesoris Korea" onclick="selectSupplier(this)">Supplier
                                            Aksesoris Korea</li>
                                        <li class="supplier-item px-3 py-2 hover:bg-green-50 cursor-pointer"
                                            data-value="UD Mode Fashion" onclick="selectSupplier(this)">UD Mode Fashion
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <p id="supplierError" class="hidden mt-1 text-xs text-red-500">⚠ Supplier wajib dipilih.</p>
                        </div>

                        <!-- Baris 3: Tujuan (hanya Barang Keluar) -->
                        <div id="fieldTujuan" class="hidden">
                            <label
                                class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">Tujuan</label>
                            <input id="modalTujuan" type="text" placeholder="Tujuan (Contoh: Toko Cabang A)"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" />
                        </div>

                        <!-- Baris 4: Keterangan -->
                        <div>
                            <label
                                class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">Keterangan</label>
                            <textarea id="modalCatatan" rows="3" placeholder="Keterangan (opsional)"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"></textarea>
                        </div>

                    </div>


                    <!-- Error Alert (Flowbite Alert Component) -->
                    <div id="modalErrorAlert"
                        class="hidden flex items-center p-3 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span id="modalErrorText">Terjadi kesalahan.</span>
                    </div>


                    <!-- Footer Actions -->
                    <div class="flex items-center justify-end gap-3 pt-1">
                        <button onclick="closeModal()" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                            Batal
                        </button>
                        <button id="modalSimpan" onclick="handleSimpan()" type="button"
                            class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Simpan
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT BARANG --}}
    <div id="modalEditBarang" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">

            <!-- Modal content -->
            <div class="relative bg-white rounded-2xl shadow-xl">

                <!-- Modal Header -->
                <div class="flex items-center justify-between p-4 md:p-5 rounded-t-2xl bg-orange-500">
                    <h3 class="text-lg font-semibold text-white">
                        Edit Barang
                    </h3>
                    <button type="button" onclick="closeEditModal()"
                        class="text-white/70 bg-transparent hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Tutup modal</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-4 md:p-5 space-y-4">

                    <!-- Nama Barang -->
                    <div>
                        <label for="editNamaBarang"
                            class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                            Nama Barang
                        </label>
                        <input id="editNamaBarang" type="text" placeholder="Nama barang"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="editKategori"
                            class="block mb-1 text-xs font-medium text-gray-500 uppercase tracking-wide">
                            Kategori
                        </label>
                        <select id="editKategori"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5">
                            <option value="Atasan">Atasan</option>
                            <option value="Bawahan">Bawahan</option>
                            <option value="Aksesoris">Aksesoris</option>
                        </select>
                    </div>

                    <!-- Error Alert (Flowbite Alert Component) -->
                    <div id="editErrorAlert"
                        class="hidden flex items-center p-3 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                        <svg class="shrink-0 inline w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span id="editErrorText">Terjadi kesalahan.</span>
                    </div>

                    <!-- Footer Actions -->
                    <div class="flex items-center justify-end gap-3 pt-1">
                        <button onclick="closeEditModal()" type="button"
                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                            Batal
                        </button>
                        <button type="button" onclick="handleSimpanEdit()"
                            class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Simpan
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        // MENU AKSI (⋮)
        function toggleMenu(button) {
            const menu = button.nextElementSibling
            document.querySelectorAll('.menu-aksi').forEach(m => {
                if (m !== menu) m.classList.add('hidden')
            })
            menu.classList.toggle('hidden')
        }

        // Tutup menu aksi saat klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.menu-aksi') && !e.target.closest('button[onclick^="toggleMenu"]')) {
                document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'))
            }
        })

        let currentMode = 'tambah';

        const modalConfig = {
            tambah: {
                title: 'Tambah Barang Baru',
                headerBg: 'bg-orange-500',
                btnClass: 'text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center',
            },
            masuk: {
                title: 'Barang Masuk',
                headerBg: 'bg-green-600',
                btnClass: 'text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center',
            },
            keluar: {
                title: 'Barang Keluar',
                headerBg: 'bg-red-500',
                btnClass: 'text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center',
            },
        };

        // FIX: tambah parameter nama & kategori agar card bisa pre-fill data
        function openModal(mode, nama = '', kategori = '') {
            currentMode = mode;

            const config = modalConfig[mode];
            const modal = document.getElementById('modalCatatBarang');
            const header = document.getElementById('modalHeader');
            const title = document.getElementById('modalTitle');
            const simpanBtn = document.getElementById('modalSimpan');

            // Reset semua section & field kondisional
            document.getElementById('sectionTambah').classList.add('hidden');
            document.getElementById('sectionTransaksi').classList.add('hidden');
            document.getElementById('fieldSupplier').classList.add('hidden');
            document.getElementById('fieldTujuan').classList.add('hidden');
            document.getElementById('modalErrorAlert').classList.add('hidden');

            // Terapkan warna header & tombol sesuai mode
            header.className = `flex items-center justify-between p-4 md:p-5 rounded-t-2xl ${config.headerBg}`;
            simpanBtn.className = config.btnClass;
            title.textContent = config.title;

            if (mode === 'tambah') {
                document.getElementById('sectionTambah').classList.remove('hidden');
            } else {
                document.getElementById('sectionTransaksi').classList.remove('hidden');

                // FIX: pre-fill nama & kategori dari card
                document.getElementById('modalNamaBarang').value = nama;
                document.getElementById('modalKategori').value = kategori;

                if (mode === 'masuk') {
                    document.getElementById('fieldSupplier').classList.remove('hidden');
                } else {
                    document.getElementById('fieldTujuan').classList.remove('hidden');
                }
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('modalCatatBarang');
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            // Reset field
            document.getElementById('modalNamaBarang').value = '';
            document.getElementById('modalJumlah').value = '';
            document.getElementById('modalTujuan').value = '';
            document.getElementById('modalCatatan').value = '';
            document.getElementById('modalKategori').selectedIndex = 0;
            document.getElementById('modalSupplier').selectedIndex = 0;

            // closeModal() supplier
            document.getElementById('modalSupplier').value = '';
            document.getElementById('supplierLabel').textContent = 'Pilih Supplier';
            document.getElementById('supplierLabel').classList.add('text-gray-400');
            document.getElementById('supplierLabel').classList.remove('text-gray-900');
            document.getElementById('supplierDropdown').classList.add('hidden');
            document.getElementById('supplierSearch').value = '';
            document.getElementById('supplierError').classList.add('hidden');
            document.querySelectorAll('.supplier-item').forEach(i => i.style.display = '');
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                document.getElementById('imageUploadPlaceholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        function showError(message) {
            const alert = document.getElementById('modalErrorAlert');
            document.getElementById('modalErrorText').textContent = message;
            alert.classList.remove('hidden');
        }

        function handleSimpan() {
            document.getElementById('modalErrorAlert').classList.add('hidden');

            if (currentMode === 'tambah') {
                const kode = document.getElementById('modalKodeBarang').value.trim();
                const nama = document.getElementById('modalNamaBarangTambah').value.trim();
                if (!kode) return showError('Kode barang wajib diisi.');
                if (!nama) return showError('Nama barang wajib diisi.');
            } else {
                const nama = document.getElementById('modalNamaBarang').value.trim();
                const jumlah = document.getElementById('modalJumlah').value;
                if (!nama) return showError('Nama barang wajib diisi.');
                if (!jumlah || jumlah <= 0) return showError('Jumlah wajib diisi dan harus lebih dari 0.');

                // Validasi supplier hanya untuk mode masuk
                if (currentMode === 'masuk') {
                    const supplier = document.getElementById('modalSupplier').value;
                    if (!supplier) {
                        document.getElementById('supplierError').classList.remove('hidden');
                        return;
                    }
                }
            }

            // TODO: kirim data ke server
            closeModal();
        }

        document.getElementById('modalCatatBarang').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // FIX: hanya satu definisi openEditModal, referensi ID yang benar
        function openEditModal(nama = '', kategori = '') {
            document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'))

            const modal = document.getElementById('modalEditBarang');
            document.getElementById('editNamaBarang').value = nama;
            document.getElementById('editKategori').value = kategori;
            document.getElementById('editErrorAlert').classList.add('hidden'); // FIX: ID yang benar

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('modalEditBarang');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('editNamaBarang').value = '';
            document.getElementById('editKategori').selectedIndex = 0;
        }

        function handleSimpanEdit() {
            const nama = document.getElementById('editNamaBarang').value.trim();
            const errorAlert = document.getElementById('editErrorAlert');
            const errorText = document.getElementById('editErrorText');

            errorAlert.classList.add('hidden');

            if (!nama) {
                errorText.textContent = 'Nama barang wajib diisi.';
                errorAlert.classList.remove('hidden');
                return;
            }

            // TODO: kirim data ke server
            closeEditModal();
        }

        document.getElementById('modalEditBarang').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        // FIX: fungsi filterBarang yang hilang
        function filterBarang() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const filterStatus = document.getElementById('filterStatus').value;
            const filterKategori = document.getElementById('filterKategori').value;

            document.querySelectorAll('.card-barang').forEach(card => {
                const nama = card.dataset.nama.toLowerCase();
                const kategori = card.dataset.kategori;
                const stok = parseInt(card.dataset.stok);

                // Tentukan status berdasarkan stok
                let status = '';
                if (stok === 0) status = 'Habis';
                else if (stok <= 5) status = 'Menipis';
                else status = 'Tersedia';

                const matchSearch = nama.includes(search);
                const matchStatus = !filterStatus || status === filterStatus;
                const matchKategori = !filterKategori || kategori === filterKategori;

                card.style.display = (matchSearch && matchStatus && matchKategori) ? '' : 'none';
            });
        }

        document.getElementById('searchInput').addEventListener('input', filterBarang)
        document.getElementById('filterStatus').addEventListener('change', filterBarang)
        document.getElementById('filterKategori').addEventListener('change', filterBarang)

        // SUPPLIER DROPDOWN
        function toggleSupplierDropdown() {
            const dropdown = document.getElementById('supplierDropdown');
            dropdown.classList.toggle('hidden');
            if (!dropdown.classList.contains('hidden')) {
                document.getElementById('supplierSearch').focus();
            }
        }

        function selectSupplier(el) {
            document.getElementById('modalSupplier').value = el.dataset.value;
            document.getElementById('supplierLabel').textContent = el.dataset.value;
            document.getElementById('supplierLabel').classList.remove('text-gray-400');
            document.getElementById('supplierLabel').classList.add('text-gray-900');
            document.getElementById('supplierDropdown').classList.add('hidden');
            document.getElementById('supplierError').classList.add('hidden');
        }

        function filterSupplier() {
            const keyword = document.getElementById('supplierSearch').value.toLowerCase();
            document.querySelectorAll('.supplier-item').forEach(item => {
                item.style.display = item.dataset.value.toLowerCase().includes(keyword) ? '' : 'none';
            });
        }

        // Tutup dropdown supplier saat klik di luar
        document.addEventListener('click', function(e) {
            const btn = document.getElementById('supplierBtn');
            const dropdown = document.getElementById('supplierDropdown');
            if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
@endpush
