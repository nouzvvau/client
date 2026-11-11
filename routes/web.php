<?php

use App\Http\Controllers\DaftarMuridController;
use App\Http\Controllers\PendaftaranMuridController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pendaftaran', [PendaftaranMuridController::class, 'index'])
    ->name('pendaftaran.index');

Route::post('/pendaftaran', [PendaftaranMuridController::class, 'store'])
    ->name('pendaftaran.store');

Route::get('/murid', [DaftarMuridController::class, 'index'])
    ->name('murid.index');

Route::view('/program', 'pages.program')->name('program');
Route::view('/galeri', 'pages.galeri')->name('galeri');
Route::view('/lokasi', 'pages.lokasi')->name('lokasi');
