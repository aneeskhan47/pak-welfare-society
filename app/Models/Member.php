<?php

namespace App\Models;

use App\Shared\Traits\HasUserTimestamps;
use App\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Member extends Model implements HasMedia
{
    use HasUserTimestamps;
    use HasUuid;
    use InteractsWithMedia;
    use SoftDeletes;

    public const PROFILE_PHOTO_COLLECTION = 'profile_photo';

    protected $fillable = [
        'document_file_id',
        'is_owner',
        'name',
        'father_name',
        'membership_number',
        'address',
        'mobile_number',
        'list_order',
        'is_active',
        'created_by_id',
        'updated_by_id',
    ];

    protected function casts(): array
    {
        return [
            'is_owner' => 'boolean',
            'is_active' => 'boolean',
            'list_order' => 'integer',
        ];
    }

    public function documentFile(): BelongsTo
    {
        return $this->belongsTo(DocumentFile::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::PROFILE_PHOTO_COLLECTION)->singleFile();
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        $url = $this->getFirstMediaUrl(self::PROFILE_PHOTO_COLLECTION);

        return $url !== '' ? $url : null;
    }
}
