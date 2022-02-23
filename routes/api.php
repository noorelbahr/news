<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('v1')->namespace('V1')->group(function () {
    // Auth
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::middleware('auth:api')->group(function () {
        // Profile
        Route::get('profile', 'ProfileController@index');

        // Categories
        Route::apiResource('categories', 'CategoryController');

        // News
        Route::apiResource('news', 'NewsController');

        // Comments
        Route::get('news/{news}/comments', 'NewsCommentController@index');
        Route::post('news/{news}/comments', 'NewsCommentController@store');
        Route::delete('news/{news}/comments/{id}', 'NewsCommentController@destroy');

        // Likes
        Route::get('news/{news}/likes', 'NewsLikeController@index');
        Route::post('news/{news}/like', 'NewsLikeController@like');
        Route::post('news/{news}/unlike', 'NewsLikeController@unlike');
    });
});
