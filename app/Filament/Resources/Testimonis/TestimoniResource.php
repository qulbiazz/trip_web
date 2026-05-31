<?php

namespace App\Filament\Resources\Testimonis;

use App\Filament\Resources\Testimonis\Pages\CreateTestimoni;
use App\Filament\Resources\Testimonis\Pages\EditTestimoni;
use App\Filament\Resources\Testimonis\Pages\ListTestimonis;
use App\Filament\Resources\Testimonis\Schemas\TestimoniForm;
use App\Filament\Resources\Testimonis\Tables\TestimonisTable;
use App\Models\Testimoni;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TestimoniResource extends Resource
{
    protected static ?string $model = Testimoni::class;

    protected static ?string $navigationLabel = 'Testimoni';
    protected static ?string $modelLabel = 'Testimoni';
    protected static ?string $pluralModelLabel = 'Testimoni';    

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): string
    {
        return 'Marketing';
    }

    public static function getBreadcrumb(): string
    {
        return 'Marketing';
    }

    public static function form(Schema $schema): Schema
    {
        return TestimoniForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestimonisTable::configure($table);
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
            'index' => ListTestimonis::route('/'),
            'create' => CreateTestimoni::route('/create'),
            'edit' => EditTestimoni::route('/{record}/edit'),
        ];
    }
}
