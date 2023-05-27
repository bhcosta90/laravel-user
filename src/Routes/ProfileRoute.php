<?php

namespace BRCas\LaravelUser\Routes;

use BRCas\LaravelUser\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

class ProfileRoute
{
    public static function defaults($excepts = [])
    {
        Route::resource('profile', ProfileController::class)->middleware('auth')->only('index', 'store');
        Route::post('update-password', [ProfileController::class, 'password'])->middleware('auth')->name('profile.password');
    }
}
