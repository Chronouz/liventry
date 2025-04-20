@extends('homepage')

@section('content')
<div class="p-4 flex-1 overflow-y-auto" x-data="{ activeId: null }">
    <div class="text-xl font-bold mb-4">Catatan Diarymu</div>

    @if($items->isEmpty())
        <div class="text-gray-500">Tidak ada catatan untuk tanggal {{ $tanggal }}.</div>
    @else
        @foreach ($items as $item)
            <div 
                @click="activeId === {{ $item->id }} ? activeId = null : activeId = {{ $item->id }}"
                class="bg-white rounded shadow p-4 mb-4 cursor-pointer transition-all duration-300 ease-in-out overflow-hidden"
                :class="{ 'flex-col': activeId === {{ $item->id }}, 'flex': activeId !== {{ $item->id }} }"
            >
                {{-- Gambar --}}
                <img 
                    alt="{{ $item->title }}"
                    src="{{ asset('storage/' . $item->image_path) }}"
                    class="rounded mb-2 transition-all duration-300 ease-in-out"
                    :class="{ 'w-full h-auto mb-4': activeId === {{ $item->id }}, 'w-24 h-24 mr-4': activeId !== {{ $item->id }} }"
                />

                <div class="flex-1">
                    {{-- Judul --}}
                    <div class="font-bold text-lg text-gray-800">
                        {{ $item->title }}
                    </div>

                    {{-- Konten --}}
                    <div class="text-gray-600 mt-2 text-sm transition-all duration-300"
                         :class="{ 'line-clamp-3': activeId !== {{ $item->id }} }">
                        {{ $item->content }}
                    </div>

                    {{-- Detail waktu --}}
                    <div class="flex items-center text-gray-500 text-sm mt-3 space-x-4">
                        <div class="flex items-center">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>{{ $item->date }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span>{{ $item->time }}</span>
                        </div>
                    </div>

                    {{-- Tombol Edit hanya saat expanded --}}
                    <div class="mt-4 flex justify-end" x-show="activeId === {{ $item->id }}" x-transition>
                        <a href="{{ route('catatan.edit', $item->id) }}"
                           class="px-4 py-1 bg-yellow-500 text-black rounded hover:bg-yellow-600 text-sm">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection