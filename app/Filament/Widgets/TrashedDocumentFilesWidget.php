<?php

namespace App\Filament\Widgets;

use App\Models\DocumentFile;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Support\Htmlable;

class TrashedDocumentFilesWidget extends TableWidget
{
    protected static bool $isDiscovered = false;

    protected int|string|array $columnSpan = 'full';

    protected function getTableHeading(): string|Htmlable|null
    {
        return 'Document files';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => DocumentFile::onlyTrashed()->latest('deleted_at'))
            ->columns([
                TextColumn::make('file_number')
                    ->label('File number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Deleted at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                RestoreAction::make(),
            ])
            ->toolbarActions([
                RestoreBulkAction::make(),
            ])
            ->paginationMode(PaginationMode::Default)
            ->emptyStateHeading('No deleted document files')
            ->emptyStateDescription('deleted document files will appear here.');
    }
}
