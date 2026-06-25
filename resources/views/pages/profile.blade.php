@extends('layouts.app')

@section('title', 'Profil')

@section('content')

    <div class="flex items-center justify-center">

        <div class="w-full lg:w-[750px] bg-white rounded-2xl shadow-xl overflow-hidden">

            {{-- HEADER --}}
            <div class="bg-[#205375] px-4 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-white font-semibold text-lg">Profil Pengguna</h2>
                    <p class="text-blue-200 text-xs mt-0.5">
                        Informasi akun kamu
                    </p>
                </div>

                <button onclick="goBack()"
                    class="flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-[#112B3C] hover:bg-red-600 text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-arrow-left">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    <span>Kembali</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-0">

                {{-- KIRI --}}
                <div
                    class="md:col-span-2 flex flex-col items-center justify-center bg-gray-50 border-r border-gray-100 py-8 px-6 gap-4">

                    {{-- Avatar --}}
                    <div
                        class="w-28 h-28 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-md
                        {{ session('role') === 'admin' ? 'bg-[#F66B0E]' : 'bg-[#0E8A5F]' }}">
                        {{ strtoupper(substr(session('nama', 'U'), 0, 1)) }}
                    </div>

                    {{-- Nama & Role --}}
                    <div class="text-center">
                        <p class="font-semibold text-[#112B3C] text-base">
                            {{ session('username') }}
                        </p>
                        <span
                            class="inline-block mt-1 px-3 py-0.5 rounded-full text-xs font-medium
                            {{ session('role') === 'admin' ? 'bg-orange-100 text-orange-700' : 'bg-green-100 text-green-700' }}">
                            {{ ucfirst(session('role')) }}
                        </span>
                    </div>

                    {{-- Email & Telepon --}}
                    <div class="w-full border-t border-gray-200 pt-4 space-y-3 text-sm text-gray-500 text-center">

                        {{-- Email --}}
                        <div class="flex items-center justify-center gap-2 break-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>{{ session('email') }}</span>
                        </div>

                        {{-- Telepon --}}
                        <div class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>{{ session('hp') }}</span>
                        </div>

                    </div>

                </div>

                {{-- KANAN --}}
                <div class="md:col-span-3 px-6 py-6">

                    <form action="{{ route('profile.update') }}" method="POST">

                        @csrf
                        @method('PUT')

                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">
                            Edit Informasi
                        </h3>

                        <div class="space-y-4">

                            {{-- Username --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Nama Pengguna
                                </label>
                                <input id="nama" name="nama" type="text"
                                    value="{{ old('nama', session('nama')) }}" readonly
                                    class="w-full rounded-lg px-3 py-2.5 bg-white border border-gray-200 shadow-sm text-sm text-[#112B3C]">
                                @error('nama')
                                    <p id="error_nama" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Email
                                </label>
                                <input id="email" name="email" type="email"
                                    value="{{ old('email', session('email')) }}" readonly
                                    class="w-full rounded-lg px-3 py-2.5 bg-white border border-gray-200 shadow-sm text-sm text-[#112B3C]">
                                @error('email')
                                    <p id="error_email" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- HP --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    No Handphone
                                </label>
                                <input id="hp" name="hp" type="text" value="{{ old('hp', session('hp')) }}"
                                    readonly
                                    class="w-full rounded-lg px-3 py-2.5 bg-white border border-gray-200 shadow-sm text-sm text-[#112B3C]">
                                @error('hp')
                                    <p id="error_hp" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password Lama --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Password Lama
                                </label>
                                <div class="relative">
                                    <input id="password_lama" name="password_lama" type="password"
                                        placeholder="Masukkan password lama" readonly
                                        class="w-full rounded-lg px-3 py-2.5 pr-12 bg-white border border-gray-200 shadow-sm text-sm">
                                    <button type="button" id="toggle_lama"
                                        onclick="togglePassword('password_lama', 'icon_lama')"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-300 pointer-events-none transition-colors duration-200">
                                        <svg id="icon_lama" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password_lama')
                                    <p id="error_password_lama" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Password Baru
                                </label>
                                <div class="relative">
                                    <input id="password_baru" name="password_baru" type="password"
                                        placeholder="Masukkan password baru" readonly
                                        class="w-full rounded-lg px-3 py-2.5 pr-12 bg-white border border-gray-200 shadow-sm text-sm">
                                    <button type="button" id="toggle_baru"
                                        onclick="togglePassword('password_baru', 'icon_baru')"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-300 pointer-events-none transition-colors duration-200">
                                        <svg id="icon_baru" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                @error('password_baru')
                                    <p id="error_password_baru" class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Konfirmasi Password
                                </label>
                                <div class="relative">
                                    <input id="konfirmasi_password" name="konfirmasi_password" type="password"
                                        placeholder="Konfirmasi password baru" readonly
                                        class="w-full rounded-lg px-3 py-2.5 pr-12 bg-white border border-gray-200 shadow-sm text-sm">
                                    <button type="button" id="toggle_konfirmasi"
                                        onclick="togglePassword('konfirmasi_password', 'icon_konfirmasi')"
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-300 pointer-events-none transition-colors duration-200">
                                        <svg id="icon_konfirmasi" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                {{-- Tidak ada error server untuk konfirmasi_password --}}
                            </div>

                            {{-- Role --}}
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">
                                    Role
                                </label>
                                <input type="text" value="{{ ucfirst(session('role')) }}" readonly
                                    class="w-full rounded-lg px-3 py-2.5 bg-gray-100 border border-gray-200 shadow-sm text-sm text-gray-500">
                            </div>

                        </div>

                        {{-- BUTTON --}}
                        <div class="mt-6 flex justify-end gap-3">

                            <button type="button" onclick="cancelEdit()" id="btnBatal"
                                class="hidden px-5 py-2 rounded-lg text-sm font-medium border border-gray-200 text-gray-600 hover:bg-red-600 hover:text-white transition-all duration-200">
                                Batal
                            </button>

                            <button type="button" onclick="enableEdit()" id="btnEdit"
                                class="px-5 py-2 rounded-lg text-sm font-medium bg-[#F66B0E] text-white hover:bg-orange-600 transition-all duration-200">
                                Edit Profil
                            </button>

                            <button type="submit" id="btnSimpan"
                                class="hidden px-5 py-2 rounded-lg text-sm font-medium bg-[#F66B0E] text-white hover:bg-orange-600 transition-all duration-200">
                                Simpan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>
        const PREV_KEY = 'profile_back_url';
        if (document.referrer && !document.referrer.includes('/profile')) {
            sessionStorage.setItem(PREV_KEY, document.referrer);
        }

        function goBack() {
            const url = sessionStorage.getItem(PREV_KEY);
            if (url) {
                sessionStorage.removeItem(PREV_KEY);
                window.location.href = url;
            } else {
                window.history.go(-2);
            }
        }

        const eyeIcon = `
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;

        const eyeOffIcon = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.477 10.488a3 3 0 004.243 4.243" />
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9.88 5.09A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7
                a9.97 9.97 0 01-1.563 3.029M6.228 6.228C4.483 7.38 3.181 9.06
                2.458 12c1.274 4.057 5.064 7 9.542 7a9.953 9.953 0 005.09-1.372" />
        `;

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = eyeOffIcon;
            } else {
                input.type = 'password';
                icon.innerHTML = eyeIcon;
            }
        }

        function resetPasswordIcons() {
            ['icon_lama', 'icon_baru', 'icon_konfirmasi'].forEach(id => {
                document.getElementById(id).innerHTML = eyeIcon;
            });
        }

        function enableToggleButtons() {
            ['toggle_lama', 'toggle_baru', 'toggle_konfirmasi'].forEach(id => {
                const btn = document.getElementById(id);
                btn.classList.remove('pointer-events-none', 'text-gray-300');
                btn.classList.add('text-gray-400', 'hover:text-gray-600');
            });
        }

        function disableToggleButtons() {
            ['toggle_lama', 'toggle_baru', 'toggle_konfirmasi'].forEach(id => {
                const btn = document.getElementById(id);
                btn.classList.add('pointer-events-none', 'text-gray-300');
                btn.classList.remove('text-gray-400', 'hover:text-gray-600');
            });
        }

        let originalData = {};

        function enableEdit() {
            const inputs = ['nama', 'email', 'hp', 'password_lama', 'password_baru', 'konfirmasi_password'];

            inputs.forEach(id => {
                const el = document.getElementById(id);
                originalData[id] = el.value;
                el.removeAttribute('readonly');
                el.classList.add('bg-yellow-50', 'border-blue-400', 'ring-1', 'ring-blue-200');
            });

            enableToggleButtons();

            document.getElementById('btnEdit').classList.add('hidden');
            document.getElementById('btnBatal').classList.remove('hidden');
            document.getElementById('btnSimpan').classList.remove('hidden');
        }

        function cancelEdit() {
            const inputs = [
                'nama',
                'email',
                'hp',
                'password_lama',
                'password_baru',
                'konfirmasi_password'
            ];

            inputs.forEach(id => {
                const el = document.getElementById(id);

                el.value = originalData[id];
                el.setAttribute('readonly', true);

                el.classList.remove(
                    'bg-yellow-50',
                    'border-blue-400',
                    'ring-1',
                    'ring-blue-200'
                );

                if (
                    id === 'password_lama' ||
                    id === 'password_baru' ||
                    id === 'konfirmasi_password'
                ) {
                    el.type = 'password';
                }
            });

            disableToggleButtons();
            resetPasswordIcons();

            // Hilangkan semua pesan error saat batal
            document.querySelectorAll('.text-red-500').forEach(error => {
                error.remove();
            });

            document.getElementById('btnEdit').classList.remove('hidden');
            document.getElementById('btnBatal').classList.add('hidden');
            document.getElementById('btnSimpan').classList.add('hidden');
        }

        // Auto buka mode edit jika ada error validasi
        @if ($errors->any())
            enableEdit();
        @endif

        // Peta input -> id error masing-masing
        // Saat user mengetik di input tertentu, hanya error input itu yang hilang
        const errorMap = {
            'nama'                : 'error_nama',
            'email'               : 'error_email',
            'hp'                  : 'error_hp',
            'password_lama'       : 'error_password_lama',
            'password_baru'       : 'error_password_baru',
            'konfirmasi_password' : null  // tidak ada error server untuk field ini
        };

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function () {
                const errorId = errorMap[this.id];
                if (errorId) {
                    const errorEl = document.getElementById(errorId);
                    if (errorEl) errorEl.remove();
                }
            });
        });
    </script>

@endsection
