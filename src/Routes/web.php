<?php

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::resource("users", config('user.controllers.users'));
        Route::resource("roles", config('user.controllers.roles'))->except(['show']);
    });
});

Route::group([
    'prefix' => 'admin/users/profile',
    'middleware' => ['auth']
], function () {
    Route::get('/', [config('user.controllers.profile'), 'index'])->name('profile');
    Route::post('/profile', [config('user.controllers.profile'), 'profile'])->name('admin.users.profile.profile');
    Route::post('/password', [config('user.controllers.profile'), 'password'])->name('admin.users.profile.password');
});
