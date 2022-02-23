<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Api\V1\ProfileResource;
use Illuminate\Support\Facades\Auth;

class ProfileController extends ApiController
{
    /**
     * @return ProfileResource
     */
    public function index()
    {
        return new ProfileResource(Auth::user());
    }
}
