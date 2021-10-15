<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\String\StringValuesNotEqualsException;

class AssertString
{
    public function equals(string $expected, string $value): void
    {
        if ($expected === $value) {
            return;
        }

        throw new StringValuesNotEqualsException();
    }
}
