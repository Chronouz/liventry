@extends('layout')

@section('content')
<div class="p-4">
  <h2 class="text-2xl font-bold mb-4">Daftar Catatan</h2>
  <a href="{{ route('catatan.create') }}" class="btn-add-entry mb-4 inline-block">+ Tambah Catatan</a>

  <form method="GET" class="mb-4">
    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="border p-2 rounded">
    <button class="bg-blue-500 text-white px-4 py-2 rounded ml-2">Filter</button>
  </form>

  @foreach($catatan as $item)
    <div class="entry-card mb-4">
      @if($item->image_path)
        <img src="{{ asset('storage/'.$item->image_path) }}" class="w-24 h-24 rounded mr-4">
      @endif
      <div class="flex-1">
        <div class="entry-title">{{ $item->title }}</div>
        <div class="text-gray-500">{{ Str::limit($item->content, 100) }}</div>
        <div class="entry-meta">
          <i class="fas fa-calendar-alt mr-2"></i><span>{{ $item->entry_date }}</span>
          <i class="fas fa-map-marker-alt ml-4 mr-2"></i><span>{{ $item->location }}</span>
        </div>
        <a href="{{ route('catatan.edit', $item) }}" class="text-blue-600 mt-2 inline-block">Edit</a>
      </div>
    </div>
  @endforeach
</div>
@endsection
