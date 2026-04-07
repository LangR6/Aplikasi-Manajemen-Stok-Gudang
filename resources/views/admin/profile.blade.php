@extends('admin.app')

@section('title', 'Profile')

@section('content')
    <div class="p-20 flex items-center justify-center">

        <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow border">

            <!-- Tombol Kembali -->
            <div class="flex justify-end mb-4">
                <a href="{{ url()->previous() }}" class="px-4 py-1 text-sm text-white border rounded bg-red-500 hover:bg-red-700">
                    Kembali
                </a>
            </div>

            <div class="grid grid-cols-2 gap-6">

                <!-- FOTO PROFILE -->
                <div class="flex items-center justify-center border rounded-lg h-64">
                    <img id="preview" src="{{ auth()->user()->foto ?? 'https://via.placeholder.com/150' }}"
                        class="w-full h-full object-cover ">
                </div>

                <!-- FORM -->
                <div>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Panggilan -->
                        <label class="block mb-1 text-sm font-medium">Nama Pengguna :</label>
                        <input type="text" value="ADMIN 1"
                            class="w-full border rounded text-center p-11 mb-3 bg-gray-50 cursor-not-allowed" readonly>

                        <!-- Upload Foto -->
                        <div class="flex items-center gap-2 mb-3">
                            <input type="file" name="foto" id="foto" class="border p-1 w-full"
                                onchange="previewImage(event)">
                            <span class="text-sm text-gray-500">.jpg</span>
                        </div>

                        <!-- Tombol -->
                        <div class="flex gap-2">
                            <button type="submit" class="w-full text-white bg-green-500 hover:bg-green-700 p-2 rounded">
                                Simpan
                            </button>

                            <button type="button" onclick="location.reload()" class="w-full text-white bg-red-500 hover:bg-red-700 py-2 rounded text-sm">
                                Batal
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT PREVIEW FOTO -->
    <script>
        function previewImage(event) {
            const image = document.getElementById('preview');
            image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
