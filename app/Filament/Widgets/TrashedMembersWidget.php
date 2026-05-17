<?php

namespace App\Filament\Widgets;

use App\Models\Member;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Contracts\Support\Htmlable;

class TrashedMembersWidget extends TableWidget
{
    protected static bool $isDiscovered = false;

    protected int|string|array $columnSpan = 'full';

    protected function getTableHeading(): string|Htmlable|null
    {
        return 'Members';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Member::onlyTrashed()->with('documentFile')->latest('deleted_at'))
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('documentFile.file_number')
                    ->label('File number')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_owner')
                    ->label('Main member')
                    ->boolean(),
                TextColumn::make('mobile_number')
                    ->label('Mobile number')
                    ->searchable(),
                TextColumn::make('membership_number')
                    ->label('Membership #')
                    ->toggleable(),
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
            ->emptyStateHeading('No deleted members')
            ->emptyStateDescription('deleted members will appear here.');
    }
}
