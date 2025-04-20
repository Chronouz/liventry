@extends('homepage')

@section('content')
    {{-- <livewire:catatan-form /> --}}
    <div class="w-full px-8 max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Tambah Catatan Baru</h1>
    
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif
    
        <form action="{{ route('catatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
    
            {{-- JUDUL --}}
            <div>
                <label class="block font-semibold mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full px-4 py-2 border rounded-md bg-gray-100 focus:ring focus:border-blue-400">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
    
            {{-- CERITA KEGIATAN --}}
            <div>
                <label class="block font-semibold mb-1">Cerita Kegiatanmu</label>
                <textarea name="content" rows="4"
                          class="w-full px-4 py-2 border rounded-md bg-gray-100 focus:ring focus:border-blue-400">{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
    
            {{-- TANGGAL DAN WAKTU --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date') }}"
                           class="w-full px-4 py-2 border rounded-md bg-gray-100 focus:ring focus:border-blue-400">
                    @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Waktu</label>
                    <input type="time" name="time" value="{{ old('time') }}" step="1"
                           class="w-full px-4 py-2 border rounded-md bg-gray-100 focus:ring focus:border-blue-400">
                    @error('time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
    
            {{-- GAMBAR + PREVIEW --}}
            <div>
                <label class="block font-semibold mb-1">Foto Kegiatan</label>
                <input type="file" name="image_path" accept="image/*" onchange="previewImage(event)"
                       class="w-full px-4 py-2 bg-white border rounded-md">
                @error('image_path') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    
                <div id="previewContainer" class="mt-4 hidden">
                    <p class="block font-semibold mb-1">Preview:</p>
                    <img id="imagePreview" src="" class="w-80 h-120 object-cover rounded-lg shadow-md">
                </div>
            </div>
    
            <div class="flex gap-4 pt-4 pb-6">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                <a href="{{ url('/') }}" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Kembali</a>
            </div>
        </form>
    </div>
    
    {{-- PREVIEW SCRIPT --}}
    <script>
    function previewImage(event) {
            const previewContainer = document.getElementById('previewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const file = event.target.files[0];
    
            console.log('File selected:', file); // Debugging: Periksa file yang dipilih
    
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    console.log('FileReader result:', e.target.result); // Debugging: Periksa hasil FileReader
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                console.log('No file selected'); // Debugging: Tidak ada file
                previewContainer.classList.add('hidden');
                imagePreview.src = '';
            }
        }
    </script>
@endsection