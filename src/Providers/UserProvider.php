<?php

namespace BRCas\User\Providers;

use BRCas\Laravel\Providers\PackageServiceProvider;
use BRCas\User\Repositories\{Contracts\UserContract, UserRepository};
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(PackageServiceProvider::class);
        $this->registerConfig();

        $this->app->bind(UserContract::class, UserRepository::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                realpath(__DIR__ . '/../Config/config.php') => config_path('user.php'),
            ], 'config');
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php',
            'user'
        );
    }

    public function boot()
    {
        $this->registerViews();
        $this->registerTranslations();
        $this->registerConfig();
    }

    public function registerViews()
    {
        $viewPath = resource_path('views/modules/user');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'user']);

        $this->loadViewsFrom($sourcePath, "user");
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . "/../Resources/lang", "user");
    }
}