<?php

use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingPublicController;
use App\Http\Controllers\DaftarMuridController;
use App\Http\Controllers\GaleriPageController;
use App\Http\Controllers\InformasiPageController;
use App\Http\Controllers\LokasiPageController;
use App\Http\Controllers\PendaftaranMuridController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\ProgramPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('beranda');
});

// Route untuk Ganti Bahasa (IDN / ENG)
Route::get('/bahasa/{locale}', function (Request $request, string $locale) {
    abort_unless(in_array($locale, ['id', 'en'], true), 404);

    $request->session()->put('locale', $locale);
    // Menyimpan session secara permanen sebelum redirect
    $request->session()->save();

    return redirect()->back();
})->name('language.switch');

// SEMENTARA: halaman tes bahasa. Hapus blok ini setelah selesai dites.
Route::get('/cek-bahasa', function () {
    return [
        'locale'    => app()->getLocale(),
        'session'   => session('locale'),
        'tes'       => __('Daftar Jadi Murid'),
        'lang_path' => lang_path(),
        'en_json'   => file_exists(lang_path('en.json')),
    ];
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.proses')
    ->middleware('throttle:6,1');

Route::middleware(['auth', 'admin'])->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin/dashboard', function () {
        return view('admincakraaji.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/pendaftar', [AdminPageController::class, 'pendaftar'])
        ->name('admin.pendaftar');

    Route::get('/admin/booking', [AdminPageController::class, 'booking'])
        ->name('admin.booking');

    Route::get('/admin/nama-murid', [AdminPageController::class, 'namaMurid'])
        ->name('admin.nama-murid');

    Route::post('/admin/nama-murid', [AdminPageController::class, 'storeMurid'])
        ->name('admin.nama-murid.store');

    Route::put('/admin/nama-murid/{student}', [AdminPageController::class, 'updateMurid'])
        ->name('admin.nama-murid.update');

    Route::delete('/admin/nama-murid/{student}', [AdminPageController::class, 'destroyMurid'])
        ->name('admin.nama-murid.destroy');

    Route::get('/admin/galeri', [GaleriController::class, 'index'])
        ->name('admin.galeri');

    Route::get('/admin/galeri/create', [GaleriController::class, 'create'])
        ->name('admin.galeri.create');

    Route::post('/admin/galeri', [GaleriController::class, 'store'])
        ->name('admin.galeri.store');
});

Route::get('/pendaftaran', [PendaftaranMuridController::class, 'index'])
    ->name('pendaftaran.index');

Route::post('/pendaftaran', [PendaftaranMuridController::class, 'store'])
    ->name('pendaftaran.store');

Route::post('/booking', [BookingPublicController::class, 'store'])
    ->name('booking.store')
    ->middleware('throttle:6,1');

Route::get('/booking', [InformasiPageController::class, 'booking'])
    ->name('booking');

Route::get('/murid', [DaftarMuridController::class, 'index'])
    ->name('murid.index');

Route::get('/program', [ProgramPageController::class, 'index'])
    ->name('program');

Route::get('/program/kegiatan/{slug}', [ProgramPageController::class, 'detail'])
    ->name('program.detail');

Route::get('/galeri', [GaleriPageController::class, 'index'])
    ->name('galeri');

Route::get('/lokasi', [LokasiPageController::class, 'index'])
    ->name('lokasi');

Route::get('/kontak', [InformasiPageController::class, 'kontak'])
    ->name('kontak');

Route::get('/faq', [InformasiPageController::class, 'faq'])
    ->name('faq');

Route::get('/pengurus', [PengurusController::class, 'index'])
    ->name('pengurus');

Route::get('/tentang-kami', function () {
    return view('tentang-kami');
});