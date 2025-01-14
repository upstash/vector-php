# Vector SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/upstash/vector.svg?style=flat-square)](https://packagist.org/packages/upstash/vector)
[![Tests](https://img.shields.io/github/actions/workflow/status/upstash/vector/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/upstash/vector/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/upstash/vector.svg?style=flat-square)](https://packagist.org/packages/upstash/vector)

This is where your description should go. Try and limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require upstash/vector
```

## Usage

```php
$index = new Upstash\Vector\Index::fromEnv();
$index->getInfo();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jorge Lapa](https://github.com/heyjorgedev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
