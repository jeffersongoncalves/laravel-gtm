# Changelog

All notable changes to this project will be documented in this file.

## 2.0.2 - 2026-04-26

### What's Changed

* build(deps): bump ramsey/composer-install from 3 to 4 by @dependabot[bot] in https://github.com/jeffersongoncalves/laravel-gtm/pull/11
* build(deps): bump dependabot/fetch-metadata from 2.5.0 to 3.0.0 by @dependabot[bot] in https://github.com/jeffersongoncalves/laravel-gtm/pull/12

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-gtm/compare/2.0.1...2.0.2

## 2.0.1 - 2026-02-24

### What's Changed

- Add Laravel 13.x support in composer.json
- Add orchestra/testbench ^11.0 for Laravel 13 testing

## 2.0.0 - 2026-02-20

### Breaking Changes

- Removed `config/gtm.php` and `GTM_ID` environment variable support
- GTM ID is now configured exclusively via database using `spatie/laravel-settings`

### Migration from 1.x

Run `php artisan migrate` to create the settings table, then set your GTM ID at runtime:

```php
$settings = gtm_settings();
$settings->gtm_id = 'GTM-XXXXXX';
$settings->save();



```
## 1.1.0 - 2026-02-20

### What's New

#### Database-backed GTM Settings via spatie/laravel-settings

GTM configuration can now be managed at runtime via database instead of being limited to `config/gtm.php` + `.env`. This enables changing the GTM ID via admin panels, per-tenant settings, or any dynamic scenario.

#### Added

- **`GtmSettings` class** (`src/Settings/GtmSettings.php`) — Spatie Settings class with `gtm_id` property and `'gtm'` group
- **Settings migration** — Seeds from existing `config('gtm.gtm_id')` / `env('GTM_ID')` for backward compatibility
- **`Gtm` Facade** — `JeffersonGoncalves\Gtm\Facades\Gtm` for convenient access
- **`gtm_settings()` helper** — Global helper function returning the `GtmSettings` instance
- **Test suite** — 9 Pest tests covering settings resolution, persistence, view rendering, helper, and facade

#### Changed

- Views (`head.blade.php`, `body.blade.php`) now read from `GtmSettings` instead of `config()`
- `GtmServiceProvider` registers settings class and migrations path

#### Backward Compatibility

- `config/gtm.php` is **kept as-is** — it serves as the seed source for the settings migration
- Existing users running `php artisan migrate` will have their GTM ID automatically migrated to the database
- Users who published views will need to re-publish to use the new settings-based approach

#### New Dependencies

- `spatie/laravel-settings: ^3.0` (required)

## 1.0.0 - 2025-05-01

**Full Changelog**: https://github.com/jeffersongoncalves/laravel-gtm/commits/1.0.0
