<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\Types\Strings\StringValuesNotEqualException;
use Quillstack\UnitTests\Tests\DataProviders\StringData\EqualStringsDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\StringData\NotEqualStringsDataProvider;
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
}
