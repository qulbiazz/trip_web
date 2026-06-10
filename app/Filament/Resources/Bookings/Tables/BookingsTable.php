<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_booking')
                    ->label('Kode Booking')
                    ->searchable(),
                TextColumn::make('jadwal.destinasi.nama')
                    ->label('Destinasi')
                    ->description(fn ($record): ?string => $record->jadwal?->tanggal_berangkat?->format('d M Y'))
                    ->searchable(),
                TextColumn::make('promo.kode')
                    ->label('Promo')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable(),
                TextColumn::make('email_pelanggan')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('nomor_handphone')
                    ->label('No. Handphone')
                    ->searchable(),
                TextColumn::make('alamat_penjemputan')
                    ->label('Alamat Penjemputan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('jumlah_peserta')
                    ->label('Jumlah Peserta')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('total_bayar')
                    ->label('Total Bayar')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'      => 'warning',
                        'dikonfirmasi' => 'info',
                        'dibayar'      => 'success',
                        'dibatalkan'   => 'danger',
                        default        => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending'      => 'Belum dibayar',
                        'dikonfirmasi' => 'Dikonfirmasi',
                        'dibayar'      => 'Berhasil dibayar',
                        'dibatalkan'   => 'Dibatalkan',
                        default        => $state,
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diubah Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'pending'      => '🟡 Belum dibayar',
                        'dikonfirmasi' => '🔵 Dikonfirmasi',
                        'dibayar'      => '🟢 Berhasil dibayar',
                        'dibatalkan'   => '🔴 Dibatalkan',
                    ])
                    ->placeholder('Semua Status'),
            ])
            ->recordActions([
                Action::make('lihatInvoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-document-text')
                    ->url(fn ($record): string => route('bookings.invoice.show', $record) . '?admin=1', shouldOpenInNewTab: true),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
