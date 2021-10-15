<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Strings\StringValuesNotEqualException;

class AssertString
{
    public function equal(string $expected, string $value): void
    {
        if ($expected === $value) {
            return;
        }

        throw new StringValuesNotEqualException();
    }
}
