<?php

namespace JeffersonGoncalves\Gtm\Tests;

use Illuminate\Support\Facades\Schema;
use JeffersonGoncalves\Gtm\GtmServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelSettings\LaravelSettingsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelSettingsServiceProvider::class,
            GtmServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUpDatabase(): void
    {
        if (! Schema::hasTable('settings')) {
            Schema::create('settings', function ($table) {
                $table->id();
                $table->string('group');
                $table->string('name');
                $table->boolean('locked')->default(false);
                $table->json('payload');
                $table->timestamps();

                $table->unique(['group', 'name']);
            });
        }

        $this->seedSettings();
    }

    protected function seedSettings(string $gtmId = ''): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
            ['group' => 'gtm', 'name' => 'gtm_id'],
            ['payload' => json_encode($gtmId), 'locked' => false, 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
