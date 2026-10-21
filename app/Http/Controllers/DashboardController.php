<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $totalHotels = Hotel::where('archived', false)->count();
            $totalRooms = Room::where('archived', false)->count();
            $totalBookings = Booking::where('archived', false)->count();
            $totalRevenue = Booking::where('archived', false)
                ->whereIn('status', ['confirmed', 'checked_in', 'completed'])
                ->sum('total_price');

            $roomsAvailable = Room::where('archived', false)->where('status', 'available')->count();
            $roomsBooked = Room::where('archived', false)->where('status', 'booked')->count();
            $roomsMaintenance = Room::where('archived', false)->where('status', 'maintenance')->count();

            // Tren booking 7 hari terakhir
            $last7Days = collect(range(6, 0))->map(function ($i) {
                $date = now()->subDays($i)->startOfDay();
                $count = Booking::where('archived', false)
                    ->whereDate('created_at', $date->toDateString())
                    ->count();
                return ['label' => $date->translatedFormat('D'), 'count' => $count];
            });
            $maxCount = max(1, $last7Days->max('count'));

            $upcomingCheckins = Booking::with(['user', 'room.hotel'])
                ->where('archived', false)
                ->whereIn('status', ['confirmed', 'checked_in'])
                ->whereDate('check_in', '>=', now()->toDateString())
                ->orderBy('check_in')
                ->take(5)
                ->get();

            $recentBookings = Booking::with(['user', 'room.hotel'])
                ->where('archived', false)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.admin', compact(
                'totalHotels', 'totalRooms', 'totalBookings', 'totalRevenue',
                'roomsAvailable', 'roomsBooked', 'roomsMaintenance',
                'last7Days', 'maxCount', 'upcomingCheckins', 'recentBookings'
            ));
        }

        return view('dashboard.customer', [
            'bookings' => $user->bookings()->latest()->take(5)->get(),
        ]);
    }
}