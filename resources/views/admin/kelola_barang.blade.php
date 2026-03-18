@extends('admin.app')

@section('title', 'Kelola Barang')

@section('content')
    <div class="space-y-8">

        <!-- SEARCH & FILTER -->
        <div class="flex items-center justify-between rounded-xl">

            <div class="flex items-center gap-3 flex-1">

                <!-- SEARCH -->
                <div class="relative flex-1">
                    <input type="text" id="searchInput" placeholder="Cari barang..."
                        class="w-full border rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <svg class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>
                </div>

                <!-- FILTER KATEGORI -->
                <select id="filterKategori" class="border rounded-lg px-4 py-2 bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="Kaos">Kaos</option>
                    <option value="Hoodie">Hoodie</option>
                    <option value="Topi">Topi</option>
                </select>

            </div>

            <!-- TOMBOL TAMBAH -->
            <button onclick="openModal('tambah', null)"
                class="ml-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-5 py-2 rounded-lg shadow hover:from-orange-600 hover:to-orange-700 transition flex items-center gap-2">
                <span class="text-lg font-bold">+</span>
                Tambah Barang
            </button>

        </div>

        <!-- GRID BARANG -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">

            @foreach ([['nama' => 'Kaos', 'stok' => 12, 'kategori' => 'Kaos'],
                        ['nama' => 'Topi', 'stok' => 8, 'kategori' => 'Topi'],
                        ['nama' => 'Sweater', 'stok' => 5, 'kategori' => 'Hoodie'],
                        ['nama' => 'Celana', 'stok' => 0, 'kategori' => 'Kaos'],
                        ['nama' => 'Hoodie', 'stok' => 3, 'kategori' => 'Hoodie']] as $barang)
                <div
                    class="relative bg-white rounded-xl shadow-sm hover:shadow-lg transition p-4 flex flex-col items-center border">

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

                    <!-- BADGE STOK -->
                    <p
                        class="text-sm mb-4 {{ $barang['stok'] == 0 ? 'text-red-600 font-bold' : ($barang['stok'] <= 5 ? 'text-red-500 font-semibold' : 'text-gray-500') }}">
                        Stok : {{ $barang['stok'] }}
                        @if ($barang['stok'] == 0)
                            <span class="ml-1 text-xs bg-red-200 text-red-600 px-1 rounded">Habis</span>
                        @elseif ($barang['stok'] <= 5)
                            <span class="ml-1 text-xs bg-red-100 text-red-500 px-1 rounded">Menipis</span>
                        @endif
                    </p>

                    <!-- TOMBOL MASUK / KELUAR -->
                    <div class="flex gap-3">
                        <button onclick="openModal('keluar', '{{ $barang['nama'] }}')" title="Barang Keluar"
                            class="w-10 h-10 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600 transition text-xl font-bold">
                            −
                        </button>
                        <button onclick="openModal('masuk', '{{ $barang['nama'] }}')" title="Barang Masuk"
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
    <div id="modalOverlay" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        onclick="handleOverlayClick(event)">

        <div id="modalBox" class="bg-white rounded-2xl w-[460px] shadow-xl overflow-hidden">

            <!-- HEADER -->
            <div id="modalHeader" class="px-6 py-4 flex justify-between items-center">
                <h2 id="modalTitle" class="text-lg font-semibold text-white">Catat Barang</h2>
                <button onclick="closeModal()" class="text-white/70 hover:text-white text-xl leading-none">✕</button>
            </div>

            <div class="px-6 py-5 space-y-4">

                {{-- SECTION: TAMBAH BARANG BARU --}}
                <div id="sectionTambah" class="hidden space-y-4">

                    <!-- Upload Gambar -->
                    <div id="imageUploadArea" onclick="document.getElementById('imageInput').click()"
                        class="w-full h-36 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-orange-400 hover:bg-orange-50 transition group relative overflow-hidden">
                        <img id="imagePreview" src="" alt=""
                            class="hidden absolute inset-0 w-full h-full object-cover rounded-xl">
                        <div id="imageUploadPlaceholder"
                            class="flex flex-col items-center gap-1 text-gray-400 group-hover:text-orange-400 transition">
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
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kode Barang</label>
                            <input id="modalKodeBarang" type="text" placeholder="e.g. BRG-001"
                                class="border rounded-lg w-full px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Barang</label>
                            <input id="modalNamaBarangTambah" type="text" placeholder="e.g. Kaos Polos"
                                class="border rounded-lg w-full px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
                        </div>
                    </div>

                    <!-- Kategori -->
                    <div class="space-y-1">
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</label>
                        <select id="modalKategoriTambah"
                            class="border rounded-lg w-full px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-200">
                            <option value="">— Pilih Kategori —</option>
                            <option value="Kaos">Kaos</option>
                            <option value="Hoodie">Hoodie</option>
                            <option value="Topi">Topi</option>
                        </select>
                    </div>

                </div>

                {{-- SECTION: BARANG MASUK / KELUAR --}}
                <div id="sectionTransaksi" class="hidden space-y-4">

                    <input id="modalNamaBarang" type="text" placeholder="Nama Barang"
                        class="border rounded-lg w-full px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">

                    <div class="grid grid-cols-2 gap-3">
                        <select id="modalKategori" class="border rounded-lg px-3 py-2 text-sm bg-white">
                            <option value="">Pilih Kategori</option>
                            <option value="Kaos">Kaos</option>
                            <option value="Hoodie">Hoodie</option>
                            <option value="Topi">Topi</option>
                        </select>
                        <input id="modalJumlah" type="number" placeholder="Jumlah" min="1"
                            class="border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <select id="modalSupplier" class="border rounded-lg px-3 py-2 text-sm bg-white">
                            <option value="">Pilih Supplier</option>
                            <option value="Supplier A">Supplier A</option>
                            <option value="Supplier B">Supplier B</option>
                        </select>
                        <input id="modalTanggal" type="date" class="border rounded-lg px-3 py-2 text-sm">
                    </div>

                    <textarea id="modalCatatan" placeholder="Catatan (opsional)" rows="3"
                        class="border rounded-lg px-3 py-2 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>

                </div>

                <!-- ERROR -->
                <p id="modalError" class="text-red-500 text-sm hidden"></p>

                <!-- ACTIONS -->
                <div class="flex justify-end gap-3 pt-1">
                    <button onclick="closeModal()"
                        class="border px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button id="modalSimpan" onclick="handleSimpan()"
                        class="text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                        Simpan
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL EDIT BARANG --}}
    <div id="modalEditBarang" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50"
        onclick="handleEditOverlayClick(event)">

        <div id="editModalBox" class="bg-white rounded-xl w-[420px] p-6 space-y-4 shadow-lg">

            <!-- HEADER -->
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Edit Barang</h2>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
            </div>

            <!-- NAMA BARANG -->
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nama Barang</label>
                <input id="editNamaBarang" type="text" placeholder="Nama barang"
                    class="border rounded-lg w-full px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            <!-- KATEGORI -->
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</label>
                <select id="editKategori"
                    class="border rounded-lg w-full px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-orange-200">
                    <option value="Kaos">Kaos</option>
                    <option value="Hoodie">Hoodie</option>
                    <option value="Topi">Topi</option>
                    <option value="Celana">Celana</option>
                </select>
            </div>

            <!-- ERROR -->
            <p id="editError" class="text-red-500 text-sm hidden"></p>

            <!-- ACTIONS -->
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeEditModal()"
                    class="border px-4 py-2 rounded-lg text-sm hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="button" onclick="handleSimpanEdit()"
                    class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-orange-600 hover:to-orange-700 transition">
                    Simpan
                </button>
            </div>

        </div>
    </div>
@endpush

@push('scripts')
    <script>
        let currentType = null
        document.getElementById('modalTanggal').valueAsDate = new Date()

        function openModal(type, namaBarang) {
            currentType = type
            const overlay = document.getElementById('modalOverlay')
            const header = document.getElementById('modalHeader')
            const title = document.getElementById('modalTitle')
            const simpan = document.getElementById('modalSimpan')
            const secTambah = document.getElementById('sectionTambah')
            const secTrans = document.getElementById('sectionTransaksi')
            const error = document.getElementById('modalError')

            error.classList.add('hidden')
            error.innerText = ''
            overlay.classList.remove('hidden')

            secTambah.classList.add('hidden')
            secTrans.classList.add('hidden')

            if (type === 'tambah') {
                title.innerText = 'Tambah Barang Baru'
                header.className =
                    'px-6 py-4 flex justify-between items-center bg-gradient-to-r from-orange-500 to-orange-600'
                simpan.className =
                    'bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition'
                secTambah.classList.remove('hidden')

            } else if (type === 'masuk') {
                title.innerText = 'Catat Barang Masuk'
                header.className =
                    'px-6 py-4 flex justify-between items-center bg-gradient-to-r from-green-500 to-green-600'
                simpan.className =
                    'bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition'
                secTrans.classList.remove('hidden')
                setNamaBarang(namaBarang)

            } else if (type === 'keluar') {
                title.innerText = 'Catat Barang Keluar'
                header.className = 'px-6 py-4 flex justify-between items-center bg-gradient-to-r from-red-500 to-red-600'
                simpan.className =
                    'bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition'
                secTrans.classList.remove('hidden')
                setNamaBarang(namaBarang)
            }
        }

        function setNamaBarang(namaBarang) {
            const input = document.getElementById('modalNamaBarang')
            input.value = namaBarang ?? ''
            input.readOnly = !!namaBarang
            input.className =
                `border rounded-lg w-full px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 ${namaBarang ? 'bg-gray-100 cursor-not-allowed' : ''}`
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.add('hidden')
            document.getElementById('modalNamaBarang').value = ''
            document.getElementById('modalNamaBarangTambah').value = ''
            document.getElementById('modalKodeBarang').value = ''
            document.getElementById('modalKategoriTambah').value = ''
            document.getElementById('modalJumlah').value = ''
            document.getElementById('modalCatatan').value = ''
            document.getElementById('modalTanggal').valueAsDate = new Date()
            document.getElementById('imagePreview').classList.add('hidden')
            document.getElementById('imagePreview').src = ''
            document.getElementById('imageUploadPlaceholder').classList.remove('hidden')
            document.getElementById('imageInput').value = ''
        }

        function handleOverlayClick(event) {
            if (!document.getElementById('modalBox').contains(event.target)) closeModal()
        }

        function previewImage(event) {
            const file = event.target.files[0]
            if (!file) return
            const reader = new FileReader()
            reader.onload = e => {
                const preview = document.getElementById('imagePreview')
                const placeholder = document.getElementById('imageUploadPlaceholder')
                preview.src = e.target.result
                preview.classList.remove('hidden')
                placeholder.classList.add('hidden')
            }
            reader.readAsDataURL(file)
        }

        function handleSimpan() {
            if (currentType === 'tambah') {
                const kode = document.getElementById('modalKodeBarang').value.trim()
                const nama = document.getElementById('modalNamaBarangTambah').value.trim()
                const kat = document.getElementById('modalKategoriTambah').value
                if (!kode) {
                    showError('Kode barang wajib diisi.');
                    return
                }
                if (!nama) {
                    showError('Nama barang wajib diisi.');
                    return
                }
                if (!kat) {
                    showError('Kategori wajib dipilih.');
                    return
                }
                console.log({
                    type: currentType,
                    kode,
                    nama,
                    kategori: kat
                })
            } else {
                const nama = document.getElementById('modalNamaBarang').value.trim()
                const jumlah = document.getElementById('modalJumlah').value
                if (!nama) {
                    showError('Nama barang wajib diisi.');
                    return
                }
                if (!jumlah || parseInt(jumlah) < 1) {
                    showError('Jumlah harus lebih dari 0.');
                    return
                }
                console.log({
                    type: currentType,
                    nama,
                    jumlah
                })
            }
            closeModal()
        }

        function showError(msg) {
            const error = document.getElementById('modalError')
            error.innerText = msg
            error.classList.remove('hidden')
        }

        // =====================
        // MENU AKSI (⋮)
        // =====================

        function toggleMenu(button) {
            const menu = button.nextElementSibling
            document.querySelectorAll('.menu-aksi').forEach(m => {
                if (m !== menu) m.classList.add('hidden')
            })
            menu.classList.toggle('hidden')
        }

        // Tutup menu aksi jika klik di luar
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.menu-aksi') && !event.target.closest('[onclick^="toggleMenu"]')) {
                document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'))
            }
        })

        function openEditModal(nama, kategori) {
            // Tutup semua menu aksi
            document.querySelectorAll('.menu-aksi').forEach(m => m.classList.add('hidden'))

            document.getElementById('editNamaBarang').value = nama ?? ''
            document.getElementById('editKategori').value = kategori ?? ''
            document.getElementById('editError').classList.add('hidden')
            document.getElementById('editError').innerText = ''
            document.getElementById('modalEditBarang').classList.remove('hidden')
        }

        function closeEditModal() {
            document.getElementById('modalEditBarang').classList.add('hidden')
            document.getElementById('editNamaBarang').value = ''
            document.getElementById('editKategori').selectedIndex = 0
        }

        function handleEditOverlayClick(event) {
            if (!document.getElementById('editModalBox').contains(event.target)) closeEditModal()
        }

        function handleSimpanEdit() {
            const nama = document.getElementById('editNamaBarang').value.trim()
            const kategori = document.getElementById('editKategori').value
            const error = document.getElementById('editError')

            if (!nama) {
                error.innerText = 'Nama barang wajib diisi.'
                error.classList.remove('hidden')
                return
            }

            // TODO: kirim ke server via fetch/form submit
            console.log({
                nama,
                kategori
            })

            closeEditModal()
        }
    </script>
@endpush
