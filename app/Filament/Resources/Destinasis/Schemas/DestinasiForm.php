<?php

namespace App\Filament\Resources\Destinasis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;

class DestinasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Destinasi')
                    ->required(),
                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                TextInput::make('lokasi')
                    ->label('Lokasi')
                    ->required()
                    ->maxLength(30)
                    ->live(debounce: 100) // Memberikan jeda 100ms saat mengetik agar server tidak terbebani
                    ->hint(fn(?string $state, $component) => mb_strlen($state ?? '') . '/' . $component->getMaxLength() . ' Karakter'),
                TextInput::make('negara')
                    ->label('Negara')
                    ->required()
                    ->default('Indonesia'),
                TextInput::make('harga_dasar')
                    ->label('Harga Dasar')
                    ->required()
                    ->rules(['numeric'])
                    ->prefix('Rp'),
                FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->disk('public')
                    ->directory('destinasi')
                    ->visibility('public')
                    ->imagePreviewHeight('200')
                    ->maxSize(5120),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'domestik' => 'Domestik',
                        'internasional' => 'Internasional',
                    ])
                    ->required()
                    ->default('domestik'),
                Textarea::make('fasilitas')
                    ->label('Fasilitas')
                    ->helperText('Pisahkan dengan enter'),
                Toggle::make('is_aktif')
                    ->label('Aktif')
                    ->required(),
            ]);
    }
}
