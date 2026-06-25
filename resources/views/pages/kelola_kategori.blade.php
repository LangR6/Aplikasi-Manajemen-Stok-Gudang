@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="space-y-3">

        {{-- TOOLBAR --}}
        <form method="GET" action="{{ route('kelola_kategori') }}" id="filterForm">
            <div class="flex flex-wrap items-center gap-3">

                {{-- SEARCH --}}
                <div class="relative w-full sm:flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                        onchange="document.getElementById('filterForm').submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
                </div>

                {{-- PILL FILTER --}}
                <div
                    class="flex items-center gap-1 bg-white p-1 rounded-lg border border-gray-200
                            w-full sm:w-auto justify-between sm:justify-start">
                    <button type="submit" name="status" value="semua"
                        class="pill-btn {{ !request('status') || request('status') === 'semua' ? 'on' : 'text-gray-500' }}
                               px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-150 hover:text-orange-500">
                        Semua
                    </button>
                    <button type="submit" name="status" value="aktif"
                        class="pill-btn {{ request('status') === 'aktif' ? 'on' : 'text-gray-500' }}
                               px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-150 hover:text-orange-500">
                        Aktif
                    </button>
                    <button type="submit" name="status" value="nonaktif"
                        class="pill-btn {{ request('status') === 'nonaktif' ? 'on' : 'text-gray-500' }}
                               px-3 py-1.5 rounded-md text-sm font-medium transition-all duration-150 hover:text-orange-500">
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
        </form>

        {{-- ACTIVE FILTER TAGS --}}
        @if (request('search') || (request('status') && request('status') !== 'semua'))
            <div class="flex flex-wrap items-center gap-2">

                @if (request('status') && request('status') !== 'semua')
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-[#205375] text-white">
                        {{ ucfirst(request('status')) }}
                        <a href="{{ route('kelola_kategori', array_merge(request()->except(['status', 'page']))) }}"
                            class="ml-1 font-bold hover:text-gray-200">×</a>
                    </span>
                @endif

                @if (request('search'))
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8" />
                            <path d="M21 21l-4.35-4.35" />
                        </svg>
                        "{{ request('search') }}"
                        <a href="{{ route('kelola_kategori', array_merge(request()->except(['search', 'page']))) }}"
                            class="ml-1 text-gray-500 hover:text-gray-700 font-bold">×</a>
                    </span>
                @endif

                <a href="{{ route('kelola_kategori') }}"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-gray-500 hover:text-red-500 underline underline-offset-2 transition">
                    Reset semua
                </a>

            </div>
        @endif

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
                            <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wide">No
                            </th>
                            <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">Nama Kategori
                            </th>
                            <th class="px-4 py-3 text-xs font-semibold text-white uppercase tracking-wide">Status</th>
                            @if (session('role') === 'admin')
                                <th class="px-4 py-3 text-center text-xs font-semibold text-white uppercase tracking-wide">
                                    Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $dataku)
                            <tr class="border-b border-gray-100 {{ $loop->even ? '' : 'bg-gray-50/60' }}">
                                <td class="px-4 py-2.5 text-center text-sm font-medium text-gray-800">
                                    {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
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
                                                onclick="openModal('modalKategori'); setModalKategori('edit', {{ json_encode($dataku['nama_kategori']) }}, {{ $dataku['status'] ? 'true' : 'false' }}, {{ json_encode($dataku['id_kategori']) }})"
                                                class="px-3 py-1 rounded-md text-sm font-medium border border-orange-200
                                                       text-orange-800 bg-orange-100 hover:bg-orange-500 hover:text-white
                                                       active:scale-[.98] hover:-translate-y-px transition-all">
                                                Edit
                                            </button>
                                            <button type="button"
                                                onclick="openModal('modalHapus'); setModalHapus({{ json_encode($dataku['nama_kategori']) }}, {{ json_encode($dataku['id_kategori']) }})"
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
                    <div class="px-4 py-3 {{ $loop->even ? '' : 'bg-gray-50/60' }}">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <span
                                    class="shrink-0 w-6 h-6 rounded-full bg-[#205375] text-white
                                             text-xs font-semibold flex items-center justify-center">
                                    {{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}
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
                                        onclick="openModal('modalKategori'); setModalKategori('edit', {{ json_encode($dataku['nama_kategori']) }}, {{ $dataku['status'] ? 'true' : 'false' }}, {{ json_encode($dataku['id_kategori']) }})"
                                        class="p-1.5 rounded-md border border-orange-200 text-orange-700
                                               bg-orange-50 hover:bg-orange-500 hover:text-white
                                               active:scale-[.98] transition-all"
                                        title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button type="button"
                                        onclick="openModal('modalHapus'); setModalHapus({{ json_encode($dataku['nama_kategori']) }}, {{ json_encode($dataku['id_kategori']) }})"
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
            @if ($data->isEmpty())
                <div class="py-12 text-center">
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
                    <a href="{{ route('kelola_kategori') }}"
                        class="inline-flex items-center gap-1.5 bg-[#F66B0E] hover:bg-orange-600
                               text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                        Tampilkan Semua
                    </a>
                </div>
            @endif

            {{-- FOOTER PAGINATION --}}
            <div class="px-4 py-2.5 border-t border-gray-100 flex flex-wrap items-center justify-between gap-2">
                <span class="text-sm text-gray-400 w-full text-center sm:w-auto sm:text-left">
                    @if ($data->total())
                        Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} kategori
                    @else
                        Tidak ada kategori
                    @endif
                </span>
                <div class="w-full sm:w-auto flex justify-center sm:justify-end gap-1">
                    @if ($data->onFirstPage())
                        <span
                            class="w-8 h-8 rounded-md border border-gray-100 text-sm font-medium flex items-center justify-center text-gray-300 cursor-not-allowed">‹</span>
                    @else
                        <a href="{{ $data->previousPageUrl() }}"
                            class="w-8 h-8 rounded-md border border-gray-300 text-sm font-medium flex items-center justify-center text-gray-600 hover:border-orange-500 hover:text-orange-500 transition-all">‹</a>
                    @endif

                    @foreach ($data->links()->elements[0] as $page => $url)
                        @if (is_string($page))
                            <span class="text-sm text-gray-400 px-0.5">…</span>
                        @elseif ($page == $data->currentPage())
                            <span
                                class="w-8 h-8 rounded-md border border-[#F66B0E] bg-[#F66B0E] text-white text-sm font-medium flex items-center justify-center">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="w-8 h-8 rounded-md border border-gray-300 text-sm font-medium flex items-center justify-center text-gray-600 hover:border-orange-500 hover:text-orange-500 transition-all">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($data->hasMorePages())
                        <a href="{{ $data->nextPageUrl() }}"
                            class="w-8 h-8 rounded-md border border-gray-300 text-sm font-medium flex items-center justify-center text-gray-600 hover:border-orange-500 hover:text-orange-500 transition-all">›</a>
                    @else
                        <span
                            class="w-8 h-8 rounded-md border border-gray-100 text-sm font-medium flex items-center justify-center text-gray-300 cursor-not-allowed">›</span>
                    @endif
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
                <h3 id="modalKategoriTitle" class="text-[16px] font-semibold text-white">Tambah Kategori</h3>
                <button type="button" onclick="closeModal('modalKategori')"
                    class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center
                           text-white hover:bg-white/30 transition">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <form id="formKategori" method="POST" action="{{ route('kelola_kategori.store') }}">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="px-5 py-5 space-y-4">
                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                            Nama Kategori
                        </label>
                        <input type="text" name="nama_kategori" id="namaKategori" placeholder="Contoh: Sepatu..."
                            oninput="clearAlert('alertKategori', 'namaKategori')" value="{{ old('nama_kategori') }}"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                                   rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                                   focus:ring-orange-400 focus:border-transparent transition
                                   placeholder-gray-300 @error('nama_kategori') input-error @enderror" />

                        {{-- error JS: field kosong --}}
                        <x-input-error id="alertKategori" message="Nama kategori wajib diisi." />

                        {{-- error Laravel: required / unique --}}
                        @error('nama_kategori')
                            <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                            Status
                        </label>
                        <div
                            class="flex items-center justify-between px-3 py-2.5 bg-gray-50
                                    border border-gray-200 rounded-lg">
                            <p id="statusLabel" class="text-sm font-semibold status-label-aktif">Aktif</p>
                            <label class="cursor-pointer"
                                style="display:inline-block;width:40px;height:22px;position:relative;">
                                <input type="checkbox" id="statusToggle" class="sr-only" checked
                                    onchange="syncLabel('statusToggle','statusLabel'); syncToggleColor(this)">
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
        // data dari server untuk restore modal jika ada error validasi
        const serverData = {
            hasError: {{ $errors->has('nama_kategori') ? 'true' : 'false' }},
            oldNama: @json(old('nama_kategori', '')),
            oldStatus: @json(old('status', 'aktif')),
            oldMode: @json(old('_form_mode', 'tambah')), // ← dari old(), bukan session
            oldId: @json(old('id_kategori', '')), // ← dari old(), bukan session
            errorMsg: @json($errors->first('nama_kategori')),
        };

        // ===== MODAL =====
        function openModal(id) {
            const ov = document.getElementById(id);
            ov.classList.remove('hidden');
            ov.classList.add('flex');
            void ov.offsetWidth;
            ov.classList.add('is-open');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            const ov = document.getElementById(id);
            ov.classList.remove('is-open');
            setTimeout(() => {
                ov.classList.remove('flex');
                ov.classList.add('hidden');
                // cek apakah masih ada modal lain yang terbuka sebelum buka scroll lagi
                const anyOpen = ['modalKategori', 'modalHapus'].some(i => {
                    const el = document.getElementById(i);
                    return el && !el.classList.contains('hidden');
                });
                if (!anyOpen) document.body.style.overflow = '';
            }, 200);
        }

        document.querySelectorAll('.modal-overlay').forEach(ov => {
            ov.querySelector('.modal-backdrop').addEventListener('click', () => closeModal(ov.id));
        });

        // ===== MODAL KATEGORI =====
        function setModalKategori(mode, nama, aktif, id, hapusError = true) {
            if (nama === undefined) nama = '';
            if (aktif === undefined) aktif = true;
            if (id === undefined) id = null;

            const isTambah = mode === 'tambah';
            document.getElementById('modalKategoriTitle').textContent =
                isTambah ? 'Tambah Kategori' : 'Edit Kategori';

            document.getElementById('namaKategori').value = isTambah ? '' : nama.trim();
            document.getElementById('statusToggle').checked = isTambah ? true : aktif;

            const form = document.getElementById('formKategori');
            if (isTambah) {
                form.action = "{{ route('kelola_kategori.store') }}";
                document.getElementById('formMethod').value = 'POST';
            } else {
                form.action = "{{ url('kategori') }}" + '/' + id;
                document.getElementById('formMethod').value = 'PUT';
            }

            clearAlert('alertKategori', 'namaKategori');
            syncLabel('statusToggle', 'statusLabel');
            syncToggleColor(document.getElementById('statusToggle'));
            syncStatusValue();

            // hapus pesan error Laravel saat modal dibuka
            document.querySelectorAll('#formKategori .text-red-600').forEach(el => {
                if (el.id !== 'alertKategori') el.remove();
            });
            document.getElementById('namaKategori').classList.remove('input-error');
        }

        function simpanKategori() {
            const input = document.getElementById('namaKategori');
            const alertEl = document.getElementById('alertKategori');

            if (!input.value.trim()) {
                alertEl.classList.remove('hidden');
                alertEl.classList.add('flex');
                input.classList.add('input-error');
                input.focus();
                return;
            }

            document.getElementById('formKategori').submit();
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
            const isChecked = document.getElementById('statusToggle').checked;
            document.getElementById('statusValue').value = isChecked ? 'aktif' : 'nonaktif';
        }

        document.getElementById('statusToggle').addEventListener('change', syncStatusValue);

        // ===== MODAL HAPUS =====
        function setModalHapus(nama, id) {
            document.getElementById('formHapus').action = "{{ url('kategori') }}" + '/' + id;
            document.getElementById('hapusNama').textContent = nama;
        }

        function clearAlert(alertId, inputId) {
            const alertEl = document.getElementById(alertId);
            const input = document.getElementById(inputId);
            alertEl.classList.add('hidden');
            alertEl.classList.remove('flex');
            if (input) input.classList.remove('input-error');

            // hapus pesan error Laravel juga
            document.querySelectorAll('#formKategori p.text-red-600').forEach(el => {
                if (el.id !== alertId) el.remove();
            });
        }

        // ===== BUKA MODAL OTOMATIS JIKA ADA ERROR VALIDASI =====
        @if ($errors->has('nama_kategori'))
            document.addEventListener('DOMContentLoaded', () => {
                openModal('modalKategori');

                const isEdit = serverData.oldMode === 'edit' && serverData.oldId;

                document.getElementById('modalKategoriTitle').textContent =
                    isEdit ? 'Edit Kategori' : 'Tambah Kategori';

                const form = document.getElementById('formKategori');
                if (isEdit) {
                    form.action = "{{ url('kategori') }}" + '/' + serverData.oldId;
                    document.getElementById('formMethod').value = 'PUT';
                } else {
                    form.action = "{{ route('kelola_kategori.store') }}";
                    document.getElementById('formMethod').value = 'POST';
                }

                document.getElementById('namaKategori').value = serverData.oldNama;

                const isAktif = serverData.oldStatus === 'aktif';
                document.getElementById('statusToggle').checked = isAktif;
                syncLabel('statusToggle', 'statusLabel');
                syncToggleColor(document.getElementById('statusToggle'));
                syncStatusValue();
            });
        @endif

        // ===== INIT =====
        syncToggleColor(document.getElementById('statusToggle'));
        syncStatusValue();
    </script>
@endpush
