<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PendaftaranMurid;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    /**
     * Halaman admin: daftar pendaftar murid dari tabel pendaftaran_murids.
     */
    public function pendaftar(Request $request): View
    {
        $query = PendaftaranMurid::query()
            ->when($request->filled('cari'), function ($query) use ($request) {
                $cari = $request->cari;
                $query->where(function ($sub) use ($cari) {
                    $sub->where('nama_murid', 'like', '%'.$cari.'%')
                        ->orWhere('nama_wali', 'like', '%'.$cari.'%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest();

        $pendaftars = $query->paginate(10)->withQueryString();

        $jumlahBaru = PendaftaranMurid::where('status', 'Menunggu')->count();
        $jumlahDihubungi = PendaftaranMurid::where('status', 'Dihubungi')->count();
        $jumlahDiterima = PendaftaranMurid::where('status', 'Diterima')->count();

        return view('admincakraaji.daftarSiswa', compact(
            'pendaftars',
            'jumlahBaru',
            'jumlahDihubungi',
            'jumlahDiterima',
        ));
    }

    /**
     * Ubah status pendaftaran murid dari panel admin.
     */
    public function updatePendaftarStatus(Request $request, PendaftaranMurid $pendaftar): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Menunggu', 'Dihubungi', 'Diterima'])],
        ]);

        $pendaftar->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status pendaftar berhasil diperbarui.');
    }

    /**
     * Halaman admin: daftar booking acara.
     */
    public function booking(Request $request): View
    {
        $bookings = Booking::query()
            ->when($request->filled('cari'), function ($query) use ($request) {
                $cari = $request->cari;
                $query->where(function ($sub) use ($cari) {
                    $sub->where('name', 'like', '%'.$cari.'%')
                        ->orWhere('event_name', 'like', '%'.$cari.'%')
                        ->orWhere('institution_name', 'like', '%'.$cari.'%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $jumlahBaru = Booking::where('status', 'pending')->count();
        $jumlahDikonfirmasi = Booking::where('status', 'accepted')->count();
        $jumlahDitolak = Booking::where('status', 'rejected')->count();

        return view('admincakraaji.bookingAcara', compact(
            'bookings',
            'jumlahBaru',
            'jumlahDikonfirmasi',
            'jumlahDitolak',
        ));
    }

    /**
     * Ubah status booking (hanya kolom status).
     */
    public function updateBookingStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'accepted', 'rejected'])],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * Hapus booking dari panel admin.
     */
    public function destroyBooking(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()
            ->route('admin.booking')
            ->with('success', 'Booking berhasil dihapus.');
    }

    /**
     * Halaman admin: pengaturan daftar nama siswa yang tampil di website.
     */
    public function namaMurid(Request $request): View
    {
        $murids = Student::query()
            ->with('programs')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $query->where('full_name', 'like', '%'.$request->cari.'%');
            })
            ->orderBy('full_name')
            ->paginate(10)
            ->withQueryString();

        $programs = Program::orderBy('name')->get();

        return view('admincakraaji.namaMurid', compact('murids', 'programs'));
    }

    /**
     * Tambah murid baru dari panel admin.
     */
    public function storeMurid(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_murid' => ['required', 'string', 'max:255'],
            'program_id' => ['nullable', 'integer', 'exists:programs,id'],
        ]);

        $student = Student::create(['full_name' => $validated['nama_murid']]);

        if (! empty($validated['program_id'])) {
            $student->programs()->attach($validated['program_id'], [
                'status' => 'active',
                'joined_at' => now()->toDateString(),
            ]);
        }

        return back()->with('success', 'Murid berhasil ditambahkan.');
    }

    /**
     * Ubah nama murid dari panel admin.
     */
    public function updateMurid(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'nama_murid' => ['required', 'string', 'max:255'],
            'program_id' => ['nullable', 'integer', 'exists:programs,id'],
        ]);

        $student->update(['full_name' => $validated['nama_murid']]);

        if (array_key_exists('program_id', $validated)) {
            $student->programs()->detach();
            if (! empty($validated['program_id'])) {
                $student->programs()->attach($validated['program_id'], [
                    'status' => 'active',
                    'joined_at' => now()->toDateString(),
                ]);
            }
        }

        return back()->with('success', 'Nama murid berhasil diperbarui.');
    }

    /**
     * Hapus murid dari panel admin.
     */
    public function destroyMurid(Student $student): RedirectResponse
    {
        if ($student->programs()->exists()) {
            return back()->withErrors([
                'murid' => 'Murid masih terhubung dengan program. Lepaskan programnya terlebih dahulu.',
            ]);
        }

        $student->delete();

        return back()->with('success', 'Murid berhasil dihapus.');
    }
}
