<?php

namespace Quillstack\UnitTests\Tests\Unit;

use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\ExceptionExpectation;
use Quillstack\UnitTests\Tests\DataProviders\ExceptionsDataProvider;
use Quillstack\UnitTests\Types\AssertString;

class TestExceptionExpectation
{
    public function __construct(private AssertString $assertString)
    {
    }

    #[ProvidesDataFrom(ExceptionsDataProvider::class)]
    public function expectException($exception)
    {
        ExceptionExpectation::set($exception);
        $this->assertString->equals($exception, ExceptionExpectation::getExceptionClass());
        ExceptionExpectation::reset();
    }
}