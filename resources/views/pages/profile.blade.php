@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="flex items-center justify-center py-6">

        <div class="w-[900px] bg-white p-6 rounded-xl shadow-2xl">

            <!-- Tombol Kembali -->
            <div class="flex justify-end mb-4">
                <button onclick="window.history.back()"
                    class="px-4 py-2 text-sm rounded bg-red-500 text-white
    hover:bg-red-700
    transform hover:scale-105 active:scale-95
    transition-all duration-300 ease-in-out
    shadow-md hover:shadow-lg">
                    Kembali
                </button>
            </div>

            <div class="grid grid-cols-2 gap-6">

                <!-- FOTO -->
                <div class="rounded-xl h-[350px] flex flex-col items-center justify-center gap-2 bg-gray-50 shadow-lg">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-28 h-28 text-gray-400" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>

                <!-- FORM -->
                <div class="rounded-xl p-5 bg-gray-50 shadow-md hover:shadow-xl transition duration-300">

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf

                        <!-- Nama -->
                        <label class="text-sm text-gray-600">Nama Pengguna</label>
                        <input id="nama" type="text" value="ADMIN 1"
                            class="w-full rounded-lg p-2 text-center bg-white mb-3 shadow-sm" readonly>

                        <!-- Email -->
                        <label class="text-sm text-gray-600">Email</label>
                        <input id="email" type="text" value="admin1xxx@gmail.com"
                            class="w-full rounded-lg p-2 text-center bg-white mb-3 shadow-sm" readonly>

                        <!-- No HP -->
                        <label class="text-sm text-gray-600">No Handphone</label>
                        <input id="hp" type="text" value="08xxxxxxxxxx"
                            class="w-full rounded-lg p-2 text-center bg-white mb-4 shadow-sm" readonly>

                        <!-- Tombol Edit -->
                        <div class="flex justify-end mb-4">
                            <button type="button" onclick="enableEdit()" id="btnEdit"
                                class="px-4 py-1 rounded bg-orange-500 text-white
                            hover:bg-orange-600
                            transform hover:scale-105 active:scale-95
                            transition-all duration-300 shadow-md hover:shadow-lg">
                                Edit
                            </button>
                        </div>

                        <!-- Tombol bawah -->
                        <div class="flex gap-3">
                            <!-- BATAL -->
                            <button type="button" onclick="cancelEdit()" id="btnBatal"
                                class="w-full rounded-lg py-2 bg-red-500 text-white
                            hover:bg-red-700
                            transform hover:scale-105 active:scale-95
                            transition-all duration-300 ease-in-out
                            shadow-md hover:shadow-lg hidden">
                                Batal
                            </button>

                            <!-- SIMPAN -->
                            <button type="submit" id="btnSimpan"
                                class="w-full rounded-lg py-2 bg-blue-900 text-white
                            hover:bg-orange-500
                            transform hover:scale-105 active:scale-95
                            transition-all duration-300 ease-in-out
                            shadow-md hover:shadow-lg hidden">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        let originalData = {};

        function enableEdit() {
            const inputs = ['nama', 'email', 'hp'];

            inputs.forEach(id => {
                const el = document.getElementById(id);
                originalData[id] = el.value;
                el.removeAttribute('readonly');
                el.classList.add('bg-yellow-50');
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
                el.classList.remove('bg-yellow-50');
            });

            document.getElementById('btnEdit').classList.remove('hidden');
            document.getElementById('btnBatal').classList.add('hidden');
            document.getElementById('btnSimpan').classList.add('hidden');
        }
    </script>
    

@endsection

