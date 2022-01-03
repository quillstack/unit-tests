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

    public function expectMessage(string $message): void
    {
        ExceptionExpectation::setExceptionMessage($message);
    }
}
