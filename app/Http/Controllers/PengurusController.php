<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PengurusController extends Controller
{
    public function index(): View
    {
        return view('pengurus', $this->staticTeam());
    }

    /**
     * @return array{pengurus: array<int, array{nama: string, jabatan: string, tipe: string, inisial: string, warna: string, foto: null}>, asisten: array<int, array{nama: string, inisial: string, warna: string, foto: null}>}
     */
    private function staticTeam(): array
    {
        $pengurus = [
            [
                'nama' => 'Yuli Wildan Santoso, S.Sn.',
                'jabatan' => __('ui.pengurus.role_coach'),
                'tipe' => 'coach',
                'inisial' => 'YW',
                'warna' => 'hijau',
                'foto' => null,
            ],
            [
                'nama' => 'Anwar Fajar Sidiq, S.Sn.',
                'jabatan' => __('ui.pengurus.role_coach'),
                'tipe' => 'coach',
                'inisial' => 'AF',
                'warna' => 'kuning',
                'foto' => null,
            ],
            [
                'nama' => 'Imas Ayu Kharisma Putri',
                'jabatan' => __('ui.pengurus.role_coach'),
                'tipe' => 'coach',
                'inisial' => 'IA',
                'warna' => 'krem',
                'foto' => null,
            ],
            [
                'nama' => 'Mayla Nazwa Putri Aisyah',
                'jabatan' => __('ui.pengurus.role_admin'),
                'tipe' => 'admin',
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

        return compact('pengurus', 'asisten');
    }
}
