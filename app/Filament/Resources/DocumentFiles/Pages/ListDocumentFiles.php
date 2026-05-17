<?php

namespace App\Filament\Resources\DocumentFiles\Pages;

use App\Filament\Resources\DocumentFiles\DocumentFileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDocumentFiles extends ListRecords
{
    protected static string $resource = DocumentFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
