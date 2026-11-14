<?php
namespace App\Http\Controllers;

class PengurusController extends Controller
{
    public function index()
    {
        $pengurus = [
            [
                'nama' => 'Yuli Wildan Santoso, S.Sn.',
                'jabatan' => 'Pelatih',
                'inisial' => 'YW',
                'warna' => 'hijau',
                'foto' => null,
            ],
            [
                'nama' => 'Anwar Fajar Sidiq, S.Sn.',
                'jabatan' => 'Pelatih',
                'inisial' => 'AF',
                'warna' => 'kuning',
                'foto' => null,
            ],
            [
                'nama' => 'Imas Ayu Kharisma Putri',
                'jabatan' => 'Pelatih',
                'inisial' => 'IA',
                'warna' => 'krem',
                'foto' => null,
            ],
            [
                'nama' => 'Mayla Nazwa Putri Aisyah',
                'jabatan' => 'Admin & Sosmed Spesialis',
                'inisial' => 'MN',
                'warna' => 'merah',
                'foto' => null,
            ],
        ];

        $asisten = [
            [
                'nama' => 'Zefanya Widya',
                'inisial' => 'ZW',
                'warna' => 'hijau',
                'foto' => null,
            ],
            [
                'nama' => 'Jawwada Hayyu Setya Gita',
                'inisial' => 'JG',
                'warna' => 'kuning',
                'foto' => null,
            ],
            [
                'nama' => 'Angga Ramadhan',
                'inisial' => 'AR',
                'warna' => 'krem',
                'foto' => null,
            ],
            [
                'nama' => 'Mario Bima',
                'inisial' => 'MB',
                'warna' => 'merah',
                'foto' => null,
            ],
        ];

        return view('Pengurus', compact('pengurus', 'asisten'));
    }
}
