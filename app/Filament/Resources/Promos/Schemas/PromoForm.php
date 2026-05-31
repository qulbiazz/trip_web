<?php

namespace App\Filament\Resources\Promos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PromoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('kode')
                    ->required(),
                Select::make('tipe_diskon')
                    ->options([
                        'persentase' => 'Persentase (%)',
                        'nominal' => 'Nominal (Rp)',
                    ])
                    ->required()
                    ->default('persentase'),
                TextInput::make('nilai_diskon')
                    ->required()
                    ->numeric(),
                DatePicker::make('expired_at')
                    ->label('Berlaku Hingga')
                    ->native(false)
                    ->minDate(today()),

                Toggle::make('is_aktif')
                    ->required(),

            ]);
    }
}
