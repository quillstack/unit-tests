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

require $rootDir . '/vendor/autoload.php';

// Coverage needs phpdbg. Without it the tests still run, they just report no coverage.
$driver = PHPDbg::isAvailable() ? PHPDbg::class : NoCoverage::class;

$container = new Container([
    StorageInterface::class => LocalStorage::class,
    TestCoverageInterface::class => TestCoverage::class,
    TestCoverageDriverInterface::class => $driver,
    TestCoverageOutputInterface::class => CoverageXml::class,
]);

$tests = require $rootDir . '/tests/unit.php';
$unitTests = new UnitTests($container, $tests);
$exitCode = $unitTests->run($srcDir, $rootDir);
