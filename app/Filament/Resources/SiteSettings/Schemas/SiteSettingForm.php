<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
             ->components([
                TextInput::make('site_name')
                    ->label('Nama Website')
                    ->required()
                    ->maxLength(255),
                TextInput::make('hero_badge')
                    ->label('Badge Hero')
                    ->required()
                    ->maxLength(255),
                TextInput::make('hero_title')
                    ->label('Judul Hero')
                    ->required()
                    ->maxLength(255),
                TextInput::make('hero_highlight')
                    ->label('Highlight Hero')
                    ->required()
                    ->maxLength(255),
                Textarea::make('hero_description')
                    ->label('Deskripsi Hero')
                    ->rows(3)
                    ->columnSpanFull(),
                FileUpload::make('hero_image')
                    ->label('Gambar Background Hero')
                    ->image()
                    ->disk('public')
                    ->directory('site-settings')
                    ->visibility('public')
                    ->columnSpanFull(),
                TextInput::make('cta_primary_text')
                    ->label('Teks Tombol Utama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cta_secondary_text')
                    ->label('Teks Tombol Sekunder')
                    ->required()
                    ->maxLength(255),
                TextInput::make('feature_title')
                    ->label('Judul Fitur')
                    ->required()
                    ->maxLength(255),
                Textarea::make('feature_description')
                    ->label('Deskripsi Fitur')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->required()
                    ->default(true),
            ]);
    }
}
