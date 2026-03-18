@extends('admin.app')

@section('title', 'Dashboard')

@section('content')
    @if(session('success'))
        <div class="mb-4 rounded-xl border border-green-500 bg-green-50 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <!-- Top Cards -->
    <div class="grid grid-cols-2 gap-5 mb-6">
        <div class="outline-box h-[155px] p-4">
            <h2 class="panel-title">Barang Masuk</h2>
        </div>
        <div class="outline-box h-[155px] p-4">
            <h2 class="panel-title">Barang Keluar</h2>
        </div>
    </div>

    <!-- Small Cards -->
    <div class="grid grid-cols-3 gap-5 mb-6">
        <div class="outline-box h-[150px] p-4">
            <h2 class="text-[20px] font-medium">Total Barang</h2>
        </div>
        <div class="outline-box h-[150px] p-4">
            <h2 class="text-[20px] font-medium">Stok Barang Menipis</h2>
        </div>
        <div class="outline-box h-[150px] p-4">
            <h2 class="text-[20px] font-medium">Stok Barang Habis</h2>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-12 gap-5">
        <!-- Data Supplier -->
        <div class="col-span-6">
            <div class="outline-box min-h-[390px] overflow-hidden">
                <div class="flex items-center justify-between px-4 py-3 border-b-2 thin-line">
                    <h2 class="text-[22px] font-semibold text-[#222]">Data Supplier</h2>

                    <button
                        type="button"
                        onclick="openModal()"
                        class="border-2 border-[#8f8f8f] rounded-xl px-4 py-1.5 text-[18px] font-medium hover:bg-gray-100 flex items-center gap-2"
                    >
                        <span class="text-[24px] leading-none">+</span>
                        <span>Tambah Supplier</span>
                    </button>
                </div>

                <div class="px-4 pt-4">
                    <div class="grid grid-cols-4 text-[18px] font-medium text-[#333] pb-3 border-b-2 thin-line">
                        <div>Nama Supplier</div>
                        <div>Kontak</div>
                        <div>Email</div>
                        <div>Kota</div>
                    </div>

                    <div class="py-4">
                        @forelse($suppliers as $supplier)
                            <div class="grid grid-cols-4 text-[16px] py-3 border-b">
                                <div>{{ $supplier['nama_supplier'] }}</div>
                                <div>{{ $supplier['kontak'] }}</div>
                                <div>{{ $supplier['email'] }}</div>
                                <div>{{ $supplier['kota'] }}</div>
                            </div>
                        @empty
                            <div class="h-[230px] flex items-center justify-center text-gray-400">
                                Belum ada data supplier
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Cards -->
        <div class="col-span-6 space-y-4">
            <div class="outline-box overflow-hidden">
                <div class="px-4 py-3 border-b-2 thin-line">
                    <h2 class="text-[22px] font-semibold text-[#222]">Barang Masuk Terbaru</h2>
                </div>

                <div class="p-4">
                    <div class="outline-box p-4 flex items-center justify-between min-h-[120px]">
                        <div class="text-[18px] text-[#444] leading-8">
                            <div>Supplier : {{ $barangMasukTerbaru['supplier'] }}</div>
                            <div>Kontak : {{ $barangMasukTerbaru['kontak'] }}</div>
                            <div>Tanggal : {{ $barangMasukTerbaru['tanggal'] }}</div>
                        </div>

                        <button class="border-2 border-[#8f8f8f] rounded-xl px-6 py-2 text-[18px] hover:bg-gray-100">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>

            <div class="outline-box overflow-hidden">
                <div class="px-4 py-3 border-b-2 thin-line">
                    <h2 class="text-[22px] font-semibold text-[#222]">Barang Keluar Terbaru</h2>
                </div>

                <div class="p-4">
                    <div class="outline-box p-4 flex items-center justify-between min-h-[120px]">
                        <div class="text-[18px] text-[#444] leading-8">
                            <div>Supplier : {{ $barangKeluarTerbaru['supplier'] }}</div>
                            <div>Kontak : {{ $barangKeluarTerbaru['kontak'] }}</div>
                            <div>Tanggal : {{ $barangKeluarTerbaru['tanggal'] }}</div>
                        </div>

                        <button class="border-2 border-[#8f8f8f] rounded-xl px-6 py-2 text-[18px] hover:bg-gray-100">
                            Lihat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
<div id="supplierModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
    <div class="w-full max-w-[620px] bg-white rounded-2xl border-2 border-[#b0b0b0] shadow-xl overflow-hidden">
        <div class="flex items-center justify-between px-4 py-3 border-b-2 thin-line">
            <h3 class="text-[20px] font-semibold text-[#222]">Tambah Supplier</h3>
            <button type="button" onclick="closeModal()" class="text-[24px] text-[#333] leading-none">&times;</button>
        </div>

        <form action="{{ route('supplier.store') }}" method="POST" class="p-4">
            @csrf

            <div class="mb-3">
                <label class="block text-[13px] font-medium mb-1">Nama Supplier</label>
                <input
                    type="text"
                    name="nama_supplier"
                    placeholder="Masukkan nama supplier..."
                    class="w-full h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 outline-none"
                    value="{{ old('nama_supplier') }}"
                >
                @error('nama_supplier')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <label class="block text-[13px] font-medium mb-1">No. Kontak</label>
                    <input
                        type="text"
                        name="kontak"
                        placeholder="Masukkan kontak supplier..."
                        class="w-full h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 outline-none"
                        value="{{ old('kontak') }}"
                    >
                    @error('kontak')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-[13px] font-medium mb-1">Kota</label>
                    <input
                        type="text"
                        name="kota"
                        placeholder="Masukkan kota asal..."
                        class="w-full h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 outline-none"
                        value="{{ old('kota') }}"
                    >
                    @error('kota')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-[13px] font-medium mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email supplier..."
                    class="w-full h-[46px] border-2 border-[#8f8f8f] rounded-xl px-4 outline-none"
                    value="{{ old('email') }}"
                >
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 h-[46px] border-2 border-[#8f8f8f] rounded-xl font-medium hover:bg-gray-100"
                >
                    Simpan
                </button>

                <button
                    type="button"
                    onclick="closeModal()"
                    class="w-[120px] h-[46px] border-2 border-[#8f8f8f] rounded-xl font-medium hover:bg-gray-100"
                >
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openModal() {
        const modal = document.getElementById('supplierModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal() {
        const modal = document.getElementById('supplierModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
</script>

@if ($errors->any())
<script>
    openModal();
</script>
@endif
@endpush