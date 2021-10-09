<?php

namespace Quillstack\UnitTests;

class ExceptionExpectation
{
    private static ?string $expectedException = null;

    public static function set(string $exception): void
    {
        static::$expectedException = $exception;
    }

    public static function reset(): void
    {
        static::$expectedException = null;
    }

    public static function expected(string $exception): bool
    {
        return static::$expectedException === $exception;
    }
}
