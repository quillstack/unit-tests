# Quillstack Unit Tests

[![Build Status](https://app.travis-ci.com/quillstack/unit-tests.svg?branch=main)](https://app.travis-ci.com/quillstack/unit-tests)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/unit-tests.svg)](https://packagist.org/packages/quillstack/unit-tests)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=coverage)](https://sonarcloud.io/dashboard?id=quillstack_unit-tests)
[![Lines of Code](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=ncloc)](https://sonarcloud.io/dashboard?id=quillstack_unit-tests)
[![StyleCI](https://github.styleci.io/repos/415063550/shield?branch=main)](https://github.styleci.io/repos/415063550?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/unit-tests/badge)](https://www.codefactor.io/repository/github/quillstack/unit-tests)
![Packagist License](https://img.shields.io/packagist/l/quillstack/unit-tests)
[![Reliability Rating](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=reliability_rating)](https://sonarcloud.io/dashboard?id=quillstack_unit-tests)
[![Maintainability](https://api.codeclimate.com/v1/badges/be781b23b0ea32a7df12/maintainability)](https://codeclimate.com/github/quillstack/unit-tests/maintainability)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=security_rating)](https://sonarcloud.io/dashboard?id=quillstack_unit-tests)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/quillstack/unit-tests)

A simple library for unit testing in PHP 8.

### Unit tests
Run your tests using a command:

```shell
phpdbg -qrr ./vendor/bin/unit-tests
```

Run local tests for this library:

```shell
phpdbg -qrr ./bin/local
```

### Docker

```shell
$ docker-compose up -d
$ docker exec -w /var/www/html -it quillstack_unit-tests sh
```
