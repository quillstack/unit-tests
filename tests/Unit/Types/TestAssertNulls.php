<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Tests\Unit\Types;

use Quillstack\UnitTests\AssertExceptions;
use Quillstack\UnitTests\Exceptions\Types\Nulls\ValueIsNotNullException;
use Quillstack\UnitTests\Exceptions\Types\Nulls\ValueIsNullException;
use Quillstack\UnitTests\Types\AssertNull;

class TestAssertNulls
{
    public function __construct(private AssertNull $assertNull, private AssertExceptions $assertExceptions)
    {
        //
    }

    public function testNull()
    {
        $this->assertNull->isNull(null);
    }

    public function nullException()
    {
        $this->assertExceptions->expect(ValueIsNotNullException::class);

        $this->assertNull->isNull(1);
    }

    public function notNull()
    {
        $this->assertNull->isNotNull(1);
    }

    public function notNullException()
    {
        $this->assertExceptions->expect(ValueIsNullException::class);

        $this->assertNull->isNotNull(null);
    }
}
