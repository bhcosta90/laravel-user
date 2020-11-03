<?php

namespace BRCas\User\Test;

use BRCas\User\Models\User;
use BRCas\User\Providers\UserProvider;
use BRCas\User\Providers\UserTestProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase as BaseTestCase;

// use Orchestra\Testbench\BrowserKit\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    use DatabaseMigrations, WithFaker;

    public $baseUrl = 'http://localhost';

    /**
     * Load package service provider.
     *
     * @param Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        return [UserProvider::class, UserTestProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function debugSql($table)
    {
        dd(DB::table($table)->get()->toArray());
    }
}