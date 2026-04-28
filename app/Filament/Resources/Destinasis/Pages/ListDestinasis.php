<?php

namespace App\Filament\Resources\Destinasis\Pages;

use App\Filament\Resources\Destinasis\DestinasiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDestinasis extends ListRecords
{
    protected static string $resource = DestinasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
