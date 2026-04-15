@extends('app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="space-y-3">

    {{-- TOOLBAR --}}
    <div class="flex items-center gap-3">

        {{-- SEARCH --}}
        <div class="relative max-w-xs w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="srchInput"
                placeholder="Cari nama kategori..."
                oninput="onSearch()"
                class="w-full bg-white border border-gray-200 text-gray-800 text-xs
                       rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-2
                       focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />
        </div>

        {{-- PILL FILTER --}}
        <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-lg border border-gray-200">
            <button data-f="semua" onclick="setPill(this)"
                class="pill-btn on px-3 py-1.5 rounded-md text-xs font-medium transition">
                Semua
            </button>
            <button data-f="aktif" onclick="setPill(this)"
                class="pill-btn px-3 py-1.5 rounded-md text-xs font-medium text-gray-500 transition hover:bg-white">
                Aktif
            </button>
            <button data-f="nonaktif" onclick="setPill(this)"
                class="pill-btn px-3 py-1.5 rounded-md text-xs font-medium text-gray-500 transition hover:bg-white">
                Nonaktif
            </button>
        </div>

        {{-- TAMBAH --}}
        <button type="button" onclick="openModal('modalKategori'); setModalKategori('tambah')"
            class="flex items-center gap-2 bg-orange-500 hover:bg-orange-600
                   active:scale-[.98] text-white text-xs font-medium px-4 py-2
                   rounded-lg transition-all ml-auto whitespace-nowrap">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-linecap="round"
                    stroke-linejoin="round" stroke-width="2.2" d="M9 1v16M1 9h16"/>
            </svg>
            Tambah Kategori
        </button>
    </div>

    {{-- TABLE --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <table class="w-full text-left table-fixed">
            <colgroup>
                <col class="w-11">
                <col>
                <col class="w-28">
                <col class="w-36">
            </colgroup>
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-center text-[10.5px] font-medium text-gray-500 uppercase tracking-wide">No</th>
                    <th class="px-4 py-3 text-[10.5px] font-medium text-gray-500 uppercase tracking-wide">Nama Kategori</th>
                    <th class="px-4 py-3 text-[10.5px] font-medium text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-center text-[10.5px] font-medium text-gray-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody id="tbody">
                @foreach ($data as $dataku)
                <tr class="tbl-row border-b border-gray-100 transition-colors duration-100 hover:bg-orange-50
                            {{ $loop->even ? 'bg-gray-50/60' : '' }}"
                    data-name="{{ strtolower($dataku['nama_kategori']) }}"
                    data-status="{{ $dataku['status'] ? 'aktif' : 'nonaktif' }}"
                    data-index="{{ $loop->index }}">

                    <td class="px-4 py-2.5 text-center text-[11px] text-gray-400 font-medium row-num">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-4 py-2.5 text-xs font-medium text-gray-800">
                        {{ $dataku['nama_kategori'] }}
                    </td>
                    <td class="px-4 py-2.5">
                        @if($dataku['status'])
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full
                                         bg-green-100 text-green-700 text-[11px] font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 shrink-0"></span>Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full
                                         bg-gray-100 text-gray-500 text-[11px] font-medium border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 shrink-0"></span>Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button"
                                onclick="openModal('modalKategori'); setModalKategori('edit', '{{ $dataku['nama_kategori'] }}', {{ $dataku['status'] ? 'true' : 'false' }})"
                                class="px-3 py-1 rounded-md text-[11px] font-medium border border-gray-300
                                       text-gray-700 bg-transparent hover:bg-gray-100
                                       active:scale-[.98] transition-all hover:-translate-y-px">
                                Edit
                            </button>
                            <button type="button"
                                onclick="openModal('modalHapus'); setModalHapus('{{ $dataku['nama_kategori'] }}')"
                                class="px-3 py-1 rounded-md text-[11px] font-medium border border-red-200
                                       text-red-600 bg-red-50 hover:bg-red-100
                                       active:scale-[.98] transition-all hover:-translate-y-px">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- EMPTY STATE --}}
        <div id="emptyState" class="hidden py-12 text-center">
            <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200
                        flex items-center justify-center mx-auto mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="1.8"/>
                    <line x1="21" y1="21" x2="16.65" y2="16.65" stroke="currentColor" stroke-width="1.8"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-700 mb-1">Tidak ada kategori ditemukan</p>
            <p class="text-xs text-gray-400 mb-4">Coba ubah kata kunci atau filter</p>
            <button onclick="resetFilter()"
                class="inline-flex items-center gap-1.5 bg-orange-500 hover:bg-orange-600
                       text-white text-xs font-medium px-4 py-2 rounded-lg transition">
                Tampilkan Semua
            </button>
        </div>

        {{-- FOOTER PAGINATION --}}
        <div class="px-4 py-2.5 border-t border-gray-100 flex items-center justify-between">
            <span id="tblInfo" class="text-[11px] text-gray-400"></span>
            <div id="pgnWrap" class="flex items-center gap-1"></div>
        </div>
    </div>

</div>
@endsection


@push('modals')

{{-- ===== MODAL TAMBAH / EDIT ===== --}}
<div id="modalKategori"
    class="modal-overlay hidden fixed inset-0 z-50 flex items-start justify-center pt-20 px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
    <div class="modal-box relative bg-white rounded-2xl w-full max-w-md border border-gray-200
                transform scale-95 opacity-0 transition-all duration-200 origin-top">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5" id="modalKategoriHeader">
                <div id="modalKategoriIcon"
                    class="w-6 h-6 rounded-md bg-orange-50 flex items-center justify-center">
                    <svg class="w-3 h-3 text-orange-500" id="modalKategoriIconSvg"
                        fill="none" viewBox="0 0 18 18">
                        <path stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2.2" d="M9 1v16M1 9h16"/>
                    </svg>
                </div>
                <h3 id="modalKategoriTitle" class="text-sm font-medium text-gray-800">Tambah Kategori</h3>
            </div>
            <button onclick="closeModal('modalKategori')"
                class="w-6 h-6 rounded-md border border-gray-200 flex items-center justify-center
                       text-gray-400 hover:bg-gray-100 transition">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

        <div class="px-5 py-5 space-y-4">
            <div>
                <label class="block mb-1.5 text-[10px] font-medium text-gray-400 uppercase tracking-wide">
                    Nama Kategori
                </label>
                <input type="text" id="namaKategori"
                    placeholder="Contoh: Pakaian Dalam, Elektronik..."
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-xs
                           rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                           focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300"/>
                <p class="mt-1 text-[10.5px] text-gray-400">Gunakan nama yang singkat dan mudah dikenali</p>
            </div>
            <div>
                <label class="block mb-1.5 text-[10px] font-medium text-gray-400 uppercase tracking-wide">
                    Status
                </label>
                <div class="flex items-center justify-between px-3 py-2.5 bg-gray-50
                            border border-gray-200 rounded-lg">
                    <div>
                        <p id="statusLabel" class="text-xs text-gray-800 font-medium">Aktif</p>
                        <p class="text-[10.5px] text-gray-400">Kategori tersedia untuk produk</p>
                    </div>
                    <label class="relative w-10 h-[22px] cursor-pointer">
                        <input type="checkbox" id="statusToggle" class="sr-only peer" checked
                            onchange="syncLabel('statusToggle','statusLabel')">
                        <div class="w-10 h-[22px] bg-gray-200 rounded-full peer-checked:bg-orange-500
                                    after:content-[''] after:absolute after:top-[3px] after:left-[3px]
                                    after:bg-white after:rounded-full after:w-4 after:h-4
                                    after:transition-all peer-checked:after:translate-x-[18px] transition-colors">
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
            <button onclick="closeModal('modalKategori')"
                class="px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-200
                       rounded-lg hover:bg-gray-50 active:scale-[.98] transition-all">
                Batal
            </button>
            <button type="button"
                class="px-4 py-2 text-xs font-medium text-white bg-orange-500 hover:bg-orange-600
                       rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                Simpan
            </button>
        </div>
    </div>
</div>

{{-- ===== MODAL HAPUS ===== --}}
<div id="modalHapus"
    class="modal-overlay hidden fixed inset-0 z-50 flex items-start justify-center pt-20 px-4">
    <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
    <div class="modal-box relative bg-white rounded-2xl w-full max-w-md border border-gray-200
                transform scale-95 opacity-0 transition-all duration-200 origin-top">

        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-md bg-red-50 flex items-center justify-center">
                    <svg class="w-3 h-3 text-red-600" fill="none" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="2"/>
                        <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"
                            stroke="currentColor" stroke-width="2"/>
                        <path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="text-sm font-medium text-gray-800">Konfirmasi Hapus</h3>
            </div>
            <button onclick="closeModal('modalHapus')"
                class="w-6 h-6 rounded-md border border-gray-200 flex items-center justify-center
                       text-gray-400 hover:bg-gray-100 transition">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>

        <div class="px-5 py-6 text-center">
            <div class="w-11 h-11 rounded-full bg-red-50 border border-red-200
                        flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"
                        stroke="currentColor" stroke-width="1.8"/>
                    <line x1="12" y1="9" x2="12" y2="13" stroke="currentColor" stroke-width="1.8"/>
                    <line x1="12" y1="17" x2="12.01" y2="17" stroke="currentColor" stroke-width="1.8"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-gray-800 mb-1.5">
                Hapus kategori "<span id="hapusNama" class="text-red-600">—</span>"?
            </p>
            <p class="text-xs text-gray-400 leading-relaxed">
                <span class="font-medium text-red-500">Tindakan ini tidak dapat dibatalkan.</span><br>
                Produk terkait akan kehilangan kategorinya.
            </p>
        </div>

        <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
            <button onclick="closeModal('modalHapus')"
                class="px-4 py-2 text-xs font-medium text-gray-700 bg-white border border-gray-200
                       rounded-lg hover:bg-gray-50 active:scale-[.98] transition-all">
                Batal
            </button>
            <button type="button"
                class="px-4 py-2 text-xs font-medium text-white bg-red-600 hover:bg-red-700
                       rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                Hapus Permanen
            </button>
        </div>
    </div>
</div>

@endpush


@push('styles')
<style>
    /* ── ROW ANIMATION ── */
    @keyframes rowIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .row-anim {
        animation: rowIn .22s ease both;
    }

    /* ── MODAL OPEN STATE ── */
    .modal-overlay.is-open .modal-backdrop {
        background: rgba(0,0,0,.3) !important;
    }
    .modal-overlay.is-open .modal-box {
        transform: scale(1) !important;
        opacity: 1 !important;
    }

    /* ── PILL ACTIVE ── */
    .pill-btn.on {
        background: white;
        color: #ea580c;
        font-weight: 500;
        box-shadow: 0 0 0 0.5px #e5e7eb;
    }
</style>
@endpush


@push('scripts')
<script>
    const PER_PAGE = 7;
    let curPage    = 1;
    let curFilter  = 'semua';
    let curKw      = '';

    /* ── COLLECT ALL ROWS ── */
    const allRows = Array.from(document.querySelectorAll('#tbody .tbl-row'));

    function getFiltered() {
        return allRows.filter(function(r) {
            const nm  = r.dataset.name   || '';
            const st  = r.dataset.status || '';
            const matchKw = !curKw || nm.includes(curKw);
            const matchF  = curFilter === 'semua' || st === curFilter;
            return matchKw && matchF;
        });
    }

    function render() {
        const filtered   = getFiltered();
        const total      = filtered.length;
        const totalPages = Math.max(1, Math.ceil(total / PER_PAGE));
        if (curPage > totalPages) curPage = totalPages;

        const start = (curPage - 1) * PER_PAGE;
        const end   = start + PER_PAGE;

        /* hide all rows first */
        allRows.forEach(function(r) {
            r.style.display = 'none';
            r.classList.remove('row-anim');
        });

        const empty = document.getElementById('emptyState');

        if (total === 0) {
            empty.classList.remove('hidden');
            document.getElementById('tblInfo').textContent = 'Tidak ada data';
            document.getElementById('pgnWrap').innerHTML   = '';
            return;
        }
        empty.classList.add('hidden');

        /* show page rows with staggered animation */
        filtered.slice(start, end).forEach(function(r, i) {
            r.style.display = '';
            /* update row number */
            const numCell = r.querySelector('.row-num');
            if (numCell) numCell.textContent = start + i + 1;
            /* reflow to restart animation */
            void r.offsetWidth;
            r.style.animationDelay = (i * 35) + 'ms';
            r.classList.add('row-anim');
        });

        const s = start + 1, e = Math.min(end, total);
        document.getElementById('tblInfo').textContent =
            'Menampilkan ' + s + '–' + e + ' dari ' + total + ' kategori';

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        const wrap = document.getElementById('pgnWrap');
        if (totalPages <= 1) { wrap.innerHTML = ''; return; }

        const btnBase = 'w-7 h-7 rounded-md border text-xs font-medium flex items-center justify-center transition-all cursor-pointer ';
        const btnNorm = btnBase + 'border-gray-200 text-gray-600 hover:bg-gray-100 ';
        const btnCur  = btnBase + 'border-orange-500 bg-orange-500 text-white ';
        const btnDis  = btnBase + 'border-gray-100 text-gray-300 cursor-not-allowed ';

        let html = '';

        /* prev */
        if (curPage === 1) {
            html += '<button class="' + btnDis + '" disabled>‹</button>';
        } else {
            html += '<button class="' + btnNorm + '" onclick="goPage(' + (curPage - 1) + ')">‹</button>';
        }

        /* page numbers */
        let rangeStart = Math.max(1, curPage - 2);
        let rangeEnd   = Math.min(totalPages, curPage + 2);

        if (rangeStart > 1) {
            html += '<button class="' + btnNorm + '" onclick="goPage(1)">1</button>';
            if (rangeStart > 2) html += '<span class="text-xs text-gray-400 px-0.5">…</span>';
        }
        for (let p = rangeStart; p <= rangeEnd; p++) {
            html += '<button class="' + (p === curPage ? btnCur : btnNorm) + '" onclick="goPage(' + p + ')">' + p + '</button>';
        }
        if (rangeEnd < totalPages) {
            if (rangeEnd < totalPages - 1) html += '<span class="text-xs text-gray-400 px-0.5">…</span>';
            html += '<button class="' + btnNorm + '" onclick="goPage(' + totalPages + ')">' + totalPages + '</button>';
        }

        /* next */
        if (curPage === totalPages) {
            html += '<button class="' + btnDis + '" disabled>›</button>';
        } else {
            html += '<button class="' + btnNorm + '" onclick="goPage(' + (curPage + 1) + ')">›</button>';
        }

        wrap.innerHTML = html;
    }

    function goPage(p) {
        const tp = Math.max(1, Math.ceil(getFiltered().length / PER_PAGE));
        if (p < 1 || p > tp) return;
        curPage = p;
        render();
    }

    function onSearch() {
        curKw   = document.getElementById('srchInput').value.toLowerCase().trim();
        curPage = 1;
        render();
    }

    function setPill(el) {
        document.querySelectorAll('.pill-btn').forEach(function(p) {
            p.classList.remove('on');
            p.classList.add('text-gray-500');
        });
        el.classList.add('on');
        el.classList.remove('text-gray-500');
        curFilter = el.dataset.f;
        curPage   = 1;
        render();
    }

    function resetFilter() {
        document.getElementById('srchInput').value = '';
        curKw     = '';
        curFilter = 'semua';
        curPage   = 1;
        document.querySelectorAll('.pill-btn').forEach(function(p) {
            p.classList.remove('on');
            p.classList.add('text-gray-500');
        });
        document.querySelector('.pill-btn[data-f="semua"]').classList.add('on');
        document.querySelector('.pill-btn[data-f="semua"]').classList.remove('text-gray-500');
        render();
    }

    /* ── MODAL ── */
    function openModal(id) {
        const ov = document.getElementById(id);
        ov.classList.remove('hidden');
        /* force reflow before adding open class so transition fires */
        void ov.offsetWidth;
        ov.classList.add('is-open');
    }

    function closeModal(id) {
        const ov = document.getElementById(id);
        ov.classList.remove('is-open');
        /* wait for transition then hide */
        setTimeout(function() {
            ov.classList.add('hidden');
        }, 200);
    }

    /* close on backdrop click */
    document.querySelectorAll('.modal-overlay').forEach(function(ov) {
        ov.querySelector('.modal-backdrop').addEventListener('click', function() {
            closeModal(ov.id);
        });
    });

    function setModalKategori(mode, nama = '', aktif = true) {
        const isTambah = mode === 'tambah';
        document.getElementById('modalKategoriTitle').textContent =
            isTambah ? 'Tambah Kategori' : 'Edit Kategori';

        const icon    = document.getElementById('modalKategoriIcon');
        const iconSvg = document.getElementById('modalKategoriIconSvg');

        if (isTambah) {
            icon.className    = 'w-6 h-6 rounded-md bg-orange-50 flex items-center justify-center';
            iconSvg.className = 'w-3 h-3 text-orange-500';
            document.getElementById('namaKategori').value = '';
            document.getElementById('statusToggle').checked = true;
        } else {
            icon.className    = 'w-6 h-6 rounded-md bg-green-50 flex items-center justify-center';
            iconSvg.className = 'w-3 h-3 text-green-600';
            document.getElementById('namaKategori').value = nama;
            document.getElementById('statusToggle').checked = aktif;
        }
        syncLabel('statusToggle', 'statusLabel');
    }

    function setModalHapus(nama) {
        document.getElementById('hapusNama').textContent = nama;
    }

    function syncLabel(cbId, labelId) {
        const cb = document.getElementById(cbId);
        document.getElementById(labelId).textContent = cb.checked ? 'Aktif' : 'Nonaktif';
    }

    /* ── INIT ── */
    render();
</script>
@endpush