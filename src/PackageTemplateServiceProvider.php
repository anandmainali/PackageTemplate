<?php

namespace Anand\PackageTemplate;

use Illuminate\Support\ServiceProvider;

class PackageTemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/package.php',
            'package'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require 'helpers.php';

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        $this->publishes([
            __DIR__ . './config/package.php' => config_path('package.php')
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\CreatePackage::class,
                Console\Commands\CreateController::class,
                Console\Commands\CreateMigration::class,
                Console\Commands\CreateModel::class,
                Console\Commands\CreatePolicy::class,
            ]);
        }
    }
}
