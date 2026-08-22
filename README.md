# Quillstack Unit Tests

[![Tests](https://github.com/quillstack/unit-tests/actions/workflows/tests.yml/badge.svg)](https://github.com/quillstack/unit-tests/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/quillstack/unit-tests.svg)](https://packagist.org/packages/quillstack/unit-tests)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/unit-tests.svg)](https://packagist.org/packages/quillstack/unit-tests)
[![PHP Version](https://img.shields.io/packagist/php-v/quillstack/unit-tests)](https://packagist.org/packages/quillstack/unit-tests)
[![StyleCI](https://github.styleci.io/repos/415063550/shield?branch=main)](https://github.styleci.io/repos/415063550?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/unit-tests/badge)](https://www.codefactor.io/repository/github/quillstack/unit-tests)
[![Maintainability](https://api.codeclimate.com/v1/badges/be781b23b0ea32a7df12/maintainability)](https://codeclimate.com/github/quillstack/unit-tests/maintainability)
[![License](https://img.shields.io/packagist/l/quillstack/unit-tests)](https://github.com/quillstack/unit-tests/blob/main/LICENSE)

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
