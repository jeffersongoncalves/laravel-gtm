<?php

use JeffersonGoncalves\Gtm\Settings\GtmSettings;

it('can resolve GtmSettings from the container', function () {
    $settings = app(GtmSettings::class);

    expect($settings)->toBeInstanceOf(GtmSettings::class);
});

it('has empty gtm_id by default', function () {
    $settings = app(GtmSettings::class);

    expect($settings->gtm_id)->toBe('');
});

it('can persist gtm_id', function () {
    $settings = app(GtmSettings::class);
    $settings->gtm_id = 'GTM-TEST123';
    $settings->save();

    $fresh = app(GtmSettings::class);
    expect($fresh->gtm_id)->toBe('GTM-TEST123');
});

it('renders head view with gtm_id', function () {
    $settings = app(GtmSettings::class);
    $settings->gtm_id = 'GTM-HEADTEST';
    $settings->save();

    $view = view('gtm::head')->render();

    expect($view)
        ->toContain('GTM-HEADTEST')
        ->toContain('googletagmanager.com/gtm.js');
});

it('renders body view with gtm_id', function () {
    $settings = app(GtmSettings::class);
    $settings->gtm_id = 'GTM-BODYTEST';
    $settings->save();

    $view = view('gtm::body')->render();

    expect($view)
        ->toContain('GTM-BODYTEST')
        ->toContain('googletagmanager.com/ns.html');
});

it('does not render head view when gtm_id is empty', function () {
    $settings = app(GtmSettings::class);
    $settings->gtm_id = '';
    $settings->save();

    $view = view('gtm::head')->render();

    expect($view)->not->toContain('googletagmanager.com');
});

it('does not render body view when gtm_id is empty', function () {
    $settings = app(GtmSettings::class);
    $settings->gtm_id = '';
    $settings->save();

    $view = view('gtm::body')->render();

    expect($view)->not->toContain('googletagmanager.com');
});

it('provides gtm_settings helper function', function () {
    $settings = gtm_settings();

    expect($settings)->toBeInstanceOf(GtmSettings::class);
});

it('provides Gtm facade', function () {
    $facade = JeffersonGoncalves\Gtm\Facades\Gtm::getFacadeRoot();

    expect($facade)->toBeInstanceOf(GtmSettings::class);
});
