<?php

declare(strict_types=1);

namespace Quillstack\UnitTests;

use Quillstack\UnitTests\Exceptions\Exceptions\ExceptionMessageException;

class AssertExceptions
{
    public function expect(string $exception): void
    {
        ExceptionExpectation::set($exception);
    }

    public function messageEquals(string $message): void
    {
        if ($message === ExceptionExpectation::getExceptionMessage()) {
            return;
        }

        throw new ExceptionMessageException();
    }
}
