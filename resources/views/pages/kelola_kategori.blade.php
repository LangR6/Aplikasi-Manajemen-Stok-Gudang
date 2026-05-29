@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="space-y-3">

        {{-- TOOLBAR --}}
        <div class="flex flex-wrap items-center gap-3">

            {{-- SEARCH --}}
            <div class="relative w-full sm:flex-1">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="srchInput" placeholder="Cari kategori..." oninput="onSearch()"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
            </div>

            {{-- PILL FILTER --}}
            <div
                class="flex items-center gap-1 bg-white p-1 rounded-lg border border-gray-200
                       w-full sm:w-auto justify-between sm:justify-start">
                <button data-f="semua" onclick="setPill(this)"
                    class="pill-btn on px-3 py-1.5 rounded-md text-sm font-medium
                           transition-all duration-150 hover:text-orange-500">
                    Semua
                </button>
                <button data-f="aktif" onclick="setPill(this)"
                    class="pill-btn px-3 py-1.5 rounded-md text-sm font-medium text-gray-500
                           transition-all duration-150 hover:text-orange-500">
                    Aktif
                </button>
                <button data-f="nonaktif" onclick="setPill(this)"
                    class="pill-btn px-3 py-1.5 rounded-md text-sm font-medium text-gray-500
                           transition-all duration-150 hover:text-orange-500">
                    Nonaktif
                </button>
            </div>

            {{-- TAMBAH --}}
            @if (session('role') === 'admin')
                <button type="button" onclick="openModal('modalKategori'); setModalKategori('tambah')"
                    class="flex items-center justify-center gap-2 bg-[#F66B0E] hover:bg-orange-600
                           active:scale-[.98] text-white text-sm font-medium px-6 py-2.5
                           rounded-lg transition-all whitespace-nowrap w-full sm:w-auto">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                            d="M9 1v16M1 9h16" />
                    </svg>
                    Tambah Kategori
                </button>
            @endif
        </div>

        {{-- TABLE --}}
        <div class="border border-gray-300 rounded-xl overflow-hidden">

            {{-- Desktop table --}}
            <div class="overflow-x-auto" id="desktopTable">
                <table class="w-full text-left table-fixed min-w-120">
                    <colgroup>
                        <col class="w-11">
                        <col>
                        <col class="w-40">
                        @if (session('role') === 'admin')
                            <col class="w-40">
                        @endif
                    </colgroup>
                    <thead class="bg-[#205375] border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wide">
                                No</th>
                            <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">
                                Nama Kategori</th>
                            <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">
                                Status</th>
                            @if (session('role') === 'admin')
                                <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wide">
                                    Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach ($data as $dataku)
                            <tr class="tbl-row border-b border-gray-100 {{ $loop->even ? '' : 'bg-gray-50/60' }}"
                                data-name="{{ strtolower($dataku['nama_kategori']) }}"
                                data-status="{{ $dataku['status'] ? 'aktif' : 'nonaktif' }}"
                                data-index="{{ $loop->index }}" data-id="{{ $dataku['id_kategori'] }}">
                                <td class="px-4 py-2.5 text-center text-sm font-medium text-gray-800 row-num">
                                    {{ $loop->iteration }}</td>
                                <td class="px-4 py-2.5 text-sm font-medium text-gray-800">
                                    {{ $dataku['nama_kategori'] }}</td>
                                <td class="px-4 py-2.5">
                                    @if ($dataku['status'])
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full
                                            bg-green-100 text-green-700 text-sm font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 shrink-0"></span>Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full
                                            bg-gray-100 text-gray-500 text-sm font-medium border border-gray-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>Nonaktif
                                        </span>
                                    @endif
                                </td>
                                @if (session('role') === 'admin')
                                    <td class="px-4 py-2.5">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                onclick="openModal('modalKategori'); setModalKategori('edit',
                                                '{{ addslashes($dataku['nama_kategori']) }}',
                                                {{ $dataku['status'] ? 'true' : 'false' }},
                                                {{ $dataku['id_kategori'] }})"
                                                class="px-3 py-1 rounded-md text-sm font-medium border border-orange-200
                                                       text-orange-800 bg-orange-100 hover:bg-orange-500 hover:text-white
                                                       active:scale-[.98] hover:-translate-y-px transition-all">
                                                Edit
                                            </button>
                                            <button type="button"
                                                onclick="openModal('modalHapus'); setModalHapus(
                                                '{{ $dataku['nama_kategori'] }}',
                                                {{ $loop->index }},
                                                {{ $dataku['id_kategori'] }})"
                                                class="px-3 py-1 rounded-md text-sm font-medium border border-red-200
                                                       text-red-800 bg-red-100 hover:bg-red-600 hover:text-white
                                                       active:scale-[.98] hover:-translate-y-px transition-all">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile card list --}}
            <div class="divide-y divide-gray-100" id="cardList">
                @foreach ($data as $dataku)
                    <div class="mobile-card px-4 py-3 {{ $loop->even ? '' : 'bg-gray-50/60' }}"
                        data-name="{{ strtolower($dataku['nama_kategori']) }}"
                        data-status="{{ $dataku['status'] ? 'aktif' : 'nonaktif' }}" data-index="{{ $loop->index }}"
                        data-id="{{ $dataku['id_kategori'] }}">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span
                                    class="mobile-num shrink-0 w-6 h-6 rounded-full bg-[#205375] text-white
                                           text-xs font-semibold flex items-center justify-center">
                                    {{ $loop->iteration }}
                                </span>
                                <span class="text-sm font-medium text-gray-800 truncate">
                                    {{ $dataku['nama_kategori'] }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                @if ($dataku['status'])
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                               bg-green-100 text-green-700 text-xs font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 shrink-0"></span>Aktif
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full
                                               bg-gray-100 text-gray-500 text-xs font-medium border border-gray-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>Nonaktif
                                    </span>
                                @endif
                                @if (session('role') === 'admin')
                                    <button type="button"
                                        onclick="openModal('modalKategori'); setModalKategori('edit',
                                        '{{ addslashes($dataku['nama_kategori']) }}',
                                        {{ $dataku['status'] ? 'true' : 'false' }},
                                        {{ $dataku['id_kategori'] }})"
                                        class="p-1.5 rounded-md border border-orange-200 text-orange-700
                                               bg-orange-50 hover:bg-orange-500 hover:text-white
                                               active:scale-[.98] transition-all"
                                        title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button type="button"
                                        onclick="openModal('modalHapus'); setModalHapus(
                                        '{{ $dataku['nama_kategori'] }}',
                                        {{ $loop->index }},
                                        {{ $dataku['id_kategori'] }})"
                                        class="p-1.5 rounded-md border border-red-200 text-red-700
                                               bg-red-50 hover:bg-red-600 hover:text-white
                                               active:scale-[.98] transition-all"
                                        title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- EMPTY STATE --}}
            <div id="emptyState" class="hidden py-12 text-center">
                <div
                    class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200
                           flex items-center justify-center mx-auto mb-3">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor"
                            stroke-width="1.8" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-700 mb-1">Tidak ada kategori ditemukan</p>
                <p class="text-sm text-gray-400 mb-4">Coba ubah kata kunci atau filter</p>
                <button onclick="resetFilter()"
                    class="inline-flex items-center gap-1.5 bg-[#F66B0E] hover:bg-orange-600
                           text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    Tampilkan Semua
                </button>
            </div>

            {{-- FOOTER PAGINATION --}}
            <div
                class="px-4 py-2.5 border-t border-gray-100 flex flex-wrap items-center
                       justify-between gap-2">
                <span id="tblInfo" class="text-sm text-gray-400 w-full text-center sm:w-auto sm:text-left"></span>
                <div id="pgnWrap" class="flex items-center justify-center sm:justify-end gap-1 w-full sm:w-auto">
                </div>
            </div>
        </div>
    </div>
@endsection


@push('modals')
    {{-- ===== MODAL TAMBAH / EDIT ===== --}}
    <div id="modalKategori" class="modal-overlay hidden fixed inset-0 z-50 items-center justify-center p-4">
        <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
        <div
            class="modal-box relative bg-white rounded-2xl w-full max-w-md
                   transform scale-95 opacity-0 transition-all duration-200 origin-top">

            <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
                <h3 id="modalKategoriTitle" class="text-[16px] font-semibold text-white">
                    Tambah Kategori</h3>
                <button type="button" onclick="closeModal('modalKategori')"
                    class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center
                           text-white hover:bg-white/30 transition">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            {{-- FORM TAMBAH / EDIT --}}
            <form id="formKategori" method="POST" action="{{ route('kelola_kategori.store') }}">
                @csrf
                {{-- field method akan diubah oleh JS saat mode edit --}}
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="px-5 py-5 space-y-4">
                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                            Nama Kategori
                        </label>
                        <input type="text" name="nama_kategori" id="namaKategori" placeholder="Contoh: Sepatu..."
                            oninput="clearAlert('alertKategori', 'namaKategori')"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                                   rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                                   focus:ring-orange-400 focus:border-transparent transition
                                   placeholder-gray-300" />
                    </div>
                    <x-input-error id="alertKategori" message="Nama kategori wajib diisi" />
                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                            Status
                        </label>
                        <div
                            class="flex items-center justify-between px-3 py-2.5 bg-gray-50
                                   border border-gray-200 rounded-lg">
                            <p id="statusLabel" class="text-sm font-semibold status-label-aktif">
                                Aktif</p>
                            <label class="cursor-pointer"
                                style="display:inline-block;width:40px;height:22px;position:relative;">
                                <input type="checkbox" id="statusToggle" class="sr-only" checked
                                    onchange="syncLabel('statusToggle','statusLabel'); syncToggleColor(this)">
                                {{-- input hidden untuk kirim nilai status ke controller --}}
                                <input type="hidden" name="status" id="statusValue" value="aktif">
                                <div id="toggleBg"
                                    style="width:40px;height:22px;border-radius:11px;background:#d1d5db;
                                           position:relative;transition:background .2s;">
                                    <div id="toggleThumb"
                                        style="position:absolute;top:3px;left:3px;width:16px;height:16px;
                                               border-radius:50%;background:white;transition:transform .2s;">
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal('modalKategori')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200
                               rounded-lg active:scale-[.98] hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button type="button" onclick="simpanKategori()"
                        class="px-4 py-2 text-sm font-medium text-white bg-[#F66B0E] hover:bg-orange-600
                               rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ===== MODAL HAPUS ===== --}}
    <div id="modalHapus" class="modal-overlay hidden fixed inset-0 z-50 items-center justify-center p-4">
        <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
        <div
            class="modal-box relative bg-white rounded-2xl w-full max-w-md
                   transform scale-95 opacity-0 transition-all duration-200 origin-top">

            <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-red-600">
                <h3 class="text-[16px] font-semibold text-white">Konfirmasi Hapus</h3>
                <button type="button" onclick="closeModal('modalHapus')"
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
                    Hapus kategori "<span id="hapusNama" class="text-red-600">—</span>"?
                </p>
                <p class="text-sm text-gray-400 leading-relaxed">
                    <span class="font-medium text-red-500">Data akan hilang setelah dihapus.</span>
                </p>
            </div>

            {{-- FORM HAPUS --}}
            <form id="formHapus" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal('modalHapus')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200
                               rounded-lg active:scale-[.98] transition-all">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700
                               rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush


@push('styles')
    <style>
        .status-label-aktif {
            color: #16a34a;
        }

        .status-label-nonaktif {
            color: #dc2626;
        }

        .modal-overlay.is-open .modal-backdrop {
            background: rgba(0, 0, 0, .35) !important;
            backdrop-filter: blur(2px) !important;
            -webkit-backdrop-filter: blur(2px) !important;
        }

        .modal-overlay.is-open .modal-box {
            transform: scale(1) !important;
            opacity: 1 !important;
        }

        .pill-btn.on {
            background: white;
            color: #F66B0E;
            font-weight: 500;
        }

        .input-error {
            border-color: #fca5a5 !important;
            background-color: #fff5f5 !important;
        }

        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 639px) {
            #desktopTable {
                display: none;
            }
        }

        @media (min-width: 640px) {
            #cardList {
                display: none !important;
            }
        }
    </style>
@endpush


@push('scripts')
    <script>
        const PER_PAGE = 10;
        let curPage = 1;
        let curFilter = 'semua';
        let curKw = '';
        let editIdTarget = null;
        let hapusIndexTarget = -1;

        const allRows = Array.from(document.querySelectorAll('#tbody .tbl-row'));
        const allCards = Array.from(document.querySelectorAll('#cardList .mobile-card'));

        // ===== FILTER & PAGINATION =====

        function getFiltered() {
            return allRows.filter(function(r) {
                const matchKw = !curKw || (r.dataset.name || '').includes(curKw);
                const matchF = curFilter === 'semua' || r.dataset.status === curFilter;
                return matchKw && matchF;
            });
        }

        function render() {
            const filtered = getFiltered();
            const total = filtered.length;
            const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
            if (curPage > totalPages) curPage = totalPages;

            const start = (curPage - 1) * PER_PAGE;
            const end = start + PER_PAGE;

            allRows.forEach(r => r.style.display = 'none');
            allCards.forEach(c => c.style.display = 'none');

            const empty = document.getElementById('emptyState');

            if (total === 0) {
                empty.classList.remove('hidden');
                document.getElementById('tblInfo').textContent = 'Tidak ada data';
                document.getElementById('pgnWrap').innerHTML = '';
                return;
            }

            empty.classList.add('hidden');

            filtered.slice(start, end).forEach(function(r, i) {
                r.style.display = '';
                const numCell = r.querySelector('.row-num');
                if (numCell) numCell.textContent = start + i + 1;
                r.classList.toggle('bg-gray-50/60', i % 2 === 1);

                const matchedCard = allCards.find(c => c.dataset.index === r.dataset.index);
                if (matchedCard) {
                    matchedCard.style.display = '';
                    const numEl = matchedCard.querySelector('.mobile-num');
                    if (numEl) numEl.textContent = start + i + 1;
                    matchedCard.classList.toggle('bg-gray-50/60', i % 2 === 1);
                }
            });

            const s = start + 1;
            const e = Math.min(end, total);
            document.getElementById('tblInfo').textContent =
                'Menampilkan ' + s + '–' + e + ' dari ' + total + ' kategori';

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
                '<button class="' + btnDis + '" disabled>‹</button>' :
                '<button class="' + btnNorm + '" onclick="goPage(' + (curPage - 1) + ')">‹</button>';

            const rangeStart = Math.max(1, curPage - 2);
            const rangeEnd = Math.min(totalPages, curPage + 2);

            if (rangeStart > 1) {
                html += '<button class="' + btnNorm + '" onclick="goPage(1)">1</button>';
                if (rangeStart > 2) html += '<span class="text-sm text-gray-400 px-0.5">…</span>';
            }
            for (let p = rangeStart; p <= rangeEnd; p++) {
                html += '<button class="' + (p === curPage ? btnCur : btnNorm) +
                    '" onclick="goPage(' + p + ')">' + p + '</button>';
            }
            if (rangeEnd < totalPages) {
                if (rangeEnd < totalPages - 1) html += '<span class="text-sm text-gray-400 px-0.5">…</span>';
                html += '<button class="' + btnNorm + '" onclick="goPage(' + totalPages + ')">' + totalPages + '</button>';
            }

            html += curPage === totalPages ?
                '<button class="' + btnDis + '" disabled>›</button>' :
                '<button class="' + btnNorm + '" onclick="goPage(' + (curPage + 1) + ')">›</button>';

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

        function onSearch() {
            curKw = document.getElementById('srchInput').value.toLowerCase().trim();
            curPage = 1;
            render();
        }

        function setPill(el) {
            document.querySelectorAll('.pill-btn').forEach(p => {
                p.classList.remove('on');
                p.classList.add('text-gray-500');
            });
            el.classList.add('on');
            el.classList.remove('text-gray-500');
            curFilter = el.dataset.f;
            curPage = 1;
            render();
        }

        function resetFilter() {
            document.getElementById('srchInput').value = '';
            curKw = '';
            curFilter = 'semua';
            curPage = 1;
            document.querySelectorAll('.pill-btn').forEach(p => {
                p.classList.remove('on');
                p.classList.add('text-gray-500');
            });
            const semuaBtn = document.querySelector('.pill-btn[data-f="semua"]');
            semuaBtn.classList.add('on');
            semuaBtn.classList.remove('text-gray-500');
            render();
        }

        // ===== MODAL =====

        function openModal(id) {
            const ov = document.getElementById(id);
            ov.classList.remove('hidden');
            ov.classList.add('flex');
            void ov.offsetWidth;
            ov.classList.add('is-open');
        }

        function closeModal(id) {
            const ov = document.getElementById(id);
            ov.classList.remove('is-open');
            setTimeout(() => ov.classList.add('hidden'), 200);
        }

        document.querySelectorAll('.modal-overlay').forEach(ov => {
            ov.querySelector('.modal-backdrop').addEventListener('click', () => closeModal(ov.id));
        });

        // ===== MODAL KATEGORI =====

        function setModalKategori(mode, nama, aktif, id) {
            if (nama === undefined) nama = '';
            if (aktif === undefined) aktif = true;
            if (id === undefined) id = null;

            const isTambah = mode === 'tambah';

            // simpan id untuk keperluan edit
            editIdTarget = isTambah ? null : id;

            document.getElementById('modalKategoriTitle').textContent =
                isTambah ? 'Tambah Kategori' : 'Edit Kategori';

            document.getElementById('namaKategori').value = isTambah ? '' : nama.trim();
            document.getElementById('statusToggle').checked = isTambah ? true : aktif;

            // ubah action form dan method sesuai mode tambah atau edit
            const form = document.getElementById('formKategori');
            if (isTambah) {
                form.action = "{{ route('kelola_kategori.store') }}";
                document.getElementById('formMethod').value = 'POST';
            } else {
                form.action = '/kategori/' + id;
                document.getElementById('formMethod').value = 'PUT';
            }

            clearAlert('alertKategori', 'namaKategori');
            syncLabel('statusToggle', 'statusLabel');
            syncToggleColor(document.getElementById('statusToggle'));
            syncStatusValue();
        }

        function simpanKategori() {
            const input = document.getElementById('namaKategori');
            const alertEl = document.getElementById('alertKategori');

            if (!input.value.trim()) {
                // tampilkan pesan error jika nama kategori kosong
                alertEl.classList.remove('hidden');
                alertEl.classList.add('flex');
                input.classList.add('input-error');
                input.focus();
                return;
            }

            // submit form ke controller
            document.getElementById('formKategori').submit();
        }

        function clearAlert(alertId, inputId) {
            const alertEl = document.getElementById(alertId);
            const input = document.getElementById(inputId);
            alertEl.classList.add('hidden');
            alertEl.classList.remove('flex');
            if (input) input.classList.remove('input-error');
        }

        function syncLabel(cbId, labelId) {
            const isChecked = document.getElementById(cbId).checked;
            const lbl = document.getElementById(labelId);
            lbl.textContent = isChecked ? 'Aktif' : 'Nonaktif';
            lbl.className = 'text-sm font-semibold ' +
                (isChecked ? 'status-label-aktif' : 'status-label-nonaktif');
        }

        function syncToggleColor(cb) {
            const bg = document.getElementById('toggleBg');
            const thumb = document.getElementById('toggleThumb');
            bg.style.backgroundColor = cb.checked ? '#16a34a' : '#d1d5db';
            thumb.style.transform = cb.checked ? 'translateX(18px)' : 'translateX(0)';
        }

        function syncStatusValue() {
            // sinkronkan nilai hidden input status dengan kondisi toggle
            const isChecked = document.getElementById('statusToggle').checked;
            document.getElementById('statusValue').value = isChecked ? 'aktif' : 'nonaktif';
        }

        // update nilai status setiap kali toggle berubah
        document.getElementById('statusToggle').addEventListener('change', syncStatusValue);

        // ===== MODAL HAPUS =====

        function setModalHapus(nama, index, id) {
            hapusIndexTarget = parseInt(index);

            // set action form hapus ke url delete yang sesuai
            document.getElementById('formHapus').action = '/kategori/' + id;
            document.getElementById('hapusNama').textContent = nama;
        }

        // ===== INIT =====
        render();
        syncToggleColor(document.getElementById('statusToggle'));
        syncStatusValue();
    </script>
@endpush
