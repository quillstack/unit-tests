<?php

declare(strict_types=1);

use Quillstack\DI\Container;
use Quillstack\LocalStorage\LocalStorage;
use Quillstack\StorageInterface\StorageInterface;
use Quillstack\TestCoverage\CoverageOutput\CoverageXml;
use Quillstack\TestCoverage\Drivers\PHPDbg;
use Quillstack\TestCoverage\TestCoverageDriverInterface;
use Quillstack\TestCoverage\TestCoverage;
use Quillstack\TestCoverage\TestCoverageInterface;
use Quillstack\TestCoverage\TestCoverageOutputInterface;
use Quillstack\UnitTests\UnitTests;

require ROOT . '/vendor/autoload.php';
$tests = require ROOT . '/tests/unit.php';

$container = new Container([
    StorageInterface::class => LocalStorage::class,
    TestCoverageInterface::class => TestCoverage::class,
    TestCoverageDriverInterface::class => PHPDbg::class,
    TestCoverageOutputInterface::class => CoverageXml::class,
]);

$unitTests = new UnitTests($container, $tests);
$unitTests->run($srcDir);
