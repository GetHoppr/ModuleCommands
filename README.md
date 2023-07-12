# This is my package modulecommands

[![Latest Version on Packagist](https://img.shields.io/packagist/v/gethoppr/modulecommands.svg?style=flat-square)](https://packagist.org/packages/gethoppr/modulecommands)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/gethoppr/modulecommands/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/gethoppr/modulecommands/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/gethoppr/modulecommands/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/gethoppr/modulecommands/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/gethoppr/modulecommands.svg?style=flat-square)](https://packagist.org/packages/gethoppr/modulecommands)


## Usage

### Avaialble Commands

Make a new module
```bash 
php artisan make:module {name}
```

Destroy a module
```bash     
php artisan module:destroy {name}
```

Pull a module out into a separate microservice
```bash
php artisan module:pull {name}
```

Use a regular artisan command, but in the context of a module
```bash
php artisan module:command --module={name} {command}
```

For example, lets say we want to create a new controller in the `User` module. We can do that with the following command:

```bash
php artisan module:command --module=User make:controller UserController
```


## Installation

You can install the package via composer:

```bash
composer require gethoppr/modulecommands
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="modulecommands-migrations"
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="modulecommands-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="modulecommands-views"
```

## Usage

```php
$moduleCommands = new GetHoppr\ModuleCommands();
echo $moduleCommands->echoPhrase('Hello, GetHoppr!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Joe Cianflone](https://github.com/GetHoppr)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
