<?php

namespace Costa\User\Providers;

use Config;
use Costa\User\View\Components\PaginatorComponent;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Costa\User\Repositories\Contracts\{RoleContract, UserContract};
use Costa\User\Routes\CostaRoutesFacade;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'User';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'costa_user';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        Blade::component('paginator', PaginatorComponent::class);
        $this->app->bind(UserContract::class, config('costa_user.repositories.user'));
        $this->app->bind(RoleContract::class, config('costa_user.repositories.role'));
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/vendor/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(__DIR__ . "/../Resources/lang", $this->moduleNameLower);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . "/../Config/config.php" => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . "/../Config/config.php", $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/vendor/' . $this->moduleNameLower);

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(RouteServiceProvider::class);
        $defaultInput = [
            'wrapper_class'       => 'form-group',
            'wrapper_error_class' => 'has-error',
            'label_class'         => 'control-label',
            'field_class'         => 'form-control',
            'field_error_class'   => '',
            'help_block_class'    => 'help-block',
            'error_class'         => 'text-danger',
            'required_class'      => 'required',
            'radio' => [
                'wrapper_class'   => 'form-group icheck-primary',
                'choice_options' => [
                    'wrapper' => ['class' => 'form-radio'],
                    'label' => ['class' => 'form-radio-label'],
                    'field' => ['class' => 'form-radio-field'],
                ],
            ],
            'checkbox' => [
                'wrapper_class'   => 'form-group icheck-primary',
                'choice_options' => [
                    'wrapper' => ['class' => 'form-radio'],
                    'label' => ['class' => 'form-radio-label'],
                    'field' => ['class' => 'form-radio-field'],
                ],
            ]
        ];

        config()->set('laravel-form-builder.defaults', $defaultInput);
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('CostaRoutesFacade', CostaRoutesFacade::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
