<?php

namespace App\Http\Controllers;

use App\Models\catatan;
use Illuminate\Http\Request;

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
                         ->orWhere('entry_date', $request->search);
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
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'location' => 'nullable|string',
            'entry_date' => 'required|date',
            'time' => 'required|date_format:H:i', // Validasi waktu
            'image_path' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('catatan', 'public');
        }

        Catatan::create($data);
        return redirect()->route('catatan.index')->with('success', 'Diarymu berhasil ditambahkan!');
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
    public function edit(catatan $catatan)
    {
        return view('catatan.edit', compact('catatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, catatan $catatan)
    {
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'location' => 'nullable|string',
            'entry_date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('catatan', 'public');
        }

        $catatan->update($data);
        return redirect()->route('catatan.index')->with('success', 'Diary berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(catatan $catatan)
    {
        //
    }
}
