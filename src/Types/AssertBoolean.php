<?php

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\ValueIsNotFalseException;
use Quillstack\UnitTests\Exceptions\Types\ValueIsNotTrueException;
use Quillstack\UnitTests\Exceptions\Types\ValueNotBooleanException;

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
