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
}
