<h1 align="center">Vapor HTTP Logger</h1>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ageekdev/vapor-http-logger.svg?style=flat-square)](https://packagist.org/packages/ageekdev/vapor-http-logger)
[![Laravel 9.x](https://img.shields.io/badge/Laravel-9.x-red.svg?style=flat-square)](https://laravel.com/docs/9.x)
[![Laravel 10.x](https://img.shields.io/badge/Laravel-10.x-red.svg?style=flat-square)](http://laravel.com)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/ageekdev/vapor-http-logger/run-tests?label=tests&style=flat-square)](https://github.com/ageekdev/vapor-http-logger/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ageekdev/vapor-http-logger.svg?style=flat-square)](https://packagist.org/packages/ageekdev/vapor-http-logger)

Log HTTP requests in Laravel Vapor applications

## Installation

You can install the package via composer:

```bash
composer require ageekdev/vapor-http-logger
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="AgeekDev\HttpLogger\HttpLoggerServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    /*
     *  Automatic registration of middleware will only happen if this setting is `true`
     */
    'enabled' => env('HTTP_LOGGER_ENABLED', true),

    /*
     * The log profile which determines whether a request should be logged.
     * It should implement `LogProfile`.
     */
    'log_profile' => \AgeekDev\HttpLogger\LogNonGetRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer' => \AgeekDev\HttpLogger\DefaultLogWriter::class,

    /*
     * The log level used to log the request.
     */
    'log_level' => 'info',

    /*
     * List of request methods that will be logged.
     */
    'request_methods' => ['post', 'put', 'patch', 'delete'],

    /*
     * Filter out body fields which will never be logged.
     */
    'except' => [
        'password',
        'password_confirmation',
    ],

    /*
     * List of headers that will be sanitized. For example Authorization, Cookie, Set-Cookie...
     */
    'sanitize_headers' => [],
];
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

- [Tint Naing Win](https://github.com/tintnaingwinn)
- [All Contributors](../../contributors)

This package contains code copied from [Log HTTP requests](https://github.com/spatie/laravel-http-logger)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
