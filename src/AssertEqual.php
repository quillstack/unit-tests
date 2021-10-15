<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\Strings\StringValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\ValueTypesNotEqualException;
use Quillstack\UnitTests\Exceptions\ValuesNotEqualException;

class AssertEqual
{
    public function equal(mixed $expected, mixed $value): void
    {
        if ($expected === $value) {
            return;
        }

        if (gettype($expected) !== gettype($value)) {
            throw new ValueTypesNotEqualException(gettype($expected) . ' !== ' . gettype($value));
        }

        if (is_array($expected)) {
            throw new ArrayValuesNotEqualException();
        }

        if (is_string($expected)) {
            throw new StringValuesNotEqualException();
        }

        throw new ValuesNotEqualException();
    }
}
