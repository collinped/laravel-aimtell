# Laravel Aimtell Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/collinped/laravel-aimtell.svg?style=flat-square)](https://packagist.org/packages/collinped/laravel-aimtell)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/collinped/laravel-aimtell/run-tests?label=tests)](https://github.com/collinped/laravel-aimtell/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/collinped/laravel-aimtell.svg?style=flat-square)](https://packagist.org/packages/collinped/laravel-aimtell)

Aimtell offers a service for push notifications to users who give permission. This package allows for interfacing with Aimtell's backend API to manage your account.

[Aimtell REST API Documentation](https://developers.aimtell.com/reference#authenticating-calls)

## Installation

You can install the package via composer:

```bash
composer require collinped/laravel-aimtell
```

You can publish and run the migrations with:

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Collinped\Aimtell\AimtellServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    'api_key' => env('AIMTELL_API_KEY'), // Required - API Key Provided by Aimtell
    'white_label_id' => env('AIMTELL_WHITE_LABEL_ID'), // Must contact Aimtell for White Label ID
    'default_site_id' => env('AIMTELL_DEFAULT_SITE_ID'), // Recommended
];
```

## Usage

#### Quick Example

``` php
$aimtell = new Collinped\Aimtell($apiKey, $whiteLabelId, $defaultSiteId);

$site = $aimtell->site()
                ->create([
                    'name' => 'Sample Website',
                    'url' => 'collinped.com'
                ]);

$campaigns = $aimtell->site($siteId)
                     ->campaign()
                     ->all();

$campaign = $aimtell->site($siteId)
                    ->campaign($campaignId)
                    ->find();
```

### Sites
- Get All Websites
- Get Website
- Get Website Code
- Add Website
- Update Website Details
- Get Website Settings
- Update Website Settings
- Update Website Package (Safari)
- Delete Website
- Get Website Keys
- Upsert Website Keys

### Subscribers
- Get All Subscribers
- Get Subscriber
- Track Subscriber Attributes
- Track Subscriber Event
- Opt-Out Subscriber

### Segments
- Get All Segments
- Get Segment
- Create Segment
- Update Segment
- Delete Segment
- Get Segment Counts Over Time

### Manual Campaigns
- Get All Manual Campaigns
- Get Manual Campaign

### Sites

#### Get All Websites

``` php
$websites = $aimtell->site()
                    ->all();
```

#### Get Website

``` php
$website = $aimtell->site()
                   ->find($siteId);
```

#### Get Website Code

``` php
$website = $aimtell->site($siteId)
                   ->getCode();
```

#### Add Website

``` php
$websites = $aimtell->site()
                    ->create([
                        'name' => 'Website Name', // Required
                        'url' => 'facebook.com' // Required
                    ]);
```

#### Update Website Details

``` php
$websites = $aimtell->site($siteId)
                    ->update([
                        'name' => 'Website Name',
                        'url' => 'facebook.com'
                        'icon' => 'imageUrl.jpg'
                    ]);
```

#### Get Website Settings

``` php
$websites = $aimtell->site($siteId)
                    ->getSettings();
```

#### Update Website Settings

``` php
$websites = $aimtell->site($siteId)
                    ->updateSettings([
                        ...
                    ]);
```

#### Update Website Package (Safari)

``` php
$websites = $aimtell->site($siteId)
                    ->updatePackage();
```

#### Delete Website

``` php
$websites = $aimtell->site($siteId)
                    ->delete();
```

#### Update Website Keys

``` php
$websites = $aimtell->site($siteId)
                    ->getKeys();
```

#### Upsert Website Keys

``` php
$websites = $aimtell->site($siteId)
                    ->upsertKeys([
                        ...
                    ]);
```

### Subscribers

#### Get All Subscribers

``` php
$subscribers = $aimtell->site($siteId)
                        ->subscriber()
                        ->all();
```

#### Get Subscriber

``` php
$subscriber = $aimtell->site($siteId)
                        ->subscriber()
                        ->find($subscriberId);
```

#### Track Subscriber Attribute

``` php
$subscriber = $aimtell->site($siteId)
                        ->subscriber($subscriberId)
                        ->trackEvent([
                            'first_name' => 'jeff'
                            'gender' => 'male'
                        ]);
```

#### Track Subscriber Event

``` php
$subscriber = $aimtell->site($siteId)
                        ->subscriber($subscriberId)
                        ->trackEvent([
                            'category' => '' // Required
                            'action' => '', // Required
                            'label' => '',
                            'value' => 1.00
                        ]);
```
#### Opt-Out Subscriber

``` php
$subscriber = $aimtell->site($siteId)
                        ->subscriber($subscriberId)
                        ->optOut();
```


## Testing

``` bash
composer test
```

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
