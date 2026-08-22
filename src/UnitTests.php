<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

use Quillstack\DI\Container;
use Quillstack\StorageInterface\StorageInterface;
use Quillstack\TestCoverage\TestCoverageInterface;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Exceptions\ExceptionExpectedException;
use Quillstack\UnitTests\Exceptions\Exceptions\ExceptionMessageException;
use ReflectionException;
use ReflectionMethod;
use Throwable;

class UnitTests
{
    private TestCoverageInterface $testCoverage;
    private TestResult $result;

    /**
     * The definitions every test container is built from, taken once so each test can get
     * a container of its own instead of sharing one with every other test.
     */
    /**
     * @var array<string, mixed>
     */
    private array $config;

    /**
     * @param array<int, class-string> $tests
     */
    public function __construct(private Container $container, private array $tests = [])
    {
        /** @var TestCoverageInterface $testCoverage */
        $testCoverage = $this->container->get(TestCoverageInterface::class);
        $this->testCoverage = $testCoverage;
        $this->config = $this->container->getConfig();
        $this->result = new TestResult();
    }

    /**
     * Runs every test and returns the exit code: 0 when they all passed.
     *
     * @throws ReflectionException
     */
    public function run(?string $srcDir = __DIR__, ?string $rootDir = __DIR__): int
    {
        $srcDir ??= __DIR__;
        $rootDir ??= __DIR__;
        $this->testCoverage->start();

        foreach ($this->tests as $test) {
            $this->runTestClass($test);
        }

        $this->testCoverage->end();
        $this->saveCoverageXml($srcDir, $rootDir);
        $this->report();

        return $this->result->isSuccessful() ? 0 : 1;
    }

    public function getResult(): TestResult
    {
        return $this->result;
    }

    /**
     * @throws ReflectionException
     */
    private function runTestClass(string $test): void
    {
        echo $test, ':', PHP_EOL;

        foreach ($this->getTestMethods($test) as $method) {
            $this->runTests($test, $method);
        }

        echo PHP_EOL;
    }

    /**
     * @throws ReflectionException
     */
    /**
     * @return string[]
     *
     * @throws ReflectionException
     */
    private function getTestMethods(string $test): array
    {
        $methods = [];

        foreach (get_class_methods($test) as $method) {
            if (str_starts_with($method, '__')) {
                continue;
            }

            if ((new ReflectionMethod($test, $method))->isPublic()) {
                $methods[] = $method;
            }
        }

        return $methods;
    }

    /**
     * Builds a test object of its own for the given test, so nothing a previous test left
     * behind can reach the next one.
     */
    private function createTestObject(string $test): object
    {
        /** @var object $testObject */
        $testObject = (new Container($this->config))->get($test);

        return $testObject;
    }

    private function saveCoverageXml(string $srcDir, string $rootDir): void
    {
        if (!$this->testCoverage->isAvailable()) {
            echo 'Coverage: not measured, run the tests under phpdbg to collect it.', PHP_EOL;

            return;
        }

        $rootDirNoBin = $this->removeAbsolutePath($rootDir);
        $xml = $this->testCoverage->process($srcDir, $rootDirNoBin);

        /** @var StorageInterface $storage */
        $storage = $this->container->get(StorageInterface::class);
        $storage->save($rootDir . '/unit-tests.coverage.xml', $xml);

        $summary = $this->testCoverage->getSummary();
        echo 'Coverage: ', $summary['percent'], '% (',
        $summary['covered'], '/', $summary['total'], ' lines in ',
        $summary['files'], ' files)', PHP_EOL;
        echo 'Coverage XML saved to: ', $rootDir, '/unit-tests.coverage.xml', PHP_EOL;
    }

    private function report(): void
    {
        $failures = $this->result->getFailures();

        foreach ($failures as $index => $failure) {
            $error = $failure['error'];
            echo PHP_EOL, $index + 1, ') ', $failure['test'], '::', $failure['method'], PHP_EOL,
            '   ', $error::class, ': ', $error->getMessage(), PHP_EOL,
            '   ', $error->getFile(), ':', $error->getLine(), PHP_EOL;
        }

        echo PHP_EOL, 'Tests: ', $this->result->getTotal(),
        ', passed: ', $this->result->getPassed(),
        ', failed: ', count($failures), PHP_EOL;
    }

    /**
     * The prefix stripped from file names in the report, so they read as `src/App.php`.
     */
    private function removeAbsolutePath(string $path): string
    {
        // Remove from vendor paths:
        $rootDirNoBin = str_replace('vendor/quillstack/unit-tests/bin/../../../..', '', $path);

        // Remove from local paths:
        $rootDirNoBin = str_replace('bin/..', '', $rootDirNoBin);

        return rtrim($rootDirNoBin, '/') . '/';
    }

    /**
     * @throws ReflectionException
     */
    private function runTests(string $test, string $method): void
    {
        foreach ($this->getArgs($test, $method) ?: [[]] as $argumentList) {
            $this->runSingleTest($test, $method, $argumentList);
        }
    }

    /**
     * @throws ReflectionException
     */
    /**
     * The rows a data provider hands over, or nothing when the test does not name one.
     *
     * @return array<int, array<int, mixed>>
     *
     * @throws ReflectionException
     */
    private function getArgs(string $test, string $method): array
    {
        $attributes = (new ReflectionMethod($test, $method))->getAttributes(ProvidesDataFrom::class);

        if ($attributes === []) {
            return [];
        }

        /** @var class-string<DataProviderInterface> $dataProviderClass */
        $dataProviderClass = $attributes[0]->newInstance()->dataProvider;

        return (new $dataProviderClass())->provides();
    }

    /**
     * @param array<int, mixed> $arg
     */
    private function runSingleTest(string $test, string $method, array $arg): void
    {
        // A failing test is recorded and the run carries on, so one broken test no longer
        // hides the state of every test after it.
        try {
            $testObject = $this->createTestObject($test);
            $testObject->$method(...$arg);

            if (ExceptionExpectation::isExpected()) {
                throw new ExceptionExpectedException(
                    'Exception expected: ' . ExceptionExpectation::getExceptionClass()
                );
            }

            echo '.';
            $this->result->pass();
        } catch (Throwable $throwable) {
            $this->handleThrowable($test, $method, $throwable);
        } finally {
            ExceptionExpectation::reset();
        }
    }

    /**
     * An expected exception is a pass, anything else is a failure. Errors count too: a
     * TypeError or an uninitialised property says as much about the code as an exception.
     */
    private function handleThrowable(string $test, string $method, Throwable $throwable): void
    {
        if (!ExceptionExpectation::expected($throwable::class)) {
            echo 'E';
            $this->result->fail($test, $method, $throwable);

            return;
        }

        $expectedMessage = ExceptionExpectation::getExceptionMessage();

        if ($expectedMessage !== null && $expectedMessage !== $throwable->getMessage()) {
            echo 'E';
            $this->result->fail($test, $method, new ExceptionMessageException(
                "Expected message: {$expectedMessage}, current message {$throwable->getMessage()}"
            ));

            return;
        }

        echo '.';
        $this->result->pass();
    }
}
