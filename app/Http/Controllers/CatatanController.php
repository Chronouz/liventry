<?php

namespace App\Http\Controllers;

use App\Models\catatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatatanController extends Controller
{
    public function home()
    {
        $catatan = Catatan::latest()->take(5)->get();
        return view('home', compact('catatan'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $catatan = Catatan::when($request->search, function($query) use ($request) {
            return $query->where('location', 'like', "%{$request->search}%")
                         ->orWhere('date', $request->search);
        })
        ->latest()->paginate(10);

    return view('catatan.index', compact('catatan'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('catatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'date' => 'required|date',
            'time' => 'required', 
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('catatan', 'public');
        }

        Catatan::create($validated);
        return redirect()->route('catatan.create')->with('success', 'Diarymu berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(catatan $catatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $catatan = Catatan::findOrFail($id);
        return view('catatan.edit', compact('catatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $catatan = Catatan::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('catatan', 'public');
        }

        $catatan->update($validated);

        return redirect()->route('catatan.edit', $catatan->id)->with('success', 'Diary berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $catatan = Catatan::findOrFail($id);

    // Opsional: hapus file gambar dari storage
    if ($catatan->image_path && Storage::disk('public')->exists($catatan->image_path)) {
        Storage::disk('public')->delete($catatan->image_path);
    }

    $catatan->delete();

    return redirect()->route('catatan.create')->with('success', 'Catatan berhasil dihapus.');
    }
}
