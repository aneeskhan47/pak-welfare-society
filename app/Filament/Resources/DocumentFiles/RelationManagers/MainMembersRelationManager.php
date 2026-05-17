<?php

namespace App\Filament\Resources\DocumentFiles\RelationManagers;

use App\Models\Member;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class MainMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'mainMembers';

    protected static ?string $title = 'Main members';

    protected static ?string $modelLabel = 'main member';

    protected static ?string $pluralModelLabel = 'main members';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('is_owner')
                    ->default(true),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('mobile_number')
                    ->label('Mobile number')
                    ->tel()
                    ->maxLength(30)
                    ->unique(table: Member::class, column: 'mobile_number', ignoreRecord: true),
                SpatieMediaLibraryFileUpload::make('profile_photo')
                    ->label('Profile picture')
                    ->collection(Member::PROFILE_PHOTO_COLLECTION)
                    ->image()
                    ->customHeaders(['ACL' => 'public-read'])
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => time().Str::random(10).'.'.$file->getClientOriginalExtension()
                    )
                    ->columnSpanFull(),
                // TextInput::make('list_order')
                //     ->numeric()
                //     ->minValue(0),
                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('profile_photo')
                    ->label('Photo')
                    ->collection(Member::PROFILE_PHOTO_COLLECTION)
                    ->circular(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mobile_number')
                    ->label('Mobile number')
                    ->searchable(),
                TextColumn::make('list_order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(fn (array $data): array => [
                        ...$data,
                        'is_owner' => true,
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
