<?php

namespace Quillstack\UnitTests;

use Exception;
use Psr\Container\ContainerInterface;
use Quillstack\StorageInterface\StorageInterface;
use Quillstack\TestCoverage\TestCoverageInterface;

class UnitTests
{
    private TestCoverageInterface $testCoverage;

    public function __construct(private ContainerInterface $container, private array $tests = [])
    {
        $this->testCoverage = $this->container->get(TestCoverageInterface::class);
    }

    public function run(?string $dir = __DIR__): void
    {
        $dir ??= __DIR__;
        $this->testCoverage->start();

        foreach ($this->tests as $test) {
            echo $test, ':', PHP_EOL;
            $testObject = $this->container->get($test);
            $methods = get_class_methods($test);

            foreach ($methods as $method) {
                if (str_starts_with($method, '__')) {
                    continue;
                }

                try {
                    $testObject->$method();
                    echo '.';
                } catch (Exception $exception) {
                    if (ExceptionExpectation::expected(get_class($exception))) {
                        echo '.';
                        ExceptionExpectation::reset();
                        continue;
                    }

                    echo 'E';
                    throw $exception;
                }
            }

            echo PHP_EOL;
        }

        $this->testCoverage->end();
        $xml = $this->testCoverage->process($dir);

        $storage = $this->container->get(StorageInterface::class);
        $storage->save(__DIR__ . '/../unit-tests.coverage.xml', $xml);
    }
}
