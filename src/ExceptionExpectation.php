<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

class ExceptionExpectation
{
    private static ?string $expectedException = null;
    private static ?string $exceptionMessage = null;

    public static function set(string $exception): void
    {
        static::$expectedException = $exception;
    }

    public static function setExceptionMessage(string $message): void
    {
        static::$exceptionMessage = $message;
    }

    public static function reset(): void
    {
        static::$expectedException = null;
        static::$exceptionMessage = null;
    }

    /**
     * A subclass of the expected exception counts as expected, the way `instanceof` reads.
     */
    public static function expected(string $exception): bool
    {
        return static::$expectedException !== null
            && is_a($exception, static::$expectedException, true);
    }

    public static function isExpected(): bool
    {
        return static::$expectedException !== null;
    }

    public static function getExceptionClass(): ?string
    {
        return static::$expectedException;
    }

    public static function getExceptionMessage(): ?string
    {
        return static::$exceptionMessage;
    }
}
