<?php


namespace Costa\User\Routes;


use Costa\User\Http\Controllers\{ProfileController, UserController};
use Illuminate\Support\Facades\Route;

class CostaRoutes
{
    public static function setRoutes()
    {
        Route::resource('user', config('costa_user.controllers.user'));
        Route::resource('profile', config('costa_user.controllers.profile'))->only('index', 'store')
            ->middleware('auth');

        Route::post('/profile/password', [config('costa_user.controllers.profile'), 'password'])->name('profile.password');
    }
}
