@extends('layouts.app')

@section('title', 'Kelola Supplier')

@section('content')
<div class="space-y-3">

    {{-- TOOLBAR --}}
    <div class="flex flex-wrap items-center gap-3">

        {{-- SEARCH --}}
        <div class="relative w-full sm:flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input id="srchInput" type="text" oninput="onSearch()" placeholder="Cari supplier..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                   focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
        </div>

        {{-- TAMBAH --}}
        @if (session('role') === 'admin')
        <button type="button" onclick="openSupplierModal()"
            class="flex items-center justify-center gap-2 bg-[#F66B0E] hover:bg-orange-600
                   active:scale-[.98] text-white text-sm font-medium px-6 py-2.5
                   rounded-lg transition-all whitespace-nowrap w-full sm:w-auto">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-width="2.2" d="M9 1v16M1 9h16" />
            </svg>
            Tambah Supplier
        </button>
        @endif
    </div>

    {{-- TABLE --}}
    <div class="border border-gray-300 rounded-xl overflow-hidden">

        {{-- Desktop table --}}
        <div class="overflow-x-auto" id="desktopTable">
            <table class="w-full text-left table-fixed min-w-225">
                <colgroup>
                    <col class="w-16">
                    <col class="w-[24%]">
                    <col class="w-[18%]">
                    <col class="w-[28%]">
                    <col class="w-[14%]">
                    @if (session('role') === 'admin')
                    <col class="w-[16%]">
                    @endif
                </colgroup>
                <thead class="bg-[#205375] border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wide">No
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">Nama Supplier
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">Kontak</th>
                        <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">Email</th>
                        <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">Kota</th>
                        @if (session('role') === 'admin')
                        <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wide">
                            Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody id="tbody">
                    @forelse($suppliers as $supplier)
                    <tr class="tbl-row border-b border-gray-100 {{ $loop->even ? '' : 'bg-gray-50/60' }}"
                        data-name="{{ strtolower($supplier['nama_supplier'] . ' ' . $supplier['kontak'] . ' ' . $supplier['email'] . ' ' . $supplier['kota']) }}">
                        <td class="row-num px-4 py-3 text-center text-sm text-gray-800 font-medium">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $supplier['nama_supplier'] }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $supplier['kontak'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 wrap-break-words">{{ $supplier['email'] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $supplier['kota'] }}</td>
                        @if (session('role') === 'admin')
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" data-supplier='@json($supplier)'
                                    onclick="openSupplierModal('edit', JSON.parse(this.dataset.supplier))"
                                    class="px-3 py-1 rounded-md text-sm font-medium border border-orange-200
                                               text-orange-800 bg-orange-100 hover:bg-orange-500 hover:text-white
                                               active:scale-[.98] hover:-translate-y-px transition-all">Edit</button>
                                <button type="button" data-nama="{{ $supplier['nama_supplier'] }}"
                                    onclick="openModal('modalHapusSupplier'); setModalHapusSupplier(this.dataset.nama)"
                                    class="px-3 py-1 rounded-md text-sm font-medium border border-red-200
                                               text-red-800 bg-red-100 hover:bg-red-600 hover:text-white
                                               active:scale-[.98] hover:-translate-y-px transition-all">Hapus</button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    @endforelse

                    {{-- Data kosong disearch --}}
                    <tr id="emptySearchRow" class="hidden">
                        <td colspan="{{ session('role') === 'admin' ? 6 : 5 }}" class="px-4 py-0">
                            <div class="flex min-h-[260px] flex-col items-center justify-center text-center">
                                <div class="mb-4 flex h-[60px] w-[60px] items-center justify-center rounded-full border border-gray-200 bg-gray-50">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                                    </svg>
                                </div>

                                <p class="text-sm font-medium text-gray-700 mb-1">
                                    Tidak ada supplier ditemukan
                                </p>
                                <p class="text-sm text-gray-400 mb-4">
                                    Coba ubah kata kunci atau filter
                                </p>

                                <button type="button" onclick="resetSupplierSearch()"
                                    class="inline-flex items-center gap-1.5 bg-[#F66B0E] hover:bg-orange-600
                                    text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                                    Tampilkan Semua
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Mobile card list --}}
        <div class="divide-y divide-gray-100" id="cardList">
            @forelse($suppliers as $supplier)
            <div class="mobile-card px-4 py-3 {{ $loop->even ? '' : 'bg-gray-50/60' }}"
                data-name="{{ strtolower($supplier['nama_supplier'] . ' ' . $supplier['kontak'] . ' ' . $supplier['email'] . ' ' . $supplier['kota']) }}">

                {{-- Baris atas: nomor + nama + tombol aksi --}}
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

                    @if (session('role') === 'admin')
                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="button" data-supplier='@json($supplier)'
                            onclick="openSupplierModal('edit', JSON.parse(this.dataset.supplier))"
                            class="p-1.5 rounded-md border border-orange-200 text-orange-700 bg-orange-50
                                       hover:bg-orange-500 hover:text-white active:scale-[.98] transition-all"
                            title="Edit">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button type="button" data-nama="{{ $supplier['nama_supplier'] }}"
                            onclick="openModal('modalHapusSupplier'); setModalHapusSupplier(this.dataset.nama)"
                            class="p-1.5 rounded-md border border-red-200 text-red-700 bg-red-50
                                       hover:bg-red-600 hover:text-white active:scale-[.98] transition-all"
                            title="Hapus">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    @endif
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
                        <span class="break-all">{{ $supplier['email'] }}</span>
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
            @empty
            @endforelse

            {{-- Data kosong search mobile --}}
            <div id="emptySearchCard" class="hidden px-4 py-10 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full border border-gray-200 bg-gray-50">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                    </svg>
                </div>

                <h3 class="text-base font-semibold text-gray-800">Tidak ada supplier ditemukan</h3>
                <p class="mt-1 text-sm text-gray-400">Coba ubah kata kunci atau filter</p>

                <button type="button" onclick="resetSupplierSearch()"
                    class="mt-5 rounded-full bg-[#F66B0E] px-5 py-2 text-sm font-semibold text-white transition-all hover:bg-orange-600 active:scale-[.98]">
                    Tampilkan Semua
                </button>
            </div>
        </div>

        {{-- FOOTER PAGINATION --}}
        <div class="px-4 py-2.5 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
            <span id="tblInfo" class="text-sm text-gray-400 w-full text-center sm:w-auto sm:text-left"></span>
            <div id="pgnWrap" class="flex items-center justify-center sm:justify-end gap-1 w-full sm:w-auto"></div>
        </div>
    </div>

</div>
@endsection

@push('modals')
<div id="supplierModal" class="modal-overlay hidden fixed inset-0 z-50 flex items-start justify-center pt-20 px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>

    <div
        class="modal-box relative bg-white rounded-2xl w-full max-w-xl
        transform scale-95 opacity-0 transition-all duration-200 origin-top">

        <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
            <div class="flex items-center gap-2.5">
                <h3 id="supplierModalTitle" class="text-[16px] font-semibold text-white">Tambah Supplier</h3>
            </div>

            <button type="button" onclick="closeSupplierModal()"
                class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <form onsubmit="return validateSupplierForm()" class="px-5 py-5 space-y-4">

            <div>
                <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                    Nama Supplier
                </label>
                <input id="namaSupplier" type="text" name="nama_supplier" placeholder="Contoh: CV Sumber Jaya..."
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
            rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
            focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />

                <!-- ERROR -->
                <x-input-error id="errNamaSupplier" message="Nama supplier wajib diisi." class="hidden" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                        No. Kontak
                    </label>
                    <input id="kontakSupplier" type="text" name="kontak" placeholder="Contoh: 0812-3456-7890"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />

                    <!-- ERROR -->
                    <x-input-error id="errKontakSupplier" message="Kontak wajib diisi." class="hidden" />
                </div>

                <div>
                    <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                        Kota
                    </label>
                    <input id="kotaSupplier" type="text" name="kota" placeholder="Contoh: Bandung"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />

                    <!-- ERROR -->
                    <x-input-error id="errKotaSupplier" message="Kota wajib diisi." class="hidden" />
                </div>
            </div>

            <div>
                <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                    Email
                </label>
                <input id="emailSupplier" type="email" name="email" placeholder="Contoh: supplier@email.com"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
            rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
            focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />

                <!-- ERROR -->
                <x-input-error id="errEmailSupplier" message="Email wajib diisi." class="hidden" />
            </div>

            <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-100">
                <button type="button" onclick="closeSupplierModal()"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200
            rounded-lg hover:bg-gray-50 active:scale-[.98] transition-all">
                    Batal
                </button>

                <button id="supplierSubmitBtn" type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-[#F66B0E] hover:bg-orange-600
            rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalHapusSupplier" class="modal-overlay hidden fixed inset-0 z-50 items-center justify-center p-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>

    <div
        class="modal-box relative bg-white rounded-2xl w-full max-w-md
        transform scale-95 opacity-0 transition-all duration-200 origin-top">

        <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-red-600">
            <div class="flex items-center gap-2.5">
                <h3 class="text-[16px] font-semibold text-white">Konfirmasi Hapus</h3>
            </div>

            <button onclick="closeModal('modalHapusSupplier')"
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
                Hapus supplier "<span id="hapusNamaSupplier" class="text-red-600">—</span>"?
            </p>
            <p class="text-sm text-gray-400 leading-relaxed">
                <span class="font-medium text-red-500">Data akan hilang setelah dihapus.</span>
            </p>
        </div>

        <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
            <button onclick="closeModal('modalHapusSupplier')"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200
                rounded-lg hover:bg-gray-50 active:scale-[.98] transition-all">
                Batal
            </button>

            <button type="button" onclick="hapusSupplier()"
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

    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
    }

    /* Mobile: sembunyikan tabel, tampilkan cards */
    @media (max-width: 639px) {
        #desktopTable {
            display: none;
        }
    }

    /* Desktop: sembunyikan cards, tampilkan tabel */
    @media (min-width: 640px) {
        #cardList {
            display: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let hapusNamaSupplierTarget = '';

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
        const ov = document.getElementById(id);
        if (!ov) return;
        ov.classList.remove('hidden');
        ov.classList.add('flex');
        void ov.offsetWidth;
        ov.classList.add('is-open');
        lockBodyScroll();
    }

    function closeModal(id) {
        const ov = document.getElementById(id);
        if (!ov) return;
        ov.classList.remove('is-open');
        setTimeout(function() {
            ov.classList.add('hidden');
            ov.classList.remove('flex');
        }, 200);
        unlockBodyScroll();
    }

    function openSupplierModal(mode = 'tambah', data = {}) {
        openModal('supplierModal');

        const isEdit = mode === 'edit';

        document.getElementById('supplierModalTitle').textContent =
            isEdit ? 'Edit Supplier' : 'Tambah Supplier';

        document.getElementById('namaSupplier').value = isEdit ? (data.nama_supplier ?? '') : '';
        document.getElementById('kontakSupplier').value = isEdit ? (data.kontak ?? '') : '';
        document.getElementById('kotaSupplier').value = isEdit ? (data.kota ?? '') : '';
        document.getElementById('emailSupplier').value = isEdit ? (data.email ?? '') : '';

        ['namaSupplier', 'kontakSupplier', 'kotaSupplier', 'emailSupplier'].forEach(function(id) {
            const input = document.getElementById(id);
            if (input) input.classList.remove('border-orange-500', 'bg-red-50');
        });
        ['errNamaSupplier', 'errKontakSupplier', 'errKotaSupplier', 'errEmailSupplier'].forEach(function(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        });
    }

    function closeSupplierModal() {
        closeModal('supplierModal');
    }

    function setModalHapusSupplier(nama) {
        hapusNamaSupplierTarget = nama;
        document.getElementById('hapusNamaSupplier').textContent = nama;
    }

    function hapusSupplier() {
        const rowIdx = allRows.findIndex(r => r.dataset.name && r.dataset.name.startsWith(hapusNamaSupplierTarget
            .toLowerCase()));
        const cardIdx = allCards.findIndex(c => c.dataset.name && c.dataset.name.startsWith(hapusNamaSupplierTarget
            .toLowerCase()));

        if (rowIdx !== -1) {
            allRows[rowIdx].remove();
            allRows.splice(rowIdx, 1);
        }
        if (cardIdx !== -1) {
            allCards[cardIdx].remove();
            allCards.splice(cardIdx, 1);
        }

        closeModal('modalHapusSupplier');
        render();
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal-overlay').forEach(function(ov) {
            const backdrop = ov.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    closeModal(ov.id);
                });
            }
        });
    });

    const PER_PAGE = 10;
    let curPage = 1;
    let curKw = '';

    const allRows = Array.from(document.querySelectorAll('#tbody .tbl-row'));
    const allCards = Array.from(document.querySelectorAll('#cardList .mobile-card'));
    const emptySearchRow = document.getElementById('emptySearchRow');
    const emptySearchCard = document.getElementById('emptySearchCard');

    function getFiltered() {
        return allRows.filter(function(r) {
            return !curKw || (r.dataset.name || '').includes(curKw);
        });
    }

    function render() {
        const filtered = getFiltered();
        const total = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (curPage > totalPages) curPage = totalPages;

        const start = (curPage - 1) * PER_PAGE;
        const end = start + PER_PAGE;

        allRows.forEach(function(r) {
            r.style.display = 'none';
        });
        allCards.forEach(function(c) {
            c.style.display = 'none';
        });

        if (emptySearchRow) emptySearchRow.classList.add('hidden');
        if (emptySearchCard) emptySearchCard.classList.add('hidden');

        if (total === 0) {
            if (emptySearchRow) emptySearchRow.classList.remove('hidden');
            if (emptySearchCard) emptySearchCard.classList.remove('hidden');
            document.getElementById('tblInfo').textContent = 'Tidak ada data';
            document.getElementById('pgnWrap').innerHTML = '';
            return;
        }

        filtered.slice(start, end).forEach(function(r, i) {
            r.style.display = '';
            const numCell = r.querySelector('.row-num');
            if (numCell) numCell.textContent = start + i + 1;
            r.classList.toggle('bg-gray-50/60', i % 2 === 1);

            const matchedCard = allCards.find(c => c.dataset.name === r.dataset.name);
            if (matchedCard) {
                matchedCard.style.display = '';
                const numEl = matchedCard.querySelector('.mobile-num');
                if (numEl) numEl.textContent = start + i + 1;
                matchedCard.classList.toggle('bg-gray-50/60', i % 2 === 1);
            }
        });

        document.getElementById('tblInfo').textContent =
            'Menampilkan ' + (start + 1) + '–' + Math.min(end, total) + ' dari ' + total + ' supplier';

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const wrap = document.getElementById('pgnWrap');
        if (totalPages <= 1) {
            wrap.innerHTML = '';
            return;
        }

        const base =
            'w-8 h-8 rounded-md border text-sm font-medium flex items-center justify-center transition-all cursor-pointer ';
        const btnNorm = base + 'border-gray-200 text-gray-600 hover:border-orange-500 hover:text-orange-500 ';
        const btnCur = base + 'border-[#F66B0E] bg-[#F66B0E] text-white ';
        const btnDis = base + 'border-gray-100 text-gray-300 cursor-not-allowed ';

        let html = '';

        html += curPage === 1 ?
            '<button type="button" class="' + btnDis + '" disabled>‹</button>' :
            '<button type="button" class="' + btnNorm + '" onclick="goPage(' + (curPage - 1) + ')">‹</button>';

        const rangeStart = Math.max(1, curPage - 2);
        const rangeEnd = Math.min(totalPages, curPage + 2);

        if (rangeStart > 1) {
            html += '<button type="button" class="' + btnNorm + '" onclick="goPage(1)">1</button>';
            if (rangeStart > 2) html += '<span class="text-sm text-gray-400 px-0.5">…</span>';
        }
        for (let p = rangeStart; p <= rangeEnd; p++) {
            html += '<button type="button" class="' + (p === curPage ? btnCur : btnNorm) + '" onclick="goPage(' + p +
                ')">' + p + '</button>';
        }
        if (rangeEnd < totalPages) {
            if (rangeEnd < totalPages - 1) html += '<span class="text-sm text-gray-400 px-0.5">…</span>';
            html += '<button type="button" class="' + btnNorm + '" onclick="goPage(' + totalPages + ')">' + totalPages +
                '</button>';
        }

        html += curPage === totalPages ?
            '<button type="button" class="' + btnDis + '" disabled>›</button>' :
            '<button type="button" class="' + btnNorm + '" onclick="goPage(' + (curPage + 1) + ')">›</button>';

        wrap.innerHTML = html;
    }

    function goPage(p) {
        const tp = Math.max(1, Math.ceil(getFiltered().length / PER_PAGE));
        if (p < 1 || p > tp) return;
        curPage = p;
        render();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    function resetSupplierSearch() {
        const input = document.getElementById('srchInput');
        if (input) input.value = '';
        curKw = '';
        curPage = 1;
        render();
    }

    function onSearch() {
        curKw = document.getElementById('srchInput').value.toLowerCase().trim();
        curPage = 1;
        render();
    }

    render();

    function validateSupplierForm() {
        let valid = true;

        const fields = [
            ['namaSupplier', 'errNamaSupplier'],
            ['kontakSupplier', 'errKontakSupplier'],
            ['kotaSupplier', 'errKotaSupplier'],
            ['emailSupplier', 'errEmailSupplier'],
        ];

        fields.forEach(([inputId, errorId]) => {
            const input = document.getElementById(inputId);
            const error = document.getElementById(errorId);
            if (input.value.trim() === '') {
                error.classList.remove('hidden');
                input.classList.add('border-orange-500', 'bg-red-50');
                valid = false;
            } else {
                error.classList.add('hidden');
                input.classList.remove('border-orange-500', 'bg-red-50');
            }
        });

        return valid;
    }
</script>
@endpush