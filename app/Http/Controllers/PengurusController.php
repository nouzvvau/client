<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    private const WARNA = ['hijau', 'kuning', 'krem', 'merah'];

    public function index()
    {
        $staff = Staff::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($staff->isEmpty()) {
            return view('pengurus', $this->staticTeam());
        }

        $pengurus = $staff
            ->filter(fn (Staff $orang) => ! str_contains(strtolower($orang->position ?? ''), 'asisten'))
            ->values()
            ->map(fn (Staff $orang, int $index) => $this->mapTeamMember($orang, $index))
            ->all();

        $asisten = $staff
            ->filter(fn (Staff $orang) => str_contains(strtolower($orang->position ?? ''), 'asisten'))
            ->values()
            ->map(fn (Staff $orang, int $index) => $this->mapTeamMember($orang, $index))
            ->all();

        return view('pengurus', compact('pengurus', 'asisten'));
    }

    private function mapTeamMember(Staff $orang, int $index): array
    {
        return [
            'nama' => $orang->name,
            'jabatan' => $orang->position,
            'inisial' => $this->initials($orang->name),
            'warna' => self::WARNA[$index % count(self::WARNA)],
            'foto' => $orang->photo ? Storage::url($orang->photo) : null,
        ];
    }

    private function initials(string $nama): string
    {
        return strtoupper(
            collect(explode(' ', trim($nama)))
                ->filter()
                ->take(2)
                ->map(fn (string $kata) => mb_substr($kata, 0, 1))
                ->implode('')
        );
    }

    /**
     * Konten statis dipakai sebagai fallback ketika tabel staff masih kosong.
     *
     * @return array{pengurus: array<int, array{nama: string, jabatan: string, inisial: string, warna: string, foto: null}>, asisten: array<int, array{nama: string, inisial: string, warna: string, foto: null}>}
     */
    private function staticTeam(): array
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

        return compact('pengurus', 'asisten');
    }
}
