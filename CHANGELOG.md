# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Releases

### [1.0.21] - 2025-02-28

* Update symfony/yaml parser from to 7.1 to 7.2

### [1.0.20] - 2025-02-28

* Add .phprc file
* Add php switcher to composer.json

### [1.0.19] - 2025-02-28

* Add isJson method to File object
* Add JSON file tests

### [1.0.18] - 2025-02-28

* Add PHPCS tests
* Add the version to test header
* Fixes to PHPCS

### [1.0.17] - 2025-02-28

* Add fixes according to PHPStan

### [1.0.16] - 2025-01-16

* Add getKeyStringLength method to JSON object

### [1.0.15] - 2024-12-19

* Add additionalBlocks parameter to Directory::getDirectoryInformationTable

### [1.0.14] - 2024-12-19

* Add false option to directory and file callback for the option to skip

### [1.0.13] - 2024-12-19

* Add directory and file callback to Directory::getDirectoryInformationTable

### [1.0.12] - 2024-12-19

* File and directory list output optimization

### [1.0.11] - 2024-12-18

* Add path check and error message

### [1.0.10] - 2024-12-18

* Add Directory and Symlink object
* Add directory and file to "bin/php-container ls"

### [1.0.9] - 2024-12-18

* Add hints

### [1.0.8] - 2024-12-18

* Fix text/x-c++ mime type

### [1.0.7] - 2024-12-18

* Update symfony/yaml (v6.4.13 => v7.1.6)

### [1.0.6] - 2024-12-18

* Update symfony components (v6.2.2 => v7.2.0)
* Update PHPStan (1.9.4 => 1.12.13)
* Update PHPMD (2.13.0 => 2.15.0)
* Update PHPUnit (9.5.27 => 9.6.22)

### [1.0.5] - 2024-12-18

* Add application/yaml mime type

### [1.0.4] - 2024-12-17

* Add bin/php-container script updates

### [1.0.3] - 2024-12-17

* Add mime types
* Add mime type icons
* Add csv and json returns
* Add File::getInformation method with callback
* Add tests
* Add bin/console ls command

### [1.0.2] - 2024-12-07

* Update ixnode packages

### [1.0.1] - 2024-12-07

* Update ixnode packages

### [1.0.0] - 2024-12-07

* Extend image class with some exif data
* Add image test

### [0.1.24] - 2024-11-30

* Add ignore orientation flag to Image class
  * Resets the orientation autocorrection of GdImage

### [0.1.23] - 2024-02-25

* Add simple JSON::deleteKey method (missing so far)

### [0.1.22] - 2023-12-30

* Add more type hints

### [0.1.21] - 2023-12-29

* Add key mode "underline"

### [0.1.20] - 2023-12-29

* Add key mode "underline"

### [0.1.19] - 2023-12-18

* Translate integer value to string within Json::getKeyString
* Remove method Json::isKey
* Add Alias getKeyBoolean (from isKeyBoolean)

### [0.1.18] - 2023-12-14

* Add Image class
* Refactoring

### [0.1.17] - 2023-12-14

* README.md badges refactoring

### [0.1.16] - 2023-12-12

* Add Json::getKeyArrayJson() method

### [0.1.15] - 2023-12-12

* Add the bool type to Json::addValue

### [0.1.14] - 2023-12-11

* Add key path config to the key path
* Add tests to this case

### [0.1.13] - 2023-12-11

* Fix recursive issue with array syntax

### [0.1.12] - 2023-12-11

* Add array key syntax to hasKey
* Add hasKey tests

### [0.1.11] - 2023-11-18

* Add float to Json::addValue

### [0.1.10] - 2023-08-14

* Add Json::getKeyFloat() method

### [0.1.9] - 2023-06-28

* Add additional methods to File class

### [0.1.8] - 2023-06-25

* Composer update
* Fix package description

### [0.1.7] - 2023-01-26

* Add Json::buildArrayCombined method

### [0.1.6] - 2023-01-26

* Add Json::buildArray method
* Add documentation

### [0.1.5] - 2023-01-22

* Add Json::isKeyBoolean method

### [0.1.4] - 2023-01-22

* Update ixnode/php-checker

### [0.1.3] - 2023-01-10

* Add CSV Container

### [0.1.2] - 2022-12-30

* Add File::getDate

### [0.1.1] - 2022-12-30

* Remove .phpunit.result.cache from repository

### [0.1.0] - 2022-12-30

* Initial release
* Add src
* Add tests
  * PHP Coding Standards Fixer
  * PHPMND - PHP Magic Number Detector
  * PHPStan - PHP Static Analysis Tool
  * PHPUnit - The PHP Testing Framework
  * Rector - Instant Upgrades and Automated Refactoring
* Add README.md
* Add LICENSE.md

## Add new version

```bash
# Checkout master branch
$ git checkout main && git pull

# Check current version
$ vendor/bin/version-manager --current

# Increase patch version
$ vendor/bin/version-manager --patch

# Change changelog
$ vi CHANGELOG.md

# Push new version
$ git add CHANGELOG.md VERSION && git commit -m "Add version $(cat VERSION)" && git push

# Tag and push new version
$ git tag -a "$(cat VERSION)" -m "Version $(cat VERSION)" && git push origin "$(cat VERSION)"
```
