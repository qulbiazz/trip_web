<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class CancelExpiredBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cancel-expired-bookings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batalkan pesanan yang sudah lebih dari 24 jam belum dibayar.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredBookings = Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(24))
            ->get();

        $count = 0;
        foreach ($expiredBookings as $booking) {
            $booking->status = 'dibatalkan';
            $booking->save(); // ini otomatis mengembalikan kuota kursi berkat event di Booking model
            $count++;
        }

        $this->info("Berhasil membatalkan {$count} pesanan yang kedaluwarsa.");
    }
}
