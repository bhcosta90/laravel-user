<?php 

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function(){
    Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
        Route::resource("users", config('user.controllers.users'));
    });
});