<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Numerics\ValueIsNotFloatException;
use Quillstack\UnitTests\Exceptions\Types\Numerics\ValueIsNotIntException;
use Quillstack\UnitTests\Exceptions\Types\Numerics\ValueIsNotNumericException;

class AssertNumeric
{
    public function isNumeric(mixed $value): void
    {
        if (is_numeric($value)) {
            return;
        }

        throw new ValueIsNotNumericException();
    }

    public function isFloat(mixed $value): void
    {
        if (is_float($value)) {
            return;
        }

        throw new ValueIsNotFloatException();
    }

    public function isInt(mixed $value): void
    {
        if (is_int($value)) {
            return;
        }

        throw new ValueIsNotIntException();
    }
}
