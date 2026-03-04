## Laravel GTM (Google Tag Manager)

The `jeffersongoncalves/laravel-gtm` package integrates Google Tag Manager into Laravel applications using `spatie/laravel-settings` for database-driven configuration.

### Overview

- **Namespace**: `JeffersonGoncalves\Gtm`
- **Service Provider**: `GtmServiceProvider` (auto-discovered)
- **Facade**: `JeffersonGoncalves\Gtm\Facades\Gtm` (resolves to `GtmSettings`)
- **Helper**: `gtm_settings()` returns `GtmSettings` instance
- **Views**: `gtm::head` (JS snippet) and `gtm::body` (noscript fallback)

### Key Concepts

- Settings are stored in the database via `spatie/laravel-settings`, not in config files.
- The `GtmSettings` class has a single property: `gtm_id` (string).
- Views conditionally render GTM scripts only when `gtm_id` is not empty.
- Two Blade includes are needed: one in `<head>` and one after `<body>`.

### Settings (spatie/laravel-settings)

The `GtmSettings` class extends `Spatie\LaravelSettings\Settings` with group `gtm`:

@verbatim
<code-snippet name="GtmSettings class" lang="php">
use JeffersonGoncalves\Gtm\Settings\GtmSettings;

// Via helper
$settings = gtm_settings();
$gtmId = $settings->gtm_id;

// Via facade
$gtmId = \JeffersonGoncalves\Gtm\Facades\Gtm::gtm_id;

// Via dependency injection
public function __construct(private GtmSettings $settings) {}
</code-snippet>
@endverbatim

### Configuration

No config file is used. All settings are database-driven via `spatie/laravel-settings`.

Settings migration adds: `gtm.gtm_id` (default: `''`).

Publish the settings migration:

@verbatim
<code-snippet name="Publishing migrations" lang="bash">
php artisan vendor:publish --tag=gtm-settings-migrations
php artisan migrate
</code-snippet>
@endverbatim

### Blade Integration

Include both GTM views in your layout:

@verbatim
<code-snippet name="Layout integration" lang="blade">
<html>
<head>
    @include('gtm::head')
</head>
<body>
    @include('gtm::body')
    <!-- Your content -->
</body>
</html>
</code-snippet>
@endverbatim

### Updating Settings

@verbatim
<code-snippet name="Updating GTM ID" lang="php">
use JeffersonGoncalves\Gtm\Settings\GtmSettings;

$settings = app(GtmSettings::class);
$settings->gtm_id = 'GTM-XXXXXXX';
$settings->save();
</code-snippet>
@endverbatim

### Conventions

- The `GtmSettings` group is `gtm` -- all database settings are prefixed with `gtm.`.
- The service provider auto-registers `GtmSettings` into `settings.settings` config array.
- The settings migration path is auto-registered into `settings.migrations_paths`.
- Views only render when `gtm_id` is a non-empty string.
- The `gtm::head` view outputs the GTM JavaScript snippet for `<head>`.
- The `gtm::body` view outputs the GTM `<noscript>` iframe for `<body>`.
