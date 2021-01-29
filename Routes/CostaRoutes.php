<?php


namespace Costa\User\Routes;


use Illuminate\Support\Facades\Route;

class CostaRoutes
{
    public static function setRoutes()
    {
        Route::group(['prefix' => 'user'], function () {
            Route::resource('user', config('costa_user.controllers.user'));
            Route::resource('role', config('costa_user.controllers.role'));

            Route::resource('profile', config('costa_user.controllers.profile'))->only('index', 'store')
                ->middleware('auth');
        });

        Route::post('/profile/password', [config('costa_user.controllers.profile'), 'password'])->name('profile.password');
    }
}
