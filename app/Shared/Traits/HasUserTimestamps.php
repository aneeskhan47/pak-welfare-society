<?php

namespace App\Shared\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * This Trait auto fills the created_by_id and updated_by_id fields upon creating and updating a model.
 */
trait HasUserTimestamps
{
    protected static function bootHasUserTimestamps(): void
    {
        $user = Auth::user();

        static::creating(function ($model) use ($user) {
            if (! $model->created_by_id) {
                $model->created_by_id = $user && $user->id ? $user->id : null;
            }
        });

        static::updating(function ($model) use ($user) {
            if (! $model->updated_by_id) {
                $model->updated_by_id = $user && $user->id ? $user->id : null;
            }
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id', 'id');
    }
}
