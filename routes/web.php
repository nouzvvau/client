<?php

use App\Http\Controllers\DaftarMuridController;
use App\Http\Controllers\PendaftaranMuridController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengurusController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pendaftaran', [PendaftaranMuridController::class, 'index'])
    ->name('pendaftaran.index');

Route::post('/pendaftaran', [PendaftaranMuridController::class, 'store'])
    ->name('pendaftaran.store');

Route::get('/murid', [DaftarMuridController::class, 'index'])
    ->name('murid.index');

Route::view('/program', 'program')->name('program');
Route::view('/galeri', 'galeri')->name('galeri');
Route::view('/lokasi', 'lokasi')->name('lokasi');

Route::get('/Pengurus', [PengurusController::class, 'index'])
    ->name('pengurusg');
   