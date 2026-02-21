<?php

namespace JeffersonGoncalves\Gtm\Facades;

use Illuminate\Support\Facades\Facade;
use JeffersonGoncalves\Gtm\Settings\GtmSettings;

/**
 * @see \JeffersonGoncalves\Gtm\Settings\GtmSettings
 */
class Gtm extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return GtmSettings::class;
    }
}
