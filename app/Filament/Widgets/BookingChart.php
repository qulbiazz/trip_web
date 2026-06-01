<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class BookingChart extends ChartWidget
{
    public function getHeading(): string
    {
        return 'Peminatan Per Bulan';
    }

    protected function getData(): array
    {
        $data = Booking::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels = [];
        $totals = [];

        $namaBulan = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agu',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des',
        ];

        foreach ($data as $item) {
            $labels[] = $namaBulan[$item->bulan];
            $totals[] = $item->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Pemesanan',
                    'data' => $totals,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}