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
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
