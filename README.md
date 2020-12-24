# Laravel Aimtell Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/collinped/laravel-aimtell.svg?style=flat-square)](https://packagist.org/packages/collinped/laravel-aimtell)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/collinped/laravel-aimtell/run-tests?label=tests&style=flat-square)](https://github.com/collinped/laravel-aimtell/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/collinped/laravel-aimtell.svg?style=flat-square)](https://packagist.org/packages/collinped/laravel-aimtell)

[Aimtell](https://aimtell.com/) offers a service for push notifications to users who give permission. This package allows for interfacing with Aimtell's backend API to manage your account.

[Aimtell REST API Documentation](https://developers.aimtell.com/reference#authenticating-calls)

## Installation

You can install the package via composer:

```bash
composer require collinped/laravel-aimtell
```

You can publish and run the migrations with:

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Collinped\LaravelAimtell\AimtellServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'api_key' => env('AIMTELL_API_KEY'), // Required - API Key Provided by Aimtell
    'default_site_id' => env('AIMTELL_DEFAULT_SITE_ID'), // Recommended
    'white_label_id' => env('AIMTELL_WHITE_LABEL_ID'), // Must contact Aimtell for White Label ID
];
```

## Usage

#### Quick Example

``` php
$site = aimtell()->site()
                ->create([
                    'name' => 'Sample Website',
                    'url' => 'collinped.com'
                ]);

$campaigns = aimtell()->site($siteId)
                     ->campaign()
                     ->all();

$campaign = aimtell()->site($siteId)
                    ->campaign()
                    ->find($campaignId);
```

## Testing

``` bash
composer test
```

## Todo

- [ ] A/B Tests for Manual Campaigns
- [ ] Create Manual Campaign (Batch)
- [ ] Update Manual Campaign (Batch)
- [ ] Delete Manual Campaign (Batch)
- [ ] Create Event Triggered Campaign (Batch)
- [ ] Update Event Triggered Campaign (Batch)
- [ ] Delete Event Triggered Campaign (Batch)
- [ ] Get Notification Logs
- [ ] Get Attributes Logs
- [ ] Get Pageview Logs
- [ ] Get Event Logs

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Collin Pedersen](https://github.com/collinped)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
