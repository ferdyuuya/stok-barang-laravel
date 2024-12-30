<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokLogController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::resource('barang', BarangController::class)->middleware('auth');

Route::post('/barang/add', [StokLogController::class, 'add'])->name('stoklog.add');
Route::post('/barang/subtract', [StokLogController::class, 'subtract'])->name('stoklog.subtract');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
