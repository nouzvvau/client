<?php

use Illuminate\Support\Facades\Route;

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranMuridController;
use App\Http\Controllers\DaftarMuridController;

Route::get('/pendaftaran', [
    PendaftaranMuridController::class,
    'index'
])->name('pendaftaran.index');

Route::post('/pendaftaran', [
    PendaftaranMuridController::class,
    'store'
])->name('pendaftaran.store');


Route::get('/murid', [
    MuridController::class,
    'index'
])->name('murid.index');


Route::get('/', function () {
    return view('welcome');
});
