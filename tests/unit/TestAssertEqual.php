<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit;

use Quillstack\UnitTests\AssertEqual;
use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\Strings\StringValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\ValueTypesNotEqualException;
use Quillstack\UnitTests\Exceptions\ValuesNotEqualException;
use Quillstack\UnitTests\Tests\DataProviders\EqualDataProvider;

class TestAssertEqual
{
    public function __construct(private AssertEqual $assertEqual, private AssertExceptions $assertExceptions)
    {
        //
    }

    #[ProvidesDataFrom(EqualDataProvider::class)]
    public function success(mixed $expected, mixed $value)
    {
        $this->assertEqual->equal($expected, $value);
    }

    public function failureGeneral()
    {
        $this->assertExceptions->expect(ValuesNotEqualException::class);
        $this->assertEqual->equal(1, -1);
    }

    public function failureTypes()
    {
        $this->assertExceptions->expect(ValueTypesNotEqualException::class);
        $this->assertEqual->equal(1, 'test');
    }

    public function failureArrays()
    {
        $this->assertExceptions->expect(ArrayValuesNotEqualException::class);
        $this->assertEqual->equal([], [1]);
    }

    public function failureStrings()
    {
        $this->assertExceptions->expect(StringValuesNotEqualException::class);
        $this->assertEqual->equal('test', '');
    }
}
