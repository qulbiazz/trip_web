<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LaporanStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // 1. Booking Stats grouped by status
        $bookingsGrouped = Booking::select('status', DB::raw('count(*) as count'), DB::raw('sum(total_bayar) as total_amount'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $bookingsTotal = Booking::count();
        $bookingsPaid = $bookingsGrouped->get('dibayar')?->count ?? 0;
        $bookingsConfirmed = $bookingsGrouped->get('dikonfirmasi')?->count ?? 0;
        $bookingsPending = $bookingsGrouped->get('pending')?->count ?? 0;
        $bookingsCancelled = $bookingsGrouped->get('dibatalkan')?->count ?? 0;

        $bookingsSuccess = $bookingsPaid + $bookingsConfirmed;

        // 2. Revenue Stats
        $revenueTotal = ($bookingsGrouped->get('dibayar')?->total_amount ?? 0) + ($bookingsGrouped->get('dikonfirmasi')?->total_amount ?? 0);
        $revenuePending = $bookingsGrouped->get('pending')?->total_amount ?? 0;
        $revenueCancelled = $bookingsGrouped->get('dibatalkan')?->total_amount ?? 0;

        // 3. User Stats
        $usersTotal = User::count();
        $usersNew30d = User::where('created_at', '>=', now()->subDays(30))->count();
        $growth = $usersTotal > 0 ? round(($usersNew30d / $usersTotal) * 100, 1) : 0;

        return [
            Stat::make('Laporan Pemesanan', $bookingsTotal . ' Total')
                ->description("Sukses: {$bookingsSuccess} | Pending: {$bookingsPending} | Batal: {$bookingsCancelled}")
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Laporan Pemasukan', 'Rp' . number_format($revenueTotal, 0, ',', '.'))
                ->description("Pending: Rp" . number_format($revenuePending, 0, ',', '.') . " | Batal: Rp" . number_format($revenueCancelled, 0, ',', '.'))
                ->icon('heroicon-o-banknotes')
                ->color('success'),

            Stat::make('Laporan Pengguna', $usersTotal . ' Pengguna')
                ->description("Baru (30 hari): +{$usersNew30d} ({$growth}%)")
                ->icon('heroicon-o-users')
                ->color('info'),
        ];
    }
}
