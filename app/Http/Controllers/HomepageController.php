<?php

namespace App\Http\Controllers;

use App\Models\catatan;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari parameter atau gunakan tanggal hari ini
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));

        // Ambil query pencarian dari kolom search
        $search = $request->get('search', '');

        // Jika ada parameter search, cari berdasarkan judul saja
        if ($search) {
            $items = catatan::where('title', 'like', "%{$search}%")
                ->latest()
                ->get();
        } else {
            // Jika tidak ada parameter search, ambil semua catatan berdasarkan tanggal
            $items = catatan::where('date', $tanggal)->latest()->get();
        }

        // Kirim data ke view show.blade.php
        return view('catatan.show', compact('items', 'tanggal', 'search'));
    }
}