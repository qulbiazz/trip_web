<?php

namespace App\Filament\Resources\Destinasis\Pages;

use App\Filament\Resources\Destinasis\DestinasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDestinasi extends EditRecord
{
    protected static string $resource = DestinasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
