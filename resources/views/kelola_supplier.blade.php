@extends('app')

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

            <input type="text"
                placeholder="Cari nama supplier..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-orange-500 focus:border-orange-500 block w-full pl-10 p-2.5" />
        </div>

        {{-- TAMBAH --}}
        <button type="button" onclick="openSupplierModal()"
            class="flex items-center gap-2 bg-[#F66B0E] hover:bg-orange-600
                       active:scale-[.98] text-white text-sm font-medium px-6 py-2.5
                       rounded-lg transition-all whitespace-nowrap">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 18 18">
                <path stroke="currentColor" stroke-width="2.2"
                    d="M9 1v16M1 9h16" />
            </svg>
            Tambah Supplier
        </button>
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
                    <col class="w-[16%]">
                </colgroup>

                <thead class="bg-[#205375] border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wide">No</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Nama Supplier</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Kontak</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Email</th>
                        <th class="px-4 py-3 text-xs font-medium text-white uppercase tracking-wide">Kota</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($suppliers as $index => $supplier)
                    <tr class="border-b border-gray-100 {{ $loop->even ? '' : 'bg-gray-50/60' }}">
                        <td class="px-4 py-3 text-center text-sm text-gray-800 font-medium">
                            {{ $suppliers->firstItem() + $index }}
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

                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button"
                                    class="px-3 py-1 rounded-md text-sm font-medium border border-gray-300
                                                   text-gray-700 bg-transparent hover:bg-gray-100
                                                   active:scale-[.98] hover:-translate-y-px transition-all">
                                    Edit
                                </button>

                                <button type="button"
                                    class="px-3 py-1 rounded-md text-sm font-medium border border-red-200
                                                   text-red-600 bg-red-50 hover:bg-red-100
                                                   active:scale-[.98] hover:-translate-y-px transition-all">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-400 text-sm">
                            Belum ada data supplier
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- FOOTER INFO --}}
        <div class="px-4 py-2.5 border-t border-gray-100 flex items-center justify-between gap-2">
            <span class="text-sm text-gray-400">
                Menampilkan {{ $suppliers->firstItem() }}–{{ $suppliers->lastItem() }} dari {{ $suppliers->total() }} supplier
            </span>

            {{ $suppliers->links() }}
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

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-5 py-4 rounded-t-2xl bg-[#F66B0E]">
            <div class="flex items-center gap-2.5">
                <h3 class="text-sm font-semibold text-white">Tambah Supplier</h3>
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
                <input type="text" name="nama_supplier" placeholder="Contoh: CV Sumber Jaya..."
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                               rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                               focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                        No. Kontak
                    </label>
                    <input type="text" name="kontak" placeholder="Contoh: 0812-3456-7890"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                                   rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                                   focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />
                </div>

                <div>
                    <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                        Kota
                    </label>
                    <input type="text" name="kota" placeholder="Contoh: Bandung"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 text-sm
                                   rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2
                                   focus:ring-orange-400 focus:border-transparent transition placeholder-gray-300" />
                </div>
            </div>

            <div>
                <label class="block mb-1.5 text-xs font-medium text-gray-800 uppercase tracking-wide">
                    Email
                </label>
                <input type="email" name="email" placeholder="Contoh: supplier@email.com"
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

                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-[#F66B0E] hover:bg-orange-600
                               rounded-lg active:scale-[.98] hover:-translate-y-px transition-all">
                    Simpan
                </button>
            </div>
        </form>
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
    function lockBodyScroll() {
        const scrollBarWidth = window.innerWidth - document.documentElement.clientWidth;
        document.body.classList.add('overflow-hidden');
        document.body.style.paddingRight = scrollBarWidth + 'px';
    }

    function unlockBodyScroll() {
        document.body.classList.remove('overflow-hidden');
        document.body.style.paddingRight = '';
    }

    function openSupplierModal() {
        const ov = document.getElementById('supplierModal');
        if (!ov) return;

        ov.classList.remove('hidden');
        void ov.offsetWidth;
        ov.classList.add('is-open');
        lockBodyScroll();
    }

    function closeSupplierModal() {
        const ov = document.getElementById('supplierModal');
        if (!ov) return;

        ov.classList.remove('is-open');
        setTimeout(function() {
            ov.classList.add('hidden');
        }, 200);

        unlockBodyScroll();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ov = document.getElementById('supplierModal');
        if (!ov) return;

        const backdrop = ov.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.addEventListener('click', function() {
                closeSupplierModal();
            });
        }
    });
</script>
@endpush