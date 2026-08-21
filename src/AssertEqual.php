<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayValuesNotEqualException;
use Quillstack\UnitTests\Exceptions\Types\Objects\ObjectValuesNotEqualException;
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

        // Two objects of the same class holding the same values count as equal, which is
        // what a test comparing a built object against an expected one is asking about.
        if (is_object($expected) && is_object($value) && $expected == $value) {
            return;
        }

        if (is_array($expected)) {
            throw new ArrayValuesNotEqualException();
        }

        if (is_string($expected)) {
            throw new StringValuesNotEqualException();
        }

        if (is_object($expected)) {
            throw new ObjectValuesNotEqualException();
        }

        throw new ValuesNotEqualException();
    }
}
