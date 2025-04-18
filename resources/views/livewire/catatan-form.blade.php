<div class="max-w-4xl mx-auto p-8 bg-white shadow rounded">
    <h1 class="text-3xl font-bold mb-6">Tambah Diary Hari Ini</h1>
    <form wire:submit.prevent="submit">
        {{ $form }}
        
        <div class="flex space-x-4 mt-6">
            <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded">Create</button>
            <button type="reset" class="bg-gray-700 text-white px-4 py-2 rounded">Reset</button>
            <a href="{{ url('/') }}" class="bg-gray-800 text-white px-4 py-2 rounded border border-gray-700">Cancel</a>
        </div>
    </form>
</div>
