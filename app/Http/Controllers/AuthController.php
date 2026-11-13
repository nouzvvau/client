<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login admin
    public function showLoginForm()
    {
        return view('auth.loginadmin');
    }

    // Memproses data login saat tombol "Masuk ke panel" ditekan
    public function login(Request $request)
    {
        // 1. Validasi input email dan password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek apakah opsi "Ingat saya" (remember me) dicentang
        $remember = $request->has('remember');

        // 3. Proses autentikasi menggunakan Laravel Auth
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Jika berhasil, arahkan ke halaman dashboard (atau halaman galeri admin)
            return redirect()->intended('/admin/dashboard') // Sesuaikan dengan route tujuanmu
                             ->with('success', 'Berhasil masuk ke panel admin.');
        }

        // 4. Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Proses Logout (Keluar)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Mengarahkan kembali ke halaman login setelah keluar
    }
}