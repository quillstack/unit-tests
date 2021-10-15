<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Booleans\ValueIsNotFalseException;
use Quillstack\UnitTests\Exceptions\Types\Booleans\ValueIsNotTrueException;
use Quillstack\UnitTests\Exceptions\Types\Booleans\ValueNotBooleanException;
use Quillstack\UnitTests\Tests\DataProviders\BooleanData\BooleanDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\BooleanData\NotBooleanDataProvider;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestAssertBooleans
{
    public function __construct(
        private AssertBoolean $assertBoolean,
        private AssertExceptions $assertExceptions
    ) {
        //
    }

    public function falseSuccess()
    {
        $this->assertBoolean->isFalse(false);
    }

    public function falseFailureValue()
    {
        $this->assertExceptions->expect(ValueIsNotFalseException::class);
        $this->assertBoolean->isFalse(true);
    }

    public function falseFailureType()
    {
        $this->assertExceptions->expect(ValueIsNotFalseException::class);
        $this->assertBoolean->isFalse(1);
    }

    public function trueSuccess()
    {
        $this->assertBoolean->isTrue(true);
    }

    public function trueFailureValue()
    {
        $this->assertExceptions->expect(ValueIsNotTrueException::class);
        $this->assertBoolean->isTrue(false);
    }

    public function trueFailureType()
    {
        $this->assertExceptions->expect(ValueIsNotTrueException::class);
        $this->assertBoolean->isTrue(0);
    }

    #[ProvidesDataFrom(NotBooleanDataProvider::class)]
    public function booleanFailure($value)
    {
        $this->assertExceptions->expect(ValueNotBooleanException::class);
        $this->assertBoolean->isBoolean($value);
    }

    #[ProvidesDataFrom(BooleanDataProvider::class)]
    public function booleanSuccess($value)
    {
        $this->assertBoolean->isBoolean($value);
    }
}
