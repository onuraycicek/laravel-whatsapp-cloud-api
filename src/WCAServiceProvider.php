<?php

namespace WCA\WCA;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use WCA\WCA\Commands\WCACommand;

class WCAServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-whatsapp-cloud-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('hook')
            ->hasMigration('create_laravel-whatsapp-cloud-api_table')
            ->hasCommand(WCACommand::class);
    }
}
