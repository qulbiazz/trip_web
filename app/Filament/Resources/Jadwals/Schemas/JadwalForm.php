<?php

namespace App\Filament\Resources\Jadwals\Schemas;

use App\Models\Destinasi;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;

class JadwalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('destinasi_id')
                    ->relationship('destinasi', 'nama', fn ($query) => $query->where('is_aktif', true))
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set): void {
                        if (! $state) {
                            return;
                        }

                        /** @var \App\Models\Destinasi|null $destinasi */
                        $destinasi = Destinasi::find($state);
                        if (! $destinasi) {
                            return;
                        }

                        $set('harga', (float) $destinasi->harga_dasar);
                    })
                    ->required(),
                DatePicker::make('tanggal_berangkat')
                    ->required(),
                DatePicker::make('tanggal_pulang')
                    ->required(),
                TextInput::make('kuota')
                    ->required()
                    ->numeric(),
                TextInput::make('harga')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
                        'tersedia' => 'Tersedia',
                        'penuh' => 'Penuh',
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->required()
                    ->default('tersedia')
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Status otomatis mengikuti sisa kursi atau pembatalan.'),
                Textarea::make('catatan')
                    ->columnSpanFull(),
            ]);
    }
}
