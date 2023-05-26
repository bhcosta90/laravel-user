<?php

namespace BRCas\LaravelUser\Routes;

use BRCas\LaravelUser\Http\Controllers\Permission\SpatiePermissionController;
use BRCas\LaravelUser\Http\Controllers\Permission\SpatieRoleController;
use BRCas\LaravelUser\Http\Controllers\Profile\ProfileController;
use BRCas\LaravelUser\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

class UserRoute
{
    public static function defaults($excepts = [])
    {
        Route::resource('user', UserController::class)->except($excepts);
        Route::resource('profile', ProfileController::class)->middleware('auth')->only('index', 'store');
        Route::post('update-password', [ProfileController::class, 'password'])->middleware('auth')->name('profile.password');

        $implements = class_uses(config('bhcosta90-user.user.model'));
        if (in_array('Spatie\Permission\Traits\HasRoles', $implements)) {
            Route::get('user/{id}/spatie/permissions', [SpatiePermissionController::class, 'index'])->name('user.permission.index');
            Route::put('user/{id}/spatie/permissions', [SpatiePermissionController::class, 'update'])->name('user.permission.update');
            Route::resource('role', SpatieRoleController::class);
        }
    }
}
