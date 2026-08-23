# Quillstack Unit Tests

[![Tests](https://github.com/quillstack/unit-tests/actions/workflows/tests.yml/badge.svg)](https://github.com/quillstack/unit-tests/actions/workflows/tests.yml)
[![Latest Version](https://img.shields.io/packagist/v/quillstack/unit-tests.svg)](https://packagist.org/packages/quillstack/unit-tests)
[![Downloads](https://img.shields.io/packagist/dt/quillstack/unit-tests.svg)](https://packagist.org/packages/quillstack/unit-tests)
[![PHP Version](https://img.shields.io/packagist/php-v/quillstack/unit-tests)](https://packagist.org/packages/quillstack/unit-tests)
[![StyleCI](https://github.styleci.io/repos/415063550/shield?branch=main)](https://github.styleci.io/repos/415063550?branch=main)
[![CodeFactor](https://www.codefactor.io/repository/github/quillstack/unit-tests/badge)](https://www.codefactor.io/repository/github/quillstack/unit-tests)
[![Quality Gate](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=quillstack_unit-tests)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=coverage)](https://sonarcloud.io/summary/new_code?id=quillstack_unit-tests)
[![Maintainability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=sqale_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_unit-tests)
[![Reliability](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=reliability_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_unit-tests)
[![Security](https://sonarcloud.io/api/project_badges/measure?project=quillstack_unit-tests&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=quillstack_unit-tests)
[![Maintainability](https://api.codeclimate.com/v1/badges/be781b23b0ea32a7df12/maintainability)](https://codeclimate.com/github/quillstack/unit-tests/maintainability)
[![License](https://img.shields.io/packagist/l/quillstack/unit-tests)](https://github.com/quillstack/unit-tests/blob/main/LICENSE)

A simple library for unit testing in PHP 8. Full documentation:
https://quillstack.org/unit-tests

A test is a class, a test is a method on it, and what a test needs is asked for in the
constructor — the container builds it, the same way it builds everything else. Coverage comes
with it, and needs no extension.

### Requirements

- PHP 8.1 or newer
- phpdbg for coverage, which ships with PHP

### Installation

```shell
composer require --dev quillstack/unit-tests
```

### Usage

#### A test

```php
namespace App\Tests\Unit;

use Quillstack\UnitTests\AssertEqual;

class TestBasket
{
    public function __construct(private AssertEqual $assertEqual)
    {
    }

    public function anEmptyBasketCostsNothing()
    {
        $this->assertEqual->equal(0, (new Basket())->total());
    }
}
```

Every public method is a test, apart from the constructor. There is no `test` prefix to
remember and no annotation to add: a method called `anEmptyBasketCostsNothing` says what it is
about, and that is what the runner prints when it fails.

Whatever the constructor asks for is built for it, so a test can take the thing it is testing
as well as the assertions it needs.

#### Listing them

`tests/unit.php` returns the classes to run:

```php
return [
    \App\Tests\Unit\TestBasket::class,
    \App\Tests\Unit\TestCheckout::class,
];
```

It is a PHP file rather than a config format, so a test needing something that is not there can
simply be left out:

```php
$tests = [\App\Tests\Unit\TestBasket::class];

if (getenv('DATABASE_DSN')) {
    $tests[] = \App\Tests\Integration\TestOrders::class;
}

return $tests;
```

Leaving it out is better than passing quietly: a suite which never reached the database should
not look like one that did.

#### Running

```shell
vendor/bin/unit-tests
```

```text
Tests: 91, passed: 91, failed: 0
```

With coverage, under phpdbg:

```shell
phpdbg -qrr vendor/bin/unit-tests
```

```text
Coverage: 97.1% (813/837 lines in 34 files)
Tests: 91, passed: 91, failed: 0
```

A file no test ever loaded still counts, uncovered — so the number says how much of the package
is tested rather than how much of what ran was tested.

### Assertions

Each is a class, asked for in the constructor.

| Class | Methods |
| --- | --- |
| `AssertEqual` | `equal()` |
| `AssertEmpty` | `isEmpty()`, `isNotEmpty()` |
| `AssertExceptions` | `expect()`, `expectMessage()` |
| `Types\AssertArray` | `count()`, `isArray()`, `hasKey()`, `doesntHaveKey()`, `equal()`, `notEqual()` |
| `Types\AssertBoolean` | `isTrue()`, `isFalse()`, `isBoolean()` |
| `Types\AssertNull` | `isNull()`, `isNotNull()` |
| `Types\AssertNumeric` | `isNumeric()`, `isInt()`, `isFloat()` |
| `Types\AssertObject` | `instanceOf()`, `notNull()` |
| `Types\AssertString` | `equal()`, `isString()`, `isNotString()` |

#### Expecting an exception

`expect()` says what should be thrown before the thing that throws it:

```php
public function anUnknownRuleSaysSo()
{
    $this->assertExceptions->expect(UnknownRuleException::class);

    $this->validator->findErrors(['a' => 1], ['a' => ['nonsense']]);
}
```

The test fails if nothing is thrown, and if something else is.

### The same test with different data

```php
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\DataProviderInterface;

class Prices implements DataProviderInterface
{
    public function provides(): array
    {
        return [[1, 100], [2, 200], [3, 300]];
    }
}
```

```php
#[ProvidesDataFrom(Prices::class)]
public function eachItemCostsAHundred(int $items, int $total)
{
    $this->assertEqual->equal($total, (new Basket())->add($items)->total());
}
```

One row per run, each holding the arguments.

### Technical documentation

| Class | What it is |
| --- | --- |
| `UnitTests` | the runner |
| `TestResult` | what passed, what failed, and why |
| `DataProviderInterface` | `provides(): array` — a row per run |
| `Attributes\ProvidesDataFrom` | says which provider a test takes its rows from |

Coverage is [quillstack/test-coverage](https://github.com/quillstack/test-coverage), and the
report it writes to `unit-tests.coverage.xml` is the one SonarCloud reads.

The runner works out where the project is from the working directory, so it runs from the root
of a package whether or not it is installed in a plain `vendor/` — a symlinked checkout used to
break it.

### Unit tests

This package is tested with itself:

```shell
composer test
composer test:coverage
composer stan
```

### Docker

```shell
docker-compose up -d
docker exec -w /var/www/html -it quillstack_unit-tests sh
```

### License

MIT. See [LICENSE](LICENSE).
