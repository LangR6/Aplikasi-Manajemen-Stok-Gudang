@extends('layouts.app')

@section('title', 'Kelola Supplier')

@section('content')
<div class="space-y-3">

    {{-- TOOLBAR --}}
    <div class="flex flex-wrap items-center gap-3">

        {{-- SEARCH --}}
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>

            <input id="srchInput" type="text" oninput="onSearch()" placeholder="Cari supplier..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
        </div>

        {{-- TAMBAH --}}
        @if (session('role') === 'admin')
        <button type="button" onclick="openSupplierModal()"
            class="flex items-center gap-2 bg-[#F66B0E] hover:bg-orange-600
            active:scale-[.98] text-white text-sm font-medium px-6 py-2.5
            rounded-lg transition-all whitespace-nowrap">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-width="2.2" d="M9 1v16M1 9h16" />
            </svg>
            Tambah Supplier
        </button>
        @endif
    </div>

    {{-- TABLE --}}
    <div class="border border-gray-300 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left table-fixed min-w-[900px]">
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
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wide">No</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Nama Supplier</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Kontak</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Email</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Kota</th>
                        @if (session('role') === 'admin')
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wide">
                            Aksi
                        </th>
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

                        <td class="px-4 py-3 text-sm font-medium text-gray-800">
                            {{ $supplier['nama_supplier'] }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $supplier['kontak'] }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700 break-words">
                            {{ $supplier['email'] }}
                        </td>

                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $supplier['kota'] }}
                        </td>

                        @if (session('role') === 'admin')
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                    data-supplier='@json($supplier)'
                                    onclick="openSupplierModal('edit', JSON.parse(this.dataset.supplier))"
                                    class="px-3 py-1 rounded-md text-sm font-medium border border-gray-300
                                    text-gray-700 bg-transparent hover:bg-gray-100
                                    active:scale-[.98] hover:-translate-y-px transition-all">
                                    Edit
                                </button>

                                <button type="button"
                                    data-nama="{{ $supplier['nama_supplier'] }}"
                                    onclick="openModal('modalHapusSupplier'); setModalHapusSupplier(this.dataset.nama)"
                                    class="px-3 py-1 rounded-md text-sm font-medium border border-red-200
                                    text-red-600 bg-red-50 hover:bg-red-100
                                    active:scale-[.98] hover:-translate-y-px transition-all">
                                    Hapus
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ session('role') === 'admin' ? 6 : 5 }}" class="px-4 py-12 text-center text-gray-400 text-sm">
                            Belum ada data supplier
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER PAGINATION --}}
        <div class="px-4 py-2.5 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
            <span id="tblInfo" class="text-sm text-gray-400">
                Menampilkan 1–{{ min(10, $suppliers->count()) }} dari {{ $suppliers->count() }} supplier
            </span>

            <div id="pgnWrap" class="flex items-center gap-1"></div>
        </div>
    </div>
</div>
@endsection

@push('modals')
<div id="supplierModal" class="modal-overlay hidden fixed inset-0 z-50 flex items-start justify-center pt-20 px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>

    <div class="modal-box relative bg-white rounded-2xl w-full max-w-xl
        transform scale-95 opacity-0 transition-all duration-200 origin-top">

        <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
            <div class="flex items-center gap-2.5">
                <h3 id="supplierModalTitle" class="text-sm font-semibold text-white">Tambah Supplier</h3>
            </div>

            <button type="button" onclick="closeSupplierModal()"
                class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>

        <form action="#" method="POST" class="px-5 py-5 space-y-4">
            @csrf

            <div>
                <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                    Nama Supplier
                </label>
                <input id="namaSupplier" type="text" name="nama_supplier" placeholder="Contoh: CV Sumber Jaya..."
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                    rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                    focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />
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
                </div>

                <div>
                    <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                        Kota
                    </label>
                    <input id="kotaSupplier" type="text" name="kota" placeholder="Contoh: Bandung"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                        rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                        focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />
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

    <div class="modal-box relative bg-white rounded-2xl w-full max-w-md
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
            <div class="w-11 h-11 rounded-full bg-red-50 border border-red-200
                flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                        stroke="currentColor" stroke-width="1.8" />
                    <line x1="12" y1="9" x2="12" y2="13" stroke="currentColor" stroke-width="1.8" />
                    <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor" stroke-width="1.8" />
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

        document.getElementById('namaSupplier').value = isEdit ? data.nama_supplier : '';
        document.getElementById('kontakSupplier').value = isEdit ? data.kontak : '';
        document.getElementById('kotaSupplier').value = isEdit ? data.kota : '';
        document.getElementById('emailSupplier').value = isEdit ? data.email : '';
    }

    function closeSupplierModal() {
        closeModal('supplierModal');
    }

    function setModalHapusSupplier(nama) {
        hapusNamaSupplierTarget = nama;
        document.getElementById('hapusNamaSupplier').textContent = nama;
    }

    function hapusSupplier() {
        closeModal('modalHapusSupplier');
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

    function getFiltered() {
        return allRows.filter(function(r) {
            const keyword = curKw.toLowerCase().trim();
            return !keyword || (r.dataset.name || '').includes(keyword);
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

        if (total === 0) {
            document.getElementById('tblInfo').textContent = 'Tidak ada data supplier';
            document.getElementById('pgnWrap').innerHTML = '';
            return;
        }

        filtered.slice(start, end).forEach(function(r, i) {
            r.style.display = '';

            const numCell = r.querySelector('.row-num');
            if (numCell) numCell.textContent = start + i + 1;

            r.classList.remove('bg-gray-50/60');

            if (i % 2 === 1) {
                r.classList.add('bg-gray-50/60');
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
            'w-7 h-7 rounded-md border text-sm font-medium flex items-center justify-center transition-all cursor-pointer ';
        const btnNorm = base + 'border-gray-200 text-gray-600 hover:bg-gray-100 ';
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
            html += '<button type="button" class="' + (p === curPage ? btnCur : btnNorm) + '" onclick="goPage(' + p + ')">' + p + '</button>';
        }

        if (rangeEnd < totalPages) {
            if (rangeEnd < totalPages - 1) html += '<span class="text-sm text-gray-400 px-0.5">…</span>';
            html += '<button type="button" class="' + btnNorm + '" onclick="goPage(' + totalPages + ')">' + totalPages + '</button>';
        }

        html += curPage === totalPages ?
            '<button type="button" class="' + btnDis + '" disabled>›</button>' :
            '<button type="button" class="' + btnNorm + '" onclick="goPage(' + (curPage + 1) + ')">›</button>';

        wrap.innerHTML = html;
    }

    function goPage(p) {
        const totalPages = Math.max(1, Math.ceil(getFiltered().length / PER_PAGE));

        if (p < 1 || p > totalPages) return;

        curPage = p;
        render();
    }

    function onSearch() {
        curKw = document.getElementById('srchInput').value.toLowerCase().trim();
        curPage = 1;
        render();
    }

    render();
</script>
@endpush