@extends('layout')

@section('content')
<div class="p-4 max-w-xl mx-auto">
  <h2 class="text-xl font-bold mb-4">Edit Catatan</h2>

  <form method="POST" action="{{ route('catatan.update', $catatan) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input name="title" value="{{ $catatan->title }}" class="w-full p-2 mb-2 border rounded">
    <textarea name="content" class="w-full p-2 mb-2 border rounded">{{ $catatan->content }}</textarea>

    <input name="entry_date" type="date" value="{{ $catatan->entry_date }}" class="w-full p-2 mb-2 border rounded" required>

    <input id="autocomplete" type="text" placeholder="Cari lokasi..." value="{{ $catatan->location }}" class="w-full p-2 mb-2 border rounded">
    <input type="hidden" name="location" id="location" value="{{ $catatan->location }}">

    <input type="file" name="image" class="mb-4">

    <button class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
  </form>

  <script>
    function initAutocomplete() {
      const input = document.getElementById('autocomplete');
      const autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        document.getElementById('location').value = place.formatted_address;
      });
    }
  </script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places&callback=initAutocomplete" async defer></script>
</div>
@endsection
