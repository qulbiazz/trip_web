<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Destinasi;
use App\Models\Jadwal;
use App\Models\Promo;
use App\Models\Booking;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Destinasi', Destinasi::count())
                ->description('Jumlah destinasi tersedia')
                ->icon('heroicon-o-map'),

            Stat::make('Jadwal Tersedia', Jadwal::count())
                ->description('Semua jadwal aktif')
                ->icon('heroicon-o-calendar'),

            Stat::make('Promo Aktif', Promo::count())
                ->description('Promo berjalan')
                ->icon('heroicon-o-tag'),

            Stat::make('Total Pemesanan', Booking::count())
                ->description('Semua transaksi pemesanan')
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Destinasi Dijalankan', Destinasi::whereHas('jadwals', fn ($q) => $q->whereIn('status', ['tersedia', 'penuh'])->where('tanggal_berangkat', '<=', now()->toDateString()))->count())
                ->description('Destinasi yang sudah mulai berjalan')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Trip Dijalankan', Jadwal::whereIn('status', ['tersedia', 'penuh'])->where('tanggal_berangkat', '<=', now()->toDateString())->count())
                ->description('Total jadwal perjalanan selesai')
                ->icon('heroicon-o-shield-check')
                ->color('success'),
        ];
    }
}