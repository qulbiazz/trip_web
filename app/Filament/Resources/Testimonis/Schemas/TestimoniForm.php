<?php

namespace App\Filament\Resources\Testimonis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimoniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama Pengguna')
                    ->required()
                    ->maxLength(255),
                
                Select::make('rating')
                    ->label('Rating Bintang')
                    ->options([
                        1 => '1 Bintang',
                        2 => '2 Bintang',
                        3 => '3 Bintang',
                        4 => '4 Bintang',
                        5 => '5 Bintang',
                    ])
                    ->required()
                    ->default(5),
                
                Textarea::make('konten')
                    ->label('Isi Testimoni')
                    ->required()
                    ->rows(4)
                    ->maxLength(1000),

                Toggle::make('is_aktif')
                    ->label('Aktif / Tampilkan')
                    ->required()
                    ->default(true),
            ]);
    }
}
