---
name: gtm-development
description: Integrate and manage Google Tag Manager tracking in Laravel applications using the jeffersongoncalves/laravel-gtm package with spatie/laravel-settings.
---

# GTM Development

## When to use this skill

Use this skill when:
- Adding Google Tag Manager (GTM) tracking to a Laravel application
- Managing the GTM container ID via database settings
- Including GTM head and body scripts in Blade layouts
- Building admin interfaces to configure GTM settings
- Working with the `GtmSettings` class (spatie/laravel-settings)

## Setup

### Install the package

```bash
composer require jeffersongoncalves/laravel-gtm
```

### Publish and run settings migration

```bash
php artisan vendor:publish --tag=gtm-settings-migrations
php artisan migrate
```

This creates the `gtm.gtm_id` setting in the `settings` database table.

### Requirements

- PHP 8.2+
- Laravel 11+
- `spatie/laravel-settings` ^3.0

## Package Structure

```
src/
  Facades/Gtm.php              # Facade resolving to GtmSettings
  Settings/GtmSettings.php     # Settings class with gtm_id property
  GtmServiceProvider.php        # Service provider (auto-discovered)
  helpers.php                   # gtm_settings() global helper
resources/views/
  head.blade.php                # GTM JavaScript snippet for <head>
  body.blade.php                # GTM noscript iframe for <body>
database/settings/
  2026_02_20_000000_create_gtm_settings.php  # Settings migration
```

## Settings Class

The `GtmSettings` class extends `Spatie\LaravelSettings\Settings`:

```php
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
```

### Accessing settings

```php
use JeffersonGoncalves\Gtm\Settings\GtmSettings;

// Via global helper
$settings = gtm_settings();
$gtmId = $settings->gtm_id;

// Via facade
$gtmId = \JeffersonGoncalves\Gtm\Facades\Gtm::gtm_id;

// Via dependency injection
public function show(GtmSettings $settings)
{
    return $settings->gtm_id;
}

// Via app container
$settings = app(GtmSettings::class);
```

### Updating settings

```php
$settings = app(GtmSettings::class);
$settings->gtm_id = 'GTM-XXXXXXX';
$settings->save();
```

## Blade Views

The package provides two Blade views that must both be included in your layout.

### Head script (`gtm::head`)

Place inside `<head>` -- renders the GTM JavaScript snippet:

```blade
<head>
    @include('gtm::head')
    <!-- other head content -->
</head>
```

The view checks if `gtm_id` is non-empty before rendering. When populated, it outputs:

```html
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
<!-- End Google Tag Manager -->
```

### Body noscript (`gtm::body`)

Place immediately after `<body>` -- renders the noscript fallback:

```blade
<body>
    @include('gtm::body')
    <!-- page content -->
</body>
```

When `gtm_id` is populated, it outputs:

```html
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
```

## Service Provider

The `GtmServiceProvider` handles:

1. **View registration**: Publishes views under the `gtm` namespace (`gtm::head`, `gtm::body`).
2. **Settings class registration**: Merges `GtmSettings::class` into `settings.settings` config array.
3. **Migration path registration**: Merges the package's `database/settings` path into `settings.migrations_paths`.
4. **Publishable migrations**: Tagged as `gtm-settings-migrations`.

## Integration with Filament

To manage GTM settings via a Filament admin panel, create a settings page:

```php
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use JeffersonGoncalves\Gtm\Settings\GtmSettings;

class ManageGtmSettings extends SettingsPage
{
    protected static string $settings = GtmSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('gtm_id')
                ->label('GTM Container ID')
                ->placeholder('GTM-XXXXXXX')
                ->maxLength(20),
        ]);
    }
}
```

## Configuration

This package has **no config file**. All configuration is stored in the database via `spatie/laravel-settings`.

| Setting | Type | Default | Description |
|---------|------|---------|-------------|
| `gtm.gtm_id` | `string` | `''` | Google Tag Manager container ID (e.g., `GTM-XXXXXXX`) |

## Testing

The package uses Pest with Orchestra Testbench:

```bash
php vendor/bin/pest
```

### Testing patterns

```php
use JeffersonGoncalves\Gtm\Settings\GtmSettings;

it('renders gtm head script when id is set', function () {
    $settings = app(GtmSettings::class);
    $settings->gtm_id = 'GTM-TEST123';
    $settings->save();

    $view = $this->blade("@include('gtm::head')");

    $view->assertSee('GTM-TEST123');
    $view->assertSee('googletagmanager.com/gtm.js');
});

it('does not render when gtm_id is empty', function () {
    $settings = app(GtmSettings::class);
    $settings->gtm_id = '';
    $settings->save();

    $view = $this->blade("@include('gtm::head')");

    $view->assertDontSee('googletagmanager');
});
```

## Publish Tags

| Tag | Description |
|-----|-------------|
| `gtm-settings-migrations` | Settings migration to `database/settings/` |
