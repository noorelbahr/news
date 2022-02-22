<?php

namespace App\Models;

use App\Traits\SoftDeletesTrait;
use App\Traits\UuidModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
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
        'slug',
        'name',
        'created_by',
        'updated_by',
    ];
}
