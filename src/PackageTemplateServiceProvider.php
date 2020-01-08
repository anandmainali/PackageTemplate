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
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        require 'helpers.php';

        if($this->app->runningInConsole()) {
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
