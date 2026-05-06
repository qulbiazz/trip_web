<?php

namespace App\Filament\Resources\Destinasis\Pages;

use App\Filament\Resources\Destinasis\DestinasiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDestinasi extends CreateRecord
{
    protected static string $resource = DestinasiResource::class;

    // Tambahkan method ini untuk menghilangkan tombol "Create & create another"
    public function canCreateAnother(): bool
    {
        return false;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}