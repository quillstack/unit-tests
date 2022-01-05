<?php

declare(strict_types=1);

namespace Quillstack\UnitTests\Types;

use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayCountNotMatchException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayDoesntHaveKeyException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ArrayHasKeyException;
use Quillstack\UnitTests\Exceptions\Types\Arrays\ValueIsNotArrayException;

class AssertArray
{
    public function count(int $expected, array $array): void
    {
        if (count($array) === $expected) {
            return;
        }

        throw new ArrayCountNotMatchException();
    }

    public function isArray(mixed $value): void
    {
        if (is_array($value)) {
            return;
        }

        throw new ValueIsNotArrayException();
    }

    public function hasKey(int|string $key, array $array): void
    {
        if (array_key_exists($key, $array)) {
            return;
        }

        throw new ArrayDoesntHaveKeyException("Key `{$key}` doesn't exist in array");
    }

    public function doesntHaveKey(int|string $key, array $array): void
    {
        if (!array_key_exists($key, $array)) {
            return;
        }

        throw new ArrayHasKeyException("Key `{$key}` exists in array");
    }
}
