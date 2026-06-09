<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SiteSetting;
use Illuminate\Http\Response;

class BookingInvoiceController extends Controller
{
    public function show(Booking $booking): Response
    {
        $booking->loadMissing(['jadwal.destinasi', 'promo']);
        $siteSetting = SiteSetting::first();

        return response()->view('invoices.booking', [
            'booking'     => $booking,
            'siteSetting' => $siteSetting,
        ]);
    }

    public function download(Booking $booking): Response
    {
        $booking->loadMissing(['jadwal.destinasi', 'promo']);
        $siteSetting = SiteSetting::first();

        $html = view('invoices.booking', [
            'booking'     => $booking,
            'siteSetting' => $siteSetting,
        ])->render();

        $filename = ($booking->nomor_invoice ?: ('booking-' . $booking->id)) . '.html';

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function simulatePayment(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking ini sudah diproses atau tidak bisa dibayar.');
        }

        $booking->update([
            'status' => 'dibayar'
        ]);

        return back()->with('success', 'Pembayaran berhasil disimulasikan!')->with('auto_send_email', true);
    }
}
