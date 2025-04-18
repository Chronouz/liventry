<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\HomepageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::resource('catatan', \App\Http\Controllers\CatatanController::class);
});

Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('/create', [CatatanController::class, 'create'])->name('catatan.create');
Route::resource('catatan', CatatanController::class);
Route::resource('catatan', CatatanController::class)->except(['destroy']);
