<?php

namespace App\Filament\Resources\Destinasis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class DestinasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                Textarea::make('deskripsi')
                    ->columnSpanFull(),
                TextInput::make('lokasi')
                    ->required(),
                TextInput::make('negara')
                    ->required()
                    ->default('Indonesia'),
                TextInput::make('harga_dasar')
                    ->required()
                    ->numeric(),
                FileUpload::make('gambar')
                    ->image()
                    ->disk('public')
                    ->directory('destinasi')
                    ->visibility('public'),
                TextInput::make('kategori')
                    ->required()
                    ->default('domestik'),
                Toggle::make('is_aktif')
                    ->required(),
            ]);
    }
}
