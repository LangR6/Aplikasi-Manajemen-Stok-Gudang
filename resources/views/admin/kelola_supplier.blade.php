@extends('admin.app')

@section('title', 'Kelola Supplier')

@section('content')
<div class="space-y-6">

    <!-- Top Action -->
    <div class="flex flex-col lg:flex-row gap-4 lg:items-center lg:justify-between">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>

            <input type="text"
                placeholder="Cari nama supplier..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5">
        </div>

        <button type="button"
            onclick="openSupplierModal()"
            class="text-white bg-orange-500 hover:bg-orange-600 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center gap-2">

            <svg class="w-4 h-4" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-width="2"
                    d="M9 1v16M1 9h16" />
            </svg>

            Tambah Supplier
        </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white border border-gray-200 rounded-[24px] shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-[24px] font-semibold text-gray-800">Daftar Supplier</h2>
        </div>

        <div class="px-6 py-5">
            @if(count($suppliers) > 0)
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 text-left">
                            <th class="py-3 text-[18px] font-semibold text-gray-700 w-[8%]">No</th>
                            <th class="py-3 text-[18px] font-semibold text-gray-700 w-[28%]">Nama Supplier</th>
                            <th class="py-3 text-[18px] font-semibold text-gray-700 w-[20%]">Kontak</th>
                            <th class="py-3 text-[18px] font-semibold text-gray-700 w-[26%]">Email</th>
                            <th class="py-3 text-[18px] font-semibold text-gray-700 w-[12%]">Kota</th>
                            <th class="py-3 text-[18px] font-semibold text-gray-700 w-[16%]">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($suppliers as $index => $supplier)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all duration-200">
                            <td class="py-4 text-[16px] text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-4 pr-4 text-[16px] text-gray-700">{{ $supplier['nama_supplier'] }}</td>
                            <td class="py-4 pr-4 text-[16px] text-gray-700">{{ $supplier['kontak'] }}</td>
                            <td class="py-4 pr-4 text-[16px] text-gray-700 break-words">{{ $supplier['email'] }}</td>
                            <td class="py-4 pr-4 text-[16px] text-gray-700">{{ $supplier['kota'] }}</td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <button
                                        type="button"
                                        class="px-4 py-2 rounded-[12px] border border-gray-300 text-gray-700 hover:bg-gray-100 transition-all duration-300">
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="px-4 py-2 rounded-[12px] bg-red-500 text-white hover:bg-red-600 transition-all duration-300">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="h-[300px] flex items-center justify-center text-gray-400 text-[18px]">
                Belum ada data supplier
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('modals')
<div id="supplierModal" class="fixed inset-0 hidden items-center justify-center bg-black/30 backdrop-blur-[2px] z-50 px-4">
    <div class="w-full max-w-[620px] bg-white rounded-[28px] border border-gray-200 shadow-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
            <h3 class="text-[22px] font-semibold text-gray-800">Tambah Supplier</h3>
            <button type="button" onclick="closeSupplierModal()" class="text-[28px] text-gray-500 leading-none">&times;</button>
        </div>

        <form action="#" method="POST" class="p-6">
            @csrf

            <div class="mb-4">
                <label class="block text-[14px] font-medium text-gray-700 mb-2">Nama Supplier</label>
                <input
                    type="text"
                    name="nama_supplier"
                    placeholder="Masukkan nama supplier..."
                    class="w-full h-[50px] border border-gray-300 rounded-[14px] px-4 outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-[14px] font-medium text-gray-700 mb-2">No. Kontak</label>
                    <input
                        type="text"
                        name="kontak"
                        placeholder="Masukkan kontak supplier..."
                        class="w-full h-[50px] border border-gray-300 rounded-[14px] px-4 outline-none focus:ring-2 focus:ring-orange-200">
                </div>

                <div>
                    <label class="block text-[14px] font-medium text-gray-700 mb-2">Kota</label>
                    <input
                        type="text"
                        name="kota"
                        placeholder="Masukkan kota supplier..."
                        class="w-full h-[50px] border border-gray-300 rounded-[14px] px-4 outline-none focus:ring-2 focus:ring-orange-200">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-[14px] font-medium text-gray-700 mb-2">Email</label>
                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email supplier..."
                    class="w-full h-[50px] border border-gray-300 rounded-[14px] px-4 outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="flex-1 h-[50px] rounded-[14px] bg-orange-500 text-white font-semibold hover:bg-orange-600 transition-all duration-300">
                    Simpan
                </button>

                <button
                    type="button"
                    onclick="closeSupplierModal()"
                    class="w-[140px] h-[50px] rounded-[14px] border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 transition-all duration-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function lockBodyScroll() {
        document.body.classList.add('overflow-hidden');
    }

    function unlockBodyScroll() {
        document.body.classList.remove('overflow-hidden');
    }

    function openSupplierModal() {
        const modal = document.getElementById('supplierModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            lockBodyScroll();
        }
    }

    function closeSupplierModal() {
        const modal = document.getElementById('supplierModal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            unlockBodyScroll();
        }
    }
</script>
@endpush