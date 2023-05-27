<?php

namespace BRCas\LaravelUser\Routes;

use BRCas\LaravelUser\Http\Controllers\Permission\SpatiePermissionController;
use BRCas\LaravelUser\Http\Controllers\Permission\SpatieRoleController;
use BRCas\LaravelUser\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

class UserRoute
{
    public static function defaults($excepts = [])
    {
        Route::middleware(['auth'])->group(function () use ($excepts) {
            Route::resource('user', UserController::class)->except($excepts);
            Route::patch('user/{user}/active', [UserController::class, 'active'])->name('user.active');

            $implements = class_uses(config('bhcosta90-user.user.model'));
            if (in_array('Spatie\Permission\Traits\HasRoles', $implements)) {
                Route::get('user/{id}/spatie/permissions', [SpatiePermissionController::class, 'index'])->name('user.permission.index');
                Route::put('user/{id}/spatie/permissions', [SpatiePermissionController::class, 'update'])->name('user.permission.update');
                Route::resource('role', SpatieRoleController::class);
            }
        });
    }
}
