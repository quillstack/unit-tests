<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Numerics\ValueIsNotFloatException;
use Quillstack\UnitTests\Exceptions\Types\Numerics\ValueIsNotIntException;
use Quillstack\UnitTests\Exceptions\Types\Numerics\ValueIsNotNumericException;
use Quillstack\UnitTests\Tests\DataProviders\NumericData\FloatDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\NumericData\IntDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\NumericData\NotNumericDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\NumericData\NumericDataProvider;
use Quillstack\UnitTests\Types\AssertNumeric;

class TestAssertNumerics
{
    public function __construct(private AssertExceptions $assertExceptions, private AssertNumeric $assertNumeric)
    {
        //
    }

    #[ProvidesDataFrom(NumericDataProvider::class)]
    public function testNumeric($value)
    {
        $this->assertNumeric->isNumeric($value);
    }

    #[ProvidesDataFrom(NotNumericDataProvider::class)]
    public function numericException($value)
    {
        $this->assertExceptions->expect(ValueIsNotNumericException::class);

        $this->assertNumeric->isNumeric($value);
    }

    #[ProvidesDataFrom(IntDataProvider::class)]
    public function testInt($value)
    {
        $this->assertNumeric->isInt($value);
    }

    #[ProvidesDataFrom(NotNumericDataProvider::class)]
    public function intException($value)
    {
        $this->assertExceptions->expect(ValueIsNotIntException::class);

        $this->assertNumeric->isInt($value);
    }

    #[ProvidesDataFrom(FloatDataProvider::class)]
    public function testFloat($value)
    {
        $this->assertNumeric->isNumeric($value);
    }

    #[ProvidesDataFrom(NotNumericDataProvider::class)]
    public function floatException($value)
    {
        $this->assertExceptions->expect(ValueIsNotFloatException::class);

        $this->assertNumeric->isFloat($value);
    }
}
