<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Destinasi;
use Illuminate\Support\Facades\DB;

class PopularDestinationsTable extends BaseWidget
{
    protected static ?string $heading = 'Destinasi Perjalanan Terpopuler';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Destinasi::query()
                    ->join('jadwals', 'destinasis.id', '=', 'jadwals.destinasi_id')
                    ->join('bookings', 'jadwals.id', '=', 'bookings.jadwal_id')
                    ->select(
                        'destinasis.id',
                        'destinasis.nama',
                        DB::raw('count(bookings.id) as total_bookings'),
                        DB::raw('sum(bookings.total_bayar) as total_revenue')
                    )
                    ->whereIn('bookings.status', ['dibayar', 'dikonfirmasi'])
                    ->groupBy('destinasis.id', 'destinasis.nama')
                    ->orderByDesc('total_bookings')
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Destinasi'),
                Tables\Columns\TextColumn::make('total_bookings')
                    ->label('Jumlah Pemesanan')
                    ->suffix(' x')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Total Pendapatan')
                    ->money('idr')
                    ->alignRight()
                    ->color('success'),
            ])
            ->paginated(false);
    }
}
