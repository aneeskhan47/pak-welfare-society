<?php

namespace App\Filament\Resources\DocumentFiles\Pages;

use App\Filament\Resources\DocumentFiles\DocumentFileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewDocumentFile extends ViewRecord
{
    protected static string $resource = DocumentFileResource::class;

    protected function resolveRecord(int | string $key): Model
    {
        return parent::resolveRecord($key)->load(['createdBy', 'updatedBy']);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
