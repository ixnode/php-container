# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Releases

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
