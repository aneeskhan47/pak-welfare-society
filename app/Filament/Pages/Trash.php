<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TrashedDocumentFilesWidget;
use App\Filament\Widgets\TrashedMembersWidget;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Trash extends Page
{
    protected static ?string $navigationLabel = 'Trash';

    protected static ?string $title = 'Trash';

    protected static ?int $navigationSort = 99;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTrash;

    protected static string|UnitEnum|null $navigationGroup = 'Welfare';

    /**
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            TrashedDocumentFilesWidget::class,
            TrashedMembersWidget::class,
        ];
    }

    public function getColumns(): int
    {
        return 1;
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make($this->getColumns())
                    ->schema(fn (): array => $this->getWidgetsSchemaComponents($this->getWidgets())),
            ]);
    }
}
