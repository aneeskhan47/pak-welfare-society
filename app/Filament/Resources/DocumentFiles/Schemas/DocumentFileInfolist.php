<?php

namespace App\Filament\Resources\DocumentFiles\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentFileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document file')
                    ->schema([
                        TextEntry::make('file_number')
                            ->label('File number'),
                        TextEntry::make('mainMembers_count')
                            ->label('Main members')
                            ->state(fn ($record) => $record->mainMembers()->count()),
                        TextEntry::make('subMembers_count')
                            ->label('Sub members')
                            ->state(fn ($record) => $record->subMembers()->count()),
                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                        TextEntry::make('createdBy.name')
                            ->label('Created by')
                            ->placeholder('—'),
                        TextEntry::make('created_at')
                            ->label('Created at')
                            ->dateTime(),
                        TextEntry::make('updatedBy.name')
                            ->label('Last updated by')
                            ->placeholder('—'),
                        TextEntry::make('updated_at')
                            ->label('Last updated at')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
