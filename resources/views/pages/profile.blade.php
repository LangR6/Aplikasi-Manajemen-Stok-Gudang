@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="flex items-center justify-center">

    <div class="w-full lg:w-[750px] bg-white rounded-2xl shadow-xl overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-[#205375] px-4 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-white font-semibold text-lg">Profil Pengguna</h2>
                <p class="text-blue-200 text-xs mt-0.5">Informasi akun kamu</p>
            </div>
            <button onclick="window.history.back()"
                class="flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-[#112B3C] hover:bg-red-600 text-white transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </button>
        </div>

        {{-- NOTIFIKASI SUKSES --}}
        @if(session('success'))
            <div class="mx-6 mt-4 px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- BODY --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-0">

            {{-- KIRI: AVATAR --}}
            <div class="md:col-span-2 flex flex-col items-center justify-center bg-gray-50 border-r border-gray-100 py-8 px-6 gap-4">

                {{-- Avatar lingkaran besar --}}
                <div class="w-28 h-28 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-md
                    {{ session('role') === 'admin' ? 'bg-[#F66B0E]' : 'bg-[#0E8A5F]' }}">
                    {{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}
                </div>

                <div class="text-center">
                    <p class="font-semibold text-[#112B3C] text-base">{{ session('nama') }}</p>
                    <span class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-medium
                        {{ session('role') === 'admin' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                        {{ ucfirst(session('role')) }}
                    </span>
                </div>

                <div class="w-full border-t border-gray-200 pt-4 space-y-2 text-sm text-gray-500 text-center">
                    <p class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        {{ session('email') }}
                    </p>
                    <p class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        {{ session('hp') }}
                    </p>
                </div>
            </div>

            {{-- KANAN: FORM --}}
            <div class="md:col-span-3 px-2 py-2">

                <form action="{{ route('profile.update') }}" method="POST" class="flex flex-col h-full">
                    @csrf

                    <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Edit Informasi</h3>

                    <div class="space-y-3 flex-1">

                        {{-- Nama --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Nama Pengguna</label>
                            <input id="nama" name="nama" type="text" value="{{ session('nama') }}"
                                class="w-full rounded-lg px-3 py-2.5 bg-white border border-gray-200 shadow-sm text-sm text-[#112B3C] outline-none cursor-default transition-all duration-200"
                                readonly>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                            <input id="email" name="email" type="text" value="{{ session('email') }}"
                                class="w-full rounded-lg px-3 py-2.5 bg-white border border-gray-200 shadow-sm text-sm text-[#112B3C] outline-none cursor-default transition-all duration-200"
                                readonly>
                        </div>

                        {{-- No HP --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">No Handphone</label>
                            <input id="hp" name="hp" type="text" value="{{ session('hp') }}"
                                class="w-full rounded-lg px-3 py-2.5 bg-white border border-gray-200 shadow-sm text-sm text-[#112B3C] outline-none cursor-default transition-all duration-200"
                                readonly>
                        </div>

                        {{-- Role (read only) --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Role</label>
                            <input type="text" value="{{ ucfirst(session('role')) }}"
                                class="w-full rounded-lg px-3 py-2.5 bg-gray-100 border border-gray-200 shadow-sm text-sm text-gray-400 outline-none cursor-default"
                                readonly>
                        </div>

                    </div>

                    {{-- TOMBOL --}}
                    <div class="mt-5 flex items-center justify-end gap-3">

                        <button type="button" onclick="cancelEdit()" id="btnBatal"
                            class="hidden px-5 py-2 rounded-lg text-sm font-medium border border-gray-200 text-gray-600
                            hover:bg-red-600 hover:text-white transition-all duration-200">
                            Batal
                        </button>

                        <button type="button" onclick="enableEdit()" id="btnEdit"
                            class="px-5 py-2 rounded-lg text-sm font-medium bg-[#F66B0E] text-white
                            hover:bg-orange-600 transition-all duration-200 shadow-sm">
                            Edit Profil
                        </button>

                        <button type="submit" id="btnSimpan"
                            class="hidden px-5 py-2 rounded-lg text-sm font-medium bg-[#F66B0E] text-white
                            hover:bg-orange-600 transition-all duration-200 shadow-sm">
                            Simpan
                        </button>

                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let originalData = {};

    function enableEdit() {
        const inputs = ['nama', 'email', 'hp'];
        inputs.forEach(id => {
            const el = document.getElementById(id);
            originalData[id] = el.value;
            el.removeAttribute('readonly');
            el.classList.remove('cursor-default', 'bg-white');
            el.classList.add('bg-yellow-50', 'border-blue-400', 'ring-1', 'ring-blue-200', 'cursor-text');
        });
        document.getElementById('btnEdit').classList.add('hidden');
        document.getElementById('btnBatal').classList.remove('hidden');
        document.getElementById('btnSimpan').classList.remove('hidden');
    }

    function cancelEdit() {
        const inputs = ['nama', 'email', 'hp'];
        inputs.forEach(id => {
            const el = document.getElementById(id);
            el.value = originalData[id];
            el.setAttribute('readonly', true);
            el.classList.add('cursor-default', 'bg-white');
            el.classList.remove('bg-yellow-50', 'border-blue-400', 'ring-1', 'ring-blue-200', 'cursor-text');
        });
        document.getElementById('btnEdit').classList.remove('hidden');
        document.getElementById('btnBatal').classList.add('hidden');
        document.getElementById('btnSimpan').classList.add('hidden');
    }
</script>

@endsection