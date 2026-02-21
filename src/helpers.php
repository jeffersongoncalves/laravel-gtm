<?php

use JeffersonGoncalves\Gtm\Settings\GtmSettings;

if (! function_exists('gtm_settings')) {
    function gtm_settings(): GtmSettings
    {
        return app(GtmSettings::class);
    }
}
