<?php

namespace JeffersonGoncalves\Gtm\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\Gtm\Settings\GtmSettings;

/**
 * @property string $gtm_id
 *
 * @see GtmSettings
 */
class Gtm extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GtmSettings::class;
    }
}
