<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\DocumentFiles\DocumentFileResource;
use App\Filament\Resources\Users\UserResource;
use App\Models\DocumentFile;
use App\Models\Member;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WelfareStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected static bool $isLazy = false;

    protected ?string $heading = 'Overview';

    protected ?string $description = 'Welfare society at a glance';

    protected function getStats(): array
    {
        $documentFileCount = DocumentFile::count();
        $activeDocumentFiles = DocumentFile::where('is_active', true)->count();

        $memberCount = Member::count();
        $mainMemberCount = Member::where('is_owner', true)->count();
        $subMemberCount = Member::where('is_owner', false)->count();

        $userCount = User::count();
        $activeUsers = User::where('is_active', true)->count();

        return [
            Stat::make('Document files', number_format($documentFileCount))
                ->description("{$activeDocumentFiles} active")
                ->descriptionIcon(Heroicon::OutlinedFolder)
                ->icon(Heroicon::OutlinedFolder)
                ->color('primary')
                ->url(DocumentFileResource::getUrl('index')),
            Stat::make('Members', number_format($memberCount))
                ->description("{$mainMemberCount} main · {$subMemberCount} sub")
                ->descriptionIcon(Heroicon::OutlinedUserGroup)
                ->icon(Heroicon::OutlinedUserGroup)
                ->color('success')
                ->url(DocumentFileResource::getUrl('index')),
            Stat::make('Users', number_format($userCount))
                ->description("{$activeUsers} active")
                ->descriptionIcon(Heroicon::OutlinedUsers)
                ->icon(Heroicon::OutlinedUsers)
                ->color('info')
                ->url(UserResource::getUrl('index')),
        ];
    }
}
