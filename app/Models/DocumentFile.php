<?php

namespace App\Models;

use App\Shared\Traits\HasUserTimestamps;
use App\Shared\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFile extends Model
{
    use HasUserTimestamps;
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'file_number',
        'list_order',
        'is_active',
        'created_by_id',
        'updated_by_id',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'list_order' => 'integer',
        ];
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function mainMembers(): HasMany
    {
        return $this->members()->where('is_owner', true);
    }

    public function subMembers(): HasMany
    {
        return $this->members()->where('is_owner', false);
    }
}
