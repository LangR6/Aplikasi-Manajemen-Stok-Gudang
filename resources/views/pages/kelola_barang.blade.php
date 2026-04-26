@extends('layouts.app')

@section('title', 'Kelola Barang')

@section('content')
    <div class="space-y-3">

        {{-- ── TOOLBAR ── --}}
        <div class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="srchInput" placeholder="Cari barang..." oninput="onSearch()"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
            </div>

            {{-- Filter Status --}}
            <select id="filterStatus" onchange="onFilter()"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                   rounded-lg focus:ring-orange-500 focus:border-orange-500 pr-9 p-2.5 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="Tersedia">Tersedia</option>
                <option value="Menipis">Menipis</option>
                <option value="Habis">Habis</option>
            </select>

            {{-- Filter Kategori --}}
            <select id="filterKategori" onchange="onFilter()"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                   rounded-lg focus:ring-orange-500 focus:border-orange-500 pr-9 p-2.5 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach ($kategori as $kat)
                    <option value="{{ $kat }}">{{ $kat }}</option>
                @endforeach
            </select>

            {{-- Tombol Tambah --}}
            @if (session('role') === 'admin')
                <button type="button" onclick="openModal('tambah')"
                    class="flex items-center gap-2 bg-[#F66B0E] hover:bg-orange-600 active:scale-[.98]
                   text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-all whitespace-nowrap">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                    Tambah Barang
                </button>
            @endif
        </div>

        {{-- ── GRID CARDS ── --}}
        <div id="gridBarang" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
        </div>

        {{-- ── EMPTY STATE ── --}}
        <div id="emptyState" class="hidden py-12 text-center border border-gray-300 rounded-xl">
            <div
                class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200
                    flex items-center justify-center mx-auto mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor"
                        stroke-width="1.8" />
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-700 mb-1">Tidak ada barang ditemukan</p>
            <p class="text-sm text-gray-400 mb-4">Coba ubah kata kunci atau filter</p>
            <button onclick="resetFilter()"
                class="inline-flex items-center gap-1.5 bg-[#F66B0E] hover:bg-orange-600
                   text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Tampilkan Semua
            </button>
        </div>

        {{-- ── PAGINATION FOOTER ── --}}
        <div class="px-1 py-2 flex flex-wrap items-center justify-between gap-2">
            <span id="tblInfo" class="text-sm text-gray-400"></span>
            <div id="pgnWrap" class="flex items-center gap-1"></div>
        </div>

    </div>
@endsection


@push('modals')

    {{-- MODAL TAMBAH BARANG / BARANG MASUK / BARANG KELUAR --}}
    <div id="modalCatatBarang" class="modal-overlay hidden fixed inset-0 z-50 items-start justify-center pt-20 px-4">
        <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
        <div
            class="modal-box relative bg-white rounded-2xl w-full max-w-md
                transform scale-95 opacity-0 transition-all duration-200 origin-top">

            {{-- Header (warna berubah sesuai mode) --}}
            <div id="mhdr" class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
                <div class="flex items-center gap-2.5">
                    <h3 id="mhdrTitle" class="text-[16px] font-semibold text-white">Tambah Barang</h3>
                </div>
                <button onclick="closeOverlay('modalCatatBarang')"
                    class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center
                       text-white hover:bg-white/30 transition">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <div class="px-5 py-5 space-y-4">

                {{-- ══ SECTION: TAMBAH BARANG BARU ══ --}}
                <div id="sectionTambah" class="hidden space-y-4">

                    {{-- Upload Foto --}}
                    <div id="imageUploadArea" onclick="document.getElementById('imageInput').click()"
                        class="w-full h-32 border-2 border-dashed border-gray-300 rounded-xl
                           flex flex-col items-center justify-center cursor-pointer
                           hover:border-orange-400 hover:bg-orange-50 transition relative overflow-hidden">
                        <img id="imagePreview" src="" alt=""
                            class="hidden absolute inset-0 w-full h-full object-cover rounded-xl">
                        <div id="imageUploadPlaceholder" class="flex flex-col items-center gap-1 text-gray-400">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5"
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

                    {{-- Kode & Nama --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Kode
                                Barang</label>
                            <input id="tKode" type="text" placeholder="Contoh: BRG-001"
                                oninput="clearErr('errTKode','tKode')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            <x-input-error id="errTKode" message="Kode barang wajib diisi." />
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Nama
                                Barang</label>
                            <input id="tNama" type="text" placeholder="Contoh: Kaos Polos"
                                oninput="clearErr('errTNama','tNama')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            <x-input-error id="errTNama" message="Nama barang wajib diisi." />
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label
                            class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Kategori</label>
                        <select id="tKategori" onchange="clearErr('errTKategori','tKategori')"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                               rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5">
                            <option value="">— Pilih Kategori —</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                        <x-input-error id="errTKategori" message="Kategori wajib dipilih." />
                    </div>
                </div>

                {{-- ══ SECTION: BARANG MASUK / KELUAR ══ --}}
                <div id="sectionTransaksi" class="hidden space-y-4">

                    {{-- Nama & Kategori (readonly) --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Nama
                                Barang</label>
                            <input id="trNama" type="text" readonly
                                class="bg-gray-100 border border-gray-200 text-gray-500 text-sm
                                   rounded-lg block w-full p-2.5 cursor-not-allowed" />
                        </div>
                        <div>
                            <label
                                class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Kategori</label>
                            <select id="trKategori" disabled
                                class="bg-gray-100 border border-gray-200 text-gray-500 text-sm
                                   rounded-lg block w-full p-2.5 cursor-not-allowed">
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Jumlah & Tanggal --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label
                                class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Jumlah</label>
                            <input id="trJumlah" type="number" placeholder="Jumlah" min="1"
                                oninput="clearErr('errTrJumlah','trJumlah')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            <x-input-error id="errTrJumlah" message="Jumlah wajib diisi (&gt; 0)." />
                        </div>
                        <div>
                            <label
                                class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Tanggal</label>
                            <input id="trTanggal" type="date" onchange="clearErr('errTrTanggal','trTanggal')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            <x-input-error id="errTrTanggal" message="Tanggal wajib diisi." />
                        </div>
                    </div>

                    {{-- Supplier (hanya mode Masuk) --}}
                    <div id="fieldSupplier" class="hidden">
                        <label
                            class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Supplier</label>
                        <div class="relative">
                            <button type="button" id="supplierBtn" onclick="toggleSupplierDropdown()"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                   w-full p-2.5 flex justify-between items-center
                                   hover:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                <span id="supplierLabel" class="text-gray-400">Pilih Supplier</span>
                                <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <input type="hidden" id="trSupplier" value="">
                            <div id="supplierDropdown"
                                class="hidden absolute w-full left-0 mt-1 border border-gray-200
                                   rounded-lg shadow-lg bg-white z-20">
                                <div class="p-2 border-b">
                                    <input type="text" id="supplierSearch" placeholder="Cari supplier..."
                                        oninput="filterSupplier()"
                                        class="w-full text-sm border border-gray-300 rounded-lg p-2
                                           focus:outline-none focus:ring-1 focus:ring-orange-500" />
                                </div>
                                <ul id="supplierList" class="max-h-40 overflow-y-auto text-sm text-gray-700">
                                    @foreach ($supplier as $sup)
                                        <li class="supplier-item px-3 py-2 hover:bg-orange-50 cursor-pointer"
                                            data-value="{{ $sup }}" onclick="selectSupplier(this)">
                                            {{ $sup }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <x-input-error id="errTrSupplier" message="Supplier wajib dipilih." />
                    </div>

                    {{-- Tujuan (hanya mode Keluar) --}}
                    <div id="fieldTujuan" class="hidden">
                        <label
                            class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Tujuan</label>
                        <input id="trTujuan" type="text" placeholder="Contoh: Toko Cabang A"
                            oninput="clearErr('errTrTujuan','trTujuan')"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                        <x-input-error id="errTrTujuan" message="Tujuan wajib diisi." />
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label
                            class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Keterangan</label>
                        <textarea id="trCatatan" rows="2" placeholder="Keterangan (opsional)"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5"></textarea>
                    </div>
                </div>

            </div>

            <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
                <button onclick="closeOverlay('modalCatatBarang')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200
                       rounded-lg hover:bg-gray-50 active:scale-[.98] transition-all">
                    Batal
                </button>
                <button id="btnSimpan" type="button" onclick="handleSimpan()"
                    class="px-4 py-2 text-sm font-medium text-white bg-[#F66B0E] hover:bg-orange-600
                       rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                    Simpan
                </button>
            </div>
        </div>
    </div>


    {{-- MODAL EDIT BARANG --}}
    @if (session('role') === 'admin')
        <div id="modalEditBarang" class="modal-overlay hidden fixed inset-0 z-50 items-start justify-center pt-20 px-4">
            <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
            <div
                class="modal-box relative bg-white rounded-2xl w-full max-w-md
                transform scale-95 opacity-0 transition-all duration-200 origin-top">

                {{-- Header orange — ikon pensil, judul "Edit Barang" --}}
                <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
                    <div class="flex items-center gap-2.5">
                        <h3 class="text-[16px] font-semibold text-white">Edit Barang</h3>
                    </div>
                    <button onclick="closeOverlay('modalEditBarang')"
                        class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center
                       text-white hover:bg-white/30 transition">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <div class="px-5 py-5 space-y-4">

                    {{-- Upload Foto --}}
                    <div id="eImageUploadArea" onclick="document.getElementById('eImageInput').click()"
                        class="w-full h-32 border-2 border-dashed border-gray-300 rounded-xl
                       flex flex-col items-center justify-center cursor-pointer
                       hover:border-orange-400 hover:bg-orange-50 transition relative overflow-hidden">
                        <img id="eImagePreview" src="" alt=""
                            class="hidden absolute inset-0 w-full h-full object-cover rounded-xl">
                        <div id="eImageUploadPlaceholder" class="flex flex-col items-center gap-1 text-gray-400">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                            </svg>
                            <span class="text-sm font-medium">Upload Foto Barang</span>
                            <span class="text-xs text-gray-300">PNG, JPG hingga 2MB</span>
                        </div>
                        <input id="eImageInput" type="file" accept="image/*" class="hidden"
                            onchange="previewImageEdit(event)">
                    </div>

                    {{-- Kode & Nama --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Kode
                                Barang</label>
                            <input id="eKode" type="text" placeholder="Contoh: BRG-001"
                                oninput="clearErr('errEKode','eKode')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            <x-input-error id="errEKode" message="Kode barang wajib diisi." />
                        </div>
                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Nama
                                Barang</label>
                            <input id="eNama" type="text" placeholder="Contoh: Kaos Polos"
                                oninput="clearErr('errENama','eNama')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                            <x-input-error id="errENama" message="Nama barang wajib diisi." />
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label
                            class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Kategori</label>
                        <select id="eKategori" onchange="clearErr('errEKategori','eKategori')"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5">
                            <option value="">— Pilih Kategori —</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                        <x-input-error id="errEKategori" message="Kategori wajib dipilih." />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
                    <button onclick="closeOverlay('modalEditBarang')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200
                       rounded-lg hover:bg-gray-50 active:scale-[.98] transition-all">
                        Batal
                    </button>
                    <button type="button" onclick="handleSimpanEdit()"
                        class="px-4 py-2 text-sm font-medium text-white bg-[#F66B0E] hover:bg-orange-600
                       rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL HAPUS BARANG --}}
    <div id="modalHapus" class="modal-overlay hidden fixed inset-0 z-50 items-center justify-center p-4">
        <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
        <div
            class="modal-box relative bg-white rounded-2xl w-full max-w-md
                transform scale-95 opacity-0 transition-all duration-200 origin-top">

            <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-red-600">
                <div class="flex items-center gap-2.5">
                    <div class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2" />
                            <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" stroke="currentColor"
                                stroke-width="2" />
                            <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white">Konfirmasi Hapus</h3>
                </div>
                <button onclick="closeOverlay('modalHapus')"
                    class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center
                       text-white hover:bg-white/30 transition">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <div class="px-5 py-6 text-center">
                <div
                    class="w-11 h-11 rounded-full bg-red-50 border border-red-200
                        flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24">
                        <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                            stroke="currentColor" stroke-width="1.8" />
                        <line x1="12" y1="9" x2="12" y2="13" stroke="currentColor"
                            stroke-width="1.8" />
                        <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor"
                            stroke-width="1.8" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-800 mb-1.5">
                    Hapus barang "<span id="hapusNama" class="text-red-600">—</span>"?
                </p>
                <p class="text-sm font-medium text-red-500 leading-relaxed">Data akan hilang setelah dihapus.</p>
            </div>

            <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
                <button onclick="closeOverlay('modalHapus')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200
                       rounded-lg hover:bg-gray-50 active:scale-[.98] transition-all">
                    Batal
                </button>
                <button type="button" onclick="konfirmasiHapus()"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700
                       rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                    Hapus
                </button>
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

        /* ── Card ── */
        .card-barang {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            transition: box-shadow .2s, transform .2s;
            position: relative;
            overflow: visible;
            padding-left: 16px;
            padding-right: 16px;
            padding-top: 16px;
            padding-bottom: 8px;
        }

        .card-barang:hover {
            box-shadow: 0 8px 24px rgba(17, 43, 60, .12);
            transform: translateY(-2px);
        }

        /* Gambar area — kotak penuh lebar, sudut atas rounded */
        .card-img-wrap {
            width: 100%;
            aspect-ratio: 1 / 1;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Info area */
        .card-info {
            padding: 10px 12px 12px;
        }

        /* Stok & badge */
        .stok-green {
            color: #16a34a;
            font-weight: 700;
        }

        .stok-yellow {
            color: #d97706;
            font-weight: 700;
        }

        .stok-red {
            color: #dc2626;
            font-weight: 700;
        }

        .badge {
            display: inline-block;
            font-size: .68rem;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 999px;
        }

        .badge-green {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-yellow {
            background: #fef9c3;
            color: #92400e;
        }

        .badge-red {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Menu aksi (⋮) --*/
        .menu-aksi-wrap {
            position: absolute;
            top: 8px;
            right: 8px;
            z-index: 10;
        }

        .menu-aksi-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 16px;
            line-height: 1;
            color: #6b7280;
            transition: background .15s;
            backdrop-filter: blur(4px);
        }

        .menu-aksi-btn:hover {
            background: #fff;
            color: #374151;
        }

        .menu-aksi {
            position: absolute;
            right: 0;
            top: 32px;
            width: 112px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .12);
            border: 1px solid #e5e7eb;
            padding: 4px 0;
            z-index: 20;
        }

        /* Input error state */
        .input-error {
            border-color: #fca5a5 !important;
            background-color: #fff5f5 !important;
        }
    </style>
@endpush


@push('scripts')
    <script>
        //  DATA
        const allBarang = @json($data);
        const isAdmin = {{ session('role') === 'admin' ? 'true' : 'false' }};

        const PER_PAGE = 25;
        let curPage = 1,
            curKw = '',
            curStat = '',
            curKat = '';

        //  HELPERS STATUS
        function getStatus(stok) {
            return stok === 0 ? 'Habis' : stok <= 5 ? 'Menipis' : 'Tersedia';
        }

        function getFiltered() {
            return allBarang.filter(b =>
                (!curKw || b.nama.toLowerCase().includes(curKw)) &&
                (!curStat || getStatus(b.stok) === curStat) &&
                (!curKat || b.kategori === curKat)
            );
        }

        //  RENDER CARDS
        function renderCards() {
            const filtered = getFiltered();
            const total = filtered.length;
            const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
            if (curPage > totalPages) curPage = totalPages;

            const paged = filtered.slice((curPage - 1) * PER_PAGE, curPage * PER_PAGE);
            const grid = document.getElementById('gridBarang');
            const empty = document.getElementById('emptyState');

            if (!total) {
                grid.innerHTML = '';
                empty.classList.remove('hidden');
                document.getElementById('tblInfo').textContent = 'Tidak ada data';
                document.getElementById('pgnWrap').innerHTML = '';
                return;
            }

            empty.classList.add('hidden');
            grid.innerHTML = paged.map(buildCard).join('');

            const s = (curPage - 1) * PER_PAGE + 1;
            const e = Math.min(curPage * PER_PAGE, total);
            document.getElementById('tblInfo').textContent = `Menampilkan ${s}–${e} dari ${total} barang`;
            renderPagination(totalPages);
        }

        function buildCard(b) {
            const status = getStatus(b.stok);
            const stokCls = b.stok === 0 ? 'stok-red' : b.stok <= 5 ? 'stok-yellow' : 'stok-green';
            const bdgCls = b.stok === 0 ? 'badge-red' : b.stok <= 5 ? 'badge-yellow' : 'badge-green';

            // Escape nama & kategori untuk atribut onclick
            const safeName = b.nama.replace(/'/g, "\\'");
            const safeKat = b.kategori.replace(/'/g, "\\'");
            const safeKode = (b.kode || '').replace(/'/g, "\\'");

            const menuHtml = isAdmin ? `
        <div class="menu-aksi-wrap">
            <button class="menu-aksi-btn" onclick="toggleMenu(this)">⋮</button>
            <div class="menu-aksi hidden">
                <button onclick="openEditModal('${safeKode}','${safeName}','${safeKat}')"
                    class="w-full text-left px-3 py-2 hover:bg-gray-50 text-sm text-gray-700">✏️ Edit</button>
                <button onclick="openHapusModal('${safeName}')"
                    class="w-full text-left px-3 py-2 hover:bg-red-50 text-sm text-red-500">🗑 Hapus</button>
            </div>
        </div>` : '';

            const btnHtml = isAdmin ? `
        <div class="flex gap-2 mt-2">
            <button onclick="openModal('keluar','${safeName}','${safeKat}')" title="Barang Keluar"
                class="flex-1 h-9 w-9 bg-red-500 text-white rounded-lg flex items-center justify-center
                       hover:bg-red-600 transition text-lg font-bold leading-none">−</button>
            <button onclick="openModal('masuk','${safeName}','${safeKat}')" title="Barang Masuk"
                class="flex-1 h-9 w-9 bg-green-500 text-white rounded-lg flex items-center justify-center
                       hover:bg-green-600 transition text-lg font-bold leading-none">+</button>
        </div>` : '';

            // Foto barang
            const imgSrc = b.foto ?
                `/storage/${b.foto}` :
                `{{ asset('images/logo1.png') }}`;
            const imgStyle = b.foto ? '' : 'width:56px;opacity:.75;object-fit:contain;';

            return `
    <div class="card-barang">
        ${menuHtml}
        <div class="card-img-wrap">
            <img src="${imgSrc}" alt="${b.nama}" style="${imgStyle}">
        </div>
        <div class="card-info">
            <h3 class="font-semibold text-sm text-[#112B3C] leading-tight mb-0.5 truncate" title="${b.nama}">${b.nama}</h3>
            <p class="text-xs text-gray-400 mb-2">${b.kode ? b.kode + ' · ' : ''}${b.kategori}</p>
            <div class="flex items-center justify-between">
                <span class="text-sm ${stokCls}">Stok: ${b.stok}</span>
                <span class="badge ${bdgCls}">${status}</span>
            </div>
            ${btnHtml}
        </div>
    </div>`;
        }

        //  PAGINATION
        function renderPagination(totalPages) {
            const wrap = document.getElementById('pgnWrap');
            if (totalPages <= 1) {
                wrap.innerHTML = '';
                return;
            }

            const n =
                'w-7 h-7 rounded-md border border-gray-200 text-sm font-medium flex items-center justify-center cursor-pointer text-gray-600 hover:bg-gray-100 transition-all ';
            const a =
                'w-7 h-7 rounded-md border border-[#F66B0E] bg-[#F66B0E] text-white text-sm font-medium flex items-center justify-center ';
            const d =
                'w-7 h-7 rounded-md border border-gray-100 text-sm font-medium flex items-center justify-center text-gray-300 cursor-not-allowed ';

            let html = curPage === 1 ?
                `<button class="${d}" disabled>‹</button>` :
                `<button class="${n}" onclick="goPage(${curPage - 1})">‹</button>`;

            const rs = Math.max(1, curPage - 2),
                re = Math.min(totalPages, curPage + 2);
            if (rs > 1) {
                html += `<button class="${n}" onclick="goPage(1)">1</button>`;
                if (rs > 2) html += `<span class="text-sm text-gray-400 px-0.5">…</span>`;
            }
            for (let p = rs; p <= re; p++)
                html += `<button class="${p === curPage ? a : n}" onclick="goPage(${p})">${p}</button>`;
            if (re < totalPages) {
                if (re < totalPages - 1) html += `<span class="text-sm text-gray-400 px-0.5">…</span>`;
                html += `<button class="${n}" onclick="goPage(${totalPages})">${totalPages}</button>`;
            }

            html += curPage === totalPages ?
                `<button class="${d}" disabled>›</button>` :
                `<button class="${n}" onclick="goPage(${curPage + 1})">›</button>`;

            wrap.innerHTML = html;
        }

        function goPage(p) {
            const tp = Math.max(1, Math.ceil(getFiltered().length / PER_PAGE));
            if (p < 1 || p > tp) return;
            curPage = p;
            renderCards();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function onSearch() {
            curKw = document.getElementById('srchInput').value.toLowerCase().trim();
            curPage = 1;
            renderCards();
        }

        function onFilter() {
            curStat = document.getElementById('filterStatus').value;
            curKat = document.getElementById('filterKategori').value;
            curPage = 1;
            renderCards();
        }

        function resetFilter() {
            document.getElementById('srchInput').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterKategori').value = '';
            curKw = '';
            curStat = '';
            curKat = '';
            curPage = 1;
            renderCards();
        }

        renderCards();

        //  MENU AKSI (⋮)
        function toggleMenu(btn) {
            const menu = btn.nextElementSibling;
            document.querySelectorAll('.menu-aksi').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        }

        //  MODAL OPEN / CLOSE
        function openOverlay(id) {
            const ov = document.getElementById(id);
            ov.classList.remove('hidden');
            ov.classList.add('flex');
            void ov.offsetWidth;
            ov.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeOverlay(id) {
            const ov = document.getElementById(id);
            ov.classList.remove('is-open');

            setTimeout(() => {
                ov.classList.remove('flex');
                ov.classList.add('hidden');

                const anyOpen = ['modalCatatBarang', 'modalEditBarang', 'modalHapus']
                    .some(i => {
                        const el = document.getElementById(i);
                        return el && !el.classList.contains('hidden'); // ← cek hidden, bukan is-open
                    });

                if (!anyOpen) document.body.style.overflow = '';
            }, 200);
        }

        document.querySelectorAll('.modal-overlay').forEach(ov => {
            const backdrop = ov.querySelector('.modal-backdrop');
            if (backdrop) backdrop.addEventListener('click', () => closeOverlay(ov.id));
        });

        //  MODAL TAMBAH / MASUK / KELUAR
        let currentMode = 'tambah';

        const modeConfig = {
            tambah: {
                title: 'Tambah Barang Baru',
                bg: '#F66B0E',
            },
            masuk: {
                title: 'Barang Masuk',
                bg: '#16a34a',
            },
            keluar: {
                title: 'Barang Keluar',
                bg: '#dc2626',
            },
        };

        function openModal(mode, nama = '', kategori = '') {
            currentMode = mode;
            const cfg = modeConfig[mode];

            document.getElementById('mhdr').style.background = cfg.bg;
            document.getElementById('btnSimpan').style.background = cfg.bg;
            document.getElementById('mhdrTitle').textContent = cfg.title;

            ['sectionTambah', 'sectionTransaksi', 'fieldSupplier', 'fieldTujuan']
            .forEach(id => document.getElementById(id).classList.add('hidden'));
            clearAllErrors();

            if (mode === 'tambah') {
                document.getElementById('sectionTambah').classList.remove('hidden');
                document.getElementById('tKode').value = '';
                document.getElementById('tNama').value = '';
                document.getElementById('tKategori').value = '';
                document.getElementById('imagePreview').classList.add('hidden');
                document.getElementById('imageUploadPlaceholder').classList.remove('hidden');
            } else {
                document.getElementById('sectionTransaksi').classList.remove('hidden');
                document.getElementById('trNama').value = nama;
                document.getElementById('trKategori').value = kategori;
                document.getElementById('trJumlah').value = '';
                document.getElementById('trTanggal').value = '';
                document.getElementById('trCatatan').value = '';
                if (mode === 'masuk') {
                    document.getElementById('fieldSupplier').classList.remove('hidden');
                    resetSupplier();
                } else {
                    document.getElementById('fieldTujuan').classList.remove('hidden');
                    document.getElementById('trTujuan').value = '';
                }
            }

            openOverlay('modalCatatBarang');
        }

        function handleSimpan() {
            clearAllErrors();
            let valid = true;

            if (currentMode === 'tambah') {
                if (!document.getElementById('tKode').value.trim()) {
                    showErr('errTKode', 'tKode');
                    valid = false;
                }
                if (!document.getElementById('tNama').value.trim()) {
                    showErr('errTNama', 'tNama');
                    valid = false;
                }
                if (!document.getElementById('tKategori').value) {
                    showErr('errTKategori', 'tKategori');
                    valid = false;
                }
            } else {
                const jumlah = document.getElementById('trJumlah').value;
                if (!jumlah || Number(jumlah) <= 0) {
                    showErr('errTrJumlah', 'trJumlah');
                    valid = false;
                }
                if (!document.getElementById('trTanggal').value) {
                    showErr('errTrTanggal', 'trTanggal');
                    valid = false;
                }
                if (currentMode === 'masuk' && !document.getElementById('trSupplier').value) {
                    showErr('errTrSupplier');
                    valid = false;
                }
                if (currentMode === 'keluar' && !document.getElementById('trTujuan').value.trim()) {
                    showErr('errTrTujuan', 'trTujuan');
                    valid = false;
                }
            }

            if (!valid) return;
            closeOverlay('modalCatatBarang');
            // TODO: kirim ke backend
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const prev = document.getElementById('imagePreview');
                prev.src = e.target.result;
                prev.classList.remove('hidden');
                document.getElementById('imageUploadPlaceholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        //  MODAL EDIT
        function openEditModal(kode, nama, kategori) {
            document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'));

            document.getElementById('eKode').value = kode;
            document.getElementById('eNama').value = nama;
            document.getElementById('eKategori').value = kategori;

            // Reset foto preview
            document.getElementById('eImagePreview').classList.add('hidden');
            document.getElementById('eImageUploadPlaceholder').classList.remove('hidden');

            // Clear errors
            ['errEKode', 'errENama', 'errEKategori'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('hidden');
            });
            ['eKode', 'eNama', 'eKategori'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('input-error');
            });

            openOverlay('modalEditBarang');
        }

        function handleSimpanEdit() {
            let valid = true;
            if (!document.getElementById('eKode').value.trim()) {
                showErr('errEKode', 'eKode');
                valid = false;
            }
            if (!document.getElementById('eNama').value.trim()) {
                showErr('errENama', 'eNama');
                valid = false;
            }
            if (!document.getElementById('eKategori').value) {
                showErr('errEKategori', 'eKategori');
                valid = false;
            }
            if (!valid) return;
            closeOverlay('modalEditBarang');
            // TODO: kirim ke backend
        }

        function previewImageEdit(event) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const prev = document.getElementById('eImagePreview');
                prev.src = e.target.result;
                prev.classList.remove('hidden');
                document.getElementById('eImageUploadPlaceholder').classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        // SUPPLIER DROPDOWN
        function toggleSupplierDropdown() {
            const dd = document.getElementById('supplierDropdown');
            dd.classList.toggle('hidden');
            if (!dd.classList.contains('hidden')) document.getElementById('supplierSearch').focus();
        }

        function selectSupplier(el) {
            document.getElementById('trSupplier').value = el.dataset.value;
            document.getElementById('supplierLabel').textContent = el.dataset.value;
            document.getElementById('supplierLabel').classList.replace('text-gray-400', 'text-gray-900');
            document.getElementById('supplierDropdown').classList.add('hidden');
            document.getElementById('errTrSupplier').classList.add('hidden');
        }

        function filterSupplier() {
            const kw = document.getElementById('supplierSearch').value.toLowerCase();
            document.querySelectorAll('.supplier-item').forEach(item =>
                item.style.display = item.dataset.value.toLowerCase().includes(kw) ? '' : 'none');
        }

        function resetSupplier() {
            document.getElementById('trSupplier').value = '';
            document.getElementById('supplierLabel').textContent = 'Pilih Supplier';
            document.getElementById('supplierLabel').classList.replace('text-gray-900', 'text-gray-400');
            document.getElementById('supplierDropdown').classList.add('hidden');
            document.getElementById('supplierSearch').value = '';
            document.querySelectorAll('.supplier-item').forEach(i => i.style.display = '');
        }
        document.addEventListener('click', e => {
            if (!e.target.closest('.menu-aksi') && !e.target.classList.contains('menu-aksi-btn'))
                document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'));

            const btn = document.getElementById('supplierBtn');
            const dd = document.getElementById('supplierDropdown');
            if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target))
                dd.classList.add('hidden');
        });

        // ERROR HELPERS
        function showErr(errId, inputId) {
            const err = document.getElementById(errId);

            err.classList.remove('hidden');
            err.classList.add('flex');

            if (inputId) document.getElementById(inputId).classList.add('input-error');
        }

        function clearErr(errId, inputId) {
            const err = document.getElementById(errId);

            err.classList.remove('flex');
            err.classList.add('hidden');

            if (inputId) document.getElementById(inputId).classList.remove('input-error');
        }

        function clearAllErrors() {
            [
                'errTKode', 'errTNama', 'errTKategori',
                'errTrJumlah', 'errTrTanggal', 'errTrSupplier', 'errTrTujuan',
                'errENama', 'errEKategori', 'errEKode'
            ].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.classList.remove('flex');
                    el.classList.add('hidden');
                }
            });

            [
                'tKode', 'tNama', 'tKategori', 'trJumlah', 'trTanggal', 'trTujuan',
                'eKode', 'eNama', 'eKategori'
            ].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('input-error');
            });
        }

        //  MODAL HAPUS
        let hapusNamaTarget = '';

        function openHapusModal(nama) {
            document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'));
            hapusNamaTarget = nama; // ← simpan target
            document.getElementById('hapusNama').textContent = nama;
            openOverlay('modalHapus');
        }

        function konfirmasiHapus() {
            const idx = allBarang.findIndex(b => b.nama === hapusNamaTarget);
            if (idx !== -1) allBarang.splice(idx, 1);
            closeOverlay('modalHapus');
            renderCards();
            // TODO: kirim ke backend
        }
    </script>
@endpush
