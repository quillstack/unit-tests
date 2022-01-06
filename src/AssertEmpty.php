<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

use Quillstack\UnitTests\Exceptions\ValueNotEmptyException;

class AssertEmpty
{
    public function isEmpty(mixed $value): void
    {
        if (empty($value)) {
            return;
        }

        throw new ValueNotEmptyException();
    }
}
