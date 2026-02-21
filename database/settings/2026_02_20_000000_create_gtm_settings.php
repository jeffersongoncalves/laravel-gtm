<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('gtm.gtm_id', config('gtm.gtm_id', env('GTM_ID', '')));
    }
};
