<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\WhatsAppService;

class BookingController extends Controller
{
    // ===== ADMIN =====

    public function index()
    {
        $bookings = Booking::with(['user', 'room.hotel', 'room.roomType'])
            ->where('archived', false)
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'room.hotel', 'room.roomType', 'payment']);

        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,completed,cancelled',
        ]);

        $booking->update($validated);

        // Sinkronkan status kamar sesuai status booking
        if (in_array($validated['status'], ['completed', 'cancelled'])) {
            $booking->room->update(['status' => 'available']);
        } elseif (in_array($validated['status'], ['confirmed', 'checked_in'])) {
            $booking->room->update(['status' => 'booked']);
        }

        // Kirim notifikasi WhatsApp perubahan status
        $statusText = match($validated['status']) {
            'confirmed' => 'DIKONFIRMASI ✅',
            'checked_in' => 'CHECK-IN 🏨',
            'completed' => 'SELESAI 🎉',
            'cancelled' => 'DIBATALKAN ❌',
            default => strtoupper($validated['status']),
        };

        WhatsAppService::send(
            $booking->user->phone,
            "Halo {$booking->user->name}!\n\n".
            "Status booking Anda ({$booking->booking_code}) telah diperbarui menjadi:\n".
            "*{$statusText}*\n\n".
            "Terima kasih telah menggunakan layanan kami."
        );

        return redirect()->route('admin.bookings.index')->with('success', 'Status booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $booking->update(['archived' => true]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus.');
    }

    // ===== CUSTOMER =====

    public function create()
    {
        $rooms = Room::with(['hotel', 'roomType'])
            ->where('status', 'available')
            ->where('archived', false)
            ->get();

        $selectedRoom = $request = request('room_id')
            ? Room::with(['hotel', 'roomType'])->find(request('room_id'))
            : null;

        return view('booking.create', compact('rooms', 'selectedRoom'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'  => 'required|exists:tbl_rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'notes'    => 'nullable|string',
        ]);

        $room = Room::with('roomType')->findOrFail($validated['room_id']);

        if ($room->status !== 'available') {
            return back()->withErrors(['room_id' => 'Kamar ini sudah tidak tersedia.'])->withInput();
        }

        $nights = (new \DateTime($validated['check_in']))->diff(new \DateTime($validated['check_out']))->days;
        $totalPrice = $nights * $room->roomType->price;

        $booking = Booking::create([
            'booking_code'  => 'BK-' . now()->format('Ymd') . '-' . str_pad(Booking::count() + 1, 4, '0', STR_PAD_LEFT),
            'user_id'       => auth()->id(),
            'room_id'       => $room->id,
            'check_in'      => $validated['check_in'],
            'check_out'     => $validated['check_out'],
            'total_nights'  => $nights,
            'total_price'   => $totalPrice,
            'status'        => 'pending',
            'notes'         => $validated['notes'] ?? null,
        ]);

        Payment::create([
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . str_pad(Payment::count() + 1, 4, '0', STR_PAD_LEFT),
            'booking_id'     => $booking->id,
            'amount'         => $totalPrice,
            'method'         => 'simulation',
            'status'         => 'pending',
        ]);

        $room->update(['status' => 'booked']);

        // Kirim notifikasi WhatsApp booking baru
        WhatsAppService::send(
            auth()->user()->phone,
            "Halo {$booking->user->name}! 👋\n\n".
            "Booking Anda berhasil dibuat.\n\n".
            "Kode Booking: {$booking->booking_code}\n".
            "Hotel: {$room->hotel->name}\n".
            "Kamar: {$room->roomType->name} ({$room->room_number})\n".
            "Check-in: " . \Carbon\Carbon::parse($booking->check_in)->translatedFormat('j M Y') . "\n".
            "Check-out: " . \Carbon\Carbon::parse($booking->check_out)->translatedFormat('j M Y') . "\n".
            "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n".
            "Status booking Anda saat ini: PENDING. Kami akan menghubungi Anda untuk konfirmasi lebih lanjut."
        );

        return redirect()->route('booking.history')->with('success', 'Booking berhasil dibuat! Kode booking: ' . $booking->booking_code);
    }

    public function myBookings()
    {
        $bookings = Booking::with(['room.hotel', 'room.roomType', 'payment'])
            ->where('user_id', auth()->id())
            ->where('archived', false)
            ->latest()
            ->paginate(10);

        return view('booking.history', compact('bookings'));
    }

    public function downloadInvoice(Booking $booking)
    {
        // Hanya pemilik booking atau admin yang boleh download
        if ($booking->user_id !== auth()->id() && ! auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak punya akses ke invoice ini.');
        }

        $booking->load(['user', 'room.hotel', 'room.roomType', 'payment']);

        $pdf = Pdf::loadView('invoice.pdf', compact('booking'));

        return $pdf->download('Invoice-' . $booking->booking_code . '.pdf');
    }
}