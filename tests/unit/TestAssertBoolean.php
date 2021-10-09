<?php

namespace Quillstack\Tests\Unit;

use Quillstack\UnitTests\AssertException;
use Quillstack\UnitTests\Exceptions\Types\ValueIsNotFalseException;
use Quillstack\UnitTests\Exceptions\Types\ValueIsNotTrueException;
use Quillstack\UnitTests\Exceptions\Types\ValueNotBooleanException;
use Quillstack\UnitTests\Types\AssertBoolean;

class TestAssertBoolean
{
    public function __construct(
        private AssertBoolean $assertBoolean,
        private AssertException $assertException
    ) {
        //
    }

    public function falseSuccess()
    {
        $this->assertBoolean->isFalse(false);
    }

    public function falseFailureValue()
    {
        $this->assertException->expect(ValueIsNotFalseException::class);
        $this->assertBoolean->isFalse(true);
    }

    public function falseFailureType()
    {
        $this->assertException->expect(ValueIsNotFalseException::class);
        $this->assertBoolean->isFalse(1);
    }

    public function trueSuccess()
    {
        $this->assertBoolean->isTrue(true);
    }

    public function trueFailureValue()
    {
        $this->assertException->expect(ValueIsNotTrueException::class);
        $this->assertBoolean->isTrue(false);
    }

    public function trueFailureType()
    {
        $this->assertException->expect(ValueIsNotTrueException::class);
        $this->assertBoolean->isTrue(0);
    }

    public function booleanSuccess()
    {
        $this->assertBoolean->isBoolean(true);
        $this->assertBoolean->isBoolean(false);
    }

    public function booleanFailure()
    {
        $this->assertException->expect(ValueNotBooleanException::class);
        $this->assertBoolean->isBoolean(1);
        $this->assertBoolean->isBoolean('abc');
    }
}
