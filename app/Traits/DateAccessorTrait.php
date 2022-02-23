<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateAccessorTrait
{
    /**
     * Created at accessor.
     * - - -
     * @param $createdAt
     * @return string
     */
    public function getCreatedAtAttribute($createdAt)
    {
        return $createdAt ? Carbon::parse($createdAt)->format('Y-m-d H:i:s') : null;
    }

    /**
     * Updated at accessor.
     * - - -
     * @param $updateAt
     * @return string
     */
    public function getUpdatedAtAttribute($updateAt)
    {
        return $updateAt ? Carbon::parse($updateAt)->format('Y-m-d H:i:s') : null;
    }

    /**
     * Human readable created at accessor.
     * - - -
     * @return string
     */
    public function getHrCreatedAtAttribute()
    {
        return $this->created_at ? Carbon::parse($this->created_at)->diffForHumans() : null;
    }
}
