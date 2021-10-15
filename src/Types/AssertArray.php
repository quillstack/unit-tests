<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayCountNotMatchException;

class AssertArray
{
    public function count(int $expected, array $array): void
    {
        if (count($array) === $expected) {
            return;
        }

        throw new ArrayCountNotMatchException();
    }
}
