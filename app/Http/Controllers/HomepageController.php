<?php

namespace App\Http\Controllers;

use App\Models\catatan;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua catatan berdasarkan tanggal jika parameter "tanggal" ada
        if ($request->has('tanggal')) {
            $items = catatan::where('entry_date', $request->tanggal)->latest()->get();
        } else {
            // Jika tidak ada parameter "tanggal", ambil semua catatan
            $items = catatan::latest()->get();
        }

        // Kirim data ke view show.blade.php
        return view('catatan.show', compact('items'));
    }
}