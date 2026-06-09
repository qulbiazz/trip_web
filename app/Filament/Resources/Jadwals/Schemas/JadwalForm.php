<?php

namespace App\Filament\Resources\Jadwals\Schemas;

use App\Models\Destinasi;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\RawJs;

class JadwalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('destinasi_id')
                    ->label('Destinasi')
                    ->relationship(
                        'destinasi',
                        'nama',
                        fn($query) => $query->where('is_aktif', true)
                    )
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set): void {
                        if (!$state) {
                            $set('harga', null);
                            return;
                        }

                        $destinasi = Destinasi::find($state);

                        if (!$destinasi) {
                            return;
                        }

                        $set('harga', $destinasi->harga_dasar);
                    })
                    ->required(),
                // Periode Pendaftaran
                DatePicker::make('pendaftaran_mulai')
                    ->label('Pendaftaran Dibuka')
                    ->placeholder('MM/DD/YYYY')
                    ->required()
                    ->minDate(today()),
                DatePicker::make('pendaftaran_tutup')
                    ->label('Pendaftaran Ditutup')
                    ->placeholder('MM/DD/YYYY')
                    ->required()
                    ->minDate(today()),
                DatePicker::make('tanggal_berangkat')
                    ->label('Tanggal Berangkat')
                    ->required()
                    ->minDate(today()),
                DatePicker::make('tanggal_pulang')
                    ->label('Tanggal Pulang')
                    ->required()
                    ->minDate(today()),
                TextInput::make('kuota')
                    ->label('Kuota')
                    ->required()
                    ->numeric(),
                TextInput::make('harga')
                    ->label('Harga')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->rules(['numeric'])
                    ->prefix('Rp') 
                    ->helperText('Harga dasar destinasi.'),
                Select::make('status')
                    ->label('Status')
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
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
