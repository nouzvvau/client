<?php

use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\EventDocumentationController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\WhatsAppSettingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarMuridController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GaleriPageController;
use App\Http\Controllers\InformasiPageController;
use App\Http\Controllers\LokasiPageController;
use App\Http\Controllers\PendaftaranMuridController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\ProgramPageController;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// PUBLIC
Route::get('/', fn () => view('beranda', ['programs' => Program::latest()->take(3)->get()]));

Route::get('/bahasa/{locale}', function (Request $request, string $locale) {
    abort_unless(in_array($locale, ['id', 'en'], true), 404);
    $request->session()->put('locale', $locale);

    return redirect()->back();
})->name('language.switch');

Route::get('/cek-bahasa', fn () => [
    'locale' => app()->getLocale(),
    'session' => session('locale'),
    'tes' => __('Daftar Jadi Murid'),
    'lang_path' => lang_path(),
    'en_json' => file_exists(lang_path('en.json')),
]);

// AUTHENTICATION
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses')->middleware('throttle:6,1');

// ADMIN
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminPageController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dokumentasi acara (terhubung dengan Program & Kegiatan)
    Route::prefix('admin/dokumentasi-kegiatan')
        ->name('admin.event-documentations.')
        ->controller(EventDocumentationController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/tambah', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{documentation}', 'show')->name('show');
            Route::get('/{documentation}/ubah', 'edit')->name('edit');
            Route::put('/{documentation}', 'update')->name('update');
            Route::delete('/{documentation}', 'destroy')->name('destroy');
            Route::delete('/foto/{photo}', 'destroyPhoto')->name('photo.destroy');
        });

    // Galeri umum (mandiri)
    Route::prefix('admin/galeri')
        ->name('admin.public-gallery.')
        ->controller(GalleryController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{photo}', 'update')->name('update');
            Route::delete('/{photo}', 'destroy')->name('destroy');
        });

    // WhatsApp settings
    Route::get('/admin/pengaturan/whatsapp', [WhatsAppSettingController::class, 'edit'])->name('admin.whatsapp.edit');
    Route::put('/admin/pengaturan/whatsapp', [WhatsAppSettingController::class, 'update'])->name('admin.whatsapp.update');

    // Student names
    Route::get('/admin/nama-murid', [AdminPageController::class, 'namaMurid'])->name('admin.nama-murid');

    Route::prefix('admin/nama-murid')->name('admin.nama-murid.')->controller(AdminPageController::class)->group(function () {
        Route::post('/', 'storeMurid')->name('store');
        Route::get('/{student}/ubah', 'editMurid')->name('edit');
        Route::put('/{student}', 'updateMurid')->name('update');
        Route::delete('/{student}', 'destroyMurid')->name('destroy');
    });

    // Programs
    Route::prefix('admin/program')->name('admin.program.')->controller(AdminProgramController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{program}/edit', 'edit')->name('edit');
        Route::put('/{program}', 'update')->name('update');
        Route::post('/{program}/foto-dokumentasi', 'documentationPhotos')->name('documentation-photos');
        Route::delete('/{program}', 'destroy')->name('destroy');
    });
});

// WEBSITE PAGES
Route::get('/pendaftaran', [PendaftaranMuridController::class, 'index'])->name('pendaftaran.index');
Route::get('/booking', [InformasiPageController::class, 'booking'])->name('booking');
Route::get('/murid', [DaftarMuridController::class, 'index'])->name('murid.index');

Route::get('/program', [ProgramPageController::class, 'index'])->name('program');
Route::get('/program/kegiatan/{slug}', [ProgramPageController::class, 'detail'])->name('program.detail');

Route::get('/galeri', [GaleriPageController::class, 'index'])->name('galeri');
Route::get('/galeri/acara/{eventDocumentation}', [GaleriPageController::class, 'show'])->name('galeri.acara');

Route::get('/lokasi', [LokasiPageController::class, 'index'])->name('lokasi');
Route::get('/kontak', [InformasiPageController::class, 'kontak'])->name('kontak');
Route::get('/faq', [InformasiPageController::class, 'faq'])->name('faq');
Route::get('/kritik-saran', [FeedbackController::class, 'create'])->name('kritik-saran');
Route::post('/kritik-saran', [FeedbackController::class, 'store'])->name('kritik-saran.store');
Route::get('/pengurus', [PengurusController::class, 'index'])->name('pengurus');
Route::view('/tentang-kami', 'tentang-kami');
