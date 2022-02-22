<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait SoftDeletesTrait
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        parent::booted();

        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
    }
}
