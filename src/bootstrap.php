<?php

declare(strict_types=1);

use Quillstack\DI\Container;
use Quillstack\LocalStorage\LocalStorage;
use Quillstack\StorageInterface\StorageInterface;
use Quillstack\TestCoverage\CoverageOutput\CoverageXml;
use Quillstack\TestCoverage\Drivers\NoCoverage;
use Quillstack\TestCoverage\Drivers\PHPDbg;
use Quillstack\TestCoverage\TestCoverage;
use Quillstack\TestCoverage\TestCoverageDriverInterface;
use Quillstack\TestCoverage\TestCoverageInterface;
use Quillstack\TestCoverage\TestCoverageOutputInterface;
use Quillstack\UnitTests\UnitTests;

// Included by bin/unit-tests, which works out where the project and its sources are.
$rootDir = $rootDir ?? null;
$srcDir = $srcDir ?? null;

if (!is_string($rootDir) || !is_string($srcDir)) {
    throw new RuntimeException('bootstrap.php is included by bin/unit-tests, which sets $rootDir and $srcDir');
}

require $rootDir . '/vendor/autoload.php';

// Coverage needs phpdbg. Without it the tests still run, they just report no coverage.
$driver = PHPDbg::isAvailable() ? PHPDbg::class : NoCoverage::class;

$container = new Container([
    StorageInterface::class => LocalStorage::class,
    TestCoverageInterface::class => TestCoverage::class,
    TestCoverageDriverInterface::class => $driver,
    TestCoverageOutputInterface::class => CoverageXml::class,
]);

// tests/unit.php returns the list of test classes, or an array holding that list under
// `tests` next to the container definitions the tests need under `config`.
$definition = require $rootDir . '/tests/unit.php';
$tests = $definition['tests'] ?? $definition;

$container->addToConfig($definition['config'] ?? []);

$unitTests = new UnitTests($container, $tests);
$exitCode = $unitTests->run($srcDir, $rootDir);
