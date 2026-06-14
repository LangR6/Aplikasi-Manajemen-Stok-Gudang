@extends('layouts.app')

@section('title', 'Kelola Barang')

@section('content')
    <div class="space-y-3">

        {{-- ── TOOLBAR ── --}}
        <form method="GET" action="{{ route('kelola_barang') }}" id="filterForm">
            <div class="flex flex-wrap items-center gap-3">

                {{-- Search --}}
                <div class="relative w-full sm:flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari kode atau nama barang..."
                        onchange="document.getElementById('filterForm').submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
                </div>

                {{-- Filter Status & Kategori --}}
                <div class="flex gap-3 w-full sm:w-auto sm:contents">
                    <select name="status" onchange="document.getElementById('filterForm').submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-orange-500 focus:border-orange-500 pr-9 p-2.5 cursor-pointer
                           flex-1 sm:flex-none">
                        <option value="">Semua Status</option>
                        <option value="Baru" {{ request('status') === 'Baru' ? 'selected' : '' }}>Baru</option>
                        <option value="Tersedia" {{ request('status') === 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Menipis" {{ request('status') === 'Menipis' ? 'selected' : '' }}>Menipis</option>
                        <option value="Habis" {{ request('status') === 'Habis' ? 'selected' : '' }}>Habis</option>
                    </select>

                    <select name="kategori" onchange="document.getElementById('filterForm').submit()"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                           rounded-lg focus:ring-orange-500 focus:border-orange-500 pr-9 p-2.5 cursor-pointer
                           flex-1 sm:flex-none">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategori as $kat)
                            <option value="{{ $kat['nama_kategori'] }}"
                                {{ request('kategori') === $kat['nama_kategori'] ? 'selected' : '' }}>
                                {{ $kat['nama_kategori'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Tambah --}}
                @if (session('role') === 'admin')
                    <button type="button" onclick="openModal('tambah')"
                        class="flex items-center justify-center gap-2 bg-[#F66B0E] hover:bg-orange-600 active:scale-[.98]
                             text-white text-sm font-medium px-6 py-2.5 rounded-lg transition-all whitespace-nowrap
                             w-full sm:w-auto">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 18 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M9 1v16M1 9h16" />
                        </svg>
                        Tambah Barang
                    </button>
                @endif
            </div>
        </form>

        {{-- ACTIVE FILTER TAGS --}}
        @if (request('search') || request('status') || request('kategori'))
            <div class="flex flex-wrap items-center gap-2">

                @if (request('status'))
                    @php
                        $statusColor = match (request('status')) {
                            'Baru' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'Tersedia' => 'bg-green-100 text-green-700 border-green-200',
                            'Menipis' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                            'Habis' => 'bg-red-100 text-red-700 border-red-200',
                            default => 'bg-gray-100 text-gray-700 border-gray-200',
                        };
                    @endphp
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $statusColor }}">
                        {{ request('status') }}
                        <a href="{{ route('kelola_barang', array_merge(request()->except(['status', 'page']))) }}"
                            class="ml-1 font-bold opacity-60 hover:opacity-100">×</a>
                    </span>
                @endif

                @if (request('kategori'))
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-[#205375] text-white">
                        {{ request('kategori') }}
                        <a href="{{ route('kelola_barang', array_merge(request()->except(['kategori', 'page']))) }}"
                            class="ml-1 font-bold opacity-60 hover:opacity-100">×</a>
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
                        <a href="{{ route('kelola_barang', array_merge(request()->except(['search', 'page']))) }}"
                            class="ml-1 text-gray-500 hover:text-gray-700 font-bold">×</a>
                    </span>
                @endif

                <a href="{{ route('kelola_barang') }}"
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-gray-500 hover:text-red-500 underline underline-offset-2 transition">
                    Reset semua
                </a>

            </div>
        @endif

        {{-- ── GRID CARDS ── --}}
        @if ($data->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3 sm:gap-4">
                @foreach ($data as $b)
                    @php
                        $isBaru = $b['is_baru'];
                        $stok = $b['stok'];
                        $status = $isBaru ? 'Baru' : ($stok === 0 ? 'Habis' : ($stok <= 5 ? 'Menipis' : 'Tersedia'));
                        $stokCls = $isBaru
                            ? 'stok-blue'
                            : ($stok === 0
                                ? 'stok-red'
                                : ($stok <= 5
                                    ? 'stok-yellow'
                                    : 'stok-green'));
                        $bdgCls = $isBaru
                            ? 'badge-blue'
                            : ($stok === 0
                                ? 'badge-red'
                                : ($stok <= 5
                                    ? 'badge-yellow'
                                    : 'badge-green'));
                        $imgSrc = $b['foto_url'] ?? 'https://placehold.co/200x200?text=No+Image';
                        $imgStyle = $b['foto_url'] ? '' : 'opacity:0.35;';

                        // Siapkan data untuk JavaScript dengan JSON encoding — stok ikut dikirim
                        $barangData = json_encode([
                            'kode' => $b['kode'],
                            'nama' => $b['nama'],
                            'kategori' => $b['kategori'],
                            'id_kategori' => $b['id_kategori'],
                            'foto_url' => $b['foto_url'] ?? '',
                            'stok' => $b['stok'],
                        ]);
                    @endphp

                    <div class="card-barang">
                        @if (session('role') === 'admin')
                            <div class="menu-aksi-wrap">
                                <button class="menu-aksi-btn" onclick="toggleMenu(this)">⋮</button>
                                <div class="menu-aksi hidden">
                                    <button onclick="openEditModal({{ $barangData }})"
                                        class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        ✏️ Edit
                                    </button>
                                </div>
                            </div>
                        @endif

                        <div class="card-img-wrap">
                            <img src="{{ $imgSrc }}" alt="{{ $b['nama'] }}" style="{{ $imgStyle }}">
                        </div>

                        <div class="card-info">
                            <h3 class="font-semibold text-sm text-[#112B3C] leading-tight mb-0.5 truncate"
                                title="{{ $b['nama'] }}">{{ $b['nama'] }}</h3>
                            <p class="text-xs text-gray-400 mb-2">
                                {{ $b['kode'] ? $b['kode'] . ' · ' : '' }}{{ $b['kategori'] }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-sm {{ $stokCls }}">Stok: {{ $stok }}</span>
                                <span class="badge {{ $bdgCls }}">{{ $status }}</span>
                            </div>

                            @if (session('role') === 'admin')
                                <div class="flex gap-2 mt-2">
                                    <button
                                        onclick="openModal('keluar', {{ json_encode($b['kode']) }}, {{ json_encode($b['nama']) }}, {{ json_encode($b['kategori']) }}, {{ $b['stok'] }})"
                                        title="Barang Keluar"
                                        class="flex-1 h-9 bg-red-500 text-white rounded-lg flex items-center justify-center
                                               hover:bg-red-600 transition text-lg font-bold leading-none">−</button>
                                    <button
                                        onclick="openModal('masuk', {{ json_encode($b['kode']) }}, {{ json_encode($b['nama']) }}, {{ json_encode($b['kategori']) }}, {{ $b['stok'] }})"
                                        title="Barang Masuk"
                                        class="flex-1 h-9 bg-green-500 text-white rounded-lg flex items-center justify-center
                                               hover:bg-green-600 transition text-lg font-bold leading-none">+</button>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="py-12 text-center border border-gray-300 rounded-xl">
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
                <a href="{{ route('kelola_barang') }}"
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
                    Menampilkan {{ $data->firstItem() }}–{{ $data->lastItem() }} dari {{ $data->total() }} barang
                @else
                    Tidak ada barang
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
@endsection


@push('modals')

    {{-- MODAL TAMBAH BARANG / BARANG MASUK / BARANG KELUAR --}}
    <div id="modalCatatBarang" class="modal-overlay hidden fixed inset-0 z-50 items-center justify-center pt-10 px-4">
        <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
        <div
            class="modal-box relative bg-white rounded-2xl w-full max-w-md
            transform scale-95 opacity-0 transition-all duration-200 origin-top">

            <div id="mhdr" class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
                <h3 id="mhdrTitle" class="text-[16px] font-semibold text-white">Tambah Barang</h3>
                <button type="button" onclick="closeOverlay('modalCatatBarang')"
                    class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <form id="formTambahBarang" method="POST" action="{{ route('kelola_barang.store') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formBarangMethod" value="POST">
                <input type="hidden" name="mode" id="formBarangMode" value="tambah">
                <input type="hidden" name="nama_display" id="trNamaHidden">
                <input type="hidden" name="kategori_display" id="trKategoriHidden">

                <div class="px-5 py-5 space-y-4 max-h-[70vh] overflow-y-auto">

                    {{-- SECTION: TAMBAH BARANG BARU --}}
                    <div id="sectionTambah" class="hidden space-y-4">

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
                            <input id="imageInput" name="foto_barang" type="file" accept="image/*" class="hidden"
                                onchange="previewImage(event)">
                        </div>

                        @error('foto_barang')
                            <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                                    Kode Barang
                                </label>
                                <input id="tKode" name="kode_barang" type="text" placeholder="Contoh: BRG-001"
                                    value="{{ old('kode_barang') }}" oninput="clearErr('errTKode','tKode')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5
                                       @error('kode_barang') input-error @enderror" />
                                <x-input-error id="errTKode" message="Kode barang wajib diisi." />
                                {{-- error Laravel --}}
                                @error('kode_barang')
                                    <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
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
                                    Nama Barang
                                </label>
                                <input id="tNama" name="nama_barang" type="text" placeholder="Contoh: Kaos Polos"
                                    value="{{ old('nama_barang') }}" oninput="clearErr('errTNama','tNama')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5
                                       @error('nama_barang') input-error @enderror" />
                                <x-input-error id="errTNama" message="Nama barang wajib diisi." />
                                @error('nama_barang')
                                    <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                                Kategori
                            </label>
                            <select id="tKategori" name="id_kategori" oninput="clearErr('errTKategori','tKategori')"
                                onchange="clearErr('errTKategori','tKategori')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                                   rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5
                                   @error('id_kategori') input-error @enderror">
                                <option value="">— Pilih Kategori —</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat['id_kategori'] }}"
                                        {{ old('id_kategori') == $kat['id_kategori'] ? 'selected' : '' }}>
                                        {{ $kat['nama_kategori'] }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error id="errTKategori" message="Kategori wajib dipilih." />
                            @error('id_kategori')
                                <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- SECTION: BARANG MASUK / KELUAR --}}
                    <div id="sectionTransaksi" class="hidden space-y-4">

                        <input type="hidden" name="kode_barang_transaksi" id="trKodeBarang">

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
                                <input id="trKategoriDisplay" type="text" readonly
                                    class="bg-gray-100 border border-gray-200 text-gray-500 text-sm
                                           rounded-lg block w-full p-2.5 cursor-not-allowed" />
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-center gap-2 px-2 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                            <span class="text-sm text-gray-700">Stok saat ini</span>
                            <span id="trStokDisplay" class="text-sm font-semibold text-gray-900">
                                0
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label
                                    class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Jumlah</label>
                                <input id="trJumlah" name="jumlah" type="number" placeholder="Jumlah"
                                    value="{{ old('jumlah') }}" oninput="clearErr('errTrJumlah','trJumlah')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                           focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5
                                           @error('jumlah') input-error @enderror" />
                                <x-input-error id="errTrJumlah" message="Jumlah wajib diisi (> 0)." />
                                @error('jumlah')
                                    <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
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
                                <label
                                    class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Tanggal</label>
                                <input id="trTanggal" name="tanggal" type="date" value="{{ old('tanggal') }}"
                                    onchange="clearErr('errTrTanggal','trTanggal')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                           focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5
                                           @error('tanggal') input-error @enderror" />
                                <x-input-error id="errTrTanggal" message="Tanggal wajib diisi." />
                                @error('tanggal')
                                    <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                        <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Supplier --}}
                        <div id="fieldSupplier" class="hidden">
                            <label
                                class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Supplier</label>
                            <div class="relative">
                                <button type="button" id="supplierBtn" onclick="toggleSupplierDropdown()"
                                    class="w-full p-2.5 flex justify-between items-center text-sm rounded-lg border
                                    {{ $errors->has('id_supplier') ? 'bg-red-50 border-red-300' : 'bg-gray-50 border-gray-300' }}
                                    hover:border-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-400">
                                    <span id="supplierLabel" class="text-gray-400">Pilih Supplier</span>
                                    <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>
                                <input type="hidden" id="trSupplier" name="id_supplier"
                                    value="{{ old('id_supplier') }}">
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
                                                data-value="{{ $sup['id_supplier'] }}"
                                                data-label="{{ $sup['nama_supplier'] }}" onclick="selectSupplier(this)">
                                                {{ $sup['nama_supplier'] }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-input-error id="errTrSupplier" message="Supplier wajib dipilih." />
                            @error('id_supplier')
                                <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        {{-- Tujuan --}}
                        <div id="fieldTujuan" class="hidden">
                            <label
                                class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Tujuan</label>
                            <input id="trTujuan" name="tujuan" type="text" placeholder="Contoh: Toko Cabang A"
                                value="{{ old('tujuan') }}" oninput="clearErr('errTrTujuan','trTujuan')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5
                                       @error('tujuan') input-error @enderror" />
                            <x-input-error id="errTrTujuan" message="Tujuan wajib diisi." />
                            @error('tujuan')
                                <p class="err-laravel mt-1.5 text-xs text-red-600 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div>
                            <label
                                class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">Keterangan</label>
                            <textarea id="trCatatan" name="keterangan" rows="2" placeholder="Keterangan (opsional)"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5">{{ old('keterangan') }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
                    <button type="button" onclick="closeOverlay('modalCatatBarang')"
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
            </form>
        </div>
    </div>

{{-- MODAL EDIT BARANG --}}
    @if (session('role') === 'admin')
        <div id="modalEditBarang" class="modal-overlay hidden fixed inset-0 z-50 items-start justify-center pt-20 px-4">
            <div class="modal-backdrop absolute inset-0 bg-black/0 transition-all duration-200"></div>
            <div
                class="modal-box relative bg-white rounded-2xl w-full max-w-md
               transform scale-95 opacity-0 transition-all duration-200 origin-top">

                <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
                    <h3 class="text-[16px] font-semibold text-white">Edit Barang</h3>
                    <button type="button" onclick="closeOverlay('modalEditBarang')"
                        class="w-6 h-6 rounded-md bg-white/20 flex items-center justify-center text-white hover:bg-white/30 transition">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>

                <form id="formEditBarang" method="POST" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="px-5 py-5 space-y-4">

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
                            <input id="eImageInput" name="foto_barang" type="file" accept="image/*" class="hidden"
                                onchange="previewImageEdit(event)">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                                    Kode Barang
                                </label>
                                <input id="eKode" name="kode_barang" type="text" placeholder="Contoh: BRG-001"
                                    oninput="clearErr('errEKode','eKode')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                                <x-input-error id="errEKode" message="Kode barang wajib diisi." />
                            </div>
                            <div>
                                <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                                    Nama Barang
                                </label>
                                <input id="eNama" name="nama_barang" type="text" placeholder="Contoh: Kaos Polos"
                                    oninput="clearErr('errENama','eNama')"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                       focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5" />
                                <x-input-error id="errENama" message="Nama barang wajib diisi." />
                            </div>
                        </div>

                        <div>
                            <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                                Kategori
                            </label>
                            <select id="eKategori" name="id_kategori" onchange="clearErr('errEKategori','eKategori')"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                                   rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5">
                                <option value="">— Pilih Kategori —</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat['id_kategori'] }}">{{ $kat['nama_kategori'] }}</option>
                                @endforeach
                            </select>
                            <x-input-error id="errEKategori" message="Kategori wajib dipilih." />
                        </div>

                    </div>

                    <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100">
                        <button type="button" onclick="closeOverlay('modalEditBarang')"
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
                </form>
            </div>
        </div>
    @endif

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

        .card-barang {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            transition: box-shadow .2s, transform .2s;
            position: relative;
            overflow: visible;
            padding: 16px 16px 8px;
        }

        .card-barang:hover {
            box-shadow: 0 8px 24px rgba(17, 43, 60, .12);
            transform: translateY(-2px);
        }

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

        .card-info {
            padding: 10px 12px 12px;
        }

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

        .stok-blue {
            color: #2563eb;
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

        .badge-blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

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

        .input-error {
            border-color: #fca5a5 !important;
            background-color: #fff5f5 !important;
        }
    </style>
@endpush


@push('scripts')
    <script>
        // Helper: set warna stok
        function setStokDisplay(elId, stok) {
            const el = document.getElementById(elId);
            if (!el) return;
            el.textContent = stok;
        }

        // data dari server untuk restore modal jika ada error validasi
        const serverData = {
            hasEditError: {{ old('_edit_kode') && $errors->hasAny(['kode_barang', 'nama_barang', 'id_kategori', 'foto_barang']) ? 'true' : 'false' }},
            editOrigKode: @json(old('_edit_kode', '')),
            editKode: @json(old('kode_barang', '')),
            editNama: @json(old('nama_barang', '')),
            editKategori: @json(old('id_kategori', '')),
            editErrorKode: @json($errors->first('kode_barang')),
            editErrorNama: @json($errors->first('nama_barang')),
            editErrorKat: @json($errors->first('id_kategori')),

            hasTambahError: {{ !old('_edit_kode') && $errors->hasAny(['kode_barang', 'nama_barang', 'id_kategori', 'foto_barang']) ? 'true' : 'false' }},

            hasTrError: {{ $errors->hasAny(['jumlah', 'tanggal', 'id_supplier', 'tujuan', 'kode_barang_transaksi']) ? 'true' : 'false' }},
            trMode: @json(session('_last_modal', 'masuk')),
            trKode: @json(session('_last_kode', '')),
            trNama: @json(session('_last_nama', '')),
            trKategori: @json(session('_last_kategori', '')),
            trStok: @json(session('_last_stok', 0)),
            trSupplier: @json(old('id_supplier', '')),
        };

        const isAdmin = {{ session('role') === 'admin' ? 'true' : 'false' }};

        // ── MENU AKSI ──
        function toggleMenu(btn) {
            const menu = btn.nextElementSibling;
            document.querySelectorAll('.menu-aksi').forEach(m => {
                if (m !== menu) m.classList.add('hidden');
            });
            menu.classList.toggle('hidden');
        }

        // ── MODAL OPEN / CLOSE ──
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
                const anyOpen = ['modalCatatBarang', 'modalEditBarang'].some(i => {
                    const el = document.getElementById(i);
                    return el && !el.classList.contains('hidden');
                });
                if (!anyOpen) document.body.style.overflow = '';
            }, 200);
        }

        document.querySelectorAll('.modal-overlay').forEach(ov => {
            const backdrop = ov.querySelector('.modal-backdrop');
            if (backdrop) backdrop.addEventListener('click', () => closeOverlay(ov.id));
        });

        // ── MODAL TAMBAH / MASUK / KELUAR ──
        let currentMode = 'tambah';

        const modeConfig = {
            tambah: {
                title: 'Tambah Barang Baru',
                bg: '#F66B0E'
            },
            masuk: {
                title: 'Barang Masuk',
                bg: '#16a34a'
            },
            keluar: {
                title: 'Barang Keluar',
                bg: '#dc2626'
            },
        };

        function openModal(mode, kode = '', nama = '', kategori = '', stok = 0) {
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
                document.getElementById('trKodeBarang').value = kode;
                document.getElementById('trNama').value = nama;
                document.getElementById('trKategoriDisplay').value = kategori;
                document.getElementById('trNamaHidden').value = nama;
                document.getElementById('trKategoriHidden').value = kategori;
                document.getElementById('trJumlah').value = '';
                document.getElementById('trTanggal').value = '';
                document.getElementById('trCatatan').value = '';

                // Tampilkan stok dengan warna sesuai kondisi
                setStokDisplay('trStokDisplay', stok);

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
                if (!jumlah || jumlah.trim() === '') {
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

            const form = document.getElementById('formTambahBarang');
            if (currentMode === 'tambah') form.action = "{{ route('kelola_barang.store') }}";
            else if (currentMode === 'masuk') form.action = "{{ route('kelola_barang.masuk') }}";
            else form.action = "{{ route('kelola_barang.keluar') }}";

            document.getElementById('formBarangMethod').value = 'POST';
            document.getElementById('formBarangMode').value = currentMode;
            form.submit();
        }

        // ── MODAL EDIT ──
        function openEditModal(data) {
            document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'));
            document.getElementById('formEditBarang').action = '/kelola_barang/' + data.kode;
            document.getElementById('eKode').value = data.kode;
            document.getElementById('eNama').value = data.nama;
            document.getElementById('eKategori').value = data.id_kategori;

            const prev = document.getElementById('eImagePreview');
            const placeholder = document.getElementById('eImageUploadPlaceholder');
            if (data.foto_url) {
                prev.src = data.foto_url;
                prev.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                prev.src = '';
                prev.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }

            clearAllErrors();
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
            document.getElementById('formEditBarang').submit();
        }

        // ── PREVIEW FOTO ──
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

        // ── SUPPLIER DROPDOWN ──
        function toggleSupplierDropdown() {
            const dd = document.getElementById('supplierDropdown');
            dd.classList.toggle('hidden');
            if (!dd.classList.contains('hidden')) document.getElementById('supplierSearch').focus();
        }

        function selectSupplier(el) {
            document.getElementById('trSupplier').value = el.dataset.value;
            document.getElementById('supplierLabel').textContent = el.dataset.label;
            document.getElementById('supplierLabel').classList.replace('text-gray-400', 'text-gray-900');
            document.getElementById('supplierDropdown').classList.add('hidden');
            document.getElementById('errTrSupplier').style.display = 'none';
            document.querySelectorAll('#fieldSupplier .err-laravel').forEach(el => el.remove());
        }

        function filterSupplier() {
            const kw = document.getElementById('supplierSearch').value.toLowerCase();
            document.querySelectorAll('.supplier-item').forEach(item =>
                item.style.display = item.dataset.label.toLowerCase().includes(kw) ? '' : 'none'
            );
        }

        function resetSupplier() {
            document.getElementById('trSupplier').value = '';
            document.getElementById('supplierLabel').textContent = 'Pilih Supplier';
            document.getElementById('supplierLabel').classList.replace('text-gray-900', 'text-gray-400');
            document.getElementById('supplierDropdown').classList.add('hidden');
            document.getElementById('supplierSearch').value = '';
            document.querySelectorAll('.supplier-item').forEach(i => i.style.display = '');
        }

        function restoreSupplier(oldValue) {
            if (!oldValue) return;
            document.getElementById('trSupplier').value = oldValue;
            const item = document.querySelector(`.supplier-item[data-value="${oldValue}"]`);
            if (item) {
                document.getElementById('supplierLabel').textContent = item.dataset.label;
                document.getElementById('supplierLabel').classList.replace('text-gray-400', 'text-gray-900');
            }
        }

        document.addEventListener('click', e => {
            if (!e.target.closest('.menu-aksi') && !e.target.classList.contains('menu-aksi-btn'))
                document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'));
            const btn = document.getElementById('supplierBtn');
            const dd = document.getElementById('supplierDropdown');
            if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target))
                dd.classList.add('hidden');
        });

        // ── ERROR HELPERS ──
        function showErr(errId, inputId) {
            const err = document.getElementById(errId);
            if (!err) return;
            err.style.display = 'flex';
            if (inputId) document.getElementById(inputId)?.classList.add('input-error');
        }

        function clearErr(errId, inputId) {
            const err = document.getElementById(errId);
            if (!err) return;
            err.style.display = 'none';
            if (inputId) {
                document.getElementById(inputId)?.classList.remove('input-error');
                // hapus error Laravel di sekitar input yang sama
                document.getElementById(inputId)?.closest('div')
                    ?.querySelectorAll('.err-laravel').forEach(el => el.remove());
            }
        }

        function clearAllErrors() {
            ['errTKode', 'errTNama', 'errTKategori',
                'errTrJumlah', 'errTrTanggal', 'errTrSupplier', 'errTrTujuan',
                'errEKode', 'errENama', 'errEKategori'
            ].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.style.display = 'none';
            });
            ['tKode', 'tNama', 'tKategori',
                'trJumlah', 'trTanggal', 'trTujuan',
                'eKode', 'eNama', 'eKategori'
            ].forEach(id => {
                document.getElementById(id)?.classList.remove('input-error');
            });
            document.querySelectorAll('#modalCatatBarang .err-laravel').forEach(el => el.remove());
            document.querySelectorAll('#modalEditBarang .err-laravel').forEach(el => el.remove());
        }

        // ── BUKA MODAL OTOMATIS JIKA ADA ERROR VALIDASI LARAVEL ──
        document.addEventListener('DOMContentLoaded', () => {

            if (serverData.hasEditError) {
                document.getElementById('formEditBarang').action = '/kelola_barang/' + serverData.editOrigKode;
                document.getElementById('eKode').value = serverData.editKode;
                document.getElementById('eNama').value = serverData.editNama;
                document.getElementById('eKategori').value = serverData.editKategori;

                if (serverData.editErrorKode) {
                    document.getElementById('errEKode').querySelector('span').textContent = serverData
                        .editErrorKode;
                    showErr('errEKode', 'eKode');
                }
                if (serverData.editErrorNama) {
                    document.getElementById('errENama').querySelector('span').textContent = serverData
                        .editErrorNama;
                    showErr('errENama', 'eNama');
                }
                if (serverData.editErrorKat) {
                    document.getElementById('errEKategori').querySelector('span').textContent = serverData
                        .editErrorKat;
                    showErr('errEKategori', 'eKategori');
                }

                openOverlay('modalEditBarang');

            } else if (serverData.hasTambahError) {
                currentMode = 'tambah';
                document.getElementById('mhdr').style.background = modeConfig.tambah.bg;
                document.getElementById('btnSimpan').style.background = modeConfig.tambah.bg;
                document.getElementById('mhdrTitle').textContent = modeConfig.tambah.title;
                ['sectionTransaksi', 'fieldSupplier', 'fieldTujuan'].forEach(id =>
                    document.getElementById(id).classList.add('hidden')
                );
                document.getElementById('sectionTambah').classList.remove('hidden');
                openOverlay('modalCatatBarang');

            } else if (serverData.hasTrError) {
                const mode = serverData.trMode;
                const kode = serverData.trKode;
                const nama = serverData.trNama;
                const kategori = serverData.trKategori;

                currentMode = mode;
                document.getElementById('mhdr').style.background = modeConfig[mode].bg;
                document.getElementById('btnSimpan').style.background = modeConfig[mode].bg;
                document.getElementById('mhdrTitle').textContent = modeConfig[mode].title;

                ['sectionTambah', 'fieldSupplier', 'fieldTujuan'].forEach(id =>
                    document.getElementById(id).classList.add('hidden')
                );
                document.getElementById('sectionTransaksi').classList.remove('hidden');

                // isi identitas barang dari session
                document.getElementById('trKodeBarang').value = kode;
                document.getElementById('trNama').value = nama;
                document.getElementById('trKategoriDisplay').value = kategori;
                document.getElementById('trNamaHidden').value = nama;
                document.getElementById('trKategoriHidden').value = kategori;

                // Restore stok saat error transaksi
                setStokDisplay('trStokDisplay', serverData.trStok);

                if (mode === 'masuk') {
                    document.getElementById('fieldSupplier').classList.remove('hidden');
                    restoreSupplier(serverData.trSupplier);
                } else {
                    document.getElementById('fieldTujuan').classList.remove('hidden');
                }

                openOverlay('modalCatatBarang');
            }
        });
    </script>
@endpush
