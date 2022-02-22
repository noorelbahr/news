<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait UuidModelTrait
{
    /**
     * Rewrite model boot function
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    /**
     * Rewrite getIncrementing function
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Rewrite getKeyType function
     */
    public function getKeyType()
    {
        return 'string';
    }
}
