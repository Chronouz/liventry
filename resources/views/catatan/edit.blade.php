@extends('homepage')

@section('content')
  <div class="w-full px-8 max-w-4xl mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Catatan</h1>

      @if (session('success'))
          <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
              {{ session('success') }}
          </div>
      @endif

      <form action="{{ route('catatan.update', $catatan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
          @csrf
          @method('PUT')

          {{-- JUDUL --}}
          <div>
              <label class="block font-semibold mb-1">Judul</label>
              <input type="text" name="title" value="{{ old('title', $catatan->title) }}"
                    class="w-full px-4 py-2 border rounded-md bg-gray-100">
          </div>

          {{-- CERITA --}}
          <div>
              <label class="block font-semibold mb-1">Cerita Kegiatanmu</label>
              <textarea name="content" rows="4"
                        class="w-full px-4 py-2 border rounded-md bg-gray-100">{{ old('content', $catatan->content) }}</textarea>
          </div>

          {{-- TANGGAL DAN WAKTU --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                  <label class="block font-semibold mb-1">Tanggal</label>
                  <input type="date" name="date" value="{{ old('date', $catatan->date) }}"
                        class="w-full px-4 py-2 border rounded-md bg-gray-100">
              </div>
              <div>
                    <label class="block font-semibold mb-1">Waktu</label>
                    <input type="time" step="1" name="time" value="{{ old('time', $catatan->time) }}"
                      class="w-full px-4 py-2 border rounded-md bg-gray-100">
              </div>
          </div>

          {{-- GAMBAR --}}
          <div>
              <label class="block font-semibold mb-1">Gambar</label>
              <input type="file" name="image_path" accept="image/*" onchange="previewImage(event)"
                    class="w-full px-4 py-2 bg-white border rounded-md">

              {{-- Preview Gambar Lama --}}
              @if ($catatan->image_path)
                  <div class="mt-4">
                      <p class="text-sm text-gray-600 mb-1">Gambar Saat Ini:</p>
                      <img src="{{ asset('storage/' . $catatan->image_path) }}"
                          class="w-40 h-40 object-cover rounded-lg shadow">
                  </div>
              @endif

              {{-- Preview Gambar Baru --}}
              <div id="previewContainer" class="mt-4 hidden">
                  <p class="text-sm text-gray-600 mb-1">Preview Gambar Baru:</p>
                  <img id="imagePreview" src="" class="w-40 h-40 object-cover rounded-lg shadow-md">
              </div>
          </div>

          <div class="flex justify-between items-center pt-4 pb-6">
            {{-- Tombol Kiri: Perbarui dan Kembali --}}
            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Perbarui
                </button>
                <a href="{{ url('/') }}" class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Kembali
                </a>
            </div>
        
            {{-- Tombol Kanan: Hapus --}}
            <form action="{{ route('catatan.destroy', $catatan->id) }}" method="POST"
                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus catatan ini?');"
                  class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    Hapus Catatan
                </button>
            </form>
        </div>
        
          
      </form>

      
  </div>
@endsection
