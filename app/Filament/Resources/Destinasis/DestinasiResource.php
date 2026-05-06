<?php

namespace App\Filament\Resources\Destinasis;

use App\Filament\Resources\Destinasis\Pages\CreateDestinasi;
use App\Filament\Resources\Destinasis\Pages\EditDestinasi;
use App\Filament\Resources\Destinasis\Pages\ListDestinasis;
use App\Filament\Resources\Destinasis\Schemas\DestinasiForm;
use App\Filament\Resources\Destinasis\Tables\DestinasisTable;
use App\Models\Destinasi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class DestinasiResource extends Resource
{
    protected static ?string $model = Destinasi::class;

    protected static ?string $navigationLabel = 'Destinasi';
    protected static ?string $modelLabel = 'Destinasi';
    protected static ?string $pluralModelLabel = 'Destinasi';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return DestinasiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DestinasisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDestinasis::route('/'),
            'create' => CreateDestinasi::route('/create'),
            'edit' => EditDestinasi::route('/{record}/edit'),
        ];
    }
}
