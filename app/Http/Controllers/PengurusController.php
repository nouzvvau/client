<?php
namespace App\Http\Controllers;

use Illuminate\View\View;

class PengurusController extends Controller
{
    public function index(): View
    {
        return view('pengurus', $this->staticTeam());
    }

    private function staticTeam(): array
    {
        $pengurus = [
            [
                'nama' => 'Yuli Wildan Santoso, S.Sn.',
                'jabatan' => __('ui.pengurus.role_coach'),
                'tipe' => 'coach',
                'inisial' => 'YW',
                'warna' => 'hijau',
                'foto' => 'assets/images/pengurus/yuli-wildan.jpg',
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
                'foto' => 'assets/images/pengurus/imas.jpg',
            ],
            [
                'nama' => 'Mayla Nazwa Putri Aisyah',
                'jabatan' => __('ui.pengurus.role_admin'),
                'tipe' => 'admin',
                'inisial' => 'MN',
                'warna' => 'merah',
                'foto' => 'assets/images/pengurus/mayla.jpg',
            ],
        ];

        $asisten = [
            [
                'nama' => 'Zefanya Widya',
                'inisial' => 'ZW',
                'warna' => 'hijau',
                'foto' => 'assets/images/pengurus/zeffan.jpg',
            ],
            [
                'nama' => 'Jawwada Hayyu Setya Gita',
                'inisial' => 'JG',
                'warna' => 'kuning',
                'foto' => 'assets/images/pengurus/jawada.jpg',
            ],
            [
                'nama' => 'Angga Ramadhan',
                'inisial' => 'AR',
                'warna' => 'krem',
                'foto' => 'assets/images/pengurus/angga.jpg',
            ],
            [
                'nama' => 'Mario Bima',
                'inisial' => 'MB',
                'warna' => 'merah',
                'foto' => 'assets/images/pengurus/mario.jpg',
            ],
        ];

        return compact('pengurus', 'asisten');
    }
}
