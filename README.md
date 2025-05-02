<div class="filament-hidden">

![Laravel Google Tag Manager](https://raw.githubusercontent.com/jeffersongoncalves/laravel-gtm/master/art/jeffersongoncalves-laravel-gtm.png)

</div>

# Laravel Google Tag Manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-gtm.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-gtm)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-gtm/fix-php-code-style-issues.yml?branch=master&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-gtm/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-gtm.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-gtm)

This plugin seamlessly integrates Google Tag Manager (GTM) into your website, enabling streamlined management and deployment of marketing tags, analytics, and tracking pixels. With easy-to-implement script inclusion and customizable options, it simplifies the process of monitoring user interactions and gathering valuable insights without altering your site's core code. Perfect for marketers and developers looking to enhance their tracking capabilities with minimal effort.

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-gtm
```

## Usage

Publish config file.

```bash
php artisan vendor:publish --tag=gtm-config
```

Add start head template.

```php
@include('gtm::head')
```

Add start body template.

```php
@include('gtm::body')
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jèfferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
