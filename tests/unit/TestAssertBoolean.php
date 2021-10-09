<?php

namespace Quillstack\Tests\Unit;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Exceptions\Types\ValueIsNotFalseException;
use Quillstack\UnitTests\Exceptions\Types\ValueIsNotTrueException;
use Quillstack\UnitTests\Exceptions\Types\ValueNotBooleanException;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestAssertBoolean
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

    public function booleanSuccess()
    {
        $this->assertBoolean->isBoolean(true);
        $this->assertBoolean->isBoolean(false);
    }

    public function booleanFailure()
    {
        $this->assertExceptions->expect(ValueNotBooleanException::class);
        $this->assertBoolean->isBoolean(1);
        $this->assertBoolean->isBoolean('abc');
    }
}
