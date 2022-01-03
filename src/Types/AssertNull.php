<?php

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Nulls\ValueIsNotNullException;
use Quillstack\UnitTests\Exceptions\Types\Nulls\ValueIsNullException;

class AssertNull
{
    public function isNull(mixed $value): void
    {
        if ($value === null) {
            return;
        }

        throw new ValueIsNotNullException();
    }

    public function isNotNull(mixed $value): void
    {
        if ($value !== null) {
            return;
        }

        throw new ValueIsNullException();
    }
}
