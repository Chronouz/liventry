@extends('homepage')

@section('content')
<div class="p-4 flex-1 overflow-y-auto">
    <div class="text-xl font-bold mb-4">Catatan Diary Hari Ini</div>
    
        @if($items->isEmpty())
            <div class="text-gray-500">Tidak ada catatan untuk tanggal {{ $tanggal }}.</div>
        @else
            @foreach ($items as $item)
                <div class="bg-white rounded shadow p-4 flex mb-4">
                    <img alt="{{ $item->title }}" class="w-24 h-24 rounded mr-4" height="100" src="{{ asset('storage/' . $item->image_path) }}" width="100"/>
                    <div class="flex-1">
                        <div class="font-bold">
                            {{ $item->title }}
                        </div>
                        <div class="text-gray-500">
                            {{ $item->content }}
                        </div>
                        <div class="flex items-center text-gray-500 text-sm mt-2">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            <span>
                                {{ $item->entry_date }}
                            </span>
                            <i class="fas fa-book-open ml-4 mr-2"></i>
                            <span>
                                {{ $item->story_count ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
</div>
@endsection