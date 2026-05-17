<?php

namespace App\Shared\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

/**
 * This Trait auto fills the uuid field on the model and make sures it doesn't get updated even if tried
 */
trait HasUuid
{
    protected static function bootHasUuid(): void
    {
        static::creating(function ($model) {
            if (! $model->{$model->getUuidColumn()}) {
                $model->{$model->getUuidColumn()} = $model->generateUuid();
            }
        });

        static::saving(function ($model) {
            if (! $model->exists) {
                return;
            }

            $original_uuid = $model->getOriginal($model->getUuidColumn());
            if ($original_uuid !== $model->{$model->getUuidColumn()}) {
                $model->{$model->getUuidColumn()} = $original_uuid;
            }
        });
    }

    /**
     * Get the uuid column name. (defaults to 'uuid')
     */
    protected function getUuidColumn(): string
    {
        return property_exists($this, 'uuidColumn') ? $this->uuidColumn : 'uuid';
    }

    /**
     * Generate a uuid
     */
    public function generateUuid(): string
    {
        return (string) Str::orderedUuid();
    }

    /**
     * Scope a query to only include records with the given uuid.
     *
     * @param  bool  $first  (whether to return the first result)
     * @return Illuminate\Database\Eloquent\Model|Builder
     */
    public function scopeUuid(Builder $query, string $uuid, bool $first = true): Model|Builder
    {
        $match = preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $uuid);

        if (! is_string($uuid) || $match !== 1) {
            throw (new ModelNotFoundException())->setModel(get_class($this));
        }

        $results = $query->where($this->getUuidColumn(), $uuid);

        return $first ? $results->firstOrFail() : $results;
    }
}
