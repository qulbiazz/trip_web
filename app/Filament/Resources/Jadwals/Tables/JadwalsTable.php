<?php

namespace App\Filament\Resources\Jadwals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JadwalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('destinasi.nama')
                    ->label('Destinasi')
                    ->searchable(),
                TextColumn::make('pendaftaran_mulai')
                    ->label('Pendaftaran Dibuka')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('pendaftaran_tutup')
                    ->label('Pendaftaran Ditutup')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('tanggal_berangkat')
                    ->label('Tanggal Berangkat')
                    ->date()
                    ->sortable(),
                TextColumn::make('tanggal_pulang')
                    ->label('Tanggal Pulang')
                    ->date()
                    ->sortable(),
                TextColumn::make('kuota')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sisa_kursi')
                    ->label('Sisa Kursi')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge() // Mengubah tampilan menjadi badge
                    ->formatStateUsing(function (string $state, $record) {
                        // Cek apakah tanggal berangkat sudah melewati jam 00:00 hari ini
                        $isPast = \Carbon\Carbon::parse($record->tanggal_berangkat)->startOfDay()->isPast();
                        
                        if ($isPast) {
                            return 'Expired';
                        }
                        
                        return ucfirst($state);
                    })
                    ->color(function (string $state, $record): string {
                        $isPast = \Carbon\Carbon::parse($record->tanggal_berangkat)->startOfDay()->isPast();
                        
                        if ($isPast) {
                            return 'danger'; // Warna merah/abu-abu untuk expired
                        }
                        
                        return match ($state) {
                            'tersedia' => 'success', // Warna hijau
                            'penuh' => 'warning', // Warna kuning/oranye
                            'dibatalkan' => 'danger', // Warna merah
                            default => 'gray',
                        };
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
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}