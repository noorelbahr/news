<?php

namespace App\Models;

use App\Traits\DateAccessorTrait;
use App\Traits\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use DateAccessorTrait;
    use UuidModelTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'created_by',
        'updated_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function likable()
    {
        return $this->morphTo();
    }
}
