<?php

namespace App\Models;

use App\Traits\SoftDeletesTrait;
use App\Traits\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    use SoftDeletesTrait;
    use UuidModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'filename',
        'created_by',
        'updated_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return url('storage/' . $this->filename);
    }
}
