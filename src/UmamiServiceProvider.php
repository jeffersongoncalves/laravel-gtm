<?php

namespace JeffersonGoncalves\Gtm;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GtmServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-gtm')
            ->hasConfigFile('gtm')
            ->hasViews();
    }
}
