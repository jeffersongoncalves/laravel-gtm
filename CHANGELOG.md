# Changelog

All notable changes to this project will be documented in this file.

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
