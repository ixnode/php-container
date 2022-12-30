# PHP Container

[![Release](https://img.shields.io/github/v/release/ixnode/php-container)](https://github.com/ixnode/php-container/releases)
[![PHP](https://img.shields.io/badge/PHP-^8.0-777bb3.svg?logo=php&logoColor=white&labelColor=555555&style=flat)](https://www.php.net/supported-versions.php)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%20Max-brightgreen.svg?style=flat)](https://phpstan.org/user-guide/rule-levels)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-brightgreen.svg?style=flat)](https://www.php-fig.org/psr/psr-12/)
[![LICENSE](https://img.shields.io/github/license/ixnode/php-container)](https://github.com/ixnode/php-container/blob/master/LICENSE)

> A collection of various PHP container classes like JSON, File, etc.

## Installation

```bash
composer require ixnode/php-container
```

```bash
vendor/bin/php-container -V
```

```bash
php-container 0.1.0 (12-19-2022 01:17:26) - Björn Hempel <bjoern@hempel.li>
```

## Usage

```php
use Ixnode\PhpContainer\Json;
use Ixnode\PhpContainer\File;
```

```php
$json = (new Json(['data' => 'json']))->getJsonStringFormatted();
```

```php
$array = (new Json('{"data": "json"}'))->getArray();
```

```php
$exists = (new File('path-to-file'))->exist();
```

```php
$fileSize = (new File('path-to-file'))->getFileSize();
```

```php
$array = (new Json(new File('path-to-json-file')))->getArray();
```

## Development

```bash
git clone git@github.com:ixnode/php-container.git && cd php-container
```

```bash
composer install
```

```bash
composer test
```

## License

This tool is licensed under the MIT License - see the [LICENSE](/LICENSE) file for details