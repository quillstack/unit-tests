<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit;

use Quillstack\DI\Container;
use Quillstack\TestCoverage\CoverageOutput\CoverageXml;
use Quillstack\TestCoverage\Drivers\NoCoverage;
use Quillstack\TestCoverage\TestCoverage;
use Quillstack\TestCoverage\TestCoverageDriverInterface;
use Quillstack\TestCoverage\TestCoverageInterface;
use Quillstack\TestCoverage\TestCoverageOutputInterface;
use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\Tests\Mocks\Runner\MockFailingTest;
use Quillstack\UnitTests\Tests\Mocks\Runner\MockPassingTest;
use Quillstack\UnitTests\Tests\Mocks\Runner\MockStatefulTest;
use Quillstack\UnitTests\TestResult;
use Quillstack\UnitTests\UnitTests;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestUnitTestsRunner
{
    public function __construct(
        private AssertEqual $assertEqual,
        private AssertBoolean $assertBoolean
    ) {
        //
    }

    /**
     * Runs the given tests through a runner of their own, with coverage switched off, and
     * swallows the output so it does not mix into the report of the running suite.
     */
    private function runNested(array $tests): TestResult
    {
        $container = new Container([
            TestCoverageInterface::class => TestCoverage::class,
            TestCoverageDriverInterface::class => NoCoverage::class,
            TestCoverageOutputInterface::class => CoverageXml::class,
        ]);

        $unitTests = new UnitTests($container, $tests);

        ob_start();
        $exitCode = $unitTests->run(null, null);
        ob_end_clean();

        $result = $unitTests->getResult();
        $this->assertEqual->equal($result->isSuccessful() ? 0 : 1, $exitCode);

        return $result;
    }

    public function passingTestsReportSuccess()
    {
        $result = $this->runNested([MockPassingTest::class]);

        $this->assertEqual->equal(2, $result->getTotal());
        $this->assertEqual->equal(2, $result->getPassed());
        $this->assertBoolean->isTrue($result->isSuccessful());
    }

    public function aFailingTestDoesNotStopTheRun()
    {
        $result = $this->runNested([MockFailingTest::class, MockPassingTest::class]);

        // Three methods of the failing test, two of the passing one.
        $this->assertEqual->equal(5, $result->getTotal());
        $this->assertEqual->equal(3, $result->getPassed());
        $this->assertEqual->equal(2, count($result->getFailures()));
        $this->assertBoolean->isFalse($result->isSuccessful());
    }

    public function failuresCarryTheTestTheyCameFrom()
    {
        $failures = $this->runNested([MockFailingTest::class])->getFailures();

        $this->assertEqual->equal(MockFailingTest::class, $failures[0]['test']);
        $this->assertEqual->equal('throwsAnException', $failures[0]['method']);
        $this->assertEqual->equal('failed on purpose', $failures[0]['error']->getMessage());
    }

    /**
     * An Error is a Throwable but not an Exception, and used to escape the runner.
     */
    public function anErrorIsRecordedAsAFailure()
    {
        $failures = $this->runNested([MockFailingTest::class])->getFailures();

        $this->assertEqual->equal('throwsAnError', $failures[1]['method']);
        $this->assertEqual->equal('wrong type on purpose', $failures[1]['error']->getMessage());
    }

    public function everyTestStartsFromAFreshObject()
    {
        $result = $this->runNested([MockStatefulTest::class]);

        $this->assertEqual->equal(2, $result->getPassed());
        $this->assertBoolean->isTrue($result->isSuccessful());
    }
}
