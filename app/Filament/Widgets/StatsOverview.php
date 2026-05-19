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
        ];
    }
}