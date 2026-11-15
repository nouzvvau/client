<?php

use App\Http\Controllers\DaftarMuridController;
use App\Http\Controllers\PendaftaranMuridController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\ProgramPageController;
use App\Http\Controllers\Admin\GaleriController;

Route::get('/', function () {return view('beranda');});
Route::get('/pendaftaran', [PendaftaranMuridController::class, 'index'])->name('pendaftaran.index');
Route::post('/pendaftaran', [PendaftaranMuridController::class, 'store'])->name('pendaftaran.store');
Route::get('/murid', [DaftarMuridController::class, 'index'])->name('murid.index');
Route::view('/program', 'program')->name('program');
Route::get('/program/kegiatan/{slug}', [ProgramPageController::class, 'detail'])->name('program.detail');
Route::view('/galeri', 'galeri')->name('galeri');
Route::view('/lokasi', 'lokasi')->name('lokasi');
Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus');
Route::get('/tentang-kami', function () {return view('tentang-kami');});


Route::get('/admin/galeri', [GaleriController::class, 'index'])->name('admin.galeri');
Route::get('/admin/galeri/create', [GaleriController::class, 'create'])->name('admin.galeri.create');
Route::post('/admin/galeri', [GaleriController::class, 'store'])->name('admin.galeri.store');