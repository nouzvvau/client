<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use App\Support\WhatsApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EventBookingController extends Controller
{
    public function index(Request $request): View
    {
        $bookings = EventBooking::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = '%'.trim((string) $request->input('q')).'%';

                $query->where(function ($query) use ($term): void {
                    $query->where('name', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhere('event_name', 'like', $term)
                        ->orWhere('institution_name', 'like', $term)
                        ->orWhere('service_type', 'like', $term);
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->input('status'));
            })
            ->when($request->filled('from'), function ($query) use ($request): void {
                $query->whereDate('event_date', '>=', $request->input('from'));
            })
            ->when($request->filled('to'), function ($query) use ($request): void {
                $query->whereDate('event_date', '<=', $request->input('to'));
            })
            ->orderByDesc('event_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => EventBooking::query()->count(),
            'pending' => EventBooking::query()->where('status', EventBooking::STATUS_PENDING)->count(),
            'accepted' => EventBooking::query()->where('status', EventBooking::STATUS_ACCEPTED)->count(),
            'rejected' => EventBooking::query()->where('status', EventBooking::STATUS_REJECTED)->count(),
        ];

        return view('admincakraaji.bookings.index', compact('bookings', 'stats'));
    }

    public function create(): View
    {
        return view('admincakraaji.bookings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBooking($request);

        $booking = EventBooking::create($validated);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Data booking acara berhasil ditambahkan.');
    }

    public function show(EventBooking $booking): View
    {
        return view('admincakraaji.bookings.show', [
            'booking' => $booking,
            'whatsappLink' => WhatsApp::link(
                'Halo '.$booking->name.', kami dari Sanggar Cakra Aji ingin menindaklanjuti booking acara '.$booking->event_name.'.',
                $booking->phone
            ),
        ]);
    }

    public function edit(EventBooking $booking): View
    {
        return view('admincakraaji.bookings.edit', compact('booking'));
    }

    public function update(Request $request, EventBooking $booking): RedirectResponse
    {
        $validated = $this->validateBooking($request);

        $booking->update($validated);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Data booking acara berhasil diperbarui.');
    }

    public function updateStatus(Request $request, EventBooking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(EventBooking::STATUSES)],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function destroy(EventBooking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Data booking acara berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateBooking(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]+$/'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'service_type' => ['required', 'string', 'max:255'],
            'event_name' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'event_location' => ['required', 'string', 'max:1000'],
            'estimated_audience' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'additional_notes' => ['nullable', 'string', 'max:2000'],
            'status' => ['nullable', Rule::in(EventBooking::STATUSES)],
        ]);

        $validated['status'] = $validated['status'] ?? EventBooking::STATUS_PENDING;

        return $validated;
    }
}
