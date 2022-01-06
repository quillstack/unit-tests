<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit;

use Quillstack\UnitTests\AssertEmpty;
use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Attributes\ProvidesDataFrom;
use Quillstack\UnitTests\Exceptions\ValueNotEmptyException;
use Quillstack\UnitTests\Tests\DataProviders\EmptyDataProvider;
use Quillstack\UnitTests\Tests\DataProviders\NotEmptyDataProvider;

class TestAssertEmpty
{
    public function __construct(private AssertEmpty $assertEmpty, private AssertExceptions $assertExceptions)
    {
        //
    }

    #[ProvidesDataFrom(EmptyDataProvider::class)]
    public function isEmpty(mixed $value)
    {
        $this->assertEmpty->isEmpty($value);
    }

    #[ProvidesDataFrom(NotEmptyDataProvider::class)]
    public function emptyException(mixed $value)
    {
        $this->assertExceptions->expect(ValueNotEmptyException::class);

        $this->assertEmpty->isEmpty($value);
    }
}
