<?php

namespace App\Filament\Resources\DocumentFiles\Pages;

use App\Filament\Resources\DocumentFiles\DocumentFileResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDocumentFile extends EditRecord
{
    protected static string $resource = DocumentFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
