<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class BookingStatusController extends Controller
{
    public function index()
    {
        return view('cek-booking');
    }

    public function cek(Request $request)
    {
        $request->validate([
            'kode_booking' => 'required|string|min:3',
        ], [
            'kode_booking.required' => 'Kode booking wajib diisi.',
            'kode_booking.min'      => 'Kode booking minimal 3 karakter.',
        ]);

        $booking = Booking::with(['jadwal.destinasi', 'promo'])
            ->where('kode_booking', strtoupper(trim($request->kode_booking)))
            ->first();

        return view('cek-booking', compact('booking'))->with('searched', true);
    }
}
