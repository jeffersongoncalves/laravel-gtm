<?php

namespace JeffersonGoncalves\Gtm\Settings;

use Spatie\LaravelSettings\Settings;

class GtmSettings extends Settings
{
    public string $gtm_id = '';

    public static function group(): string
    {
        return 'gtm';
    }

    public function hasValidId(): bool
    {
        return preg_match('/^GTM-[A-Z0-9]+$/', $this->gtm_id) === 1;
    }
}
