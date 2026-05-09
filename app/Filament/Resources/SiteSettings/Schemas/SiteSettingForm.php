<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('hero_badge')
                    ->required()
                    ->maxLength(255),
                TextInput::make('hero_title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('hero_highlight')
                    ->required()
                    ->maxLength(255),
                Textarea::make('hero_description')
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('cta_primary_text')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cta_secondary_text')
                    ->required()
                    ->maxLength(255),
                TextInput::make('feature_title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('feature_description')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}
