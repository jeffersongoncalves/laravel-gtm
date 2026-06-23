<?php

namespace JeffersonGoncalves\Gtm;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use JeffersonGoncalves\Gtm\Settings\GtmSettings;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GtmServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-gtm')
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        parent::packageRegistered();

        Config::set('settings.settings', array_merge(
            Config::get('settings.settings', []),
            [GtmSettings::class]
        ));
    }

    public function packageBooted(): void
    {
        parent::packageBooted();

        $migrationsPath = __DIR__.'/../database/settings';

        Config::set('settings.migrations_paths', array_merge(
            Config::get('settings.migrations_paths', []),
            [$migrationsPath]
        ));

        $this->publishes([
            $migrationsPath => database_path('settings'),
        ], 'gtm-settings-migrations');

        Blade::directive('gtmHead', fn () => "<?php echo view('gtm::head')->render(); ?>");
        Blade::directive('gtmBody', fn () => "<?php echo view('gtm::body')->render(); ?>");
    }
}
