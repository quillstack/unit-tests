<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

class ExceptionExpectation
{
    private static ?string $expectedException = null;
    private static ?string $exceptionMessage = null;

    public static function set(string $exception): void
    {
        self::$expectedException = $exception;
    }

    public static function setExceptionMessage(string $message): void
    {
        self::$exceptionMessage = $message;
    }

    public static function reset(): void
    {
        self::$expectedException = null;
        self::$exceptionMessage = null;
    }

    /**
     * A subclass of the expected exception counts as expected, the way `instanceof` reads.
     */
    public static function expected(string $exception): bool
    {
        return self::$expectedException !== null
            && is_a($exception, self::$expectedException, true);
    }

    public static function isExpected(): bool
    {
        return self::$expectedException !== null;
    }

    public static function getExceptionClass(): ?string
    {
        return self::$expectedException;
    }

    public static function getExceptionMessage(): ?string
    {
        return self::$exceptionMessage;
    }
}
