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

        $this->commands([
            \Anand\PackageTemplate\Console\Commands\CreatePackage::class,
            \Anand\PackageTemplate\Console\Commands\CreateController::class,
            \Anand\PackageTemplate\Console\Commands\CreateMigration::class,
            \Anand\PackageTemplate\Console\Commands\CreateModel::class,
            \Anand\PackageTemplate\Console\Commands\CreatePolicy::class,
        ]);
    }
}
