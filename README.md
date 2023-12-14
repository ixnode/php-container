# PHP Container

[![Release](https://img.shields.io/github/v/release/ixnode/php-container)](https://github.com/ixnode/php-container/releases)
[![](https://img.shields.io/github/release-date/ixnode/php-container)](https://github.com/twelvepics-com/php-calendar-builder/releases)
[![PHP](https://img.shields.io/badge/PHP-^8.0-777bb3.svg?logo=php&logoColor=white&labelColor=555555&style=flat)](https://www.php.net/supported-versions.php)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%20Max-777bb3.svg?style=flat)](https://phpstan.org/user-guide/rule-levels)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-Unit%20Tests-6b9bd2.svg?style=flat)](https://phpunit.de)
[![PHPCS](https://img.shields.io/badge/PHPCS-PSR12-416d4e.svg?style=flat)](https://www.php-fig.org/psr/psr-12/)
[![PHPMD](https://img.shields.io/badge/PHPMD-ALL-364a83.svg?style=flat)](https://github.com/phpmd/phpmd)
[![Rector - Instant Upgrades and Automated Refactoring](https://img.shields.io/badge/Rector-PHP%208.0-73a165.svg?style=flat)](https://github.com/rectorphp/rector)
[![LICENSE](https://img.shields.io/github/license/ixnode/php-container)](https://github.com/ixnode/php-container/blob/master/LICENSE)

> A collection of various PHP container classes like JSON, File, etc.

## 1) Installation

```bash
composer require ixnode/php-container
```

```bash
vendor/bin/php-container -V
```

```bash
php-container 0.1.0 (12-19-2022 01:17:26) - Björn Hempel <bjoern@hempel.li>
```

## 2) Usage

### 2.1) File

```php
use Ixnode\PhpContainer\File;
```

#### 2.1.1) Check if file exists

```php
$exists = (new File('path-to-file'))->exist();
```

```php
true || false
```

#### 2.1.2) Get the filesize (`integer` value)

```php
$fileSize = (new File('path-to-file'))->getFileSize();
```

```php
1523943
```

#### 2.1.3) Get the filesize (human readable)

```php
$fileSizeHuman = (new File('path-to-file'))->getFileSizeHuman();
```

```php
1.45 MB
```

#### 2.1.4) Get the file content

```php
$content = (new File('path-to-file'))->getContentAsText();
```

```php
line 1
line 2
line 3
...
```

#### 2.1.5) Get the file content as JSON object

```php
$content = (new File('path-to-json-file'))->getJson()->getJsonStringFormatted();
```

```php
{
    "data": "Content of file 'path-to-json-file'."
}
```

### 2.2) JSON

```php
use Ixnode\PhpContainer\Json;
```

#### 2.2.1) Convert `array` to JSON

```php
$json = (new Json(['data' => 'json']))->getJsonStringFormatted();
```

```json
{
    "data": "json"
}
```

#### 2.2.2) Convert JSON to `array`

```php
$array = (new Json('{"data": "json"}'))->getArray();
```

```php
[
    'data' => 'json',
]
```

#### 2.2.3) Convert JSON file to `array`

```php
$array = (new Json(new File('path-to-json-file')))->getArray();
```

```php
[
    "data" => "Content of file 'path-to-json-file'.",
]
```

#### 2.2.4) Build a new `array` from JSON

```php
$array = (new Json('[{"key1": 111, "key2": "222"},{"key1": 333, "key2": "444"}]'))->buildArray(
    [
        /* path []['key1'] as area1 */
        'area1' => [['key1']],
        /* path []['key2'] as area2 */
        'area2' => [['key2']],
    ]
);
```

```php
[
    'area1' => [111, 333],
    'area2' => ['222', '444'],
]
```

### 2.3) CSV

```php
use Ixnode\PhpContainer\Csv;
```

#### 2.3.1) Parse CSV file to array

```php
$array = (new Csv(new File('path-to-csv-file')))->getArray();
```

Content of "path-to-csv-file":

```text
"headerLine1Cell1";"headerLine1Cell2"
"valueLine2Cell1";"valueLine2Cell2"
"valueLine3Cell1";"valueLine3Cell2"
```

Response:

```php
[
    [
        'headerLine1Cell1' => 'valueLine2Cell1',
        'headerLine1Cell2' => 'valueLine2Cell2',
    ],    
    [
        'headerLine1Cell1' => 'valueLine3Cell1',
        'headerLine1Cell2' => 'valueLine3Cell2',
    ],
    ...
]
```

### 2.4) Curl

```php
use Ixnode\PhpContainer\Curl;
```

#### 2.4.1) Return the response value from 'URL'

```php
$text = (new Curl('URL')->getContentAsText();
```

### 2.5) Image

```php
use Ixnode\PhpContainer\Image;
```

#### 2.5.1) Return width of given image.

```php
$imageWidth = (new Image(new File('path-to-json-file')))->getWidth();
```

#### 2.5.2) Returns a resized image.

```php
$imageString = (new Image(new File('path-to-json-file')))->getImageString(1000, Image::FORMAT_JPG, 85);
```

## 3.) Development

```bash
git clone git@github.com:ixnode/php-container.git && cd php-container
```

```bash
composer install
```

```bash
composer test
```

## 4.) License

This tool is licensed under the MIT License - see the [LICENSE](/LICENSE) file for details