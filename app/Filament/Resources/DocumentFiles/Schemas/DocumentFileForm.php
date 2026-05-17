<?php

namespace App\Filament\Resources\DocumentFiles\Schemas;

use App\Models\DocumentFile;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DocumentFileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Document file')
                    ->description('A welfare document file groups main (owner) members and sub members.')
                    ->schema([
                        TextInput::make('file_number')
                            ->label('File number')
                            ->placeholder('e.g. A87')
                            ->required()
                            ->unique(table: DocumentFile::class, column: 'file_number', ignoreRecord: true)
                            ->maxLength(50),
                        // TextInput::make('list_order')
                        //     ->numeric()
                        //     ->minValue(0),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
