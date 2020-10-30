<?php

namespace BRCas\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserTestProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database');
    }
}