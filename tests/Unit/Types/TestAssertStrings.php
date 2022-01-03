<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Strings\StringValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\Strings\ValueIsNotStringException;
use Quillstack\UnitTests\Exceptions\Types\Strings\ValueIsStringException;
use Quillstack\UnitTests\Tests\DataProviders\StringData\EqualStringsDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\StringData\NotEqualStringsDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\StringData\NotStringsDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\StringData\StringsDataProvider;
use Quillstack\UnitTests\Types\AssertString;

class TestAssertStrings
{
    public function __construct(private AssertString $assertString, private AssertExceptions $assertExceptions)
    {
        //
    }

    #[ProvidesDataFrom(EqualStringsDataProvider::class)]
    public function equal($expected, $value)
    {
        $this->assertString->equal($expected, $value);
    }

    #[ProvidesDataFrom(NotEqualStringsDataProvider::class)]
    public function equalException($expected, $value)
    {
        $this->assertExceptions->expect(StringValuesNotEqualException::class);

        $this->assertString->equal($expected, $value);
    }

    #[ProvidesDataFrom(StringsDataProvider::class)]
    public function isString($value)
    {
        $this->assertString->isString($value);
    }

    #[ProvidesDataFrom(NotStringsDataProvider::class)]
    public function isNotString($value)
    {
        $this->assertString->isNotString($value);
    }

    #[ProvidesDataFrom(NotStringsDataProvider::class)]
    public function isStringException($value)
    {
        $this->assertExceptions->expect(ValueIsNotStringException::class);

        $this->assertString->isString($value);
    }

    #[ProvidesDataFrom(StringsDataProvider::class)]
    public function isNotStringException($value)
    {
        $this->assertExceptions->expect(ValueIsStringException::class);

        $this->assertString->isNotString($value);
    }
}
