<?php

namespace App\Filament\Resources\Destinasis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

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
                    ->required(),
                TextInput::make('negara')
                    ->label('Negara')
                    ->required()
                    ->default('Indonesia'),
                TextInput::make('harga_dasar')
                    ->label('Harga Dasar')
                    ->required()
                    ->numeric(),
                FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->disk('public')
                    ->directory('destinasi')
                    ->visibility('public'),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'domestik' => 'Domestik',
                        'internasional' => 'Internasional',
                    ])
                    ->required()
                    ->default('domestik'),
                Toggle::make('is_aktif')
                    ->label('Aktif')
                    ->required(),
            ]);
    }
}
