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

            $recentBookings = Booking::with(['user', 'room.hotel'])
                ->where('archived', false)
                ->latest()
                ->take(5)
                ->get();

            return view('dashboard.admin', compact(
                'totalHotels', 'totalRooms', 'totalBookings', 'totalRevenue', 'recentBookings'
            ));
        }

        return view('dashboard.customer', [
            'bookings' => $user->bookings()->latest()->take(5)->get(),
        ]);
    }
}