<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Booleans\ValueIsNotFalseException;
use Quillstack\UnitTests\Exceptions\Types\Booleans\ValueIsNotTrueException;
use Quillstack\UnitTests\Exceptions\Types\Booleans\ValueNotBooleanException;

class AssertBoolean
{
    public function isTrue($value): void
    {
        if ($value === true) {
            return;
        }

        throw new ValueIsNotTrueException();
    }

    public function isFalse($value): void
    {
        if ($value === false) {
            return;
        }

        throw new ValueIsNotFalseException();
    }

    public function isBoolean($value): void
    {
        if (is_bool($value)) {
            return;
        }

        throw new ValueNotBooleanException();
    }
}
