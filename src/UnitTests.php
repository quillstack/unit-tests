<?php

namespace Quillstack\UnitTests;

use Exception;
use Psr\Container\ContainerInterface;
use Quillstack\StorageInterface\StorageInterface;
use Quillstack\TestCoverage\TestCoverageInterface;
use Quillstack\UnitTests\Exceptions\ExceptionExpectedException;
use ReflectionException;
use ReflectionMethod;

class UnitTests
{
    private TestCoverageInterface $testCoverage;

    public function __construct(private ContainerInterface $container, private array $tests = [])
    {
        $this->testCoverage = $this->container->get(TestCoverageInterface::class);
    }

    /**
     * @throws ReflectionException
     */
    public function run(?string $srcDir = __DIR__): void
    {
        $srcDir ??= __DIR__;
        $this->testCoverage->start();

        foreach ($this->tests as $test) {
            echo $test, ':', PHP_EOL;
            $testObject = $this->container->get($test);
            $methods = get_class_methods($test);

            foreach ($methods as $method) {
                if (str_starts_with($method, '__')) {
                    continue;
                }

                $this->runTests($testObject, $method);
            }

            echo PHP_EOL;
        }

        $this->testCoverage->end();
        $this->saveCoverageXml($srcDir);
    }

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    private function runTests(object $testObject, string $method): void
    {
        $args = $this->getArgs($testObject, $method);

        if ($args) {
            foreach ($args as $argumentList) {
                $this->runSingleTest($testObject, $method, $argumentList);
            }
        } else {
            $this->runSingleTest($testObject, $method, []);
        }
    }

    private function saveCoverageXml(string $srcDir): void
    {
        $xml = $this->testCoverage->process($srcDir);

        $storage = $this->container->get(StorageInterface::class);
        $storage->save($srcDir . '/../unit-tests.coverage.xml', $xml);
    }

    /**
     * @throws ReflectionException
     */
    private function getArgs(object $testObject, string $method): array
    {
        $reflection = new ReflectionMethod($testObject, $method);

        if (!$reflection->getAttributes()) {
            return [];
        }

        $dataProviderClass = $reflection->getAttributes()[0]->newInstance()->dataProvider;
        $dataProvider = new $dataProviderClass();

        return $dataProvider->provides();
    }

    /**
     * @throws Exception
     */
    private function runSingleTest(object $testObject, string $method, array $arg): void
    {
        try {
            $testObject->$method(...$arg);

            if (ExceptionExpectation::isExpected()) {
                throw new ExceptionExpectedException('Exception expected: ' . ExceptionExpectation::getExceptionClass());
            }

            echo '.';
        } catch (Exception $exception) {
            if (ExceptionExpectation::expected(get_class($exception))) {
                echo '.';
                ExceptionExpectation::reset();

                return;
            }

            echo 'E';
            throw $exception;
        }
    }
}
