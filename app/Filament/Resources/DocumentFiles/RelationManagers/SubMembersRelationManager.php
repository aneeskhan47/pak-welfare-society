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
use Filament\Forms\Components\Textarea;
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

class SubMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'subMembers';

    protected static ?string $title = 'Sub members';

    protected static ?string $modelLabel = 'sub member';

    protected static ?string $pluralModelLabel = 'sub members';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('is_owner')
                    ->default(false),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('father_name')
                    ->label('Father name')
                    ->maxLength(255),
                TextInput::make('membership_number')
                    ->label('Membership number')
                    ->maxLength(50),
                Textarea::make('address')
                    ->rows(3)
                    ->columnSpanFull(),
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
                TextColumn::make('father_name')
                    ->label('Father name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('membership_number')
                    ->label('Membership #')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('mobile_number')
                    ->label('Mobile')
                    ->searchable(),
                TextColumn::make('address')
                    ->limit(40)
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(fn (array $data): array => [
                        ...$data,
                        'is_owner' => false,
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
