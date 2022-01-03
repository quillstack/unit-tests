<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Strings\StringValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\Strings\ValueIsNotStringException;
use Quillstack\UnitTests\Exceptions\Types\Strings\ValueIsStringException;

class AssertString
{
    public function equal(string $expected, string $value): void
    {
        if ($expected === $value) {
            return;
        }

        throw new StringValuesNotEqualException();
    }

    public function isString(mixed $value): void
    {
        if (is_string($value)) {
            return;
        }

        throw new ValueIsNotStringException();
    }

    public function isNotString(mixed $value): void
    {
        if (!is_string($value)) {
            return;
        }

        throw new ValueIsStringException();
    }
}
