<?php

namespace App\Filament\Resources\DocumentFiles;

use App\Filament\Resources\DocumentFiles\Pages\CreateDocumentFile;
use App\Filament\Resources\DocumentFiles\Pages\EditDocumentFile;
use App\Filament\Resources\DocumentFiles\Pages\ListDocumentFiles;
use App\Filament\Resources\DocumentFiles\Pages\ViewDocumentFile;
use App\Filament\Resources\DocumentFiles\RelationManagers\MainMembersRelationManager;
use App\Filament\Resources\DocumentFiles\RelationManagers\SubMembersRelationManager;
use App\Filament\Resources\DocumentFiles\Schemas\DocumentFileForm;
use App\Filament\Resources\DocumentFiles\Schemas\DocumentFileInfolist;
use App\Filament\Resources\DocumentFiles\Tables\DocumentFilesTable;
use App\Models\DocumentFile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DocumentFileResource extends Resource
{
    protected static ?string $model = DocumentFile::class;

    protected static ?string $navigationLabel = 'Document files';

    protected static ?string $modelLabel = 'document file';

    protected static ?string $pluralModelLabel = 'document files';

    protected static string|UnitEnum|null $navigationGroup = 'Welfare';

    protected static ?string $recordTitleAttribute = 'file_number';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    public static function form(Schema $schema): Schema
    {
        return DocumentFileForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DocumentFileInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocumentFilesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MainMembersRelationManager::class,
            SubMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDocumentFiles::route('/'),
            'create' => CreateDocumentFile::route('/create'),
            'view' => ViewDocumentFile::route('/{record}'),
            'edit' => EditDocumentFile::route('/{record}/edit'),
        ];
    }
}
