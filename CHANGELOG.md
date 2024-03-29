# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Releases

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
